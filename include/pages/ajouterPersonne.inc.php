<?php
if(isset($_SESSION['estConnecte'])){

  if(!empty($_POST['per_nom'])){

    if($_POST['per_pwd'] == $_POST['confMpPers']){
      $_SESSION['estValide'] = true;
      $_SESSION['addPersonne'] = new Personne($_POST);
      $pdo = new Mypdo();

      if($_POST['categorie'] == 'etudiant'){
        $divisionManager = new DivisionManager($pdo);
        $listeDivisions = $divisionManager->getAllDivisions();
        $departementManager = new DepartementManager($pdo);
        $listeDepartements = $departementManager->getAllDepartements();
        $villeManager = new VilleManager($pdo);?>

        <h1>Ajouter un étudiant</h1>

        <form action="index.php?page=2" id="addEtudiant" method="post">

          <label for="div_num">Année : </label>
          <select name="div_num" id="div_num">
            <?php foreach ($listeDivisions as $division) {
              echo "<option value=".$division->getDivNum().">".$division->getDivNom()."</option>\n";
            }?>
          </select>
          </br>
          <label for="dep_num">Departement : </label>
          <select name="dep_num" id="dep_num">
            <?php foreach ($listeDepartements as $departement) {
              $ville = $villeManager->getVille($departement->getDepVilleNum());
              echo "<option value=".$departement->getDepNum().">".$departement->getDepNom()." - ".$ville->getVilNom()."</option>\n";
            }?>
          </select>
        </br>

        <input type="submit" value="Valider" class="valider">
        </form>

      <?php }elseif($_POST['categorie'] == 'personnel'){
        $fonctionManager = new FonctionManager($pdo);
        $listeFonctions = $fonctionManager->getAllFonctions();?>

        <h1>Ajouter un salarié</h1>

        <form action="index.php?page=2" id="addSalarie" method="post">

          <label for="sal_telprof">Téléphone professionnel : </label>
            <input type="tel" name="sal_telprof" id="sal_telprof" required/>
          </br>

          <label for="fon_num">Fonction : </label>
          <select name="fon_num" id="fon_num">
            <?php foreach ($listeFonctions as $fonction) {
              echo "<option value=".$fonction->getFonNum().">".$fonction->getFonLibelle()."</option>\n";
            }?>
          </select>
        </br>

        <input type="submit" value="Valider" class="valider">
        </form>

    <?php }

    }else{
  		echo '<div class="messErreur"><p>Les mots de passe ne correspondent pas</p></div>';
  	}
  }

  if(!isset($_SESSION['estValide'])){?>

<h1>Ajouter une Personne</h1>

<form action="index.php?page=2" id="addPersonne" method="post">

  <label for="per_nom">Nom : </label>
    <input type="text" name="per_nom" id="per_nom" required/>
  </br>
	<label for="per_prenom">Prénom : </label>
    <input type="text" name="per_prenom" id="per_prenom" required/>
  </br>
	<label for="per_tel">Téléphone : </label>
    <input type="tel" name="per_tel" id="per_tel" required/>
  </br>
	<label for="per_mail">Mail : </label>
    <input type="email" name="per_mail" id="per_mail" required/>
  </br>
	<label for="per_login">Login : </label>
    <input type="text" name="per_login" id="per_login" required/>
  </br>
	<label for="per_pwd">Mot de passe : </label>
    <input type="password" name="per_pwd" id="per_pwd" required/>
  </br>
	<label for="confMpPers">Confirmation mot de passe : </label>
    <input type="password" name="confMpPers" id="confMpPers" required/>
  </br>

	<input type="radio" name="categorie" value="etudiant" id="etudiant" checked/> <label for="etudiant">Etudiant</label>
	<input type="radio" name="categorie" value="personnel" id="personnel" /> <label for="personnel">Personnel</label>
	<br />

	<input type="submit" value="Valider" class="valider">

</form>

<?php
  }else{
    $pdo = new Mypdo();

    if(!empty($_POST['div_num'])){
      $etudiant = new Etudiant($_SESSION['addPersonne'], $_POST);
      $etudiantManager = new EtudiantManager($pdo);
      $retour = $etudiantManager->add($etudiant);

      if($retour){
        echo "<p><img class='icone' src='image/valid.png' alt='Valide etudiant'>L'étudiant '".$etudiant->getPersonne()->getPersPre().' '.$etudiant->getPersonne()->getPersNom()."' a été ajouté</p>";
      }
      else{
        echo "<p><img class='icone' src='image/erreur.png' alt='Erreur etudiant'>L'étudiant '".$etudiant->getPersonne()->getPersPre().' '.$etudiant->getPersonne()->getPersNom()."' existe déjà !</p>";
      }
      unset($_SESSION['estValide']);
      unset($_SESSION['addPersonne']);

    }
    if(!empty($_POST['sal_telprof'])){
      $salarie = new Salarie($_SESSION['addPersonne'], $_POST);
      $salarieManager = new SalarieManager($pdo);
      $retour = $salarieManager->add($salarie);

      if($retour){
        echo "<p><img class='icone' src='image/valid.png' alt='Valide salarie'>Le salarié '".$salarie->getPersonne()->getPersPre().' '.$salarie->getPersonne()->getPersNom()."' a été ajouté</p>";
      }
      else{
        echo "<p><img class='icone' src='image/erreur.png' alt='Erreur salarie'>Le salarié '".$salarie->getPersonne()->getPersPre().' '.$salarie->getPersonne()->getPersNom()."' existe déjà !</p>";
      }
      unset($_SESSION['estValide']);
      unset($_SESSION['addPersonne']);

    }
}

}else{
  echo "<p>Vous devez être connecté pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
