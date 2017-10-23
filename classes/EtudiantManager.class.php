<?php
class EtudiantManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}

    public function getOneEtudiant($num){

      $sql = 'SELECT dep_nom, vil_nom FROM departement d
              INNER JOIN etudiant e ON e.dep_num = d.dep_num
              INNER JOIN ville v ON v.vil_num = d.vil_num
              WHERE per_num = :pernum';

      $requete = $this->db->prepare($sql);
      $requete->bindValue(':pernum',$num);
      $requete->execute();

      $pdo = new Mypdo();
      $perManager = new PersonneManager($pdo);
      $etudiant = new Etudiant($perManager->getOnePersonne($num),$requete->fetch(PDO::FETCH_OBJ));

      $requete->closeCursor();

      return $etudiant;
    }
}
