#include "defobj.h"
#define tablen 10


void initObj(obj** tableau_obj){	
	int i;
	for(i=0; i<tablen; i++){
		tableau_obj[i] = malloc(sizeof(obj));		

		memset(tableau_obj[i]->char_12, '\0', sizeof(char)*12);
		strcpy(tableau_obj[i]->char_12, "ident_o");
		char c = i + '0';
		strcat(tableau_obj[i]->char_12,&c);
		
		memset(tableau_obj[i]->char_24, '\0', sizeof(char)*24);
		strcpy(tableau_obj[i]->char_24, "description_o");
		strcat(tableau_obj[i]->char_24,&c);

		tableau_obj[i]->ii=10*i+1;
		tableau_obj[i]->jj=10*i+2;
		tableau_obj[i]->dd=10*i+0.2345;
		tableau_obj[i]->iqt=-1*(i==tablen-1);
	}
}


