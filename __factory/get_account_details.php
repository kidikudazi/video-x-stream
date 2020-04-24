<?php 


	/**
	 * Fetch Menu Details
	 */
	class AccountDetails extends DBConnect
	{
		protected $plug;
		function __construct()
		{
			# code...
			parent::__construct();

			# connect
			$this->plug = DBConnect::iConnect();
		}

		/**
		* user basic details
		*/
		public function userBasicDetails(){
			// get user details
			$user_id = $_SESSION['vid_user_id'];

			// deta array
			$dataArr = [];

			// fetch channels list
			$fetchChannels = "SELECT COUNT(*) FROM channels WHERE user_id = '".$user_id."' ";
			$fetchChannels = mysqli_query($this->plug, $fetchChannels);
			$totalChannels = mysqli_fetch_assoc($fetchChannels);

			// fetch videos list
			$fetchVideos = "SELECT COUNT(*) FROM Videos WHERE user_id = '".$user_id."' ";
			$fetchVideos = mysqli_query($this->plug, $fetchVideos);
			$totalVideos = mysqli_fetch_assoc($fetchVideos);

			// total video category
			$fetchChannelCategory = "SELECT DISTINCT category_id FROM channels WHERE user_id = '".$user_id."' ";
			$fetchChannelCategory = mysqli_query($this->plug, $fetchChannelCategory);
			$totalCategory = mysqli_num_rows($fetchChannelCategory);

			// fetch videos list
			$fetchNewVideos = "SELECT COUNT(*) FROM Videos WHERE user_id = '".$user_id."'  AND views  = 0";
			$fetchNewVideos = mysqli_query($this->plug, $fetchNewVideos);
			$totalNewVideos = mysqli_fetch_assoc($fetchNewVideos);


			$dataArr['totalChannels'] = $totalChannels['COUNT(*)'];
			$dataArr['totalVideos'] = $totalVideos['COUNT(*)'];
			$dataArr['totalCategory'] = $totalCategory;
			$dataArr['totalNewVideos'] = $totalNewVideos['COUNT(*)'];

			return $dataArr;
		}

		/**
		* fetch all user videos
		*/
		public function fetchUserVideos(){
			if(!empty($_SESSION['vid_user_id'])){
				$user_id = $_SESSION['vid_user_id'];

				// get videos
				$getVideos = "SELECT videos.video_tag, videos.video, videos.id, videos.user_id, videos.video_title, videos.about, videos.views, channels.profile_picture, channels.channel_name, channels.created_at, channels.channel_tag	, categories.category_name FROM videos LEFT JOIN channels ON channels.id = videos.channel_id LEFT JOIN  categories ON categories.id = channels.category_id WHERE videos.user_id = '".$user_id."' ORDER BY videos.created_at DESC";
				$getVideos = mysqli_query($this->plug, $getVideos);
				$dataArr = [];
				while ($row = mysqli_fetch_assoc($getVideos)) {
					# code...
					array_push($dataArr, $row);
				}

				return $dataArr;
			}
		}

		/**
		* get profile details
		*/
		public function fetchProfileDetails(){
			if(!empty($_SESSION['vid_user_id'])){
				$user_id = $_SESSION['vid_user_id'];

				// get user details
				$getUserDetails = "SELECT * FROM users LEFT JOIN states ON users.state_id = states.id WHERE users.id = '".$user_id."' ";
				$getUserDetails = mysqli_query($this->plug, $getUserDetails);

				return $row = mysqli_fetch_assoc($getUserDetails);
			}
		}

		/**
		* get all country list
		*/
		public function fetchCountries(){
			// fetch countries
			$getCountries = "SELECT * FROM countries";
			$getCountries = mysqli_query($this->plug, $getCountries);

			$dataArr = [];

			while ($row = mysqli_fetch_assoc($getCountries)) {
				# code...
				array_push($dataArr, $row);
			}
			return $dataArr;
		}
	}


	$accountData = new AccountDetails();
	// get basic data
	$basicData = $accountData->userBasicDetails();

	// get user videos
	$videos = $accountData->fetchUserVideos();

	// get user details
	$userDetails = $accountData->fetchProfileDetails();

	// get list of countries
	$countries = $accountData->fetchCountries();
?>