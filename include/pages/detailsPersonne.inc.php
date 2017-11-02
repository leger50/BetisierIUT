<?php
$numPersonne = $_GET['id'];

$pdo = new Mypdo();
$perManager = new PersonneManager($pdo);

if($perManager->estEtudiant($numPersonne)==null){

$etuManager = new EtudiantManager($pdo);
$etudiant = $etuManager -> getEtudiant($numPersonne);

$departementManager = new DepartementManager($pdo);
$departement = $departementManager->getOneDepartement($etudiant->getDepNum());

$villeManager = new VilleManager($pdo);
$ville = $villeManager->getNomVille($departement->getDepVilleNum());
?>

<h1>Détail sur : <?php echo $etudiant->getPersonne()->getPersNom(); ?> </h1>

<table>
	<tr>
		<th>Prénom</th>
		<th>Mail</th>
		<th>Tel</th>
    <th>Département</th>
    <th>Ville</th>
	</tr>
	<tr>
		<td><?php echo $etudiant->getPersonne()->getPersPre();?></td>
		<td><?php echo $etudiant->getPersonne()->getPersMail();?></td>
		<td><?php echo $etudiant->getPersonne()->getPersTel();?></td>
    <td><?php echo $departement->getDepNom();?></td>
		<td><?php echo $ville;?></td>
	</tr>
</table>
<br />

<?php }else{
	$salManager = new SalarieManager($pdo);
	$salarie = $salManager->getSalarie($numPersonne);

  $fonctionManager = new FonctionManager($pdo);
  $fonction = $fonctionManager->getOneFonction($salarie->getNumFonction());
	?>

	<h1>Détail sur: <?php echo $salarie->getPersonne()->getPersNom(); ?> </h1>

	<table>
		<tr>
			<th>Prénom</th>
			<th>Mail</th>
			<th>Tel</th>
	    <th>Telephone pro</th>
	    <th>Fonction</th>
		</tr>
		<tr>
			<td><?php echo $salarie -> getPersonne() -> getPersPre();?></td>
			<td><?php echo $salarie -> getPersonne() -> getPersMail();?></td>
			<td><?php echo $salarie -> getPersonne() -> getPersTel();?></td>
	    <td><?php echo $salarie -> getTelPro();?></td>
			<td><?php echo $fonction -> getFonLibelle();?></td>
		</tr>
	</table>
	<br /><?php } ?>
