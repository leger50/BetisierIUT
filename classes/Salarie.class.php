<?php
class Salarie {
    private $tel_pro;
    private $fonction;
    private $personne;

    public function __construct($personne,$valeursSalarie = array()){
  		if(!empty($valeursSalarie))
  			$this->affecte($valeursSalarie, $personne);
  		}

  	public function affecte($donnees, $personne){
      foreach ($donnees as $attribut => $valeur) {
        switch ($attribut) {

          case 'sal_telprof':
  					$this->setTelPro($valeur);
  					break;

          case 'fon_libelle':
  					$this->setFonction($valeur);
  				break;
  			}
  		}
      $this->setPersonne($personne);
  	}


    public function getPersonne(){
  		return $this->personne;
  	}
  	public function setPersonne($pers){
  		$this->personne=$pers;
  	}

    public function getFonction() {
  		return $this->fonction;
  	}
  	public function setFonction($id){
  		$this->fonction=$id;
  	}

  	public function getTelPro(){
  		return $this->tel_pro;
  	}
  	public function setTelPro($nom){
  		$this->tel_pro=$nom ;
  	}

  }
