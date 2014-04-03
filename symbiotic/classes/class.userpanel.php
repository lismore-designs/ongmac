<?php
class User{
	 var $error = '';
	 var $msg = '';
	 
 
	public function is_user($id){
	global $crypt;
		$id = $crypt->decrypt($id);
		$result = mysql_query("SELECT id FROM  " . PFX . "customers WHERE id = '$id'");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such user exists";
		return false;
	}	
	
	public function get_pass($email){
		$email = trim($email);
		if(!$this->is_new_user($email)){
$result = mysql_query("SELECT password FROM  " . PFX . "customers WHERE email = '$email'");
		while($rows = mysql_fetch_assoc($result)){
		
		return base64_decode($rows['password']);	
		}
		}
	$this->error = "User not found";
		return false;
}
	public function is_new_user($email){
	
		$result = mysql_query("SELECT id FROM  " . PFX . "customers WHERE email = '$email'");
		if(mysql_num_rows($result) == 0){
		return true;
		}
		$this->error = "User already exists";
		return false;
	}
	public function details($id){
	global $crypt;
		if($this->is_user($id)){
		$id = $crypt->decrypt($id);
			$result = mysql_query("SELECT * FROM  " . PFX . "customers WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			$result['id']= $crypt->encrypt($result['id']);
			$result['password']= base64_decode($result['password']);
			return $result;
			}
			}
		return false;
	}
	public function update($id,$column,$data){
	global $crypt;
		$id = trim($id);
		$column = trim($column);
		$data = trim($data);
		if($this->is_user($id)){
	$id = $crypt->decrypt($id);
	$update = mysql_query("UPDATE " . PFX . "customers  SET `$column` = '$data' WHERE id ='$id'");
	if($update){
		$this->msg = "Setting updated successfully";
		return true;
	}
	$this->error = "Error updating status";
	return false;
	}
	$this->error = "Error updating status";
	return false;
	}
	
	public function add($email,$password){
		if($this->is_new_user($email)){
		$email = strtolower($email);
		$password = base64_encode($password);
		$add = mysql_query("INSERT INTO " . PFX . "customers (`id`, `email`, `password`,`active`) VALUES (NULL, '$email' , '$password', '1')");
	if($add){
	
	$headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=utf-8\n";
    $headers .= "From: Ongmac Motorcycles Lismore <no-reply@".$_SERVER['HTTP_HOST']."> \n";
	$subject = "Welcome";
	$message = "<h2>Hello, ".$email ."</h2><br />";
	$message .= "Congratulations, you have successfully registered with Ongmac Motorcycles.<br />";
	$message .= "&copy; Ongmac Motorcycle Centre Lismore ";
	mail($email,$subject,$message,$headers);

	$this->msg = "Registered successfully";
		return mysql_insert_id();
		}
		$this->error = "Oops something wrong happened. Please try later.";
		return false;
	}
	$this->error = "User already exists with email id";
	return false;
	}
}
?>