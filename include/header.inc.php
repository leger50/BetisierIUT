<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php
		$title = "Bienvenue sur le site du bétisier de l'IUT.";?>
		<title>
		<?php echo $title ?>
		</title>
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />

</head>
	<body>
	<div id="header">

    <div id="connect">
      <?php if(!isset($_SESSION['login'])){?>
      <a href="index.php?page=15">Connexion</a>

      <?php }else{
      $_SESSION['estConnecte'] = false;
      echo "Utilisateur : ".$_SESSION['login']."<a href='index.php?page=15'> Deconnexion</a>";
      } ?>
		</div>

		<div id="entete">
      <?php
      if(isset($_SESSION['estConnecte'])){ ?>
        <div id="logo">
          <img id="imHeader" class="centreImage" src="image/smile.jpg" alt="Covoiturage IUT" title="Covoiturage IUT Limousin"/>
  			</div>
      <?php } else { ?>
			<div id="logo">
        <img id="imHeader" class="centreImage" src="image/lebetisier.gif" alt="Covoiturage IUT" title="Covoiturage IUT Limousin"/>
			</div>
    <?php } ?>
			<div id="titre">
				Le bétisier de l'IUT,<br />Partagez les meilleures perles !!!
			</div>
		</div>
	</div>
