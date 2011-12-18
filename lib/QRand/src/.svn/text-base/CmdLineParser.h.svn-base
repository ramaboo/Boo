#pragma once

#include <string>
#include <vector>
#include <map>
using namespace std;

/******************************************************************************
 * Command-Line (Lightweight) Parser.
 *
 * The CmdLineParser follows the POSIX program command line argument syntax 
 * recommendations, with few exceptions. Namely, standard Linux long options
 * ('--long-option-name=value') are supported, together with standard 
 * Windows switch syntax ('/option:value').
 *
 * Class usage:
 *  1) call Define(...) as many times as you need to specify all command 
 *     line options. All calls are cumulative.
 *  2) call Parse("command line string") to parse arbitraty command line
 *  3) use Read(...) to check for existance of options specified in the 
 *     cmd-line, or to read its values
 * All of these functions return 'true' on success and 'false' on failure.
 *
 * Written by Radomir Stevanovic during May/June 2007.
 * Copyright (C) 2007 Radomir Stevanovic and Rudjer Boskovic Institute, 
 * Zagreb, Croatia.
 **/

/* TODO: 
 *  - add a long option-specific possibility to have optional value 
 *    (e.g. --out[="optional-filename"])
 * 
 *
 */
class CmdLineParser {
public:
	// short & long name pair used to define one option
	// (at least ONE must be specified, other can be an empty string)
	typedef struct {
		string ShortName;
		string LongName;
		bool valueRequired;
	} OptPair;

	CmdLineParser();
	~CmdLineParser();

	// adds a definition for one option/switch (long form, short form, or combined)
	// during CmdLineParser object lifetime, these options are cumulative
	bool Define(const string& LongName, bool valueRequired = false);
	bool Define(const string& ShortName, const string& LongName = "", bool valueRequired = false);
	bool Define(OptPair options[], size_t n);
	// defines whether switches can begin with: '-', '--', and '/', respectively
	void DefineConvention(bool POSIX = true, bool GNU = true, bool Windows = true);

	// Parses the command line according to option (switch) definitions.
	// Argument values can be read with Read() function. You can preserve
	// previously parsed values with 'preserve' == 'true'.
	bool Parse(const string& line, bool preserve = false);
	bool Parse(const char* line, bool preserve = false);
	bool Parse(int argc, char* argv[], bool preserve = false);
	
	// tests for switch presence or reads parameter/option value
	// returns 'false' if option not defined, or not specified
	bool IsSpecified(const string& name);
	bool Read(const string& name, int& value);
	bool Read(const string& name, double& value);
	bool Read(const string& name, string& value);
	bool Read(const string& name, char* value);
	// fills 'arguments' with cmd-line "residue" (all non-option arguments) 
	// returns: 'true' if there are non-option arguments, or 'false' otherwise.
	bool NonOptionArgs(vector<string>& arguments);

	// debug feature
	void PrintValues();

private:
	vector<string> values;				// option/switch value
	vector<bool> valueRequired;			// does option/switch require an argument (value)?
	typedef pair<string,int> OptKeyVal;
	map<string,int> shortOptions;		// short option/switch names
	map<string,int> longOptions;		// long options/switch names
	vector<string> residueArguments;	// arguments not parsed as options/switches (aka non-option arguments)
	bool usePOSIX, useGNU, useWindows;	// defines whether switches can begin with: '-', '--', and '/', respectively

private:
	int getValueIdxFromOptionName(const string& name);
};