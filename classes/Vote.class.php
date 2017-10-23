<?php
class Vote{

	private $voteCitNum;
	private $votePerNum;
	private $voteValeur;

  public function __construct($valeurs = array()) {
    	if(!empty($valeurs)){
				$this->affecte($valeurs);
			}
  }

	public function affecte($donnees){

		foreach ($donnees as $attribut => $valeur) {

			switch ($attribut) {
				case 'cit_num':
					$this->setVoteCitNum($valeur);
					break;

				case 'per_num':
					$this->setVotePerNum($valeur);
					break;

				case 'vot_valeur':
					$this->setVoteValeur($valeur);
					break;

				default:
					# code...
					break;
			}
		}
	}

	public function getVoteCitNum(){
		return $this->voteCitNum;
	}

	public function setVoteCitNum($num){
		if(is_numeric($num)){
			$this->voteCitNum = $num;
		}
	}

	public function getVotePerNum(){
		return $this->votePerNum;
	}

	public function setVotePerNum($persNum){
		if(is_numeric($persNum)){
			$this->votePerNum = $persNum;
		}
	}

	public function getVoteValeur(){
		return $this->voteValeur;
	}

	public function setVoteValeur($valeur){
		if(is_numeric($valeur) && ($valeur >= 0 && $valeur <=20)){
			$this->voteValeur = $valeur;
		}
	}
}
?>
