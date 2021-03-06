<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){

  echo "<h1>Supprimer une citation enregistrée</h1>";

  if(empty($_GET['idCit']) && !isset($_SESSION['citation'])){
  	$pdo = new Mypdo();
  	$citationManager = new CitationManager($pdo);
  	$citations = $citationManager -> getAllCitations();
  ?>

  <p>Actuellement <?php echo count($citations) ?> citation(s) sont enregistrée(s)</p>

  <table id="tableSupCitation">
  	<tr>
  		<th>Nom de l'enseignant</th>
  		<th>Libellé</th>
  		<th>Date</th>
  		<th>Moyenne des notes</th>
  	</tr>

  	<?php
  		foreach ($citations as $citation){
        $numCit = $citation->getCitNum()?>
  	<tr>
      <td><?php echo $citation -> getNomEnseignant($citation->getCitNumEnseignant());?></td>
  		<td><?php echo $citation -> getCitLib();?></td>
  		<td><?php echo $citation -> getCitDate();?></td>
  		<td><?php echo $citation -> getMoyenneNote();?></td>
      <td><a href="index.php?page=10&amp;idCit=<?php echo $numCit?>"><img class='icone' src='image/erreur.png' alt='Supprimer Citation'></a></td>
  	</tr>
  	<?php }?>

  </table>
  <br />

<?php
}else{
  $pdo = new Mypdo();
	$citationManager = new CitationManager($pdo);

  if (isset($_POST['valider'])) {

    $citationManager->delete($_SESSION['citation']);
    $enseignant = $_SESSION['citation']->getNomEnseignant($_SESSION['citation']->getCitNumEnseignant());
    echo "<p><img class='icone' src='image/valid.png' alt='Supprimer citation valide'>La citation '".$enseignant."' a été supprimée</p>";

    unset($_SESSION['citation']);
    header("Refresh: 3;URL=index.php");

  } elseif (isset($_POST['annuler'])) {
    unset($_SESSION['citation']);
    header("Refresh: 1;URL=index.php?page=10");

  } else{
    $_SESSION['citation'] = $citationManager->getCitation($_GET['idCit']); ?>

    <form action="index.php?page=10" id="supprCitation" method="post">

      <label for="confSuppre">Etes-vous sûr de vouloir supprimer cette citation ?</label>
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
