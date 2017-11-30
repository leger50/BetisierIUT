<?php
	$pdo=new Mypdo();
	$citManager = new CitationManager($pdo);
	$citations = $citManager -> getAllCitations();
?>

<h1>Liste des citations déposées</h1>
<p>Actuellement <?php echo count($citations)?> citation(s) sont enregistrée(s)</p>

<table id="tableCitation">
	<tr>
		<th>Nom de l'enseignant</th>
		<th>Libellé</th>
		<th>Date</th>
		<th>Moyenne des notes</th>

		<?php
		if(isset($_SESSION['estConnecte']) && !$_SESSION['admin']){
			$perManager = new PersonneManager($pdo);
			$voteManager = new VoteManager($pdo);

			$numEtudiant = $perManager->getNumLogin($_SESSION['login']);

			echo "<th>Noter</th>";
		}
		?>

	</tr>

	<?php //$produits est un tableau d'objet produit
		foreach ($citations as $citation){?>
	<tr>
		<td><?php echo $citation -> getNomEnseignant($citation->getCitNumEnseignant());?></td>
		<td><?php echo $citation -> getCitLib();?></td>
		<td><?php echo $citation -> getCitDate();?></td>
		<td><?php echo $citation -> getMoyenneNote();?></td>

		<?php
		if(isset($_SESSION['estConnecte']) && !$_SESSION['admin']){
			$numCitation = $citation->getCitNum();
			if($voteManager->etudiantANoteCitation($numCitation, $numEtudiant)){
				$result = "<img class='icone' src='image/erreur.png' alt='Noter citation'>";
			}else{
				$result = "<a href='index.php?page=16&amp;numCit=".$numCitation."'><img class='icone' src='image/modifier.png' alt='Noter citation'></a>";
			}
			echo "<td>".$result."</td>";
		}
		?>

	</tr>
	<?php }?>

</table>
<br />
