<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trombinoscope SR03</title>

	<!-- Bootstrap core CSS -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="bootstrap/css/bootstrap-select.min.css" rel="stylesheet">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/bootstrap-select.js"></script>
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
        			<li><a href="index.php">Par nom/prénom<span class="sr-only">(current)</span></a></li>
					<li class="active"><a href="#">Par structure<span class="sr-only">(current)</span></a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<!-- formulaire par structure -->
	<div class="container">
		<form class="form-inline" id="formulaire" name="formulaire" action="form2.php" method="post" >
			<select class="selectpicker show-tick form-control" name="structure" onChange="request(this)">
				<option value="0" selected>---- structure ----</option>
				<?php
					include'utils.php';
					echo '';
					$url = "https://webapplis.utc.fr/Trombi_ws/mytrombi/structpere";
					if(Visit($url)){
						//récupération des infos
						$content = file_get_contents($url);		
						$result = json_decode($content);
						foreach ($result as $r) {
							echo '<option value="'.$r->structure->structId.'">'.$r->structureLibelle.'</option>';									
						}
					}
				?>
			</select>
			<select class="selectpicker show-tick form-control" name="sous_structure" id="sous_structure">
				<option value="0" selected>---- sous-structure ----</option>
			</select>
			<button class="btn btn-default" type="submit">chercher</button>
		</form>
	</div>
	<br/>

	<!-- L'affichage des résultats -->
	<?php
		if ($_POST["structure"] && $_POST["sous_structure"])
		{
			$url = "https://webapplis.utc.fr/Trombi_ws/mytrombi/resultstruct?pere=".$_POST["structure"]."&fils=".$_POST["sous_structure"];
			if(Visit($url)){
				//récupération des infos
				$content = file_get_contents($url);		
				$result = json_decode($content);
				//affichage des données
				echo '<div class="container jumbotron"><div class="row">';
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
	
	<script language="javascript">
		function request(oSelect) {
			var value = oSelect.options[oSelect.selectedIndex].value; //id selectionné
			if (window.XMLHttpRequest)
				xhr = new XMLHttpRequest(); 
			else if (window.ActiveXObject)
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
					document.getElementById("sous_structure").innerHTML = xhr.responseText;
				}
			};
			
			xhr.open("POST", "sous_structure.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("IdStructure=" + value);
		}
	</script>
</body>
</html>
