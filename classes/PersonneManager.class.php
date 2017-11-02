<?php
class PersonneManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}


    public function add($personne){
			if ($this->estPresente($personne)){
				return false;
			}else{
					$sql = 'INSERT INTO personne(per_nom, per_prenom, per_tel, per_mail, per_admin,per_login, per_pwd) VALUES (:nom, :prenom, :tel, :mail, 0, :login, :passwd)';
					$requete = $this->db->prepare($sql);

					$requete->bindValue(':nom', $personne->getPersNom());
					$requete->bindValue(':prenom', $personne->getPersPre());
					$requete->bindValue(':tel', $personne->getPersTel());
					$requete->bindValue(':mail', $personne->getPersMail());
					$requete->bindValue(':login', $personne->getPersLogin());
					$requete->bindValue(':passwd', $personne->getPersPwd());

					$retour=$requete->execute();
					return $retour;
    	}
		}

		public function getNumAjout($personne){
			$sql = 'SELECT per_num FROM personne WHERE per_nom = :nom AND per_prenom = :prenom';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':nom', $personne->getPersNom());
			$requete->bindValue(':prenom', $personne->getPersPre());

			$requete->execute();

			$resultat = $requete->fetch(PDO::FETCH_OBJ);
			return $resultat->per_num;
		}

		public function getAllPersonnes(){
			$listePersonnes = array();

			$sql = 'SELECT per_num , per_nom , per_prenom FROM personne';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while($personne = $requete->fetch(PDO::FETCH_OBJ)){
				$listePersonnes[] = new Personne($personne);
			}

			$requete->closeCursor();

			return $listePersonnes;
		}

    public function getOnePersonne($num){

			$sql = 'SELECT per_nom, per_prenom , per_mail , per_tel FROM personne WHERE per_num = :pernum ';

			$requete = $this->db->prepare($sql);
      $requete->bindValue(':pernum',$num);
			$requete->execute();

      $personne = new Personne($requete->fetch(PDO::FETCH_OBJ));

			$requete->closeCursor();

			return $personne;
		}

		private function estPresente($personne){
			$sql = 'SELECT per_nom, per_prenom FROM personne WHERE per_nom = :nom AND per_prenom = :prenom';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':nom', $personne->getPersNom());
			$requete->bindValue(':prenom', $personne->getPersPre());

			$requete->execute();

			$resultat = $requete->fetch(PDO::FETCH_OBJ);
			return $resultat != null;
		}

		public function estEtudiant($num){
			$sql = 'SELECT per_num FROM etudiant WHERE per_num = :pernum ';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':pernum',$num);
			$requete->execute();
			$personne = $requete->fetch(PDO::FETCH_OBJ);
			return $personne == null;
		}
}
