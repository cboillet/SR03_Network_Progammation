<?php
	include "utils.php";
	$url = "https://webapplis.utc.fr/Trombi_ws/mytrombi/structfils?lid=".$_POST["IdStructure"];
	if(Visit($url)){
		//récupération des infos
		$content = file_get_contents($url);		
		$result = json_decode($content);
		echo '<option value="0">Toutes les sous-structures</option>';
		foreach ($result as $r) {
			echo '<option value="'.$r->structure->structId.'">'.$r->structureLibelle.'</option>';							
		}
	}
?>

