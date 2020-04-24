<?php
	// include controller
	include('../__class/class.UserController.php');

	// collect data
	$old_password = $_REQUEST['old_password'];
	$old_password = md5(sha1(md5($old_password)));
	$new_password = $_REQUEST['new_password'];
	$new_password = md5(sha1(md5($new_password)));

	// update data
	$updateData = new UserController();
	$updateData->changePassword($old_password, $new_password);
?>