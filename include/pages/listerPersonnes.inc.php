<?php
	$pdo = new Mypdo();
	$perManager = new PersonneManager($pdo);
	$personnes = $perManager -> getAllPersonnes();
?>

<h1>Liste des Personnes</h1>
<p>Actuellement <?php echo count($personnes) ?> personne(s) sont enregistrée(s)</p>

<table>
	<tr>
		<th>Numéro</th>
		<th>Nom</th>
		<th>Prénom</th>
	</tr>

	<?php
		foreach ($personnes as $personne){ $numpers = $personne -> getPersNum();?>
	<tr>
		<td><a href="index.php?page=13" name="link"><?php echo $numpers;?></a></td>
		<td><?php echo $personne -> getPersNom();?></td>
		<td><?php echo $personne -> getPersPre();?></td>
	</tr>

	<?php }
		$_SESSION['numper']=55;
	?>

</table>

<p>Cliquer sur le numéro de la personne pour obtenir plus d'informations.</p>
<br />
