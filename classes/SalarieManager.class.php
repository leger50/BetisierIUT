<?php
class SalarieManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
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
