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

	public function delete($citation){

			$sql = 'DELETE FROM vote WHERE cit_num = :num';
			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num', $citation->getCitNum());
			$requete->execute();

			$sql = 'DELETE FROM citation WHERE cit_num = :num';
			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num', $citation->getCitNum());
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

	public function getCitation($numCit){

		$sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation WHERE cit_num=:num ';

		$requete = $this->db->prepare($sql);
		$requete->bindValue(':num', $numCit);
		$requete->execute();

		$citation = $requete->fetch(PDO::FETCH_OBJ);

		$requete->closeCursor();

		$newCitation = new Citation($citation, $this->getVotes($citation->cit_num));
		return $newCitation;
	}

  private function getVotes($numCitation){
    $pdo=new Mypdo();
  	$voteManager = new VoteManager($pdo);
  	$votesCitation = $voteManager -> getAllVoteOfCitation($numCitation);
    return $votesCitation;
  }

	public function getFiltredCitation($perNum, $dateCit, $note){
		$listeCitations = array();

			if(($perNum!=NULL) && ($dateCit==NULL) && ($note==NULL)){

				$sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation WHERE cit_valide = 1 AND cit_date_valide IS NOT NULL AND per_num=:num';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':num',$perNum);

			}elseif (($perNum==NULL) && ($dateCit!=NULL) && ($note==NULL)) {

				$sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation WHERE cit_valide = 1 AND cit_date_valide IS NOT NULL AND cit_date=:datecit';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':datecit',$dateCit);

			}elseif (($perNum==NULL) && ($dateCit==NULL) && ($note!=NULL)) {

				$sql = 'SELECT c.cit_num, c.per_num, c.cit_libelle, c.cit_date FROM citation c INNER JOIN vote v ON v.cit_num = c.cit_num WHERE c.cit_valide = 1 AND c.cit_date_valide IS NOT NULL AND v.vot_valeur=:note';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':note',$note);

			}elseif (($perNum!=NULL) && ($dateCit!=NULL) && ($note==NULL)) {

				$sql = 'SELECT cit_num, per_num, cit_libelle, cit_date FROM citation WHERE cit_valide = 1 AND cit_date_valide IS NOT NULL AND per_num=:num AND cit_date=:datecit';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':num',$perNum);
				$requete->bindValue(':datecit',$dateCit);

			}elseif (($perNum==NULL) && ($dateCit!=NULL) && ($note!=NULL)) {

				$sql = 'SELECT c.cit_num, c.per_num, c.cit_libelle, c.cit_date FROM citation c INNER JOIN vote v ON v.cit_num = c.cit_num WHERE c.cit_valide = 1 AND c.cit_date_valide IS NOT NULL AND v.vot_valeur=:note AND c.cit_date=:datecit ';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':note',$note);
				$requete->bindValue(':datecit',$dateCit);

			}elseif (($perNum!=NULL) && ($dateCit==NULL) && ($note!=NULL)) {

				$sql = 'SELECT c.cit_num, c.per_num, c.cit_libelle, c.cit_date FROM citation c INNER JOIN vote v ON v.cit_num = c.cit_num WHERE c.cit_valide = 1 AND c.cit_date_valide IS NOT NULL AND v.vot_valeur=:note AND c.per_num=:num';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':note',$note);
				$requete->bindValue(':num',$perNum);

			}elseif (($perNum!=NULL) && ($dateCit!=NULL) && ($note!=NULL)) {

				$sql = 'SELECT c.cit_num, c.per_num, c.cit_libelle, c.cit_date FROM citation c INNER JOIN vote v ON v.cit_num = c.cit_num WHERE c.cit_valide = 1 AND c.cit_date_valide IS NOT NULL AND v.vot_valeur=:note AND c.per_num=:num AND c.cit_date=:datecit';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':note',$note);
				$requete->bindValue(':num',$perNum);
				$requete->bindValue(':datecit',$dateCit);

			}

			$requete->execute();
			while($citation = $requete->fetch(PDO::FETCH_OBJ)){
				$listeCitations[] = new Citation($citation, $this->getVotes($citation->cit_num));
			}
			$requete->closeCursor();
			return $listeCitations;

	}
}

?>
