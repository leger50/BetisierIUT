<?php
class ConnexionManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}

    public function verifLogin($login){
      $sql = 'SELECT per_login FROM personne';

			$requete = $this->db->prepare($sql);
			$requete->execute();
      $existe = $requete->fetch(PDO::FETCH_OBJ);

      return $existe == null;
    }

    public function verifPassword($pw){
      $pwd = protectedPassword($pw);

      $sql = 'SELECT per_pwd FROM personne';

			$requete = $this->db->prepare($sql);
			$requete->execute();
      $pwdEnregistre = $requete->fetch(PDO::FETCH_OBJ);

      return $pwdEnregistre == $pwd;
    }

    public function estAdmin($login){
      $sql = 'SELECT per_admin FROM personne';

			$requete = $this->db->prepare($sql);
			$requete->execute();
      $estAdmin = $requete->fetch(PDO::FETCH_OBJ);

      return $estAdmin == 1;
    }
