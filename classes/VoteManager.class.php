<?php
class VoteManager {
	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function getAllVote() {
		$listeVotes = array();

		$sql = 'SELECT cit_num, per_num, vot_valeur FROM vote ORDER BY cit_num';
		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($vote = $requete->fetch(PDO::FETCH_OBJ)){
			$listeVotes[] = new Vote($vote);
		}

		$requete->closeCursor();
		return $listeVotes;
	}

	public function getAllVoteOfCitation($numCitation) {
		$listeVotes = array();

		$sql = "SELECT cit_num, per_num, vot_valeur FROM vote WHERE cit_num = :num";
		$requete = $this->db->prepare($sql);
		$requete->bindValue(':num',$numCitation);
		$requete->execute();

		while($vote = $requete->fetch(PDO::FETCH_OBJ)){
			$listeVotes[] = new Vote($vote);
		}

		$requete->closeCursor();
		return $listeVotes;
	}

	public function etudiantANoteCitation($numCitation, $numEtudiant){
		$sql = "SELECT COUNT(cit_num) AS aVote FROM vote WHERE cit_num = :numCit AND per_num = :perNum";

		$requete = $this->db->prepare($sql);
		$requete->bindValue(':numCit',$numCitation);
		$requete->bindValue(':perNum',$numEtudiant);

		$requete->execute();

		$aVote = $requete->fetch(PDO::FETCH_OBJ);
		$requete->closeCursor();

		$aVote = $aVote->aVote;
		return $aVote != 0;
	}

	public function voterCitation($numCitation, $numEtudiant, $valeurVote){
		$sql = 'INSERT INTO vote VALUES (:numCit, :numEtu, :valVote)';

		$requete = $this->db->prepare($sql);
		$requete->bindValue(':numCit', $numCitation);
		$requete->bindValue(':numEtu', $numEtudiant);
		$requete->bindValue(':valVote', $valeurVote);
		$retour=$requete->execute();

		$requete->closeCursor();

		return $retour;
	}
}

?>
