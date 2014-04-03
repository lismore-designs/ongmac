<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
class Validate{
	var $error = '';
	public function email($email){
		$email = trim($email);
		if(strstr($email,'@') && strstr($email,'.')){
			$email = explode('@',$email);
			
			if(count($email)  == 2) { return true;}
			$this->error = 'Email ID not valid';
			return false;
	}
	$this->error = 'Email ID not valid';
			return false;
	}
public function password($passowrd){
	$passowrd = trim($passowrd);
	if(strlen($passowrd) >= 10 || strlen($passowrd) <= 4 )
		$this->error = 'Password must be 5-10 characters long';
		return false;
	}
public function role($role){
	if($role == 1 || $role == 2){ return true;}
	$this->error = 'Invalid role';
	return false;
	}


}
?>