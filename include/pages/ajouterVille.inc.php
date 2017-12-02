<?php if(isset($_SESSION['estConnecte'])){?>

<h1>Ajouter une ville</h1>

<?php
if(empty($_POST['vil_nom'])){
?>

<form action="index.php?page=12" id="addVille" method="post">

  <label for="vil_nom">Nom : </label>
    <input type="text" name="vil_nom" id="vil_nom" required/>
  </br>
	<input type="submit" value="Valider" class="btn">

</form>

<?php
}else{
	$pdo = new Mypdo();
	$villeManager = new VilleManager($pdo);
	$ville = new Ville($_POST);

	$retour = $villeManager->add($ville);

  if($retour){
    echo "<p><img class='icone' src='image/valid.png' alt='Valide Ville'>La ville '".$ville->getVilNom()."' a été ajoutée</p>";
  }
  else{
    echo "<p><img class='icone' src='image/erreur.png' alt='Erreur Ville'>La ville '".$ville->getVilNom()."' existe déjà !</p>";
  }
  header("Refresh: 3;URL=index.php");
}

}else{
  echo "<p>Vous devez être connecté pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
