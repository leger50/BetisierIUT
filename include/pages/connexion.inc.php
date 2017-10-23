<?php
  $nbAlea1 = rand(1, 9);
  $nbAlea2 = rand(1, 9);
?>
<h1>Pour vous connecter</h1>

<form action="index.php" id="connexion" method="post">

  <label for="nomUser">Nom d'utilisateur : </label>
    <input type="text" name="nomUser" id="nomUser" />
  </br>
  <label for="passWord">Mot de passe : </label>
    <input type="password" name="passWord" id="passWord" />
  </br>
  <label for="captcha"><img src="image/nb/<?php echo $nbAlea1?>.jpg"> + <img src="image/nb/<?php echo $nbAlea2?>.jpg"> = </label>
    <input type="text" name="captcha" id="captcha" />
</form>
