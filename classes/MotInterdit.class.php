<?php

class MotInterdit{

	private $motLib;


  public function __construct($valeurs = array()) {
    	if(!empty($valeurs)){
				$this->affecte($valeurs);
			}
  }

	public function affecte($donnees){

		foreach ($donnees as $attribut => $valeur) {

			switch ($attribut) {
				case 'mot_interdit':
					$this->setMot($valeur);
					break;

				default:
					# code...
					break;
			}
		}
	}

	public function getMot(){
		return $this->motLib;
	}

	public function setMot($mot){
		if(is_string($mot)){
			$this->motLib = $mot;
		}
	}
}

?>
