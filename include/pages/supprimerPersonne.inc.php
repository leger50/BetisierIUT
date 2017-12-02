<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){
  $pdo = new Mypdo();
  $perManager = new PersonneManager($pdo);

  echo "<h1>Supprimer une personne enregistrée</h1>";

  if(empty($_GET['idPersonne']) && !isset($_SESSION['personne'])){
		$personnes = $perManager -> getAllPersonnes();
  ?>

  <p>Actuellement <?php echo count($personnes) ?> personne(s) sont enregistrée(s)</p>

	<table>
		<tr>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Supprimer</th>
		</tr>

		<?php
			foreach ($personnes as $personne){
				$numPersonne = $personne->getPersNum();?>
		<tr>
			<td><?php echo $personne -> getPersNom();?></td>
			<td><?php echo $personne -> getPersPre();?></td>
			<td><a href="index.php?page=4&amp;idPersonne=<?php echo $numPersonne?>"><img class='icone' src='image/erreur.png' alt='Supprimer personne'></a></td>
		</tr>

		<?php }	?>

	</table>
  <br />

<?php
}else{

  if (isset($_POST['valider'])) {

    $perManager->delete($_SESSION['personne']);
    echo "<p><img class='icone' src='image/valid.png' alt='Supprimer personne valide'>La personne '".$_SESSION['personne']->getPersPre().' '.$_SESSION['personne']->getPersNom()."' a été supprimée</p>";

    unset($_SESSION['personne']);
    header("Refresh: 3;URL=index.php");

  } elseif (isset($_POST['annuler'])) {
    unset($_SESSION['personne']);
    header("Refresh: 1;URL=index.php?page=4");

  } else{
    $_SESSION['personne'] = $perManager->getOnePersonne($_GET['idPersonne']); ?>

    <form action="index.php?page=4" id="supprPers" method="post">

      <label for="confSuppre">Etes-vous sûr de vouloir supprimer cette personne ?</label>
      </br>
    	<input type="submit" name="valider" value="Valider" class="btn">
      <input type="submit" name="annuler" value="Annuler" class="btn">

    </form>

<?php }
  }

}else{
  echo "<p>Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
