<?php 

	session_start();

	// validate login
	function isLoggedIn(){

		if(!empty($_SESSION['vid_fullname'])){

			return true;
		}else{
			return false;
		}
	}

	function randomString(){
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
		// Output: 54esmdr0qf
		return substr(str_shuffle($permitted_chars), 0, 10);
	}

?>