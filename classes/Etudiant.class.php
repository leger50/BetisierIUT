<?php
class Etudiant {
    private $personne;

    private $dep_num;
    private $div_num;

    private $dep_nom; // a modifier avec le num
    private $vil_nom; //a supprimer

    public function __construct($personne,$valeursEtudiant = array()){
  		if(!empty($valeursEtudiant))
  			$this->affecte($valeursEtudiant, $personne);
  		}

  	public function affecte($donnees, $personne){
      foreach ($donnees as $attribut => $valeur) {
        switch ($attribut) {

          case 'dep_num':
            $this->setDepNum($valeur);
            break;

          case 'div_num':
            $this->setDivNum($valeur);
            break;

          case 'dep_nom':
  					$this->setDepNom($valeur);
  					break;

          case 'vil_nom':
  					$this->setVilleNom($valeur);
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

    public function getDepNum() {
  		return $this->dep_num;
  	}
  	public function setDepNum($num){
      if(is_numeric($num)){
  			$this->dep_num = $num;
  		}
  	}

    public function getDivNum() {
  		return $this->div_num;
  	}

  	public function setDivNum($num){
      if(is_numeric($num)){
  		  $this->div_num=$num;
      }
  	}

    public function getDepNom() {
  		return $this->dep_nom;
  	}
  	public function setDepNom($id){
  		$this->dep_nom=$id;
  	}

  	public function getVilleNom(){
  		return $this->vil_nom;
  	}
  	public function setVilleNom($nom){
  		$this->vil_nom=$nom;
  	}

  }
