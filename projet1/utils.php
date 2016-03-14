
<?php
function checkRemoteFile($url)
{
	$res=getimagesize($url);
	return is_array($res);
}

function Visit($url){
       $ch=curl_init();
       curl_setopt ($ch, CURLOPT_URL,$url);
       curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt ($ch,CURLOPT_VERBOSE,true);
       curl_setopt($ch, CURLOPT_TIMEOUT, 5);
       curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
       $page=curl_exec($ch);
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       curl_close($ch);
 	if($httpcode>=200 && $httpcode<300) return true;
	else{	
		echo "<br/> error code ".$httpcode;
		switch($httpcode){
			case 301: echo " : redirection permanente";
				break;
			case 302: echo " : redirection temporaire";
				break;
			case 401: echo " : utilisateur non authentifié";
				break;
			case 403: echo " : accès refusé";
				break;
			case 404: echo " : page introuvable";
				break;
			case 500: echo " : erreur serveur";
				break;
			case 503: echo " : erreur serveur";
				break;
		}
		return false;
      	}
}
?>





