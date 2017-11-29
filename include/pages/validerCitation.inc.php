<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){

  echo "<h1>Valider une citation enregistrée</h1>";

  if(empty($_GET['idCitVal']) && empty($_GET['idCitSup']) && !isset($_SESSION['citation'])){
  	$pdo = new Mypdo();
  	$citationManager = new CitationManager($pdo);
  	$citations = $citationManager -> getAllNewCitations();
  ?>

  <p>Actuellement <?php echo count($citations) ?> citation(s) sont enregistrée(s)</p>

  <table id="tableValCitation">
  	<tr>
  		<th>Nom de l'enseignant</th>
  		<th>Libellé</th>
  		<th>Date</th>
  	</tr>

  	<?php
  		foreach ($citations as $citation){
        $numCit = $citation->getCitNum()?>
  	<tr>
      <td><?php echo $citation -> getNomEnseignant($citation->getCitNumEnseignant());?></td>
  		<td><?php echo $citation -> getCitLib();?></td>
  		<td><?php echo $citation -> getCitDate();?></td>
      <td><a href="index.php?page=9&amp;idCitVal=<?php echo $numCit;?>"><img class='icone' src='image/valid.png' alt='Valider Citation'></a></td>
      <td><a href="index.php?page=9&amp;idCitSup=<?php echo $numCit;?>"><img class='icone' src='image/erreur.png' alt='Supprimer Citation'></a></td>
  	</tr>
  	<?php }?>

  </table>
  <br />

  <?php
  }else{
    $pdo = new Mypdo();
  	$citationManager = new CitationManager($pdo);
    if(empty($_GET['idCitSup'])&&empty($_GET['idCitVal'])){
    if (isset($_POST['validerSup'])) {
          $citationManager->delete($_SESSION['citation']);
          echo "<p><img class='icone' src='image/valid.png' alt='Supprimer citation valide'>La citation '".$_SESSION['citation']->getCitNum()."' a été supprimée</p>";

          unset($_SESSION['citation']);
          unset($_SESSION['supprimer']);

      }elseif (isset($_POST['annulerSup'])) {
          unset($_SESSION['supprimer']);
          unset($_SESSION['citation']);
          header("Refresh: 1;URL=index.php?page=9");

      }elseif(isset($_POST['validerVal'])){
          $retour = $citationManager->valider($_SESSION['citation'], $_SESSION['login']);
          echo "<p><img class='icone' src='image/valid.png' alt='Supprimer citation valide'>La citation '".$_SESSION['citation']->getCitNum()."' a été validée</p>";
          unset($_SESSION['supprimer']);
          unset($_SESSION['citation']);
      }
      elseif(isset($_POST['annulerVal'])){
          unset($_SESSION['supprimer']);
          unset($_SESSION['citation']);
          header("Refresh: 1;URL=index.php?page=9");
      }


    } elseif(!empty($_GET['idCitSup'])){
        $_SESSION['supprimer'] = true;
        $_SESSION['citation'] = $citationManager->getCitation($_GET['idCitSup']); ?>

      <form action="index.php?page=9" id="suppCitation" method="post">

        <label for="confSuppre">Etes-vous sûr de vouloir supprimer cette citation ?</label>
        </br>
      	<input type="submit" name="validerSup" value="Valider" class="valider">
        <input type="submit" name="annulerSup" value="Annuler" class="Annuler"> <!--Modifier css-->

      </form>

  <?php  } elseif (!empty($_GET['idCitVal'])){
      $_SESSION['supprimer'] = false;
      $_SESSION['citation'] = $citationManager->getCitation($_GET['idCitVal']); ?>

      <form action="index.php?page=9" id="valCitation" method="post">

      <label for="confValid">Etes-vous sûr de vouloir valider cette citation ?</label>
      </br>
      <input type="submit" name="validerVal" value="Valider" class="valider">
      <input type="submit" name="annulerVal" value="Annuler" class="Annuler"> <!--Modifier css-->

    </form>
<?php
    }
}
  }else{
    echo "<p>Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>";
    echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
    header("Refresh: 3;URL=index.php");
  }
  ?>
