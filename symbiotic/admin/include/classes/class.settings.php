<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
class Settings{
	var $error = '';
	var $msg = '';
	public function get_all(){
	$setting = array();
	$result = mysql_query("SELECT * FROM  " . PFX . "settings");
	while($rows = mysql_fetch_assoc($result)){
		$setting[$rows['setting']] = $rows['value'];
		}
	return $setting;
}
	public function update($newsettings){
		//print_r($newsettings);
		foreach($newsettings as $key => $value){
	$update = mysql_query("UPDATE " . PFX . "settings  SET `value` = '" . trim($value) . "' WHERE setting ='$key'");
	if(!$update){
	$this->error = "Error saving settings";
	return false;	
	}
	}
	if(empty($this->error)){
	$this->msg = "Settings updated successfully";
	return true;
	}
	}
}

?>