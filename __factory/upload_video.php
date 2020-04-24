<?php
	// include class
	include ('../__class/class.UserController.php');
	// collect data
	$channel = $_POST['channel'];
	$video_title = ucwords($_POST['video_title']);
	$about = $_POST['about'];


	// foreach ($_POST as $key => $value) {
	// 	# code...
	// 	echo $_POST[$key];
	// }

	// get profile image  file
	$videoFile = $_FILES['video']['name'];
	$video_filesize = $_FILES['video']['size'];
	$video_target_directory = '../videos/'.time().'_'.$videoFile;
	$video_temp = $_FILES['video']['tmp_name'];
	$target_file = $video_target_directory.basename($videoFile);

	$uploadVideo = new UserController;
	$uploadVideo->uploadNewVideo($channel, $video_title, $about, $video_temp, $video_target_directory);
?>