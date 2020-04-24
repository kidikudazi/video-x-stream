<?php 


	/**
	 * Fetch Menu Details
	 */
	class MenuDetails extends DBConnect
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
		* user subscriptions
		*/
		public function userSubscriptions(){
			if(!empty($_SESSION['vid_user_id'])){

				$user_id = $_SESSION['vid_user_id'];

				// fetch user subscriptions
				$fetchSubs = "SELECT * FROM subscriptions LEFT JOIN channels ON channels.id = subscriptions.channel_id WHERE subscriptions.user_id = '".$user_id."' ORDER BY subscriptions.created_at DESC";
				$fetchSubs = mysqli_query($this->plug, $fetchSubs);

				$dataArr = [];

				while ($row = mysqli_fetch_assoc($fetchSubs)) {
					# code...
					array_push($dataArr, $row);
				}

				return $dataArr;
			}
		}		
	}


	$menuData = new MenuDetails();
	$subs = $menuData->userSubscriptions();
?>