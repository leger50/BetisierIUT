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

		public function getNumSal($personne){
			$pdo = new Mypdo();
			$personneManager = new PersonneManager($pdo);
			$num = $personneManager->getNumAjout($personne);
			return $num;
		}

    public function getOneSalarie($num){

      $sql = 'SELECT sal_telprof,fon_libelle FROM salarie s
              INNER JOIN fonction f  ON f.fon_num= s.fon_num
              WHERE per_num = :pernum';

      $requete = $this->db->prepare($sql);
      $requete->bindValue(':pernum',$num);
      $requete->execute();

      $pdo = new Mypdo();
      $perManager = new PersonneManager($pdo);
      $salarie = new Salarie($perManager->getOnePersonne($num),$requete->fetch(PDO::FETCH_OBJ));

      $requete->closeCursor();

      return $salarie;
    }
}
