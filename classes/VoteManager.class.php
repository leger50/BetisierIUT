<?php
class VoteManager {
	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	/*public function add($client){
					$requete = $this->db->prepare("INSERT INTO client (clinom, clipre, clilogin, clipass) VALUES (:nom, :prenom, '', '');");

					$requete->bindValue(':nom', $client->getCliNom());
					$requete->bindValue(':prenom', $client->getCliPrenom());

					$retour=$requete->execute();

					return $retour;
	}*/

	//Utile ?
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
}

?>
