<?php
	$pdo = new Mypdo();
	$perManager = new PersonneManager($pdo);
	$personnes = $perManager -> getAllPersonnes();

	if(isset($_SESSION['estConnecte'])){ ?>
		<a id="lienPass" href="index.php?page=17">Modifier mon mot de passe</a>
<?php } ?>

<h1>Liste des Personnes</h1>
<p>Actuellement <?php echo count($personnes) ?> personne(s) sont enregistrée(s)</p>

<table>
	<tr>
		<th>Numéro</th>
		<th>Nom</th>
		<th>Prénom</th>

	</tr>

	<?php
		foreach ($personnes as $personne){
			$numPersonne = $personne -> getPersNum();?>

	<tr>
		<td><a href="index.php?page=5&amp;id=<?php echo $numPersonne?>"><?php echo $numPersonne;?></a></td>
		<td><?php echo $personne -> getPersNom();?></td>
		<td><?php echo $personne -> getPersPre();?></td>
	</tr>

	<?php }	?>

</table>

<p>Cliquer sur le numéro de la personne pour obtenir plus d'informations.</p>
<br />
