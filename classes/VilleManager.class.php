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
				return $retour;
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

		private function estPresente($ville){
			$sql = 'SELECT vil_nom FROM ville WHERE vil_nom = :ville';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':ville', $ville->getVilNom());

			$requete->execute();

			$resultat = $requete->fetch(PDO::FETCH_OBJ);
			return $resultat != null;
		}
}

?>
