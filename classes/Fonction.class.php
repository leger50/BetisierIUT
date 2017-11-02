<?php

class Fonction{

	private $fonNum;
	private $fonLibelle;

  public function __construct($valeurs = array()) {
    	if(!empty($valeurs)){
				$this->affecte($valeurs);
			}
  }

	public function affecte($donnees){

		foreach ($donnees as $attribut => $valeur) {

			switch ($attribut) {
				case 'fon_num':
					$this->setFonNum($valeur);
					break;

				case 'fon_libelle':
					$this->setFonLibelle($valeur);
					break;

				default:
					# code...
					break;
			}
		}
	}

	public function getFonNum(){
		return $this->fonNum;
	}

	public function setFonNum($num){
		if(is_numeric($num)){
			$this->fonNum = $num;
		}
	}

	public function getFonLibelle(){
		return $this->fonLibelle;
	}

	public function setFonLibelle($libelle){
		if(is_string($libelle)){
			$this->fonLibelle = $libelle;
		}
	}
}
?>
