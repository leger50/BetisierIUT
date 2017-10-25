<?php
  if(!empty($_POST['nomUser'])){ //Cas idSAISIE
		$pdo=new Mypdo();
		$connexionManager = new ConnexionManager($pdo);

		if($connexionManager->captchaValide($_SESSION['nbAlea1'], $_SESSION['nbAlea2'], $_POST['captcha'])){
			if($connexionManager->verifInfos($_POST['nomUser'], $_POST['passWord'])){
        $_SESSION['estConnecte'] = true;
        $_SESSION['login'] = $_POST['nomUser'];
        $_SESSION['admin'] = $connexionManager->estAdmin($_POST['nomUser']);

			}else{
				echo '<div class="messErreur"><p>Identifiant ou mot de passe invalide</p></div>';
			}

		}else{
			echo '<div class="messErreur"><p>Captcha invalide</p></div>';
		}

	}
?>

<h1>Pour vous connecter</h1>

<?php if(!isset($_SESSION['login'])){

    $_SESSION['nbAlea1'] = rand(1, 9);
    $_SESSION['nbAlea2'] = rand(1, 9);

?>

<form action="index.php?page=14" id="connexion" method="post">

  <label for="nomUser">Nom d'utilisateur : </label>
    <input type="text" name="nomUser" id="nomUser" required/>
  </br>
  <label for="passWord">Mot de passe : </label>
    <input type="password" name="passWord" id="passWord" required/>
  </br>
  <label for="captcha"><img src="image/nb/<?php echo $_SESSION['nbAlea1']?>.jpg"> + <img src="image/nb/<?php echo $_SESSION['nbAlea2']?>.jpg"> = </label>
    <input type="text" name="captcha" id="captcha" required/>
  </br>
  <input type="submit" value="Valider" class="valider">
</form>

<?php }else{
  if($_SESSION['estConnecte']){
    echo "<p>Vous avez bien été connecté !</p>";
    echo "<p><img class = 'icone' src='image/valid.png' alt='Personne'>Redirection automatique dans 2 secondes</p>";
    header("Refresh: 2;URL=index.php");
  }else{
    session_destroy();
    echo "<p>Vous avez bien été déconnecté !</p>";
    echo "<p><img class = 'icone' src='image/valid.png' alt='Personne'>Redirection automatique dans 2 secondes</p>";
    header("Refresh: 2;URL=index.php");
  }

}
?>
