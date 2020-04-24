<?php 

	include ('__config/connect.php');


	/**
	 * Fetch Video Details
	 */
	class VideoDetails extends DBConnect
	{
		protected $plug;
		function __construct()
		{
			# code...
			parent::__construct();

			# connect
			$this->plug = DBConnect::iConnect();
		}

		public function details($video_tag){
			// fetch details
			$fetchData = "SELECT videos.video_tag, videos.video, videos.id, videos.user_id, videos.video_title, videos.about, videos.views, channels.profile_picture, channels.channel_name, channels.created_at, channels.channel_tag	, categories.category_name FROM videos LEFT JOIN channels ON channels.id = videos.channel_id LEFT JOIN  categories ON categories.id = channels.category_id WHERE videos.video_tag = '".$video_tag."'";
			$fetchDataResult = mysqli_query($this->plug, $fetchData);

			// update views
			$row = mysqli_fetch_assoc($fetchDataResult);
			$previousViews = $row['views'];
			$increaseViews = $previousViews + 1;

			// update record
			$updateViews = "UPDATE videos SET views = '".$increaseViews."' WHERE id = '".$row['id']."'";

			if(mysqli_query($this->plug, $updateViews)){
				return $row;
			}else{
				return $row;
			}
		}

		public function subscribers($video_tag){
			// fetch details
			$fetchData = "SELECT * FROM videos WHERE video_tag = '".$video_tag."'";
			$fetchDataResult = mysqli_query($this->plug, $fetchData);

			$channel = mysqli_fetch_assoc($fetchDataResult);

			// fetch no of subscribers
			$getTotalSubscribers = "SELECT count(*) FROM subscriptions WHERE channel_id = '".$channel['channel_id']."'";
			$getTotalSubscribers = mysqli_query($this->plug, $getTotalSubscribers);

			return $result = mysqli_fetch_assoc($getTotalSubscribers);
		}

		public function relatedVideos($video_tag){
			// fetch details
			$fetchData = "SELECT * FROM videos WHERE video_tag = '".$video_tag."'";
			$fetchDataResult = mysqli_query($this->plug, $fetchData);

			$videoRow = mysqli_fetch_assoc($fetchDataResult);

			// get channel details
			$fetchChannelData = "SELECT * FROM channels WHERE id = '".$videoRow['channel_id']."' ";
			$fetchChannelDataResult = mysqli_query($this->plug, $fetchChannelData);

			$channelRow = mysqli_fetch_assoc($fetchChannelDataResult);

			//  get all channels with the same category
			$catData = "SELECT * FROM channels WHERE category_id = '".$channelRow['category_id']."' AND user_id != '".$videoRow['user_id']."' ORDER BY created_at DESC LIMIT 6";
			// $catData = "SELECT * FROM channels WHERE category_id = '".$channelRow['category_id']."' ORDER BY created_at DESC LIMIT 6";
			$catDataResult = mysqli_query($this->plug, $catData);

			// fetch no of subscribers
			$data = [];
			while($result = mysqli_fetch_assoc($catDataResult)){
				$getChannelVideos = "SELECT videos.video_tag, videos.video, videos.id, videos.channel_id, videos.user_id, videos.video_title, videos.about, videos.views, channels.profile_picture, channels.channel_name, channels.created_at, categories.category_name FROM videos LEFT JOIN channels ON channels.id = videos.channel_id  LEFT JOIN  categories ON categories.id = channels.category_id WHERE videos.channel_id = '".$result['id']."' ORDER BY videos.created_at DESC LIMIT 1";
				$getChannelVideos = mysqli_query($this->plug, $getChannelVideos);
				$row = mysqli_fetch_assoc($getChannelVideos);
				array_push($data, $row);
			}

			return $data;
		}

		public function checkSubscription($video_tag){
			if(!empty($_SESSION['vid_user_id'])){

				$user_id = $_SESSION['vid_user_id'];
				// fetch details
				$fetchData = "SELECT * FROM videos WHERE video_tag = '".$video_tag."'";
				$fetchDataResult = mysqli_query($this->plug, $fetchData);

				$channel = mysqli_fetch_assoc($fetchDataResult);

				// check if user has subscribed to channel
				$checkSub = "SELECT * FROM subscriptions WHERE channel_id = '".$channel['channel_id']."'  AND user_id = '".$user_id."' ";
				$checkSub = mysqli_query($this->plug, $checkSub);

				if(mysqli_num_rows($checkSub) > 0){
					return true;
				}else{
					return false;
				}
			}
			return;
		}
	}


	$videoData = new VideoDetails();
	$data = $videoData->details($video_tag);

	$subscribersCount = $videoData->subscribers($video_tag	);

	$videos = $videoData->relatedVideos($video_tag);

	$isSubscriber = $videoData->checkSubscription($video_tag);

?>