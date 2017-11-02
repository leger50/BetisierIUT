<?php

class DepartementManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function getAllDepartements(){
			$listeDepartements = array();

			$sql = 'SELECT dep_num, dep_nom, vil_num FROM departement';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while($departement = $requete->fetch(PDO::FETCH_OBJ)){
				$listeDepartements[] = new Departement($departement);
			}

			$requete->closeCursor();
			return $listeDepartements;
		}

		public function getOneDepartement($num){

			$sql = 'SELECT dep_num, dep_nom, vil_num FROM departement WHERE dep_num = :num';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':num',$num);
			$requete->execute();

			$departement = new Departement($requete->fetch(PDO::FETCH_OBJ));

			$requete->closeCursor();
			return $departement;
		}
}

?>
