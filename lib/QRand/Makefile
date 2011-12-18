SHELL = /bin/sh
CC = g++
CFLAGS = -w
ALL_CFLAGS = -Wall -O6 $(CFLAGS)

OBJS = 
LIBS = QRBG.cpp CmdLineParser.cpp main.cpp
EXE = qrand

%.o : %.c Makefile
	$(CC) $(ALL_CFLAGS) -c $< -o $@

all: $(EXE)

$(EXE): $(OBJS) Makefile
	$(CC) $(ALL_CFLAGS) $(OBJS) -o $(EXE) $(LIBS)

.PHONY : clean
clean:
	rm -f $(OBJS) $(EXE)