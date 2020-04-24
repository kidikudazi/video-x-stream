<?php
	include('../__class/class.UserController.php');

	// collect data
	$country_id = $_REQUEST['country_id'];

	// get states
	$getStates = new UserController();
	$getStates->fetchAllStates($country_id);
?>