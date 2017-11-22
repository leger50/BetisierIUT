<?php
class MotsInterditsManager {
	private $db;

	public function __construct($db){
		$this->db = $db;
	}



  public function hasMotsInterdits($citation){

    $sql = 'SELECT mot_interdit FROM mot WHERE MATCH (mot_interdit) AGAINST ( :lib )';
    $requete = $this->db->prepare($sql);

    $requete->bindValue(':lib',$citation->getCitLib());
    $requete->execute();
    $mot = $requete->fetch(PDO::FETCH_OBJ);
    return $mot != null;
  }

  public function getAllMotsInterdits($citation){
    $listeMotsInterdits = array();

    $sql = 'SELECT mot_interdit FROM mot WHERE MATCH (mot_interdit) AGAINST ( :lib )';
    $requete = $this->db->prepare($sql);

    $requete->bindValue(':lib',$citation->getCitLib());
    $requete->execute();

    while($motInterdit = $requete->fetch(PDO::FETCH_OBJ)){
      $listeMotsInterdits[] = new MotInterdit($motInterdit);
    }

    $requete->closeCursor();

    return $listeMotsInterdits;
  }

	public function estInterdit($mot){
    $sql = 'SELECT mot_interdit FROM mot WHERE MATCH (mot_interdit) AGAINST ( :mot )';
    $requete = $this->db->prepare($sql);

    $requete->bindValue(':mot',$mot);
		$requete->execute();
    $interdit = $requete->fetch(PDO::FETCH_OBJ);
    return $interdit != null;
  }

}
?>
