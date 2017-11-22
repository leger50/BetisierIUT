<?php
class CitationManager {
	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function add($citation, $numetu){

					$requete = $this->db->prepare("INSERT INTO citation (per_num, per_num_etu, cit_date, cit_libelle) VALUES (:num, :etu, :datecit, :libelle);");

					$requete->bindValue(':num', $citation->getCitNumEnseignant());
					$requete->bindValue(':etu', $numetu );
					$requete->bindValue(':datecit', getEnglishDate($citation->getCitDate()));
					$requete->bindValue(':libelle', $citation->getCitLib());

					$retour=$requete->execute();

					return $retour;
	}

	public function getAllCitations() {
		$listeCitations = array();

		$sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation WHERE cit_valide = 1 AND cit_date_valide IS NOT NULL';
		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($citation = $requete->fetch(PDO::FETCH_OBJ)){
			$listeCitations[] = new Citation($citation, $this->getVotes($citation->cit_num));
		}

		$requete->closeCursor();
		return $listeCitations;
	}

  private function getVotes($numCitation){
    $pdo=new Mypdo();
  	$voteManager = new VoteManager($pdo);
  	$votesCitation = $voteManager -> getAllVoteOfCitation($numCitation);
    return $votesCitation;
  }
}

?>
