<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trombinoscope SR03</title>
	
	<!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
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
</header>

<body style="padding-top:70px;">
	<!-- La NavBar -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#to-be-collabsed" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">TrombiUTC</a>
			</div>
			<div class="collapse navbar-collapse" id="to-be-collabsed">
				<form class="navbar-form navbar-right" name="formulaire" action="index.php" method="post" >
					<div class="form-group">
						<label for="prenom" class="control-label">Prénom</label>
						<input class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?php if ($_POST['prenom']) echo $_POST['prenom']; ?>"/>
					</div>
					<div class="form-group">
						<label for="nom" class="control-label">Nom</label>
						<input class="form-control" type="text" name="nom" id="nom" placeholder="Nom" value="<?php if ($_POST['nom']) echo $_POST['nom']; ?>"/>
					</div>
					<div class="form-group">
						<button class="btn btn-default" type="submit" onClick="controle(formulaire)">chercher</button>
					</div>
				</form>
			</div>
		</div>
	</nav>

	<!-- L'affichage des résultats -->
	<?php
		include'utils.php';
		if ($_POST["prenom"] && $_POST["nom"])
		{
			//récupération des infos
			$content = file_get_contents('https://webapplis.utc.fr/Trombi_ws/mytrombi/result?nom='.$_POST["nom"].'&prenom='.$_POST["prenom"]);		
			$result = json_decode($content);
			
			//affichage des données
			echo '<div class="container"> <div class="jumbotron">';
			foreach ($result as $r) {
				$urlPhoto = "https://demeter.utc.fr/portal/pls/portal30/portal30.get_photo_utilisateur_mini?username=".$r->login;
				echo "<div>";
					if(checkRemoteFile($urlPhoto) == FALSE)	{
						echo '<img src="default.png"/>';
					}
					else {
						echo '<img src="'.$urlPhoto.'" />';
					}
					echo "<br/>".$r->nom;
				echo "</div>";
			}
			echo '</div></div>';
		}
	?>
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
