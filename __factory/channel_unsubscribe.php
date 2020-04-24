<?php
	include('../__class/class.UserController.php');

	// collect data
	$channel_tag = $_REQUEST['channel_tag'];

	$unsubscribe = new UserController();
	$unsubscribe->unsubscribeFromChannel($channel_tag);
?>