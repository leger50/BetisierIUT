<?php
if(isset($_SESSION['estConnecte'])){

  echo "<h1>Modifier une ville enregistrée</h1>";

  if(empty($_GET['idVille']) && !isset($_SESSION['ville'])){
  	$pdo = new Mypdo();
  	$vilManager = new VilleManager($pdo);
  	$villes = $vilManager -> getAllVilles();
  ?>

  <p>Actuellement <?php echo count($villes) ?> ville(s) sont enregistrée(s)</p>

  <table>
  	<tr>
  		<th>Numéro</th>
  		<th>Nom</th>
      <th>Modifier</th>
  	</tr>

  	<?php
  		foreach ($villes as $ville){
        $numVille = $ville->getVilNum()?>
  	<tr>
  		<td><?php echo $ville->getVilNum();?></td>
  		<td><?php echo $ville->getVilNom();?></td>
      <td><a href="index.php?page=13&amp;idVille=<?php echo $numVille?>"><img class='icone' src='image/modifier.png' alt='Modifier ville'></a></td>
  	</tr>
  	<?php }?>

  </table>
  <br />

<?php
}else{
  $pdo = new Mypdo();
	$villeManager = new VilleManager($pdo);

  if(empty($_POST['vil_nom'])){
      $_SESSION['ville'] = $villeManager->getVille($_GET['idVille']); ?>

  <form action="index.php?page=13" id="modifVille" method="post">

    <label for="vil_nom">Nom : </label>
      <input type="text" name="vil_nom" id="vil_nom" value="<?php echo $_SESSION['ville']->getVilNom()?>" required/>
    </br>
  	<input type="submit" value="Valider" class="btn">

  </form>

<?php }else{
  $_SESSION['ville']->setVilNom($_POST['vil_nom']);
	$retour = $villeManager->update($_SESSION['ville']);

  if($retour){
    echo "<p><img class='icone' src='image/valid.png' alt='Modification valide ville'>La ville '".$_SESSION['ville']->getVilNom()."' a été modifiée</p>";
  }
  else{
    echo "<p><img class='icone' src='image/erreur.png' alt='Modification erreur ville'>La ville '".$_SESSION['ville']->getVilNom()."' existe déjà !</p>";
  }
  unset($_SESSION['ville']);
  header("Refresh: 3;URL=index.php");
}
}

}else{
  echo "<p>Vous devez être connecté pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
