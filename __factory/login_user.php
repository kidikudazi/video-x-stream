<?php 
	include('../__class/class.UserController.php');

	// collect data
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$hashedPasswword = md5(sha1(md5($password)));

	// send data
	$login = new UserController();

	$login->loginUser($email, $hashedPasswword);
?>