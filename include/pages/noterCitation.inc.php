<?php
if(isset($_GET['numCit']) || isset($_SESSION['citation'])){
  $pdo=new Mypdo();

  if(isset($_GET['numCit'])){
    $citManager = new CitationManager($pdo);
    $_SESSION['citation'] = $citManager->getCitation($_GET['numCit']);
?>

    <table id="noterCitation">
    	<tr>
    		<th>Nom de l'enseignant</th>
    		<th>Libellé</th>
    		<th>Date</th>
    		<th>Moyenne des notes</th>
      </tr>

      <tr>
    		<td><?php echo $_SESSION['citation']->getNomEnseignant($_SESSION['citation']->getCitNumEnseignant());?></td>
    		<td><?php echo $_SESSION['citation']->getCitLib();?></td>
    		<td><?php echo $_SESSION['citation']->getCitDate();?></td>
    		<td><?php echo $_SESSION['citation']->getMoyenneNote();?></td>
      </tr>
    </table>

    <form action="index.php?page=16" id="noterCitationValeur" method="post">

      <label for="valeurNote">Note : </label>
        <input type="text" name="valeurNote" id="valeurNote" />
      </br>

      <input type="submit" name="valider" value="Valider" class="btn">
      <input type="submit" name="annuler" value="Annuler" class="btn">
    </form>

<?php //else if pour valider et annuler

}elseif(!empty($_POST['valider'])){
    $valeur = $_POST['valeurNote'];
    $numeroCitation = $_SESSION['citation']->getCitNum();

    if(is_numeric($valeur) && $valeur >= 0 && $valeur <= 20){
      $voteManager = new VoteManager($pdo);
      $perManager = new PersonneManager($pdo);

      $numeroEtudiant = $perManager->getNumLogin($_SESSION['login']);
      $valeur = round($valeur, 2);
      $retour = $voteManager->voterCitation($numeroCitation, $numeroEtudiant, $valeur);

      $enseignant = $_SESSION['citation']->getNomEnseignant($_SESSION['citation']->getCitNumEnseignant());

      if($retour){
        echo "<p><img class='icone' src='image/valid.png' alt='Valider vote'>Vote pour la citation de '".$enseignant."' validée</p>";
      }
      else{
        echo "<p><img class='icone' src='image/erreur.png' alt='Erreur valider vote'>Le vote concernant la citation de '".$enseignant."' n'a pu être validée !</p>";
      }
      unset($_SESSION['citation']);
      header("Refresh: 3;URL=index.php");

    }else{
      unset($_SESSION['citation']);
      echo "<p>Redirection automatique : </p>";
      echo "<p>La note doit être comprise entre 0 et 20</p>";
      header("Refresh: 3;URL=index.php?page=16&numCit=$numeroCitation");
    }

  }elseif(!empty($_POST['annuler'])){
    unset($_SESSION['citation']);
    header("Refresh: 1;URL=index.php?page=6");
  }
?>

<?php
}else{
  echo "<p>Vous n'avez pas les droits pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
