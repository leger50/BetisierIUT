<?php
if(isset($_SESSION['estConnecte']) && !$_SESSION['admin'] ){

  $_SESSION['aDesMotsInterdits'] = false;

  if(isset($_SESSION['estConnecte'])){

    if(empty($_POST['cit_date'])){
      $pdo = new Mypdo();
      $salarieManager = new SalarieManager($pdo);
      $listeSalaries = $salarieManager->getAllSalaries();
      ?>
          <h1>Ajouter une citation</h1>

          <form action="index.php?page=7" id="addCitation" method="post">

            <label for="per_num">Enseignant : </label>
            <select name="per_num" id="per_num">
              <?php foreach ($listeSalaries as $salarie) {
                echo "<option value=".$salarie->getPersonne()->getPersNum().">".$salarie->getPersonne()->getPersNom()."</option>\n";
              }?>
            </select>
            </br>


            <label for="cit_date">Date citation : </label>
              <input type="date" name="cit_date" id="cit_date" required/>
            </br>

            <label for="cit_libelle">Citation : </label>
              <input type="textarea" name="cit_libelle" id="cit_libelle" required/>
            </br>

            <input type="submit" value="Valider" class="valider">
          </form>
  <?php }


  else{
    $pdo = new Mypdo();
    $personneManager = new PersonneManager($pdo);
  	$citationManager = new CitationManager($pdo);
    $motsInterditsManager = new MotsInterditsManager($pdo);


  	$citation = new Citation($_POST, NULL);
    $motsInterdits =   $motsInterditsManager->getAllMotsInterdits($citation);
    if($motsInterditsManager->hasMotsInterdits($citation)){
        $_SESSION['aDesMotsInterdits'] = true;
        $retour = false;
      foreach ($motsInterdits as $motInterdit) {
        echo "<p><img class='icone' src='image/erreur.png' alt='Erreur citation'>le mot:".$motInterdit->getMot()." n'est pas autorisé!</p>";
      }
    }
    else{
      $_SESSION['aDesMotsInterdits'] = false;
      $retour = $citationManager->add($citation,$personneManager->getNumLogin($_SESSION['login']));

      unset($_SESSION['aDesMotsInterdits']);

      echo "<p><img class='icone' src='image/valid.png' alt='Valide citation'>La citation a été ajoutée</p>";
      header("Refresh: 3;URL=index.php");
    }
  }




  if(isset($_SESSION['aDesMotsInterdits']) && $_SESSION['aDesMotsInterdits']) {
    $pdo = new Mypdo();
    $salarieManager = new SalarieManager($pdo);
    $motsInterditsManager = new MotsInterditsManager($pdo);

    $listeSalaries = $salarieManager->getAllSalaries();
    $motsCitationInterdite = explode(" ",$_POST['cit_libelle'],10);
    $taille = sizeof($motsCitationInterdite);
    for($i = 0; $i<$taille;$i++){
      if($motsInterditsManager->estInterdit($motsCitationInterdite[$i])){
        $motsCitationInterdite[$i] = "---";
      }
    }
    $citationModifie = implode(" ", $motsCitationInterdite);
  ?>

        <h1>Ajouter une citation</h1>

        <form action="index.php?page=7" id="addCitation" method="post">

          <label for="per_num">Enseignant : </label>
          <select name="per_num" id="per_num">
            <?php foreach ($listeSalaries as $salarie) {
              echo "<option value=".$salarie->getPersonne()->getPersNum().">".$salarie->getPersonne()->getPersNom()."</option>\n";
            }?>
          </select>
          </br>
          <label for="cit_date">Date citation : </label>
            <input type="date" name="cit_date" id="cit_date" value="<?php echo $_POST['cit_date']?>"required/>
          </br>

          <label for="cit_libelle">Citation : </label>
            <input type="textarea" name="cit_libelle" id="cit_libelle" value="<?php echo $citationModifie ?>" required/>
          </br>

          <input type="submit" value="Valider" class="valider">
        </form>

  <?php
    }
  }

}else{
  echo "<p>Vous devez être connecté en tant qu'étudiant pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
