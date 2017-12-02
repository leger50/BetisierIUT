<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){

  echo "<h1>Supprimer une ville enregistrée</h1>";

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
      <th>Supprimer</th>
  	</tr>

  	<?php
  		foreach ($villes as $ville){
        $numVille = $ville->getVilNum()?>
  	<tr>
  		<td><?php echo $ville->getVilNum();?></td>
  		<td><?php echo $ville->getVilNom();?></td>
      <td><a href="index.php?page=14&amp;idVille=<?php echo $numVille?>"><img class='icone' src='image/erreur.png' alt='Supprimer ville'></a></td>
  	</tr>
  	<?php }?>

  </table>
  <br />

<?php
}else{
  $pdo = new Mypdo();
	$villeManager = new VilleManager($pdo);

  if (isset($_POST['valider'])) {
    $retour = $villeManager->delete($_SESSION['ville']);

    if($retour){
      echo "<p><img class='icone' src='image/valid.png' alt='Supprimer ville valide'>La ville '".$_SESSION['ville']->getVilNom()."' a été supprimée</p>";
    }
    else{
      echo "<p><img class='icone' src='image/erreur.png' alt='Supprimer ville erreur'>La ville '".$_SESSION['ville']->getVilNom()."' est encore associée à un ou plusieurs étudiants, suppression impossible !</p>";
    }
    unset($_SESSION['ville']);
    header("Refresh: 3;URL=index.php");

  } elseif (isset($_POST['annuler'])) {
    unset($_SESSION['ville']);
    header("Refresh: 1;URL=index.php?page=14");

  } else{
    $_SESSION['ville'] = $villeManager->getVille($_GET['idVille']); ?>

    <form action="index.php?page=14" id="supprVille" method="post">

      <label for="confSuppre">Etes-vous sûr de vouloir supprimer cette ville ?</label>
      </br>
    	<input type="submit" name="valider" value="Valider" class="btn">
      <input type="submit" name="annuler" value="Annuler" class="btn">

    </form>

<?php  }
  }

}else{
  echo "<p>Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
