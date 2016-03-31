<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trombinoscope SR03</title>

	<!-- Bootstrap core CSS -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="design.css" rel="stylesheet">
</head>

<header>
</header>

<body>
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
				<a class="navbar-brand" href="#"><img style="max-height:35px; margin-top:-5px;" src="https://upload.wikimedia.org/wikipedia/en/f/f6/UTC_logo.png"></a>
				<a class="navbar-brand" style="color: white;" href="#">TrombiUTC</a>
			</div>
			<div class="collapse navbar-collapse navbar-right" id="to-be-collabsed">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#" style="color: black; background-color: #F5F5F5;">Par nom/prénom<span class="sr-only">(current)</span></a></li>
					<li><a href="form2.php" style="color: white;">Par structure<span class="sr-only">(current)</span></a></li>
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
				<button class="btn btn-default" type="submit">chercher</button>
			</div>
		</form>
	</div>
	<br>


	<!-- L'affichage des résultats -->
	<?php
		include'utils.php';
		if ($_POST["prenom"] || $_POST["nom"])
		{
			$url = "https://webapplis.utc.fr/Trombi_ws/mytrombi/result?nom=".$_POST["nom"]."&prenom=".$_POST	["prenom"] ;
			if(Visit($url)){
				//récupération des infos
				$content = file_get_contents($url);		
				$result = json_decode($content);
				//affichage des données
				$i = 0;
				echo '<div class="container"><div class="row">';
				foreach ($result as $r) {
					printProfile($r, $i);	
					$i++;
					if ($i == 3)
					{
						echo '</div><div class="row">';
						$i = 0;
					}		
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

			var prenom = document.getElementById("prenom").value;
			var nom = document.getElementById("nom").value;
			if (prenom.length >= 2 || nom.length >= 2){
				this.submit();
			}
			else
			{
				document.getElementById("champ_prenom").className = "form-group has-error";
				document.getElementById("champ_nom").className = "form-group has-error";
			}
				
		});
	</script>
</body>
</html>
