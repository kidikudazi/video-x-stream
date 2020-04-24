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


		/**
		* latest videos
		*/
		public function latestVideos($limit){
			$user_id = 0;
			if(!empty($_SESSION['vid_user_id'])){
				$user_id = $_SESSION['vid_user_id'];
			}

			// fetch record
			$fetchVideos = "SELECT videos.video_tag, videos.video, videos.id, videos.user_id, videos.video_title, videos.about, videos.views, channels.profile_picture, channels.channel_name, channels.created_at, channels.channel_tag	, categories.category_name FROM videos LEFT JOIN channels ON channels.id = videos.channel_id LEFT JOIN  categories ON categories.id = channels.category_id WHERE videos.user_id != '".$user_id."' ORDER BY videos.created_at DESC LIMIT ".$limit;
			$fetchVideos = mysqli_query($this->plug, $fetchVideos);

			$videoArr = [];
			while($row = mysqli_fetch_assoc($fetchVideos)){
				array_push($videoArr, $row);
			}
			return $videoArr;
		}

		/**
		* channel category info
		*/
		public function channelCategoryInfo(){
			// get all channel category
			$getChannelCat = "SELECT DISTINCT category_id FROM channels";
			$getChannelCat = mysqli_query($this->plug, $getChannelCat);

			$channelCatInfo = [];

			while ($row = mysqli_fetch_assoc($getChannelCat)) {
				$categoryData = [];
				
				# get category info
				$getCategoryData = "SELECT * FROM categories WHERE id ='".$row['category_id']."' ";
				$getCategoryData = mysqli_query($this->plug, $getCategoryData);

				$categoryRow = mysqli_fetch_assoc($getCategoryData);
				
				# get info
				$categoryData['category_name'] = $categoryRow['category_name'];

				# get all channels linked to category and sum view
				$fetchCategoryChannels = "SELECT * FROM channels WHERE category_id ='".$row['category_id']."' ";
				$fetchCategoryChannels = mysqli_query($this->plug, $fetchCategoryChannels);

				// calculate total views per category
				$totalViews = 0;

				while ($channelRow = mysqli_fetch_assoc($fetchCategoryChannels)) {
					# code...
					$totalViews += $channelRow['views'];
				}

				$categoryData['views'] = $totalViews;

				// get single channel data
				$latestChannelData = "SELECT * FROM channels WHERE category_id = '".$row['category_id']."' ORDER BY created_at DESC limit 1";
				$latestChannelData = mysqli_query($this->plug, $latestChannelData);

				$latestChannelRow = mysqli_fetch_assoc($latestChannelData);

				$categoryData['profile_picture'] = $latestChannelRow['profile_picture'];

				array_push($channelCatInfo, $categoryData);
			}

			return $channelCatInfo;
		}
		
	}


	$videoData = new VideoDetails();
	$latest = $videoData->latestVideos($limit);

	$categoryInfo = $videoData->channelCategoryInfo();
?>