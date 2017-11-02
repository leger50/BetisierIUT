<?php

class FonctionManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function getAllFonctions(){
			$listeFonctions = array();

			$sql = 'SELECT fon_num, fon_libelle FROM fonction';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while($fonction = $requete->fetch(PDO::FETCH_OBJ)){
				$listeFonctions[] = new Fonction($fonction);
			}

			$requete->closeCursor();
			return $listeFonctions;
		}

		public function getOneFonction($num){

			$sql = 'SELECT fon_num, fon_libelle FROM fonction WHERE fon_num = :num';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num',$num);
			$requete->execute();

			$fonction = new Fonction($requete->fetch(PDO::FETCH_OBJ));

			$requete->closeCursor();
			return $fonction;
		}
}

?>
