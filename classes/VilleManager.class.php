<?php

class VilleManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}


    /*  public function add($ville){
					$requete = $this->db->prepare(
					'INSERT INTO client(clinom, clipre) VALUES ( :clinom, :clipre);');

					$requete->bindValue(':clinom',$client->getNom());
					$requete->bindValue(':clipre',$client->getPrenom());

					$retour=$requete->execute();
					return $retour;
        } */

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
}

?>
