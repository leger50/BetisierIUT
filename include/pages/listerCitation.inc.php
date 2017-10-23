<?php
	$pdo=new Mypdo();
	$citManager = new CitationManager($pdo);
	$citations = $citManager -> getAllCitations();
?>

<h1>Liste des citations déposées</h1>
<p>Actuellement <?php echo count($citations)?> citation(s) sont enregistrée(s)</p>

<table>
	<tr>
		<th>Nom de l'enseignant</th>
		<th>Libellé</th>
		<th>Date</th>
		<th>Moyenne des notes</th>
	</tr>

	<?php //$produits est un tableau d'objet produit
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
