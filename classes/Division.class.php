<?php

class Division{

	private $divNum;
	private $divNom;

  public function __construct($valeurs = array()) {
    	if(!empty($valeurs)){
				$this->affecte($valeurs);
			}
  }

	public function affecte($donnees){

		foreach ($donnees as $attribut => $valeur) {

			switch ($attribut) {
				case 'div_num':
					$this->setDivNum($valeur);
					break;

				case 'div_nom':
					$this->setDivNom($valeur);
					break;

				default:
					# code...
					break;
			}
		}
	}

	public function getDivNum(){
		return $this->divNum;
	}

	public function setDivNum($num){
		if(is_numeric($num)){
			$this->divNum = $num;
		}
	}

	public function getDivNom(){
		return $this->divNom;
	}

	public function setDivNom($nom){
		if(is_string($nom)){
			$this->divNom = $nom;
		}
	}
}
?>
