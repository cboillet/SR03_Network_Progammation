#include "defobj.h"

#define CHAR12 12
#define CHAR24 24


int* status;

void receive_string(int sd_cli, int size){
	char buf[size];
	int totalBytesRcvd = 0;
	int bytesRcvd = 0;
	while (totalBytesRcvd < size)
	{
		if ((bytesRcvd = recv(sd_cli, buf, size-1, 0)) <= 0){
			printf("problem ici\n");
			exit(-1);
		}

		totalBytesRcvd += bytesRcvd;
		buf[bytesRcvd] = '\0';
		printf("%s\n", buf);
	}
}

int receive_param(int sd_cli){
	int param;
	char buf[1];
	int totalBytesRcvd = 0;
	int bytesRcvd = 0;
	if ((bytesRcvd = recv(sd_cli, buf, sizeof(int), 0)) <= 0){
			printf("problem\n");
			exit(-1);
	}

	totalBytesRcvd += bytesRcvd;
	buf[bytesRcvd] = '\0';
	printf("%s\n", buf);
	return (buf[0]-'0');
}

int main(int argc, char* argv[])
{
	socklen_t saddrl_cli;
	socklen_t saddrl_ser;
	struct sockaddr_in saddr_cli;
	struct sockaddr_in saddr_ser;
	int sd;

	sd = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
	if (sd == -1){
		perror("socket()");
		exit(-1);	
	}
	else{
		saddrl_ser = sizeof(saddr_ser);
		bzero(&saddr_ser, saddrl_ser); //rempli de 0
		saddr_ser.sin_family = AF_INET;
		//convert values host to network long
		saddr_ser.sin_addr.s_addr = htonl(INADDR_ANY); //done quelle adresse IP du serveur à écouter 		
		saddr_ser.sin_port = htons(atoi(argv[1]));
		int res = bind(sd, (const struct sockaddr*)&saddr_ser, saddrl_ser);

		if (res == -1){
			perror("bind()");
			exit(-1);	
		}
		int lis = listen(sd, SOMAXCONN);

		while (1)
		{
			saddrl_cli = sizeof(saddr_cli);
			int sd_cli;
			if ((sd_cli = accept(sd, (struct sockaddr *)&saddr_cli, &saddrl_cli)) < 0){
				perror("accept()");
				exit(-1);	
			}
		
			int pid;
			if ((pid = fork()) == -1)
			{
				perror("fork()");
				exit(-1);
			}
			else if (pid == 0) //fils
			{
				/*protocole: recoit le nombre d'éléments en premier paramètre puis recoit tous les éléments*/				
				int nbel = receive_param(sd_cli);				
				while(nbel>0){
				receive_string(sd_cli, CHAR12);
				receive_string(sd_cli, CHAR24);
				nbel--;				
				}
			}
			else //père
			{
				waitpid(pid, status, 0);
			}
		}
	}
	return 0;
}
