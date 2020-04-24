<?php 
	include('../__class/class.UserController.php');


	$channels = new UserController();

	$channels->fetchPopularChannels();

?>