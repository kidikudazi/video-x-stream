<?php 
	include ('__config/connect.php');


	/**
	 * Fetch Channel Details
	 */
	class ChannelDetails extends DBConnect
	{
		protected $plug;
		function __construct()
		{
			# code...
			parent::__construct();

			# connect
			$this->plug = DBConnect::iConnect();
		}

		public function details($channel_tag){
			// fetch details
			$fetchData = "SELECT * FROM channels WHERE channel_tag = '".$channel_tag."'";
			$fetchDataResult = mysqli_query($this->plug, $fetchData);

			// update views
			$row = mysqli_fetch_assoc($fetchDataResult);
			$previousViews = $row['views'];
			$increaseViews = $previousViews + 1;

			// update record
			$updateViews = "UPDATE channels SET views = '".$increaseViews."' WHERE id = '".$row['id']."'";

			if(mysqli_query($this->plug, $updateViews)){
				return $row;
			}else{
				return $row;
			}
		}

		public function subscribers($channel_tag){
			// fetch details
			$fetchData = "SELECT * FROM channels WHERE channel_tag = '".$channel_tag."'";
			$fetchDataResult = mysqli_query($this->plug, $fetchData);

			$channel = mysqli_fetch_assoc($fetchDataResult);

			// fetch no of subscribers
			$getTotalSubscribers = "SELECT count(*) FROM subscriptions WHERE channel_id = '".$channel['id']."'";
			$getTotalSubscribers = mysqli_query($this->plug, $getTotalSubscribers);

			return $result = mysqli_fetch_assoc($getTotalSubscribers);
		}

		public function channelVideos($channel_tag){
			// fetch details
			$fetchData = "SELECT * FROM channels WHERE channel_tag = '".$channel_tag."'";
			$fetchDataResult = mysqli_query($this->plug, $fetchData);

			$channel = mysqli_fetch_assoc($fetchDataResult);

			// fetch no of subscribers
			$getChannelVideos = "SELECT videos.video_tag, videos.video, videos.id, videos.channel_id, videos.user_id, videos.video_title, videos.about, videos.views, channels.profile_picture, channels.channel_name,categories.category_name FROM videos LEFT JOIN channels ON channels.id = videos.channel_id  LEFT JOIN  categories ON categories.id = channels.category_id WHERE videos.channel_id = '".$channel['id']."'";
			$getChannelVideos = mysqli_query($this->plug, $getChannelVideos);
			$data = [];
			while($result = mysqli_fetch_assoc($getChannelVideos)){
				array_push($data, $result);
			}

			return $data;
		}

		public function checkSubscription($channel_tag){
			if (!empty($_SESSION['vid_user_id'])) {
				# code...
				$user_id = $_SESSION['vid_user_id'];
				// fetch details
				$fetchData = "SELECT * FROM channels WHERE channel_tag = '".$channel_tag."'";
				$fetchDataResult = mysqli_query($this->plug, $fetchData);

				$channel = mysqli_fetch_assoc($fetchDataResult);

				// check if user has subscribed to channel
				$checkSub = "SELECT * FROM subscriptions WHERE channel_id = '".$channel['id']."'  AND user_id = '".$user_id."' ";
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


	$channelData = new ChannelDetails();
	$data = $channelData->details($channel_tag);

	$subscribersCount = $channelData->subscribers($channel_tag);

	$videos = $channelData->channelVideos($channel_tag);

	$isSubscriber = $channelData->checkSubscription($channel_tag);
?>