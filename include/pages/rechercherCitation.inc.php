<?php
if(isset($_SESSION['estConnecte'])){

  $pdo = new Mypdo();
  $salarieManager = new SalarieManager($pdo);
  $listeSalaries = $salarieManager->getAllSalaries();
  ?>

<h1>Rechercher une citation</h1>

<form action="index.php?page=8" id="searchCitation" method="post">

  <label for="per_num">Enseignant : </label>
  <select name="per_num" id="per_num">
    <option value="" selected></option>
    <?php foreach ($listeSalaries as $salarie) {
      echo "<option value=".$salarie->getPersonne()->getPersNum().">".$salarie->getPersonne()->getPersNom()."</option>\n";
    }?>
  </select>
  </br>


  <label for="cit_date">Date citation : </label>
    <input type="date" name="cit_date" id="cit_date" />
  </br>

  <label for="vot_valeur">Note Obtenue : </label>
    <input type="textarea" name="vot_valeur" id="vot_valeur" />
  </br>

  <input type="submit" value="Valider" class="btn">
</form>

<?php
if(empty($_POST['per_num']) && empty($_POST['cit_date']) && empty($_POST['vot_valeur'])){
  	$pdo=new Mypdo();
  	$citManager = new CitationManager($pdo);
  	$citations = $citManager -> getAllCitations();
  ?>
  <table id="tableCitation">
  	<tr>
  		<th>Nom de l'enseignant</th>
  		<th>Libellé</th>
  		<th>Date</th>
  		<th>Moyenne des notes</th>
  	</tr>

  	<?php
  		foreach ($citations as $citation){?>
  	<tr>
  		<td><?php echo $citation -> getNomEnseignant($citation->getCitNumEnseignant());?></td>
  		<td><?php echo $citation -> getCitLib();?></td>
  		<td><?php echo $citation -> getCitDate();?></td>
  		<td><?php echo $citation -> getMoyenneNote();?></td>
  	</tr>
  	<?php }?>

  </table>
  <br />
<?php } else {
  $pdo=new Mypdo();
  $citManager = new CitationManager($pdo);
  $citations = $citManager -> getFiltredCitation($_POST['per_num'],$_POST['cit_date'],$_POST['vot_valeur']);
  ?>
  <table id="tableCitation">
  	<tr>
  		<th>Nom de l'enseignant</th>
  		<th>Libellé</th>
  		<th>Date</th>
  		<th>Moyenne des notes</th>
  	</tr>

  	<?php
  		foreach ($citations as $citation){?>
  	<tr>
  		<td><?php echo $citation -> getNomEnseignant($citation->getCitNumEnseignant());?></td>
  		<td><?php echo $citation -> getCitLib();?></td>
  		<td><?php echo $citation -> getCitDate();?></td>
  		<td><?php echo $citation -> getMoyenneNote();?></td>
  	</tr>
  	<?php }?>

  </table>
  <br /><?php
}?>


<?php
}else{
  echo "<p>Vous devez être connecté pour accéder à cette page !</p>";
  echo "<p><img class = 'icone' src='image/erreur.png' alt='Erreur connexion'>Redirection automatique dans 3 secondes</p>";
  header("Refresh: 3;URL=index.php");
}
?>
