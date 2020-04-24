<?php
	// include controller
	include('../__class/class.UserController.php');

	// collect data
	$firstname = $_REQUEST['firstname'];
	$lastname = $_REQUEST['lastname'];
	$phone = $_REQUEST['phone'];
	$state = $_REQUEST['state'];
	$city = $_REQUEST['city'];
	$address = $_REQUEST['address'];
	$zip_code = $_REQUEST['zip_code'];

	// update data
	$updateData = new UserController();
	$updateData->updateUserProfile($firstname, $lastname, $phone, $state, $city, $address, $zip_code);
?>