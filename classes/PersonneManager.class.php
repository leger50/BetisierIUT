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
					$requete->closeCursor();
					return $retour;
    	}
		}

		public function update($personne){
				$sql = 'UPDATE personne SET per_nom=:nom, per_prenom=:prenom, per_tel=:tel, per_mail=:mail, per_login=:login
								WHERE per_num = :num';
				$requete = $this->db->prepare($sql);

				$requete->bindValue(':num', $personne->getPersNum());
				$requete->bindValue(':nom', $personne->getPersNom());
				$requete->bindValue(':prenom', $personne->getPersPre());
				$requete->bindValue(':tel', $personne->getPersTel());
				$requete->bindValue(':mail', $personne->getPersMail());
				$requete->bindValue(':login', $personne->getPersLogin());

				$retour=$requete->execute();
				$requete->closeCursor();
				return $retour;
		}

		public function getNumAjout($personne){
			$sql = 'SELECT per_num FROM personne WHERE per_nom = :nom AND per_prenom = :prenom';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':nom', $personne->getPersNom());
			$requete->bindValue(':prenom', $personne->getPersPre());

			$requete->execute();

			$resultat = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();
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

			$sql = 'SELECT per_num, per_nom, per_prenom , per_tel, per_mail , per_login FROM personne WHERE per_num = :pernum ';

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
			$requete->closeCursor();
			return $resultat != null;
		}

		public function estEtudiant($num){
			$sql = 'SELECT COUNT(per_num) AS estEtudiant FROM etudiant WHERE per_num = :pernum ';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':pernum',$num);
			$requete->execute();

			$estEtudiant = $requete->fetch(PDO::FETCH_OBJ);
			$estEtudiant = $estEtudiant->estEtudiant;

			$requete->closeCursor();

			return $estEtudiant != 0;
		}

		public function getNumLogin($login){
			$sql = 'SELECT per_num FROM personne WHERE per_login=:per_login';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':per_login',$login);
			$requete->execute();
			$resultat = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();
			return $resultat->per_num;

		}

		public function delete($personne){
			$num = $personne->getPersNum();

			$sql = 'DELETE FROM vote WHERE cit_num = :num';
			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num', $num);
			$requete->execute();
			$requete->closeCursor();

			$sql = 'DELETE FROM citation WHERE cit_num = :num';
			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num', $num);
			$requete->execute();
			$requete->closeCursor();

			$sql = 'DELETE FROM etudiant WHERE per_num = :num';
			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num', $num);
			$requete->execute();
			$requete->closeCursor();

			$sql = 'DELETE FROM salarie WHERE per_num = :num';
			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num', $num);
			$requete->execute();
			$requete->closeCursor();

			$sql = 'DELETE FROM personne WHERE per_num = :num';
			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num', $num);
			$retour = $requete->execute();
			$requete->closeCursor();
			return $retour;
		}
}
