<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
class Address{
	var $error = '';
	var $msg = '';
	 
 
	 
	public function is_address($id){
	global $crypt;
		$id = $crypt->decrypt($id);
		$result = mysql_query("SELECT id FROM  " . PFX . "address WHERE id = '$id'");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such address exists";
		return false;
	}
	public function details($id){
	global $crypt;
		if($this->is_address($id)){
			$id = $crypt->decrypt($id);
			$result = mysql_query("SELECT * FROM  " . PFX . "address WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			return $result;
			}
			}
		$this->error = "No such address exists";
		return false;
	}
	
}

?>