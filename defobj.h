#ifndef defobj_H
#define defobj_H
	
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <sys/wait.h>  
#include <stdio.h>
#include <stdlib.h>
#include <strings.h>
#include <string.h>
#include <errno.h>
#include <unistd.h>
#include <netdb.h>
#include <sys/wait.h> 


typedef struct { 
	char char_12[12];
	char char_24[24];
	int ii;
	int jj;
	double dd;
	int iqt;
} obj;

#endif
