<?php
class EtudiantManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($etudiant){

			if($this->addPersonneEtu($etudiant->getPersonne())){

				$sql = 'INSERT INTO etudiant VALUES (:num, :depNum, :divNum)';
				$requete = $this->db->prepare($sql);

				$requete->bindValue(':num', $this->getNumEtu($etudiant->getPersonne()));
				$requete->bindValue(':depNum', $etudiant->getDepNum());
				$requete->bindValue(':divNum', $etudiant->getDivNum());

				$retour=$requete->execute();
				return $retour;
			}
			return false;

		}

		public function addPersonneEtu($personne){
			$pdo = new Mypdo();
			$personneManager = new PersonneManager($pdo);
			$retour = $personneManager->add($personne);
			return $retour;
		}

		public function getNumEtu($personne){
			$pdo = new Mypdo();
			$personneManager = new PersonneManager($pdo);
			$num = $personneManager->getNumAjout($personne);
			return $num;
		}

		public function getEtudiant($num){
			$sql = 'SELECT dep_num, div_num FROM etudiant WHERE per_num = :num';

			$requete = $this->db->prepare($sql);
      $requete->bindValue(':num',$num);
      $requete->execute();

			$pdo = new Mypdo();
      $perManager = new PersonneManager($pdo);

			$etudiant = new Etudiant($perManager->getOnePersonne($num),$requete->fetch(PDO::FETCH_OBJ));

			$requete->closeCursor();
      return $etudiant;
		}
}
