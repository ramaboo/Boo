#include "CmdLineParser.h"

using namespace std;

CmdLineParser::CmdLineParser() {
	values.reserve(50);
	valueRequired.reserve(50);
}


CmdLineParser::~CmdLineParser() {
}

// -----------------------------------------------------------------------------
//
// Define(...)
//
// --

bool CmdLineParser::Define(const string &ShortName, const string &LongName /* = "" */, bool isValueRequired /* = false */) {
	if (ShortName.empty() && LongName.empty())
		return false;

	pair<map<string,int>::iterator, bool> iterShort, iterLong;

	if (!ShortName.empty()) {
		// try to add option with short name, use dummy index value, correct later
		iterShort = shortOptions.insert(OptKeyVal(ShortName, 0));
		if (!iterShort.second)
			// element (short option with the same name) already exists
			return false;
	}

	if (!LongName.empty()) {
		iterLong = longOptions.insert(OptKeyVal(LongName, 0));
		if (!iterLong.second)
			return false;
	}

	// option names added, now associate them with option value (in the 'values' vector)
	values.push_back("");
	if (!ShortName.empty())
		iterShort.first->second = values.size() - 1;
	if (!LongName.empty())
		iterLong.first->second = values.size() - 1;

	// remember if this option requires user to specify option value
	valueRequired.push_back(isValueRequired);

	return true;
}

bool CmdLineParser::Define(const string &LongName, bool isValueRequired /* = false */) {
	return Define("", LongName, isValueRequired);
}

bool CmdLineParser::Define(OptPair options[], size_t n) {
	while (n && Define(options[n-1].ShortName, options[n-1].LongName, options[n-1].valueRequired) && n--);
	return n == 0;
}

// defines whether arguments that begin with '-', '--', or '/' will be parsed (recognized as options), respectively
void CmdLineParser::DefineConvention(bool POSIX /* = true */, bool GNU /* = true */, bool Windows /* = true */) {
	usePOSIX = POSIX;
	useGNU = GNU;
	useWindows = Windows;
}

// -----------------------------------------------------------------------------
//
// Parse(...)
//
// --

/*
Some parsing rules (based on POSIX. GNU adds long options. Windows adds '/name:value' styled options):
- Arguments are options if they begin with an Option Prefix.
- Possible Option Prefixes are: '-' (short option; POSIX), '--' (long option; GNU) and '/' (short/long option; WINDOWS).
- Short option names are single alphanumeric characters (isalnum test).
- Long option names are made of alphanumeric characters and dashes. Option names are typically one to three words long, with hyphens to separate words.
- Multiple short options may follow one Option Prefix in a single token if the options do not take arguments. Thus, `-abc' is equivalent to `-a -b -c'.
- Certain options require an argument.
- An option and its argument may or may not appear as separate tokens. (In other words, the whitespace separating them is optional.)
  Thus, `-o foo' and `-ofoo' are equivalent.
- Valid option-argument separators are: (nothing), whitespace, '=', ':'.
- Options typically, but not necessary, precede other non-option arguments.
- A token consisting only of a Option Prefix is interpreted as an ordinary non-option argument.
- Options may be supplied in any order, or appear multiple times. In case the same option is specified multiple times with different arguments, 
  this parser will save only the last argument (going from left to right).
- All non-option tokens shall be saved into a vector of "residue arguments."
*/

#define getNextToken() \
	(++idxToken < argc) ? argv[idxToken] : NULL

#define processNonOptionArgument() \
	residueArguments.push_back(string(token)); \
	token = getNextToken()

bool CmdLineParser::Parse(int argc, char* argv[], bool preserve) {
	// clear (or preserve!) last parse results
	if (!preserve) {
		residueArguments.clear();
		for (vector<string>::iterator iter = values.begin(); iter != values.end(); iter++) 
			*iter = "";
	}

	int idxToken = 0;
	char* token = getNextToken();
	bool inMultipleShortOptions = false;

	while (token) {
		if (!token[0]) {
			// invalid function call; argv[] is probably not system given
			return false;
		}

		//
		// classify token (option or non-option beginning?)
		//

		int pos = 0;
		bool searchShort = false, searchLong = false;

		if ((usePOSIX || useGNU) && token[pos] == '-') {
			pos++;

			if (isalnum(token[pos])) {
				// a short option
				searchShort = true;

			} else if (useGNU && token[pos] == '-') {
				pos++;

				// long option?
				if (isalnum(token[pos])) {
					// yes, it could be a long option
					searchLong = true;

				} else if (!token[pos]) {
					// the case of a double dashes without the option name, '--'
					processNonOptionArgument();
					continue;

				} else {
					// invalid long option format; treat as an syntax error
					return false;
				}

			} else if (!token[pos]) {
				// the case of a single dash without the option name, '-'
				processNonOptionArgument();
				continue;

			} else {
				// invalid long option format; treat as an syntax error
				return false;				
			}

		} else if (useWindows && token[pos] == '/') {
			pos++;
			searchShort = searchLong = true;

		} else if (inMultipleShortOptions) {
			searchShort = true;
			inMultipleShortOptions = false;

		} else {
			// non-option argument (token doesn't begin with '-', '--', or '/' on windows)
			processNonOptionArgument();
			continue;
		}

		//
		// do the search through option names
		//

		map<string,int>::iterator iterOption;
		bool found = false;

		// try to recognize a short option
		if (searchShort) {
			// NOTE: we can not do the hash find() because we don't know what string are we looking for! (we only know the beginning)
			for (iterOption = shortOptions.begin(); iterOption != shortOptions.end() && !found; iterOption++) {
				if (iterOption->first.compare(0, iterOption->first.length(), token+pos, iterOption->first.length()) == 0) {
					found = true;
					break;
				}
			}
		}
		// if short option not found, try to recognize a long option (this can happen only under if user defines 'useWindows' !)
		if (!found && searchLong) {
			for (iterOption = longOptions.begin(); iterOption != longOptions.end() && !found; iterOption++) {
				if (iterOption->first.compare(0, iterOption->first.length(), token+pos, iterOption->first.length()) == 0) {
					found = true;
					break;
				}
			}
		}
		if (!found) {
			// unrecognized option!
			return false;
		}

		// skip option name
		pos += iterOption->first.length();
		
		//
		// read option argument (if it's required)
		//

		// NOTE: in while loop we also handle cases like '-p =pass' and '-p = pass'
		if (valueRequired[iterOption->second]) {
			
			bool reachedValue = false;
			while (1) {
				if (reachedValue) {
					values[iterOption->second] = string(token+pos);
					break;
				}

				if (!token[pos]) {
					// we reached the end of this token, option argument must be in the next token!
					token = getNextToken();
					if (!token) {
						// reached end of command line while trying to read option argument (value)!
						return false;
					}
					pos = 0;

				} else {
					// try to extract option argument from this token

					// for POSIX and GNU, separator can be: nothing, whitespace, '='
					// for Windows,       separator can be: nothing, whitespace, '=', ':'
					if (token[pos] == '=' || useWindows && token[pos] == ':') pos++;
					if (token[pos]) reachedValue = true;
				}

			}

		} else {
			// put something, anything, as a value to indicate switch was specified
			values[iterOption->second] = "1";

			// can we read more options from this token?
			if (token[pos]) {
				inMultipleShortOptions = true;
				token += pos;
				continue;
			}
		}

		token = getNextToken();
	}

	return true;
}

#define addArgument() \
	argv[argc++] = new char[maxlen];

#define removeArgument() \
	delete[] argv[--argc];

#define currentArgument \
	argv[argc-1]

bool CmdLineParser::Parse(const char* line, bool preserve) {
	// allocate memory for tokens buffer
	int maxlen = strlen(line) + 1;
	char** argv = new(nothrow) char*[maxlen + 1];
	if (!argv) return false;
	int argc = 0;
	addArgument();
	currentArgument[0] = 0;

	// split the 'line' into tokens
	/* Splitting rules:
	*   - Whitespace characters are: 0x09 to 0x0D, and 0x20.
	*	- Tokens are [single or multiple] whitespace delimited, except when 
	*     surrounded with double quotation marks. To include the double quotation
	*     mark (`"') in quoted string you must escape it with the backslash character
	*     (`\').
	*   - Beginning and ending option argument quotation marks are removed. Escaped
	*     characters are preserved.
	*   - Under quotes, only quotation mark can be escaped '"' (for all other 
	*     characters, escaping backslash will also be included). 
	*     Otherwise, any character can be escaped.
	*/	
	int tokenPos = 0, linePos = 0;
	bool underQuotes = false;

	addArgument();	

	while (line[linePos]) {

		if (underQuotes) {
			if (line[linePos] == '"') {
				linePos++;
				underQuotes = false;
				continue;
			}

			if (line[linePos] == '\\' && line[linePos+1] == '"')
				linePos++;

		} else {
			if (isspace(line[linePos])) {
				currentArgument[tokenPos] = 0;
				while (isspace(line[++linePos]));
				addArgument();
				tokenPos = 0;
			}

			if (line[linePos] == '\\') {
				linePos++;
			} else {
				if (line[linePos] == '"') {
					underQuotes = true;
					linePos++;
				}
			}

		}

		currentArgument[tokenPos++] = line[linePos++];
	}

	currentArgument[tokenPos] = 0;

	// do the parsing...
	bool retParser = Parse(argc, argv, preserve);

	// free tokens memory
	while (argc) removeArgument();
	delete[] argv;

	return retParser;
}

bool CmdLineParser::Parse(const string& line, bool preserve) {
	return Parse(line.c_str(), preserve);
}

// -----------------------------------------------------------------------------
//
// Read(...)
//
// --

// returns index in values[] for option with 'name', or -1 if option not found.
// looks first in short options, then in long.
int CmdLineParser::getValueIdxFromOptionName(const string& name) {
	map<string,int>::iterator iter;
	if ((iter = shortOptions.find(name)) != shortOptions.end()) {
		return iter->second;
	}
	if ((iter = longOptions.find(name)) != longOptions.end()) {
		return iter->second;
	}
	return -1;
}

// returns: 'true' if option (switch) was found in parsed command line, and
//          'false' if not, or if wasn't even defined as a switch (in which
//          case 'value' argument won't be modified).
bool CmdLineParser::IsSpecified(const string& name) {
	int idx = getValueIdxFromOptionName(name);
	return idx >= 0 && !values[idx].empty();
}

bool CmdLineParser::Read(const string& name, int& value) {
	int idx = getValueIdxFromOptionName(name);
	if (idx >= 0 && !values[idx].empty()) {
		value = atoi(values[idx].c_str());
		return true;
	}
	return false;
}

bool CmdLineParser::Read(const string& name, double& value) {
	int idx = getValueIdxFromOptionName(name);
	if (idx >= 0 && !values[idx].empty()) {
		value = atof(values[idx].c_str());
		return true;
	}
	return false;
}

bool CmdLineParser::Read(const string& name, string& value) {
	int idx = getValueIdxFromOptionName(name);
	if (idx >= 0 && !values[idx].empty()) {
		value = values[idx];
		return true;
	}
	return false;
}

bool CmdLineParser::Read(const string& name, char* value) {
	int idx = getValueIdxFromOptionName(name);
	if (idx >= 0 && !values[idx].empty()) {
		strcpy(value, values[idx].c_str());
		return true;
	}
	return false;
}

// fills 'arguments' with cmd-line "residue" (all non-option arguments) 
// returns: 'true' if there are non-option arguments, or 'false' otherwise.
bool CmdLineParser::NonOptionArgs(vector<string>& arguments) {
	arguments = residueArguments;
	return !residueArguments.empty();
}

// -----------------------------------------------------------------------------
//
// Debug features
//
// --

#include <stdio.h>		// printf

void CmdLineParser::PrintValues() {
	printf("Options with values ([short option name][, long option name] = 'value'):\n");
	for (int idx = values.size()-1; idx >= 0; idx--) {
		// find short and long option name entry for this value (with index 'idx')
		map<string,int>::iterator iterShort, iterLong;
		bool foundShort = false, foundLong = false;
		for (iterShort = shortOptions.begin(); iterShort != shortOptions.end() && !foundShort; iterShort++) {
			if (iterShort->second == idx) {
				foundShort = true;
				break;
			}
		}
		for (iterLong = longOptions.begin(); iterLong != longOptions.end() && !foundLong; iterLong++) {
			if (iterLong->second == idx) {
				foundLong = true;
				break;
			}
		}
		// print option name(s) and value
		if (foundShort || foundLong) {
			printf("   ");
			if (foundShort)
				printf("%s", iterShort->first.c_str());
			if (foundLong)
				printf("%s%s", (foundShort?",":""), iterLong->first.c_str());
			printf(" = '%s'\n", values[idx].c_str());
		} else {
			// ERROR in Define(..) !!!
		}
	}
	printf("Residue/unparsed arguments:\n");
	for (vector<string>::iterator iterArgs = residueArguments.begin(); iterArgs != residueArguments.end(); iterArgs++)
		printf("   '%s'\n", iterArgs->c_str());
}