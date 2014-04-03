<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Manage Admins'; 
require_once('./include/admin-load.php');
if($user->is_admin(USER)){
// Pre Scripts
if(isset($_REQUEST['new_email']) && isset($_REQUEST['new_password']) && isset($_REQUEST['new_role'])){
	$email = trim($_REQUEST['new_email']);
	$password = trim($_REQUEST['new_password']);
	$role =trim($_REQUEST['new_role']);
	$validated = $validate->email($email);
	$validated = $validate->password($password);
	$validated = $validate->role($role);
		if(empty($validate->error)){
	$result =$user->add_user($email, $password, $role);
	
}else{
$error = $validate->error;
}
}
if(isset($_REQUEST['user']) && isset($_REQUEST['edit_email']) && isset($_REQUEST['edit_pwd']) && isset($_REQUEST['edit_role']) && isset($_REQUEST['edit_active'])){
	$email = trim($_REQUEST['user']);
	$newmail = trim($_REQUEST['edit_email']);
	$newmail = strtolower($newmail);
	$email = strtolower($email);
	$password = trim($_REQUEST['edit_pwd']);
	$role =trim($_REQUEST['edit_role']);
	$active =trim($_REQUEST['edit_active']);
	$validated = $validate->email($email);
	$validated = $validate->email($newmail);
	$validated = $validate->password($password);
	$validated = $validate->role($role);
	$result =$user->update_password($email, $password);
	$result = $user->update_role($email, $role);
	$result =$user->update_status($email, $active);
	if($email != $newmail){
	$result =$user->update_email($email, $newmail);
	if(empty($user->error)){
	$_REQUEST['user'] = $newmail;
	}
	}
}
$users = $user->all_users();
//print_r($users);
}

if(!empty($user->msg)){
	$success = $user->msg;
	}
	if(!empty($user->error)){
	$error = $user->error;
	}
	
require_once('./header.php');

if($user->is_admin(USER)){
?>
<?php if(isset($_REQUEST['edit'])){ 
?>
<ul class="nav nav-pills"><li><a href="settings-admins.php">All Admin Users</a></li></ul>
<hr>
<form action="settings-admins.php?edit=1&user=<?php echo $_REQUEST['user'];?>" method="post" class="form-horizontal">
<h3>Edit User (<?php echo trim($_REQUEST['user']);?>)</h3>
<div class="form-group"><label class="col-md-3 control-label" for="">
Email ID</label><div class="col-md-4">
<input class="form-control"type="text" class="input-medium" name="edit_email" value="<?php echo trim($_REQUEST['user']);?>" id="edit-admin-email">
</div>
</div>
<div class="form-group"><label class="col-md-3 control-label" for="">Password</label><div class="col-md-4">
<input class="form-control"type="password" class="input-medium" name="edit_pwd" value="<?php echo $user->get_pass(trim($_REQUEST['user']));?>" id="edit-admin-pwd">
</div>
</div>

<?php if(trim($_REQUEST['user']) == $_SESSION['curr_user']){ ?>

<input class="form-control"type="hidden" name="edit_role" id="edit-admin-role" value=1>
<input class="form-control"type="hidden" name="edit_active" id="edit-admin-active" value="1">
<?php }else{?><div class="form-group"><label class="col-md-3 control-label" for="">
Role</label><div class="col-md-4">
<select class="form-control"  class="input-medium" name="edit_role" id="edit-admin-role">
<option value="2">Worker</option>
<option value="1" <?php echo ($user->get_role(trim($_REQUEST['user'])) == 1)? "selected":""; ?>>Administrator</option>
</select>
</div>
</div>
<div class="form-group"><label class="col-md-3 control-label" for="">
Active</label><div class="col-md-4">
<select class="form-control" class="input-medium" name="edit_active" id="edit-admin-active">
<option value="1">Active</option>
<option value="0">Inactive</option>
</select>
</div>
</div>
<?php } ?>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button>
</div>
</div>
</form>	
<?php	
}  else {?>
<form action="settings-admins.php" method="post" class="form-horizontal">
<div class="form-group">
<label class="col-md-3 control-label text-right" for=""><p><strong>Add an Admin</strong></p></label><div class="col-md-4"></div></div><div class="form-group">
<label class="col-md-3 control-label text-right" for="">Email ID:</label><div class="col-md-4">
<input class="form-control"type="text" name="new_email" value="" id="new-admin-email"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Password:</label><div class="col-md-4">
<input class="form-control"type="text" name="new_password" value="" id="new-admin-pwd"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Role:</label><div class="col-md-4">
<select class="form-control" name="new_role" id="new-admin-role">
<option value="2">Worker</option>
<option value="1">Administrator</option>
</select></div></div><div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Add</button></div></div>

</form>
<?php } ?>



<table class="table">
<thead><tr>
<th>Email ID:</th><th>Role</th><th>Last Login</th><th>Active</th><th>Edit</th>
</tr></thead>
<?php foreach ($users as $user){
switch ($user['role']){
	case '1':
	$role = 'Administrator';
	break;
	case '2':
	$role = 'Worker';
	break;
	default:
	$role = 'Unknown';	
	}
switch ($user['active']){
	case '1':
	$active = 'Yes';
	break;
	case '0':
	$active = 'Not active';
	break;
	default:
	$active = 'Unknown';	
	
}
	?>
<tr><td><?php echo $user['email']; ?></td><td><?php echo $role; ?></td><td><?php echo $user['last_login'];?></td><td><?php echo $active; ?></td><td><a href="settings-admins.php?edit=1&user=<?php echo $user['email'];?>"><i class="icon-pencil"></i> Edit</a></td>
</tr>
<?php } ?>
</table>
<?php } else {?>
<p><strong>You are not authorised to view this page.</strong></p>
<?php } 
require_once('./footer.php');

?>