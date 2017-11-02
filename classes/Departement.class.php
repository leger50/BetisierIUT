<?php

class Departement{

	private $depNum;
	private $depNom;
  private $depVilleNum;

  public function __construct($valeurs = array()) {
    	if(!empty($valeurs)){
				$this->affecte($valeurs);
			}
  }

	public function affecte($donnees){

		foreach ($donnees as $attribut => $valeur) {

			switch ($attribut) {
				case 'dep_num':
					$this->setDepNum($valeur);
					break;

				case 'dep_nom':
					$this->setDepNom($valeur);
					break;

        case 'vil_num':
  				$this->setDepVilleNum($valeur);
  				break;

				default:
					# code...
					break;
			}
		}
	}

	public function getDepNum(){
		return $this->depNum;
	}

	public function setDepNum($num){
		if(is_numeric($num)){
			$this->depNum = $num;
		}
	}

	public function getDepNom(){
		return $this->depNom;
	}

	public function setDepNom($nom){
		if(is_string($nom)){
			$this->depNom = $nom;
		}
	}

  public function getDepVilleNum(){
		return $this->depVilleNum;
	}

	public function setDepVilleNum($num){
		if(is_numeric($num)){
			$this->depVilleNum = $num;
		}
	}
}
?>
