<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
class Auth{
	var $error = '';
	var $key = 'SYMBIOTIC';
	public function is_loggedin(){
		
		if(isset($_SESSION['adminauth']) && isset($_SESSION['curr_user']) && isset($_SESSION['token'])){
		$checksum = md5($_SESSION['curr_user'] . 'symbiotic' . date('ymd'));
			if($checksum == $_SESSION['token']){
			return true;
			}
			return false;
		}
		return false;	
	}
public function is_admin(){
		if($this->is_loggedin()){
			if($_SESSION['role'] == '1'){
				return true;
			}
		return false;	
		}
		return false;
}
public function login($email,$password){
	$password = base64_encode($password);
	$email = strtolower($email);
		$result = mysql_query("SELECT * FROM  " . PFX . "users WHERE active = 1 AND email = '$email' AND password = '$password' ");
	while($rows = mysql_fetch_assoc($result)){
		
		
		$_SESSION['curr_user'] = $rows['email'];
		$_SESSION['role'] =	$rows['role'];
		$_SESSION['token'] = md5($rows['email'] . 'symbiotic' . date('ymd'));
		$_SESSION['adminauth'] = true;
		$update = mysql_query("UPDATE " . PFX . "users  SET `last_login` = '" . $rows['latest_login'] . "' WHERE id =" . $rows['id']);
		$update = mysql_query("UPDATE " . PFX . "users  SET `latest_login` = '" . date('d M Y') . "' WHERE id =" . $rows['id']);
		return true;
	}
	$this->error = 'Invalid Username / Password';
	return false;
}
public function logout(){
	session_destroy();
	session_name('SYMBIOTIC');
	header("location:login.php");
	exit;
}	
}

?>