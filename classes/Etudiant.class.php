<?php
class Etudiant {
    private $dep_nom;
    private $vil_nom;
    private $personne;

    public function __construct($personne,$valeursEtudiant = array()){
  		if(!empty($valeursEtudiant))
  			$this->affecte($valeursEtudiant, $personne);
  		}

  	public function affecte($donnees, $personne){
      foreach ($donnees as $attribut => $valeur) {
        switch ($attribut) {

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
