<?php
if(isset($_SESSION['estConnecte']) && $_SESSION['admin']){

	//Affichage liste des personnes
  if(empty($_GET['idPersonne']) && !isset($_SESSION['estValide'])){
  	$pdo = new Mypdo();
		$perManager = new PersonneManager($pdo);
		$personnes = $perManager -> getAllPersonnes();

  ?>

	<h1>Modifier une personne enregistrée</h1>
  <p>Actuellement <?php echo count($personnes) ?> personne(s) sont enregistrée(s)</p>

	<table>
		<tr>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Modifier</th>
		</tr>

		<?php
			foreach ($personnes as $personne){
				$numPersonne = $personne->getPersNum();?>
		<tr>
			<td><?php echo $personne -> getPersNom();?></td>
			<td><?php echo $personne -> getPersPre();?></td>
			<td><a href="index.php?page=3&amp;idPersonne=<?php echo $numPersonne?>"><img class='icone' src='image/modifier.png' alt='Modifier personne'></a></td>
		</tr>

		<?php }	?>

	</table>

<?php

//Lorsque l'utilisateur clique sur modifier
}else{
  $pdo = new Mypdo();
  $perManager = new PersonneManager($pdo);

  if(!isset($_SESSION['personne'])){
    $_SESSION['estValide'] = true;
    $_SESSION['personne'] = $perManager->getOnePersonne($_GET['idPersonne']);?>

    <h1>Modifier une Personne</h1>

    <form action="index.php?page=3" id="modifPersonne" method="post">

      <label for="per_nom">Nom : </label>
        <input type="text" name="per_nom" id="per_nom" value="<?php echo $_SESSION['personne']->getPersNom()?>" required/>
      </br>
    	<label for="per_prenom">Prénom : </label>
        <input type="text" name="per_prenom" id="per_prenom" value="<?php echo $_SESSION['personne']->getPersPre()?>" required/>
      </br>
    	<label for="per_tel">Téléphone : </label>
        <input type="tel" name="per_tel" id="per_tel" value="<?php echo $_SESSION['personne']->getPersTel()?>" required/>
      </br>
    	<label for="per_mail">Mail : </label>
        <input type="email" name="per_mail" id="per_mail" value="<?php echo $_SESSION['personne']->getPersMail()?>" required/>
      </br>
    	<label for="per_login">Login : </label>
        <input type="text" name="per_login" id="per_login" value="<?php echo $_SESSION['personne']->getPersLogin()?>" required/>
      </br>

      <input type="hidden" name="per_num" id="per_num" value="<?php echo $_SESSION['personne']->getPersNum()?>"/>

      <input type="submit" value="Valider" class="valider">

    </form>

    <?php
  }elseif(!empty($_POST['per_nom'])){
    $_SESSION['personne'] = new Personne($_POST);

    $numPersonne = $_SESSION['personne']->getPersNum();

    if($perManager->estEtudiant($numPersonne)==null){ //refaire cette condition
      $etuManager = new EtudiantManager($pdo);
      $_SESSION['etudiant'] = $etuManager->getEtudiant($numPersonne);
      $_SESSION['etudiant']->setPersonne($_SESSION['personne']); //GAFFE §
      //unset($_SESSION['personne']);

      $divisionManager = new DivisionManager($pdo);
      $listeDivisions = $divisionManager->getAllDivisions();

			$departementManager = new DepartementManager($pdo);
      $listeDepartements = $departementManager->getAllDepartements();

			$villeManager = new VilleManager($pdo);?>

      <h1>Modifier un étudiant</h1>

      <form action="index.php?page=3" id="modifEtudiant" method="post">

        <label for="div_num">Année : </label>
        <select name="div_num" id="div_num">
          <?php foreach ($listeDivisions as $division) {
            if($division->getDivNum() == $_SESSION['etudiant']->getDivNum()){
              echo "<option value=".$division->getDivNum()." selected>".$division->getDivNom()."</option>\n";
            }else{
              echo "<option value=".$division->getDivNum().">".$division->getDivNom()."</option>\n";
            }

          }?>
        </select>
        </br>
        <label for="dep_num">Departement : </label>
        <select name="dep_num" id="dep_num">
          <?php foreach ($listeDepartements as $departement) { //FAIRE SELECTED
            $ville = $villeManager->getVille($departement->getDepVilleNum());

            if($departement->getDepNum() == $_SESSION['etudiant']->getDepNum()){
              echo "<option value=".$departement->getDepNum()." selected>".$departement->getDepNom()." - ".$ville->getVilNom()."</option>\n";
            }else{
              echo "<option value=".$departement->getDepNum().">".$departement->getDepNom()." - ".$ville->getVilNom()."</option>\n";
            }
          }?>
        </select>
      </br>

      <input type="submit" value="Valider" class="valider">
      </form>

		<!--TODO partie salarie-->
    <?php }else{
      $salarieManager = new SalarieManager($pdo);
      $_SESSION['salarie'] = $salarieManager->getSalarie($numPersonne);
      $_SESSION['salarie']->setPersonne($_SESSION['personne']); //GAFFE §

      $fonctionManager = new FonctionManager($pdo);
      $listeFonctions = $fonctionManager->getAllFonctions();?>

      <h1>Modifier un salarié</h1>

      <form action="index.php?page=3" id="modifSalarie" method="post">

        <label for="sal_telprof">Téléphone professionnel : </label>
          <input type="tel" name="sal_telprof" id="sal_telprof" value="<?php echo $_SESSION['salarie']->getTelPro()?>" required/>
        </br>

        <label for="fon_num">Fonction : </label>
        <select name="fon_num" id="fon_num">
          <?php foreach ($listeFonctions as $fonction) {
            if($fonction->getFonNum() == $_SESSION['salarie']->getNumFonction()){
              echo "<option value=".$fonction->getFonNum()." selected>".$fonction->getFonLibelle()."</option>\n";
            }else{
              echo "<option value=".$fonction->getFonNum().">".$fonction->getFonLibelle()."</option>\n";
            }

          }?>
        </select>
      </br>

      <input type="submit" value="Valider" class="valider">
      </form>

  <?php
  }

}else{

  if(!empty($_POST['div_num'])){
    $etudiant = new Etudiant($_SESSION['etudiant']->getPersonne(), $_POST);
    $etudiantManager = new EtudiantManager($pdo);
    $retour = $etudiantManager->update($etudiant);

    if($retour){
      echo "<p><img class='icone' src='image/valid.png' alt='Valide modification etudiant'>L'étudiant '".$etudiant->getPersonne()->getPersPre().' '.$etudiant->getPersonne()->getPersNom()."' a été modifié</p>";
    }
    else{
      echo "<p><img class='icone' src='image/erreur.png' alt='Erreur modification etudiant'>L'étudiant '".$etudiant->getPersonne()->getPersPre().' '.$etudiant->getPersonne()->getPersNom()."' n'a pu être modifié</p>";
    }
    unset($_SESSION['etudiant']);

  }

  if(!empty($_POST['sal_telprof'])){
    $salarie = new Salarie($_SESSION['salarie']->getPersonne(), $_POST);
    $salarieManager = new SalarieManager($pdo);
    $retour = $salarieManager->update($salarie);

    if($retour){
      echo "<p><img class='icone' src='image/valid.png' alt='Valide modification salarie'>Le salarié '".$salarie->getPersonne()->getPersPre().' '.$salarie->getPersonne()->getPersNom()."' a été modifié</p>";
    }
    else{
      echo "<p><img class='icone' src='image/erreur.png' alt='Erreur modification salarie'>Le salarié '".$salarie->getPersonne()->getPersPre().' '.$salarie->getPersonne()->getPersNom()."' n'a pu être modifié</p>";
    }
    unset($_SESSION['salarie']);
  }

  unset($_SESSION['estValide']);
  unset($_SESSION['personne']);
}
}
//FERMER TOUTES LES VARS DE SESSION, TOUTEEEEEEEEESSSS
}else{
  echo "<p>Vous devez être connecté en tant qu'administrateur pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
