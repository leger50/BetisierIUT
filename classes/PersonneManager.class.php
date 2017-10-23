<?php
class PersonneManager {

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

		public function getAllPersonnes(){
			$listePersonnes = array();

			$sql = 'SELECT per_num , per_nom , per_prenom FROM personne';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while($personne = $requete->fetch(PDO::FETCH_OBJ)){
				$listePersonnes[] = new Personne($personne);
			}

			$requete->closeCursor();

			return $listePersonnes;
		}

    public function getOnePersonne($num){

			$sql = 'SELECT per_nom, per_prenom , per_mail , per_tel FROM personne WHERE per_num = :pernum ';

			$requete = $this->db->prepare($sql);
      $requete->bindValue(':pernum',$num);
			$requete->execute();

      $personne = new Personne($requete->fetch(PDO::FETCH_OBJ));

			$requete->closeCursor();

			return $personne;
		}

		public function estEtudiant($num){
			$sql = 'SELECT per_num FROM etudiant WHERE per_num = :pernum ';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':pernum',$num);
			$requete->execute();
			$personne = $requete->fetch(PDO::FETCH_OBJ);
			return $personne == null;
		}
}
