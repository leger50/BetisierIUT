<?php
class Citation{

	private $citNum;
	private $citNumEnseignant;
	private $citLib;
	private $citDate;
	private $citTableVote;

  public function __construct($valeurs = array(), $votes) {
    	if(!empty($valeurs)){
				$this->affecte($valeurs , $votes);
			}
  }

	public function affecte($donnees, $votes){

		foreach ($donnees as $attribut => $valeur) {

			switch ($attribut) {
				case 'cit_num':
					$this->setCitNum($valeur);
					break;

				case 'per_num':
					$this->setCitNumEnseignant($valeur);
					break;

				case 'cit_libelle':
					$this->setCitLib($valeur);
					break;

				case 'cit_date':
					$this->setCitDate($valeur);
					break;

				default:
					# code...
					break;
			}
		}
		$this->setCitTableVote($votes);
	}

	public function getCitNum(){
		return $this->citNum;
	}

	public function setCitNum($num){
		if(is_numeric($num)){
			$this->citNum = $num;
		}
	}

	public function getCitNumEnseignant(){
		return $this->citNumEnseignant;
	}

	public function setCitNumEnseignant($num){
		if(is_numeric($num)){
			$this->citNumEnseignant = $num;
		}
	}

	public function getCitLib(){
		return $this->citLib;
	}

	public function setCitLib($libelle){
		if(is_string($libelle)){
			$this->citLib = $libelle;
		}
	}

	public function getCitDate(){
		return getFrenchDate($this->citDate);
	}

	//verifier date ? + english date
	public function setCitDate($date){

			$this->citDate = $date;

	}

	public function getCitTabVote(){
		return $this->citTableVote;
	}

	public function setCitTableVote($tabVotes){
		$this->citTableVote = $tabVotes;
	}


	public function getMoyenneNote(){
		$moyenne = 0;
		$compteur = 0;

		foreach ($this->citTableVote as $vote){
			$note = $vote->getVoteValeur();
			$moyenne += $note;
			$compteur++;
		}

		if($compteur == 0){
			return "Non notée";
		}
		return $moyenne / $compteur;
	}

	public function getNomEnseignant($num){
		$pdo=new Mypdo();
		$perManager = new PersonneManager($pdo);
		$enseignant = $perManager -> getOnePersonne($num);
		return $enseignant->getPersNom().' '.$enseignant->getPersPre();
	}
}
?>
