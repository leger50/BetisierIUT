<?php if(isset($_SESSION['estConnecte'])){?>

  <h1>Modifier mon mot de passe</h1>

  <?php
  if(!empty($_POST['old_password'])){

    if($_POST['new_password'] == $_POST['conf_password']){
      $pdo = new Mypdo();
      $connexionManager = new ConnexionManager($pdo);

      if($connexionManager->verifInfos($_SESSION['login'], $_POST['old_password'])){
        $perManager = new PersonneManager($pdo);

        $personne = $perManager->getNumLogin($_SESSION['login']);
        $personne = $perManager->getOnePersonne($personne);
        $personne->setPersPwd($_POST['new_password']);

        $retour = $perManager->updatePassword($personne);

        if($retour){
          echo '<div class="messConfirmation"><p>Le mot de passe a été modifié</p></div>';
        }else{
          echo "<div class='messErreur'><p>Le mot de passe n'a pu être modifié</p></div>";
        }

      }else{
        echo '<div class="messErreur"><p>Ancien mot de passe saisi invalide</p></div>';
      }

    }else{
      echo '<div class="messErreur"><p>Les mots de passe saisis ne correspondent pas</p></div>';
    }
  }
  ?>

  <form action="index.php?page=17" id="modifPassWd" method="post">

    </br>
    <label for="old_password">Ancien mot de passe : </label>
      <input type="password" name="old_password" id="old_password" required/>
    </br>
    <label for="new_password">Nouveau mot de passe : </label>
      <input type="password" name="new_password" id="new_password" required/>
    </br>
    <label for="conf_password">Confirmation mot de passe : </label>
      <input type="password" name="conf_password" id="conf_password" required/>

    </br>
  	<input type="submit" value="Valider" class="btn">

  </form>

<?php
}else{
  echo "<p>Vous devez être connecté pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
