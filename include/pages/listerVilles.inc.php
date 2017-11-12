<?php
	$pdo = new Mypdo();
	$vilManager = new VilleManager($pdo);
	$villes = $vilManager -> getAllVilles();
?>

<h1>Liste des villes</h1>
<p>Actuellement <?php echo count($villes) ?> ville(s) sont enregistrée(s)</p>

<table>
	<tr>
		<th>Numéro</th>
		<th>Nom</th>
	</tr>

	<?php
		foreach ($villes as $ville){?>
	<tr>
		<td><?php echo $ville->getVilNum();?></td>
		<td><?php echo $ville->getVilNom();?></td>
	</tr>
	<?php }?>

</table>
<br />
