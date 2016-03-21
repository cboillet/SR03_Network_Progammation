<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trombinoscope SR03</title>

	<!-- Bootstrap core CSS -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

	
	
</head>

<header>
</header>

<body style="padding-top:80px; padding-bottom:20px; background-color: #F5F5F5;">
	<!-- La NavBar -->
	<nav class="navbar navbar-default navbar-fixed-top" style="background-color: #B0C4DE;">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#to-be-collabsed" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img style="max-height:35px; margin-top:-5px;" src="https://upload.wikimedia.org/wikipedia/en/f/f6/UTC_logo.png"></a>
				<a class="navbar-brand" style="color: #696969;" href="#">TrombiUTC</a>
			</div>
			<div class="collapse navbar-collapse navbar-right" id="to-be-collabsed">
				<ul class="nav navbar-nav">
        				<li class="active"><a href="#">Par nom/prénom<span class="sr-only">(current)</span></a></li>
					<li><a href="form2.php">Par structure<span class="sr-only">(current)</span></a></li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- formulaire par nom / prenom -->
	<div class="container">
		<form class="form-inline" id="formulaire" name="formulaire" action="index.php" method="post" >
			<div id="champ_prenom" class="form-group">
				<label for="prenom" style="color: #696969;" class="control-label">Prénom</label>
				<input class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?php if ($_POST['prenom']) echo $_POST['prenom']; ?>"/>
			</div>
			<div id="champ_nom" class="form-group">
				<label for="nom" style="color: #696969;" class="control-label">Nom</label>
				<input class="form-control" type="text" name="nom" id="nom" placeholder="Nom" value="<?php if ($_POST['nom']) echo $_POST['nom']; ?>"/>
			</div>
			<div class="form-group">
				<button class="btn btn-default" type="submit" onClick="controle(formulaire)">chercher</button>
			</div>
		</form>
	</div>
	<br>


	<!-- L'affichage des résultats -->
	<?php
		include'utils.php';
		if ($_POST["prenom"] && $_POST["nom"])
		{
			$url = "https://webapplis.utc.fr"."/Trombi_ws/mytrombi/result?nom=".$_POST["nom"]."&prenom=".$_POST	["prenom"] ;
			if(Visit($url)){
				//récupération des infos
				$content = file_get_contents($url);		
				$result = json_decode($content);
				//affichage des données
				echo '<div class="container"><div class="row">';
				foreach ($result as $r) {
					$urlPhoto = "https://demeter.utc.fr/portal/pls/portal30/portal30.get_photo_utilisateur_mini?username=".$r->login;
					echo '<div class="col-sm-4 col-md-3" style="text-align: center; height: 280px;">';
						echo '<strong>'.$r->nom.'</strong><br/>';						
						if(checkRemoteFile($urlPhoto) == FALSE)	{
							echo '<img src="default.png"/>';
						}
						else {
							echo '<img src="'.$urlPhoto.'" />';
						}
						echo '<br/>'.$r->structure.'<br/>';
						echo '<A HREF="mailto:'.$r->mail.'">'.$r->mail.'</A>';
					echo "</div>";				
				}
				echo '</div></div>';
			}
		}
	?>
	
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script language="javascript">
		$('form').submit(function(e){
			e.preventDefault();
			var valid = true;

			var prenom = document.getElementById("prenom").value;
			var nom = document.getElementById("nom").value;
			if (!prenom || !nom){
				valid = FALSE;
			}

			if (valid) this.submit();
		    
		});

		function controle(form) {
			var prenom = form.prenom.value;
			var nom = form.nom.value;
			if (!prenom)
				document.getElementById("champ_prenom").className = "form-group has-error";
			else
				document.getElementById("champ_prenom").className = "form-group";
			if (!nom)
				document.getElementById("champ_nom").className = "form-group has-error";
			else
				document.getElementById("champ_nom").className = "form-group";
		}
	</script>
</body>
</html>
