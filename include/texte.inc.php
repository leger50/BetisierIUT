<div id="texte">
<?php
if (!empty($_GET["page"])){
	$page=$_GET["page"];}
	else
	{$page=0;
	}

switch ($page) {

//
// Personnes
//
case 0:
	// inclure ici la page accueil photo
	include_once('pages/accueil.inc.php');
	break;

case 1:
	// inclure ici la page lister personnes
	include("pages/listerPersonnes.inc.php");
  break;

case 2:
	// inclure ici la page ajouter personnes
	include_once('pages/ajouterPersonne.inc.php');
  break;

case 3:
	// inclure ici la page modification des personnes
	include("pages/modifierPersonne.inc.php");
  break;

case 4:
	// inclure ici la page suppression personnes
	include_once('pages/supprimerPersonne.inc.php');
  break;

case 5:
	// inclure ici la page détails personnes
	include_once('pages/detailsPersonne.inc.php');
	break;

//
// Citations
//
case 6:
	// inclure ici la page lister citations
  include("pages/listerCitation.inc.php");
  break;

case 7:
	// inclure ici la page ajouter citations
	include("pages/ajouterCitation.inc.php");
  break;

case 8:
	include("pages/rechercherCitation.inc.php");
	break;

case 9:
		include("pages/validerCitation.inc.php");
	break;

case 10:
	include("pages/supprimerCitation.inc.php");
	break;

//
// Villes
//
case 11:
	// inclure ici la page lister ville
	include("pages/listerVilles.inc.php");
  break;

case 12:
	// inclure ici la page ajouter  ville
	include("pages/ajouterVille.inc.php");
  break;

case 13:
	// inclure ici la page modifier ville
	include("pages/modifierVille.inc.php");
  break;

case 14:
	// inclure ici la page supprimer ville
	include("pages/supprimerVille.inc.php");
  break;

//
// Autres
//
case 15:
	// inclure ici la page connexion
	include("pages/connexion.inc.php");
  break;

case 16:
	// inclure ici la page noterCitation
	include("pages/noterCitation.inc.php");
  break;

case 17:
	// inclure ici la page noterCitation
	include("pages/modifierPassword.inc.php");
  break;

default :
	include_once('pages/accueil.inc.php');
}

?>
</div>
