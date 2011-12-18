/******************************************************************************
 *
 * QRBG Command-Line Utility.
 *
 * Designed, written and (c) by Radomir Stevanovic, Jul/2007.
 * Developed in Rudjer Boskovic Institute, Zagreb, Croatia.
 * Last revision: 2007-07-17
 * Version: 0.2 (tested and updated 0.1 alpha version)
 *
 */

#include <stdio.h>		// printf
#include <stdlib.h>		// atoi
#include <string>
#include <sstream>
#include <iostream>
#include <set>
#include "QRBG.h"
#include "CmdLineParser.h"

using namespace std;

// the default options
#define SERVER		QRBG_SERVICE_DEFAULT_HOSTNAME
#define PORT		QRBG_SERVICE_DEFAULT_PORT
#define SEPARATOR	"\n"
#define FMT_INT		"%d"
#define FMT_LONGLONG "%I64d"
#define FMT_FLOAT	"%.7f"
#define FMT_DOUBLE	"%.14f"
#define MAIL		"stevie@irb.hr"
#define INPUT		"qrbg.ini"

// help
#define STRING(NUMBER) #NUMBER
#define HELP_FORMAT \
	"Retrieves a specified amount of random data from Quantum Random Bit Generator\n" \
	"Internet Service and outputs it into a specified file (stream).\n" \
	"\n" \
	"Usage %s [options] [config-file]\n" \
	"\n" \
	"Connect options: \n" \
	"  -u, --user=USERNAME       valid username for the QRBG service. Required.\n" \
	"  -p, --pass=PASSWORD       valid password for the QRBG service. Required.\n" \
	"  -h, --host=ADDRESS        QRBG service server's address (hostname). If not \n" \
	"                            specified, the default address (" SERVER ")\n" \
	"                            will be used.\n" \
	"  -n, --port=PORT           QRBG service port number. If not specified, the \n" \
	"                            default port (" STRING(PORT) ") will be used.\n" \
	"\n" \
	"Data type options: \n" \
	"  -t, --type={              defines the type of data requested: \n" \
	"    b | byte | int8 |        > bytes, \n" \
	"    s | shortint | int16 |   > short integers, \n" \
	"    i | int | int32 |        > integers, \n" \
	"    l | longlong | int64 |   > 64-bit long integers, \n" \
	"    f | float | float32 |    > single-precision real from [0, 1)\n" \
	"    d | double | float64     > double-precision real from [0, 1)\n" \
	"   }                        Defaults to: byte.\n" \
	"\n" \
	"  -c, -N, --count, --N=K    defines the number of elements requested with \n" \
	"                            the specified data type. \n" \
	"\n" \
	"I/O options: \n" \
	"  [config-file]             input file that contains one line with options.\n" \
	"                            If not specified, default is: '" INPUT "'.\n" \
	"  -x, --text                outputs one number per line in a file [default]\n" \
	"  -y, --binary              outputs binary stream of downloaded data \n" \
	"                            (and formatted according to data type specified) \n" \
	"  -f, --format=FORMAT       a printf-compatible format string used to print \n" \
	"                            data in text mode. Defaults to \"%" FMT_INT "\" for \n" \
	"                            integers, and \"%" FMT_FLOAT " \" for floating-point numbers. \n" \
	"  -s, --separator=SEPARATOR data delimiter sequence in text output mode. \n" \
	"                            Defaults to: new line sequence. \n" \
	"  -o, --out=FILE            output file. If not specified, default is: stdout.\n" \
	"\n" \
	"General: \n" \
	"  --help                    displays this help screen.\n" \
	"\n" \
	"Written by Radomir Stevanovic, on Jul/2007.\n" \
	"Copyright(c) Rudjer Boskovic Institute, Zagreb, Croatia.\n" \
	"\n" \
	"Register and download additional software at: http://" SERVER "/. \n" \
	"Send suggestions and bug reports to: " MAIL ".\n" \
	"\n"

void help(char* appName) {
	printf(HELP_FORMAT, appName);
}

// data amount SI units in increments of 1024 times (from 1e0 to 1e24)
const char* sizeUnit[] = {"B", "KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"};
string prettySize(double nBytes) {
	double number = nBytes;
	int inc;
	for (inc = 0; number >= 1024.0; number /= 1024.0, inc++);

	stringstream ss;
	ss.precision(3);
	ss << number << " " << sizeUnit[inc];
	return ss.str();
}

/******************************************************************************
 *
 * Parse and store command-line options specific for the QRBG Command-Line 
 * Client Tool. Written specifically for this (lightweight specific validation 
 * wrapped around universal CmdLineParser class), with no reusability in mind.
 *
 */
class Options {
public:
	enum DataTypes { tINT8, tINT16, tINT32, tINT64, tFLOAT32, tFLOAT64 };
	enum OutputModes { modeBinary, modeText };

	//
	// The options used in our QRBG command-line client utility 
	//
	string username;
	string password;
	string hostname;
	int port;
	int count;
	DataTypes type;	
	int typeSize; // == sizeof(type)
	OutputModes outputMode;
	string outputFilename;	// temp, until Validate()-ed
	FILE* outputFile;
	bool help;

	// formatting options
	string columnSeparator;
	string dataFormat;		// formatting string for printf(..) if outputMode is text

public:
	Options();
	~Options();

	// resets all member variables holding user-specified options to the default values
	void Reset();
	// parse program command line (and options configuration file) into (private) CmdLineParser object,
	// and then store those options into (public) member variables, validating them in the end
	bool ParseCmdLine(int argc, char* argv[]);

private:
	// parse the specified configuration file, storing options values into member variables
	bool ParseConfigFile(string filename, bool validate = true);

	// store (copy over) user defined options from CmdLineParser object into object's member vars
	void Store(CmdLineParser& cmdline);
	// validate the options stored in object member variables
	bool Validate();
	CmdLineParser cmdline_prototype;
	set<string> parsedConfigFiles;
};

// resets all member variables holding user-specified options to the default values
void Options::Reset() {
	username = password = "";
	hostname = SERVER;
	port = PORT;
	type = tINT8;
	typeSize = sizeof(byte);
	count = 1;
	outputMode = modeText;
	outputFilename = "";
	if (outputFile) fclose(outputFile);
	outputFile = NULL;
	help = false;
	columnSeparator = SEPARATOR;
	dataFormat = FMT_INT;
	parsedConfigFiles.clear();
}

Options::Options() : outputFile(NULL) {
	// command line options/switches definition
	CmdLineParser::OptPair options[] = {
		{"u", "user", true}, {"p", "pass", true}, {"h", "host", true}, {"n", "port", true},
		{"t", "type", true},
		{"c", "count", true}, {"N", "N", true},
		{"x", "text", false}, {"y", "binary", false},
		{"f", "format", true}, {"s", "separator", true},
		{"o", "out", true},
		{"?", "help", false}
	};

	// accept: POSIX, GNU & Windows command line format conventions!
	cmdline_prototype.DefineConvention(true, true, true);
	if (!cmdline_prototype.Define(options, sizeof(options)/sizeof(options[0]))) {
		// internal error! (double definition of a single option!)
		throw "Failed to define command line options!";
	}

	// set all options to its defaults
	Reset();
}

Options::~Options() {
	if (outputFile) fclose(outputFile);
}

// Parses the command line given in a form the main() function received it.
// Returns: success?
// On success, public member variables shall contain interpreted 
// (validated) program parameters.
bool Options::ParseCmdLine(int argc, char* argv[]) {
	// zeroth, ensure fallback to the defaults..
	Reset();

	// first, try to read options from the default configuration file..
	FILE* in = fopen(INPUT, "r");
	if (in) {
		fclose(in);
		ParseConfigFile(INPUT, false);
	}

	// than, update those options with options from command-line..
	// ..and user-specified config files..
	CmdLineParser cmdline = cmdline_prototype;
	if (!cmdline.Parse(argc, argv)) {
		fprintf(stderr, "Command line syntax error!\n");
		fprintf(stderr, "Type '%s --help' for more information. \n", argv[0]);
		return false;
	}
	Store(cmdline);

	// at last, validate all stored options..
	return Validate();
}

// Parses options specified in the first line of the file with 'filename'.
// Returns: success?
// On success, public member variables shall contain interpreted program
// parameters.
bool Options::ParseConfigFile(string filename, bool validate /* = true */) {
	// avoid endless recursion!
	//printf("Parsing: '%s'...\n", filename.c_str());
	if (parsedConfigFiles.find(filename) != parsedConfigFiles.end()) {
		fprintf(stderr, "Cyclic list of configuration files is not allowed!\nStopping at file named: '%s'.\n", filename.c_str());
		return true;
	}

	const int MAX_LINE_LEN = 1024;
	char line[MAX_LINE_LEN+1] = {0};

	FILE* in = fopen(filename.c_str(), "r+t");
	if (!in) {
		fprintf(stderr, "Failed to open config file named: '%s'.\n", filename.c_str());
		return false;
	}
	fgets(line, MAX_LINE_LEN, in);
	fclose(in);

	// add this file to read config files set
	parsedConfigFiles.insert(filename);

	CmdLineParser cmdline = cmdline_prototype;
	if (!cmdline.Parse(line, true)) {
		fprintf(stderr, "Syntax error in config file: '%s'. \n", filename.c_str());
		return false;
	}
	Store(cmdline);

	return validate ? Validate() : true;
}

// Interprets the parsed command line and copies options that were defined into
// object member variables. After parsing all user option-definition streams, 
// these options must be validated with "Validate(..)".
// "Store(..)" acts in cumulative manner, i.e. preserves options already defined,
// if 'cmdline' doesn't redefine those options.
// Returns: success?
void Options::Store(CmdLineParser& cmdline) {
	// store options from additional configuration file (if any)
	vector<string> args;
	if (cmdline.NonOptionArgs(args)) {
		// take first non-option argument as a config filename
		ParseConfigFile(args[0], false);
	}

	help |= cmdline.IsSpecified("help");

	cmdline.IsSpecified("user") && cmdline.Read("user", username);
	cmdline.IsSpecified("pass") && cmdline.Read("pass", password);
	cmdline.IsSpecified("host") && cmdline.Read("host", hostname);
	cmdline.IsSpecified("port") && cmdline.Read("port", port);

	if (cmdline.IsSpecified("type")) {
		bool redefinition = true;

		string t;
		cmdline.Read("type", t);
		if (t == "d" || t == "double" || t == "float64")
			type = tFLOAT64, typeSize = sizeof(double);
		else if (t == "f" || t == "float" || t == "float32")
			type = tFLOAT32, typeSize = sizeof(float);
		else if (t == "l" || t == "longlong" || t == "int64")
			type = tINT64, typeSize = sizeof(int64);
		else if (t == "i" || t == "int" || t == "int32")
			type = tINT32, typeSize = sizeof(int32);
		else if (t == "s" || t == "shortint" || t == "int16")
			type = tINT16, typeSize = sizeof(int16);
		else if (t == "b" || t == "byte" || t == "int8")
			type = tINT8, typeSize = sizeof(int8);
		else {
			// do nothing! leave current type
			redefinition = false;
		}

		if (redefinition) {
			dataFormat = type == tFLOAT64 ? FMT_DOUBLE : ( type == tFLOAT32 ? FMT_FLOAT : (type == tINT64 ? FMT_LONGLONG : FMT_INT) );
		}
	}

	(cmdline.IsSpecified("count") || cmdline.IsSpecified("N")) && (cmdline.Read("count", count) || cmdline.Read("N", count));

	cmdline.IsSpecified("binary") && (outputMode = modeBinary);
	cmdline.IsSpecified("text") && (outputMode = modeText);
	cmdline.IsSpecified("separator") && cmdline.Read("separator", columnSeparator);	
	cmdline.IsSpecified("format") && cmdline.Read("format", dataFormat);

	cmdline.IsSpecified("out") && cmdline.Read("out", outputFilename);

}

// Interprets the parsed command line. On success, public member variables 
// shall contain valid, user-specified, options values.
// Returns: success?
bool Options::Validate() {
	if (help)
		return true;

	if (username.length() < 1) {
		fprintf(stderr, "You MUST specify the username. See help for details. \n");
		return false;
	}
	if (password.length() < 1) {
		fprintf(stderr, "You MUST specify the password. See help for details. \n");
		return false;
	}
	// if following are not user-defined, use the default values
	if (hostname.length() < 1) hostname = SERVER;
	if (port < 1024 || port > 0xFFFF) {
		port = PORT;
		fprintf(stderr, "Specified port is out of range [1024, 65535]. Using default: %d.\n", port);
	}

	// amount of data requested
	if (count < 1) {
		fprintf(stderr, "You SHOULD request at least one random number. \n");
		return false;
	}

	// type and output mode are enums, and therefore always valid
	// typeSize coupled with type, changed privately
	
	// dataFormat and columnSeparator are currently NOT thoroughly validated
	if (dataFormat.length() < 2) {
		dataFormat = type == tFLOAT64 ? FMT_DOUBLE : ( type == tFLOAT32 ? FMT_FLOAT : (type == tINT64 ? FMT_LONGLONG : FMT_INT) );
		fprintf(stderr, "Invalid data format specified. Using default: \"%s\". \n", dataFormat.c_str());
	}
	if (columnSeparator.length() < 1) {
		columnSeparator = SEPARATOR;
		fprintf(stderr, "Invalid column separator specified. Using default: \"%s\". \n", columnSeparator.c_str());
	}

	// output destination: stdout or an user-specified-file?
	if (outputFilename.length() > 0) {
		if (outputFile) fclose(outputFile);
		outputFile = fopen(outputFilename.c_str(), outputMode == modeBinary ? "wb" : "wt");
		if (!outputFile) {
			fprintf(stderr, "Failed to open output file named: '%s'. \n", outputFilename.c_str());
			return false;
		}
	} else
		outputFile = stdout;

	return true;
}

template<class T>
bool printAsBinaryBlock(T* buffer, size_t count, FILE* stream) {
	size_t size = sizeof(buffer[0]);
	return fwrite((void*)buffer, size, count, stream) == count;
}

template<class T>
bool printAsBinaryElements(T* buffer, size_t count, FILE* stream) {
	size_t size = sizeof(buffer[0]);
	size_t i;
	for (i = 0; i < count && fwrite((void*)(buffer+i), size, 1, stream) == 1; i++);
	return i == count;
}

// WARNING/TODO: security issue with statements: fprintf(stream, format/separator...)!
// To avoid it, special case should be handled (like \t, \n, etc. for separator) and
// used secure calling syntax: fprintf(stream, "%s", separator...).
template<class T> 
bool printAsTextElements(T* buffer, size_t count, const char* format, const char* separator, bool first, FILE* stream) {
	size_t size = sizeof(buffer[0]);
	size_t i;
	// printing of the first element is a special case..
	if (count > 0) {
		if (!first) fprintf(stream, separator);
		if (!fprintf(stream, format, buffer[0])) return false;
	}
	for (i = 1; i < count && (fprintf(stream, separator), fprintf(stream, format, buffer[i])) > 0; i++);
	return i == count;
}


// 
// Serves the user request for data.
// Assumes options in opt object are valid!
// Returns: success?
//
bool serve(Options& opt) {
	if (opt.count < 1) return false;

	// create the service access object
	QRBG* rndService;
	try {
		// set qrbg cache to the minimal possible size
		rndService = new QRBG(1);
	} catch (QRBG::NetworkSubsystemError) {
		fprintf(stderr, "Network error! \n");
		return false;
	} catch (...) {
		fprintf(stderr, "Failed to create QRBG client object! \n");
		return false;
	}

	// connect to the service
	try {
		rndService->defineServer(opt.hostname.c_str(), opt.port);
	} catch (QRBG::InvalidArgumentError e) {
		fprintf(stderr, "Invalid hostname/port! \n");
		delete rndService;
		return false;
	}
	try {
		rndService->defineUser(opt.username.c_str(), opt.password.c_str());
	} catch (QRBG::InvalidArgumentError e) {
		fprintf(stderr, "Invalid username/password! \n");
		delete rndService;
		return false;
	}

	// download preparation

	// buffer max size
	const size_t bufferSizeMax = 20 * 1024 * 1024;
	size_t bufferCountMax = bufferSizeMax / opt.typeSize;

	// total requested data
	size_t totalCount = opt.count;

	// served to user so far and elements left to serve (download)
	size_t downloadedCount = 0;
	size_t toDownloadCount = totalCount;

	// real buffer size
	size_t bufferCount = min(totalCount, bufferCountMax);
	
	byte* buffer = new(nothrow) byte[bufferCount * opt.typeSize];
	if (!buffer) {
		fprintf(stderr, "Failed to allocate memory! \n");
		delete rndService;
		return false;
	}

	// timer
	double dt = 0.0;

	// data download
	try {
		bool failedToPrint = false;
		bool first = true;
		while ( (toDownloadCount = totalCount - downloadedCount) > 0 && !failedToPrint) {
			// limit the amount of data to download in this iteration to the maximal buffer size!
			toDownloadCount = min(toDownloadCount, bufferCount);

			// download appropriate data type and print it as user requested
			size_t count;
			switch (opt.type) {
				case Options::tINT8:
					count = rndService->getBytes(buffer, toDownloadCount);
					if (opt.outputMode == Options::modeBinary)
						failedToPrint = !printAsBinaryBlock<byte>(buffer, count, opt.outputFile);
					else
						failedToPrint = !printAsTextElements<byte>(buffer, count, opt.dataFormat.c_str(), opt.columnSeparator.c_str(), first, opt.outputFile);
					break;

				case Options::tINT16:
					count = rndService->getInt16s((int16*)buffer, toDownloadCount);
					if (opt.outputMode == Options::modeBinary)
						failedToPrint = !printAsBinaryBlock<int16>((int16*)buffer, count, opt.outputFile);
					else
						failedToPrint = !printAsTextElements<int16>((int16*)buffer, count, opt.dataFormat.c_str(), opt.columnSeparator.c_str(), first, opt.outputFile);
					break;

				case Options::tINT32:
					count = rndService->getLongInts((long*)buffer, toDownloadCount);
					if (opt.outputMode == Options::modeBinary)
						failedToPrint = !printAsBinaryBlock<long>((long*)buffer, count, opt.outputFile);
					else
						failedToPrint = !printAsTextElements<long>((long*)buffer, count, opt.dataFormat.c_str(), opt.columnSeparator.c_str(), first, opt.outputFile);
					break;

				case Options::tINT64:
					count = rndService->getInt64s((int64*)buffer, toDownloadCount);
					if (opt.outputMode == Options::modeBinary)
						failedToPrint = !printAsBinaryBlock<int64>((int64*)buffer, count, opt.outputFile);
					else
						failedToPrint = !printAsTextElements<int64>((int64*)buffer, count, opt.dataFormat.c_str(), opt.columnSeparator.c_str(), first, opt.outputFile);
					break;

				case Options::tFLOAT32:
					count = rndService->getFloats((float*)buffer, toDownloadCount);
					if (opt.outputMode == Options::modeBinary)
						failedToPrint = !printAsBinaryBlock<float>((float*)buffer, count, opt.outputFile);
					else
						failedToPrint = !printAsTextElements<float>((float*)buffer, count, opt.dataFormat.c_str(), opt.columnSeparator.c_str(), first, opt.outputFile);
					break;

				case Options::tFLOAT64:
					count = rndService->getDoubles((double*)buffer, toDownloadCount);
					if (opt.outputMode == Options::modeBinary)
						failedToPrint = !printAsBinaryBlock<double>((double*)buffer, count, opt.outputFile);
					else
						failedToPrint = !printAsTextElements<double>((double*)buffer, count, opt.dataFormat.c_str(), opt.columnSeparator.c_str(), first, opt.outputFile);
					break;

				default:
					fprintf(stderr, "Internal error. \n");
					failedToPrint = true;
					break;

			}
			downloadedCount += count;
			dt += rndService->getLastDownloadDuration();
			first = false;
		}

	} catch (QRBG::ConnectError e) {
		fprintf(stderr, "Service connect error! \n");
	} catch (QRBG::CommunicationError e) {
		fprintf(stderr, "Service communication error! \n");
	} catch (QRBG::ServiceDenied e) {
		fprintf(stderr, "Service denied! \n", e.ServerResponse, e.RefusalReason);
		fprintf(stderr, "--> %s! (%s.) \n", e.why(), e.cure());
	}

	size_t ds = downloadedCount * opt.typeSize;
#ifdef PLATFORM_WIN
	fprintf(stderr, "\n");
#endif
	fprintf(stderr, "Downloaded and saved %s (%.2f%% of requested) in %.3f sec (%.3f MiB/s). \n"
		, prettySize(ds).c_str(), (double)downloadedCount / totalCount * 100, dt, ds > 0 ? ds / dt / 1024.0 / 1024.0 : 0);

	// release resources
	if (buffer) delete[] buffer;
	delete rndService;

	return true;
}


int main(int argc, char* argv[]) {
	// the program will return something from this set:
	enum MainReturnCodes {OK = 0, PARSE_ERR = 1, SERVE_ERR = 2};

	Options opt;

	if (!opt.ParseCmdLine(argc, argv))
		return PARSE_ERR;

	if (opt.help) {
		help(argv[0]);
		return OK;
	}

	return serve(opt) ? OK : SERVE_ERR;
}
