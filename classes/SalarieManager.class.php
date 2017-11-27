<?php
class SalarieManager {
	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($salarie){

			if($this->addPersonneSal($salarie->getPersonne())){

				$sql = 'INSERT INTO salarie VALUES (:num, :tel, :numFonction)';
				$requete = $this->db->prepare($sql);

				$requete->bindValue(':num', $this->getNumSal($salarie->getPersonne()));
				$requete->bindValue(':tel', $salarie->getTelPro());
				$requete->bindValue(':numFonction', $salarie->getNumFonction());

				$retour=$requete->execute();
				return $retour;
			}
			return false;

		}

		public function addPersonneSal($personne){
			$pdo = new Mypdo();
			$personneManager = new PersonneManager($pdo);
			$retour = $personneManager->add($personne);
			return $retour;
		}

		public function update($salarie){
			$personne = $salarie->getPersonne();

			if($this->updatePersonneSal($personne)){

				$sql = 'UPDATE salarie SET sal_telprof=:telPro, fon_num=:foncNum WHERE per_num=:num';
				$requete = $this->db->prepare($sql);

				$requete->bindValue(':num', $personne->getPersNum());
				$requete->bindValue(':telPro', $salarie->getTelPro());
				$requete->bindValue(':foncNum', $salarie->getNumFonction());

				$retour=$requete->execute();
				return $retour;
			}
			return false;

		}

		public function updatePersonneSal($personne){
			$pdo = new Mypdo();
			$personneManager = new PersonneManager($pdo);
			$retour = $personneManager->update($personne);
			return $retour;
		}

		public function getNumSal($personne){
			$pdo = new Mypdo();
			$personneManager = new PersonneManager($pdo);
			$num = $personneManager->getNumAjout($personne);
			return $num;
		}

		public function getSalarie($num){
			$sql = 'SELECT sal_telprof, fon_num FROM salarie WHERE per_num = :num';

			$requete = $this->db->prepare($sql);
      $requete->bindValue(':num',$num);
      $requete->execute();

			$pdo = new Mypdo();
      $perManager = new PersonneManager($pdo);

			$salarie = new Salarie($perManager->getOnePersonne($num),$requete->fetch(PDO::FETCH_OBJ));

			$requete->closeCursor();
      return $salarie;
		}

		public function getAllSalaries(){
			$listeSalaries = array();

			$sql = 'SELECT per_num, sal_telprof, fon_num FROM salarie';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$pdo = new Mypdo();
      $perManager = new PersonneManager($pdo);
			$listePersonnes = $perManager->getAllPersonnes();

			while($salarie = $requete->fetch(PDO::FETCH_OBJ)){
				$listeSalaries[] = new Salarie($perManager->getOnePersonne($salarie->per_num),$salarie);
			}

			$requete->closeCursor();

			return $listeSalaries;
		}
}
