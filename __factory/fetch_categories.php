<?php 

	include ('../__class/class.UserController.php');

	$fetchData = new UserController;
	$fetchData->fetchAllCategories();

?>