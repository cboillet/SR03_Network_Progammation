
<?php
function printProfile($r, $i)
{
	$urlPhoto = "https://demeter.utc.fr/portal/pls/portal30/portal30.get_photo_utilisateur_mini?username=".$r->login;
	if(checkRemoteFile($urlPhoto) == FALSE)
		$urlPhoto = "default.png";

	echo '<div class="col-md-3 col-md-offset-1 div_result">';
		//nom + photo
		echo '<div style="text-align: center;">';
			echo '<strong>'.$r->nom.'</strong><br/>';						
			echo '<img src="'.$urlPhoto.'" class="img-rounded"/>';
		echo '</div><br/>';

		//informations complémentaires
		$tel = getTel($r);
		if ($tel != "")
			echo '<span class="glyphicon glyphicon-earphone"></span> '.$tel.'<br/>';
		if ($r->structure != "")
			echo '<strong>'.$r->structure.'</strong></br>';
		if ($r->sousStructure != "")
			echo '<em>'.$r->sousStructure.'</em></br>';
		if ($r->poste != "")
			echo $r->poste.'<br/>';
		if ($r->mail != "")
			echo '<span class="glyphicon glyphicon-envelope"></span> <a href="mailto:'.$r->mail.'">'.$r->mail.'</A>';
	echo "</div>";
}

function getTel($r)
{
	$tel = ($r->tel != "")? $r->tel : "";
	if ($r->tel2 != "")
	{
		if ($tel != "")
			$tel = $tel." / ";
		$tel = $tel.$r->tel2;
	}
	return $tel;
}

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





