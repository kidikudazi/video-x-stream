<?php 
	include('../__class/class.UserController.php');

	// collect data
	$firstname = $_REQUEST['firstname'];
	$lastname = $_REQUEST['lastname'];
	$phone = $_REQUEST['phone'];
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$hashedPasswword = md5(sha1(md5($password)));

	// send data
	$registerUser = new UserController();

	$registerUser->registerNewUser($firstname, $lastname, $phone, $email, $hashedPasswword);
?>