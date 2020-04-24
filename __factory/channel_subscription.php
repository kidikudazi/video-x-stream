<?php
	include('../__class/class.UserController.php');

	// collect data
	$channel_tag = $_REQUEST['channel_tag'];

	$subscribe = new UserController();
	$subscribe->subscribeToChannel($channel_tag);
?>