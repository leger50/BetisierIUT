<?php
class ConnexionManager {

	private $db;

		public function __construct($db){
			$this->db = $db;
		}

    public function verifInfos($login, $pw){
      $pwd = protectedPassword($pw);

      $sql = 'SELECT per_login, per_pwd FROM personne WHERE per_login = :login';

			$requete = $this->db->prepare($sql);
      $requete->bindValue(':login',$login);
			$requete->execute();
      $user = $requete->fetch(PDO::FETCH_OBJ);

			if($user == null){
				return false;
			}else{
				$pwdEnregistre = $user->per_pwd;
	      return $pwd == $pwdEnregistre;
			}
    }

		public function captchaValide($nb1, $nb2, $nbSaisi){
			return ($nb1 + $nb2) == $nbSaisi;
		}

    public function estAdmin($login){
      $sql = 'SELECT per_admin FROM personne WHERE per_login = :login';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':login',$login);
			$requete->execute();
      $estAdmin = $requete->fetch(PDO::FETCH_OBJ);

      return $estAdmin->per_admin == 1;
    }
}
?>
