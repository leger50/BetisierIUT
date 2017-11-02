<?php
class Salarie {
    private $personne;

    private $tel_pro;
    private $num_fonction;


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

          case 'fon_num':
            $this->setNumFonction($valeur);
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

    public function getNumFonction() {
  		return $this->num_fonction;
  	}

  	public function setNumFonction($num){
      if(is_numeric($num)){
  			$this->num_fonction=$num;
  		}
  	}

  	public function getTelPro(){
  		return $this->tel_pro;
  	}
  	public function setTelPro($tel){
  		$this->tel_pro=$tel ;
  	}
  }
