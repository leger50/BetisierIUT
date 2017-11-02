<?php
class Personne {
	private $persnum;
	private $persnom;
	private $perspre;
	private $perstel;
	private $persmail;
	private $perslogin;
	private $persPwd;

	public function __construct($valeurs = array()){
		if(!empty($valeurs))
			$this->affecte($valeurs);
		}

	public function affecte($donnees){

    foreach ($donnees as $attribut => $valeur) {

      switch ($attribut) {

        case 'per_num':
					$this->setPersNum($valeur);
					break;

        case 'per_nom':
					$this->setPersNom($valeur);
					break;

        case 'per_prenom':
					$this->setPersPre($valeur);
					break;

        case 'per_tel':
					$this->setPersTel($valeur);
					break;

        case 'per_mail':
					$this->setPersMail($valeur);
					break;

				case 'per_login':
					$this->setPersLogin($valeur);
					break;

				case 'per_pwd':
					$this->setPersPwd($valeur);
					break;
			}
		}
	}

	public function getPersNum() {
		return $this->persnum;
	}
	public function setPersNum($id){
		$this->persnum=$id;
	}

	public function getPersNom(){
		return $this->persnom;
	}
	public function setPersNom($nom){
		$this->persnom=$nom;
	}

  public function getPersPre(){
    return $this->perspre;
  }
  public function setPersPre($prenom){
		$this->perspre=$prenom;
	}

  public function getPersTel() {
		return $this->perstel;
	}
	public function setPersTel($id){
		$this->perstel=$id;
	}

  public function getPersMail() {
		return $this->persmail;
	}
	public function setPersMail($id){
		$this->persmail=$id;
	}

	public function getPersLogin() {
		return $this->perslogin;
	}
	public function setPersLogin($login){
		$this->perslogin=$login;
	}

	public function getPersPwd() {
		return $this->persPwd;
	}
	public function setPersPwd($pwd){
		$this->persPwd=protectedPassword($pwd);
	}

}
