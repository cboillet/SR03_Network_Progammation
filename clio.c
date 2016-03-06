#include "defobj.h"
#include "iniobj.h"

#define CHAR12 12
#define CHAR24 24

int main(int argc, char* argv[])
{
	socklen_t saddrl_cli;
	socklen_t saddrl_ser;
	struct sockaddr_in saddr_cli;
	struct sockaddr_in saddr_ser;
	struct hostent* hid;
	int sd;

	sd = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
	if (sd == -1){
		perror("socket()");
		exit(-1);	
	}
	else{
		saddrl_cli = sizeof(saddr_cli);
		bzero(&saddr_cli, saddrl_cli); //rempli de 0
		saddr_cli.sin_family = AF_INET;
		//convert values host to network long
		saddr_cli.sin_addr.s_addr = htonl(INADDR_ANY); //done quelle adresse IP du serveur à écouter 
		//num port different que celui du serveur		
		saddr_cli.sin_port = 0;
		int res = bind(sd, (const struct sockaddr*)&saddr_cli, saddrl_cli);

		if (res == -1){
			perror("bind()");
			exit(-1);	
		}

		//récupération des infos du serveur
		saddrl_ser = sizeof(saddr_ser);
		bzero(&saddr_ser, saddrl_ser); //rempli de 0
		saddr_ser.sin_family = AF_INET;
		hid = gethostbyname(argv[1]);
		if(hid==NULL){
			perror("gethostbyname()");
			exit(-1);
		}
		bcopy(hid->h_addr,&(saddr_ser.sin_addr.s_addr),hid->h_length);
		saddr_ser.sin_port = htons(atoi(argv[2]));

		//connexion au serveur
		//netstat -1 check les port utilisés
		int connection = connect(sd, (struct sockaddr*)&saddr_ser, saddrl_ser);
		if(connection == -1){
			perror("connect()");
			exit(-1);	
		}

		//données à envoyer
		obj** tab = malloc(sizeof(obj)*tablen);
		initObj(tab);
		int i=0; 
		char nbr='9'; //limité à un caractère, donc 9 maxi si on garde ce protocole
		
		//envoi du paramètre
		if (send(sd, &nbr, 1, 0) != 1){
			perror("send() param");
			exit(-1);	
		}
		
		//envoi des données
		//while(tab[i]->iqt!=-1){
		while(i < 9){ //temporaire
			if (send(sd, tab[i]->char_12, CHAR12, 0) != CHAR12){
				perror("send()");
				exit(-1);	
			}
			sleep(1); //bizarre, mais sinon le serveur perd des données
			if (send(sd, tab[i]->char_24, CHAR24, 0) != CHAR24){
				perror("send()");
				exit(-1);	
			}
			sleep(1);
			i++;
		}
		close(sd);		
	}
	return 0;
}
