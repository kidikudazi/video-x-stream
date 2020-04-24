<?php
	// include class
	include ('../__class/class.UserController.php');
	// collect data
	$category = $_POST['category'];
	$channel_name =ucwords($_POST['channel_name']);
	$about = $_POST['about'];
	$location = $_POST['location'];
	$buisness_email = $_POST['email'];
	$facebook_url = $_POST['facebook_url'];
	$twitter_url = $_POST['twitter_url'];
	$instagram_url = $_POST['instagram_url'];

	// foreach ($_POST as $key => $value) {
	// 	# code...
	// 	echo $_POST[$key];
	// }

	// get profile image  file
	$profilePic = $_FILES['profile_picture']['name'];
	$profilePic_filesize = $_FILES['profile_picture']['size'];
	$profile_pic_target_directory = '../uploads/'.time().'_'.$profilePic;
	$profile_file_temp = $_FILES['profile_picture']['tmp_name'];
	$profile_target_file = $profile_pic_target_directory.basename($profilePic);


	// get cover picture
	$coverPic = $_FILES['cover_picture']['name'];
	$coverPic_filesize = $_FILES['cover_picture']['size'];
	$cover_pic_target_directory = '../uploads/'.time().'_'.$coverPic;
	$cover_file_temp = $_FILES['cover_picture']['tmp_name'];
	$cover_target_file = $cover_pic_target_directory.basename($coverPic);

	$createChannel = new UserController;
	$createChannel->createNewChannel($category, $channel_name, $about, $location, $buisness_email, $facebook_url, $twitter_url, $instagram_url, $profile_file_temp, $profile_pic_target_directory, $cover_file_temp, $cover_pic_target_directory);
?>