<?php

class VilleManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}

    public function add($ville){
			if ($this->estPresente($ville)){
				return false;
			}else{
				$sql = 'INSERT INTO ville(vil_nom) VALUES (:ville)';
				$requete = $this->db->prepare($sql);

				$requete->bindValue(':ville', $ville->getVilNom());

				$retour=$requete->execute();
				$requete->closeCursor();
				return $retour;
			}
    }

		public function update($ville){
			if ($this->estPresente($ville)){
				return false;
			}else{
				$sql = 'UPDATE ville SET vil_nom = :nom WHERE vil_num = (:num)';
				$requete = $this->db->prepare($sql);

				$requete->bindValue(':nom', $ville->getVilNom());
				$requete->bindValue(':num', $ville->getVilNum());

				$retour=$requete->execute();
				$requete->closeCursor();
				return $retour;
			}
    }

		private function estAssocie($ville){
			$sql = "SELECT COUNT(dep_num) AS villeAssocie FROM departement WHERE vil_num = :numVille";
			$requete = $this->db->prepare($sql);

			$requete->bindValue(':numVille', $ville->getVilNum());
			$requete->execute();
			$villeAssocie = $requete->fetch(PDO::FETCH_OBJ);
			$villeAssocie = $villeAssocie->villeAssocie;
			$requete->closeCursor();

			return $villeAssocie;
		}

		public function delete($ville){

				$villeAssocie = $this->estAssocie($ville);

				if($villeAssocie == 0){
					$sql = 'DELETE FROM ville WHERE vil_num = :num';
					$requete = $this->db->prepare($sql);

					$requete->bindValue(':num', $ville->getVilNum());

					$retour=$requete->execute();
					$requete->closeCursor();
					return $retour;
				}else{
					return false;
				}



    }

		public function getAllVilles(){
			$listeVilles = array();

			$sql = 'SELECT vil_num, vil_nom FROM ville';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while($ville = $requete->fetch(PDO::FETCH_OBJ)){
				$listeVilles[] = new Ville($ville);
			}

			$requete->closeCursor();
			return $listeVilles;
		}

		public function getVille($numVille){

			$sql = 'SELECT vil_num, vil_nom FROM ville WHERE vil_num = :num';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num', $numVille);
			$requete->execute();

			$ville = $requete->fetch(PDO::FETCH_OBJ);

			$requete->closeCursor();

			$newVille = new Ville($ville);
			return $newVille;
		}

		private function estPresente($ville){
			$sql = 'SELECT vil_nom FROM ville WHERE vil_nom = :ville';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':ville', $ville->getVilNom());

			$requete->execute();

			$resultat = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();
			return $resultat != null;
		}
}

?>
