<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
class User{
	var $error = '';
	var $msg = '';
	var $key = 'SYMBIOTIC';
public function is_admin($email){
	$email = trim($email);
		$result = mysql_query("SELECT role FROM  " . PFX . "users WHERE active = 1 AND email = '$email'");
		while($rows = mysql_fetch_assoc($result)){
		if($rows['role'] == '1'){
		return true;	
		}
		}
		return false;
	}
public function get_pass($email){
		$email = trim($email);
		$result = mysql_query("SELECT password FROM  " . PFX . "users WHERE email = '$email'");
		while($rows = mysql_fetch_assoc($result)){
		return base64_decode($rows['password']);	
		
		}
}
	public function get_role($email){
		$email = trim($email);
$result = mysql_query("SELECT role FROM  " . PFX . "users WHERE email = '$email'");
		while($rows = mysql_fetch_assoc($result)){
		return $rows['role'];	
		
		}
}	
public function get_last_login($email){
		$email = trim($email);
$result = mysql_query("SELECT last_login FROM  " . PFX . "users WHERE email = '$email'");
		while($rows = mysql_fetch_assoc($result)){
		return $rows['last_login'];	
		}
}
public function is_active($email){
		$email = trim($email);
		$result = mysql_query("SELECT active FROM  " . PFX . "users WHERE email = '$email'");
		while($rows = mysql_fetch_assoc($result)){
		if($rows['active'] == '1'){
		return true;	
		}
		}
		$this->error = "User is inactive";
		return false;
	}
public function is_user($email){
		$email = trim($email);
		$result = mysql_query("SELECT active FROM  " . PFX . "users WHERE email = '$email'");
		if(mysql_num_rows($result) >= 1){
		return true;
		}
		$this->error = "No such user exists";
		return false;
	}
public function update_password($email,$password){	
		$email = trim($email);
		
		$password = trim($password);
		$password = base64_encode($password);
	$update = mysql_query("UPDATE " . PFX . "users  SET `password` = '$password' WHERE email ='$email'");
	if($update){
	$this->msg = "User updated successfully";
		return true;
	}
	$this->error = "Error updating password";
	return false;
}
public function update_role($email,$role){
		$email = trim($email);
	if($email != $_SESSION['curr_user']){
	$update = mysql_query("UPDATE " . PFX . "users  SET `role` = '$role' WHERE email ='$email'");
	if($update){
		$this->msg = "User updated successfully";
		return true;
	}
	$this->error = "An error occured while updating database";
	return false;
	}
	
	return true;
}
public function update_status($email,$status){	
		$email = trim($email);
	if($email != $_SESSION['curr_user']){
	$update = mysql_query("UPDATE " . PFX . "users  SET `active` = '$status' WHERE email ='$email'");
	if($update){
		$this->msg = "User updated successfully";
		return true;
	}
	}

	return true;
}
public function update_email($email,$new){	
	$email = trim($email);
	if($email != $_SESSION['curr_user'] && !$this->is_user($new)){
	$update = mysql_query("UPDATE " . PFX . "users  SET `email` = '$new' WHERE email ='$email'");
	if($update){
		$this->msg = "User updated successfully";
		$this->error ='';
		return true;
	}
	}
	$this->error ='Email id already in use';
	return false;
}
public function add_user($email,$password,$role){
		$email = trim($email);
		$email = strtolower($email);
		$password = base64_encode($password);
if(empty($email) || empty($password)){
			$this->error = 'Please input Email id and Password';
			return false;
		}
	if(!$this->is_user($email)){
	$add = mysql_query("INSERT INTO " . PFX . "users (`id`, `email`, `password`, `role`, `last_login`, `active`) VALUES (NULL, '$email' , '$password' , '$role' , 'Never', '1')");
	if($add){
		$this->error = "";
		$this->msg = "User added successfully";
		return true;
		}
	}
	$this->error = "User already exists";
	return false;
}
public function all_users(){
	$result = mysql_query("SELECT * FROM  " . PFX . "users");
	$users = array();
	while($rows = mysql_fetch_assoc($result)){
		$users[]=$rows;
		}
	return $users;
}
}

?>