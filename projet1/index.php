<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<title>Trombinoscope SR03</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript">
		function controle(form) {
			var prenom = form.prenom.value;
			var nom = form.nom.value;
			if (!prenom || !nom)
				alert("c'est pas bien");
		}
	</script>
</head>

<header>
	<form name="formulaire" action="index.php" method="post">
		<div class="col-md-4">
			<input class="form-control" type="text" name="prenom" placeholder="Prénom" value="<?php if ($_POST['prenom']) echo $_POST['prenom']; ?>"/>
			<input class="form-control" type="text" name="nom" placeholder="Nom" value="<?php if ($_POST['nom']) echo $_POST['nom']; ?>"/> <br/>
		<input class="btn btn-default" type="submit" value="chercher" onClick="controle(formulaire)"/>
		</div>
		
	</form>
</header>

<body>
<?php
	include'utils.php';
	if ($_POST["prenom"] && $_POST["nom"])
	{
		$content = file_get_contents('https://webapplis.utc.fr/Trombi_ws/mytrombi/result?nom='.$_POST["nom"].'&prenom='.$_POST["prenom"]);		
		$result = json_decode($content);

		foreach ($result as $r) {
		    	$urlPhoto = "https://demeter.utc.fr/portal/pls/portal30/portal30.get_photo_utilisateur_mini?username=".$r->login;
			echo "<div>";
				if(checkRemoteFile($urlPhoto) == FALSE)	{
					echo '<img src="https://www.123comparer.fr/images/no-image.jpg"/>';
				}
				else {
					echo '<img src="'.$urlPhoto.'" />';
				}
				echo "<br/>".$r->nom;
			echo "</div>";
		}	
	}
?>
</body>
</html>
