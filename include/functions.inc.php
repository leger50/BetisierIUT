<?php
	function getEnglishDate($date){
		$membres = explode('/', $date);
		$date = $membres[2].'-'.$membres[1].'-'.$membres[0];
		return $date;
	}

	function getFrenchDate($date){
		$membres = explode('-', $date);
		$date = $membres[2].'/'.$membres[1].'/'.$membres[0];
		return $date;
	}

	function protectedPassword($pwd){
		$salt = "48@!alsd";
    $passwordMD5 = md5(md5($pwd).$salt);

		return $passwordMD5;
	}
?>
