#include "defobj.h"

int* status;

int main(int argc, char* argv[])
{
	socklen_t saddrl;
	struct sockaddr_in saddr;
	int sd;

	sd = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
	if (sd == -1){
		perror("socket()");
		exit(-1);	
	}
	else{
		saddrl = sizeof(saddr);
		bzero(&saddr, saddrl); //rempli de 0
		saddr.sin_family = AF_INET;
		//convert values host to network long
		saddr.sin_addr.s_addr = htonl(INADDR_ANY); //done quelle adresse IP du serveur à écouter 		
		saddr.sin_port = htons(atoi(argv[1]));
		int res = bind(sd, (const struct sockaddr*)&saddr, saddrl);

		if (res == -1){
			perror("bind()");
			exit(-1);	
		}
		int lis = listen(sd, SOMAXCONN);

		while (1)
		{
			accept(sd, (struct sockaddr*)0, 0); //qd qql se c onnect au socket, débloque accepte

			int pid;
			if ((pid = fork()) == -1)
			{
				perror("fork()");
				exit(-1);
			}
			else if (pid == 0) //fils
			{
				obj* buf;
				recv(sd, buf, sizeof(obj), 0);
				printf("%s\n", buf->char_12);
			}
			else //père
			{
				waitpid(pid, status, 0);
			}
		}
	}
	return 0;
}
