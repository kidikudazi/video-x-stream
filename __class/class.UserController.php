<?php 
	// include connection class
	include ('../__config/connect.php');

	/**
	 * User Controller Class
	 */
	class UserController extends DBConnect
	{
		protected $plug;
		protected $response;
		function __construct()
		{
			# code...
			parent::__construct();

			# connect
			$this->plug = DBConnect::iConnect();

			# json repsonse
			$this->response = ['error' => false];
		}


		/**
		* register new user
		*/
		public function registerNewUser($firstname, $lastname, $phone, $email, $password){
			header("Content-type: application/json");

			// validate phone number
			$validatePhoneNumber = "SELECT * FROM users WHERE phone = ".$phone."";
			$validatePhoneNumberResult = mysqli_query($this->plug, $validatePhoneNumber);
			$validatePhoneNumberOutput = mysqli_num_rows($validatePhoneNumberResult);

			if($validatePhoneNumberOutput > 0){
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Phone number already Exist.</strong>
					</div>';

				$this->response['error'] = true;
				$this->response['message'] = $error;
				echo json_encode($this->response);
				return;

			}

			// validate email
			$validateEmail = "SELECT * FROM users WHERE email ='".$email."'";
			$validateEmailResult = mysqli_query($this->plug, $validateEmail);
			$validateEmailOutput = mysqli_num_rows($validateEmailResult);
			
			if($validateEmailOutput > 0){
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Email already Exist.</strong>
					</div>';

				$this->response['error'] = true;
				$this->response['message'] = $error;
				echo json_encode($this->response);
				return;
			}

			// create new user account
			$createNewAccount = "INSERT INTO users (firstname, lastname, phone, email, password) VALUES ('".$firstname."', '".$lastname."', '".$phone."', '".$email."', '".$password."')";

			if(mysqli_query($this->plug, $createNewAccount)){
				$success = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Account Created Successfully. Click <a href="login.php" class="alert-link">Here</a> to sigin in.</strong>
					</div>';

				$this->response['message'] = $success;
				echo json_encode($this->response);
				return;
			}else{
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Reguatration Failed please try again later</strong>.
					</div>';

				$this->response['message'] = $error;
				echo json_encode($this->response);
				return;
			}
		}

		/**
		* login user 
		*/
		public function loginUser($email, $password){
			header("Content-type: application/json");

			// validate email
			$validateEmail = "SELECT * FROM users WHERE email ='".$email."'";
			$validateEmailResult = mysqli_query($this->plug, $validateEmail);
			$validateEmailOutput = mysqli_num_rows($validateEmailResult);
			
			if($validateEmailOutput < 1){
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Invalid Email/Password.</strong>
					</div>';

				$this->response['error'] = true;
				$this->response['message'] = $error;
				echo json_encode($this->response);
				return;
			}

			// validate email and password
			$validateLoginDetails = "SELECT * FROM users WHERE email ='".$email."' AND password = '".$password."'";
			$validateLoginDetailsResult = mysqli_query($this->plug, $validateLoginDetails);
			$validateLoginDetailsOutput = mysqli_num_rows($validateLoginDetailsResult);
			
			if($validateLoginDetailsOutput < 1){
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Invalid Email/Password.</strong>
					</div>';

				$this->response['error'] = true;
				$this->response['message'] = $error;
				echo json_encode($this->response);
				return;
			}

			// redirect to login with credentials
			session_start();
			$userDetails = mysqli_fetch_assoc($validateLoginDetailsResult);
			$_SESSION['vid_user_id'] = $userDetails['id'];
			$_SESSION['vid_fullname'] = $userDetails['firstname'].' '.$userDetails['lastname'];
			$_SESSION['vid_email'] = $userDetails['email'];
			$_SESSION['vid_phone'] = $userDetails['phone'];

			$this->response['location'] = 'index.php';

			echo json_encode($this->response);
			return;
		}

		/**
		* fetch all categories
		*/
		public function fetchAllCategories(){
			// fetch categories
			$fetchCategory = "SELECT * FROM categories";
			$fetchCategoryResult = mysqli_query($this->plug, $fetchCategory);

			echo '<option value="">-- Select Category --</option>';
			while($row = mysqli_fetch_assoc($fetchCategoryResult)){
				echo '<option value="'.$row['id'].'">'.$row['category_name'].'</option>';
			}
			exit();
		}

		/**
		* create new channel
		*/
		public function createNewChannel($category, $channel_name, $about, $location, $business_email, 	$facebook_url, $twitter_url, $instagram_url, $profile_temp, $profile_dir, $cover_temp, $cover_dir)
		{
			session_start();
			# get user id
			$user_id = $_SESSION['vid_user_id'];

			
			# validate channel
			$validateChannel = "SELECT * FROM channels WHERE user_id = '".$user_id."' AND channel_name = '".$channel_name."'";
			$validateChannelResult = mysqli_query($this->plug, $validateChannel);

			if(mysqli_num_rows($validateChannelResult) > 0){
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Duplicate Channel Not Allowed. You have already created this channel.</strong>
					</div>';

				$_SESSION['error'] = $error;
				header('Location: ../create-channel.php');
				exit();
			}

			# validate business email
			$validateChannelEmail = "SELECT * FROM channels WHERE business_email = '".$business_email."'";
			$validateChannelEmailResult = mysqli_query($this->plug, $validateChannelEmail);

			if(mysqli_num_rows($validateChannelEmailResult) > 0){
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Business Email Already Exist.</strong>
					</div>';

				$_SESSION['error'] = $error;
				header('Location: ../create-channel.php');
				exit();
			}

			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

			$channel_tag = substr(str_shuffle($permitted_chars), 0, 10);
			$views = 0;
			// create new channel
			$createChannel = "INSERT INTO channels (user_id, category_id, channel_name, channel_tag, cover_picture, profile_picture, facebook_url, twitter_url, instagram_url, views, description, location, business_email) VALUES ('".$user_id."', '".$category."', '".$channel_name."', '".$channel_tag."', '".str_replace('../', '', $cover_dir)."', '".str_replace('../', '', $profile_dir)."', '".$facebook_url."', '".$twitter_url."', '".$instagram_url."', '".$views."', '".$about."', '".$location."', '".$business_email."')";

			if(mysqli_query($this->plug, $createChannel)){
				// move files to folder
				move_uploaded_file($cover_temp, $cover_dir);
				move_uploaded_file($profile_temp, $profile_dir);

				$success = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Channel Created Successfully</strong>
					</div>';

				$_SESSION['success'] = $success;
				header('Location: ../create-channel.php');
				exit;
			}else{
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Failed to create channel. Try again later.</strong>
					</div>';

				$_SESSION['error'] = $error;
				header('Location: ../create-channel.php');
				exit();
			}
		}

		/**
		* fetch all channels
		*/
		public function fetchAllChannels(){
			session_start();
			$user_id = 0;
			if(empty($_SESSION['vid_user_id'])){
				$user_id = 0;
			}else{

				$user_id = $_SESSION['vid_user_id'];
			}

			// fetch records
			// $fetchChannels = "SELECT * FROM channels WHERE user_id != '".$user_id."' ORDER BY created_at DESC";
			$fetchChannels = "SELECT * FROM channels ORDER BY created_at DESC";
			$fetchChannelsResult = mysqli_query($this->plug, $fetchChannels);

			echo '<div class="col-md-12">
                        <div class="main-title">
                           <h6>Channels</h6>
                        </div>
                     </div>';
			while ($row = mysqli_fetch_assoc($fetchChannelsResult)) {
				# code...
				$getSubscribers = "SELECT * FROM subscriptions WHERE channel_id = '".$row['id']."'";
				$getSubscribersResult = mysqli_query($this->plug, $getSubscribers);
				$getSubscribersOutput = mysqli_num_rows($getSubscribersResult);

				echo '<div class="col-xl-3 col-sm-6 mb-3">
                        <div class="channels-card">
                           <div class="channels-card-image">
                              <a href="single-channel.php?ch='.$row['channel_tag'].'"><img class="img-fluid" src="'.$row['profile_picture'].'" alt=""></a>';

                  if($row['user_id'] != $user_id){
                  		// check for subscription
                  		$checkSub = "SELECT * FROM subscriptions WHERE channel_id = '".$row['id']."' AND user_id = '".$user_id."' ";
                  		$checkSubResult = mysqli_query($this->plug, $checkSub);
                  		$checkSubOutput = mysqli_num_rows($checkSubResult);
                  		if($checkSubOutput > 0){
                  			echo '<div class="channels-card-image-btn"><a href="single-channel.php?ch='.$row['channel_tag'].'" class="btn btn-outline-danger btn-sm">UnSubscribe</a></div>';
                  		}else{
                  			
		                   	echo '<div class="channels-card-image-btn"><a href="single-channel.php?ch='.$row['channel_tag'].'" class="btn btn-outline-danger btn-sm">Subscribe</a></div>'; 
                  		}
                  }
                echo '</div>
                           <div class="channels-card-body">
                              <div class="channels-title">
                                 <a href="single-channel.php?ch='.$row['channel_tag'].'">'.$row['channel_name'].'</a>
                              </div>
                              <div class="channels-view">
                                 '.number_format($getSubscribersOutput).' subscribers
                              </div>
                           </div>
                        </div>
                     </div>';
			}
		}

		/**
		* fetch popular channels
		*/
		public function fetchPopularChannels(){
			session_start();
			$user_id = 0;
			if(empty($_SESSION['vid_user_id'])){
				$user_id = 0;
			}else{

				$user_id = $_SESSION['vid_user_id'];
			}

			// fetch records
			// $fetchChannels = "SELECT * FROM channels WHERE user_id != '".$user_id."' ORDER BY views DESC LIMIT 4";
			$fetchChannels = "SELECT * FROM channels ORDER BY views DESC LIMIT 4";
			$fetchChannelsResult = mysqli_query($this->plug, $fetchChannels);

			echo '<div class="col-md-12">
                        <div class="main-title">
                           <h6>Popular Channels</h6>
                        </div>
                     </div>';
			while ($row = mysqli_fetch_assoc($fetchChannelsResult)) {
				# code...
				$getSubscribers = "SELECT * FROM subscriptions WHERE channel_id = '".$row['id']."'";
				$getSubscribersResult = mysqli_query($this->plug, $getSubscribers);
				$getSubscribersOutput = mysqli_num_rows($getSubscribersResult);

				echo '<div class="col-xl-3 col-sm-6 mb-3">
                        <div class="channels-card">
                           <div class="channels-card-image">
                              <a href="single-channel.php?ch='.$row['channel_tag'].'"><img class="img-fluid" src="'.$row['profile_picture'].'" alt=""></a>';

                  if($row['user_id'] != $user_id){
                  		// check for subscription
                  		$checkSub = "SELECT * FROM subscriptions WHERE channel_id = '".$row['id']."' AND user_id = '".$user_id."' ";
                  		$checkSubResult = mysqli_query($this->plug, $checkSub);
                  		$checkSubOutput = mysqli_num_rows($checkSubResult);
                  		if($checkSubOutput > 0){
                  			echo '<div class="channels-card-image-btn"><a href="single-channel.php?ch='.$row['channel_tag'].'" class="btn btn-outline-danger btn-sm">UnSubscribe</a></div>';
                  		}else{
                  			
		                   	echo '<div class="channels-card-image-btn"><a href="single-channel.php?ch='.$row['channel_tag'].'" class="btn btn-outline-danger btn-sm">Subscribe</a></div>'; 
                  		}
                  }
                echo '</div>
                           <div class="channels-card-body">
                              <div class="channels-title">
                                 <a href="single-channel.php?ch='.$row['channel_tag'].'">'.$row['channel_name'].'</a>
                              </div>
                              <div class="channels-view">
                                 '.number_format($getSubscribersOutput).' subscribers
                              </div>
                           </div>
                        </div>
                     </div>';
			}
		}

		/**
		* fetch dropdown channels
		*/
		public function fetchDropdownChannels(){
			session_start();

			if(empty($_SESSION['vid_user_id'])){
				echo '<option value="">-- Select Channel --</option>';
				exit;
			}
			// fetch records
			$fetchChannels = "SELECT * FROM channels WHERE user_id = '".$_SESSION['vid_user_id']."' ";
			$fetchChannelsResult = mysqli_query($this->plug, $fetchChannels);

			echo '<option value="">-- Select Channel --</option>';
			while ($row = mysqli_fetch_assoc($fetchChannelsResult)) {
				echo '<option value="'.$row['id'].'"> '.$row['channel_name'].' </option>';
			}
			exit();
		}

		/**
		* upload new video
		*/
		public function uploadNewVideo($channel, $video_title, $about, $video_temp, $video_target_dir){
			session_start();

			if(empty($_SESSION['vid_user_id'])){
				header("Location: ../upload-video.php");
				exit;
			}

			// validate if a video title exist for user
			$validateVideoTitle = "SELECT * FROM videos WHERE user_id = '".$_SESSION['vid_user_id']."'  AND channel_id = '".$channel."' AND video_title = '".$video_title."' ";
			$validateVideoTitle = mysqli_query($this->plug, $validateVideoTitle);

			if(mysqli_num_rows($validateVideoTitle) > 0){
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>A video uploaded by you with this title already exist for the selected channel category.</strong>
					</div>';

				$_SESSION['error'] = $error;

				header("Location: ../upload-video.php");
				exit();
			}

			// generate video tag
			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

			$video_tag = substr(str_shuffle($permitted_chars), 0, 10);
			
			// validate if video tag exist before
			$validateTag = "SELECT * FROM videos WHERE video_tag = '".$video_tag."'";
			$validateTag = mysqli_query($this->plug, $validateTag);

			if(mysqli_num_rows($validateTag) > 0){
				$notValid = true;

				while($notValid){
					$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

					$video_tag = substr(str_shuffle($permitted_chars), 0, 10);
					
					// validate if video tag exist before
					$validateTag = "SELECT * FROM videos WHERE video_tag = '".$video_tag."'";
					$validateTag = mysqli_query($this->plug, $validateTag);

					if(mysqli_num_rows($validateTag) < 1){
						$notValid = false;
					}
				}
			}

			$views = 0;

			// save record for new video upload
			$saveRecord = "INSERT INTO videos (video_tag, user_id, channel_id, video, video_title, about, views) VALUES ('".$video_tag."', ".$_SESSION['vid_user_id'].", ".$channel.", '".str_replace('../', '', $video_target_dir)."', '".$video_title."', '".$about."', ".$views.")";

			if(mysqli_query($this->plug, $saveRecord)){
				// move files to folder
				move_uploaded_file($video_temp, $video_target_dir);
				$success = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Video Uploaded Successfully.</strong>
					</div>';

				$_SESSION['success'] = $success;

				header("Location: ../upload-video.php");
				exit();
			}else{
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Failed to upload video. Try Again Later..</strong>
					</div>';

				$_SESSION['error'] = $error;

				header("Location: ../upload-video.php");
				exit();
			}
		}

		/**
		* subscribe to channel
		*/
		public function subscribeToChannel($channel_tag){
			header("Content-type: application/json");
			session_start();

			if(empty($_SESSION['vid_user_id'])){
				$response['error'] = true;
				$response['location'] = '404.php';

				echo json_encode($response);
				return;
			}

			$user_id = $_SESSION['vid_user_id'];

			// validate if channel exist
			$validateChannel = "SELECT * FROM channels WHERE channel_tag = '".$channel_tag."' ";
			$validateChannel = mysqli_query($this->plug, $validateChannel);

			if(mysqli_num_rows($validateChannel) < 1){
				$response['error'] = true;
				$resonse['location'] = '404.php';

				echo json_encode($response);
				return;
			}

			$channelRow = mysqli_fetch_assoc($validateChannel);

			// validate if user has already subscribed to channel
			$checkSubscription = "SELECT * FROM subscriptions WHERE user_id = '".$user_id."' AND channel_id = '".$channelRow['id']."' ";
			$checkSubscription = mysqli_query($this->plug, $checkSubscription);

			if(mysqli_num_rows($checkSubscription) > 0){
				$response['error'] = true;
				$response['location'] = '404.php';

				echo json_encode($response);
				return;
			}


			// subscribe user to channel
			$subscribeUser = "INSERT INTO subscriptions (user_id, channel_id) VALUES ('".$user_id."', '".$channelRow['id']."')";

			if(mysqli_query($this->plug, $subscribeUser)){
				$response['message'] = 'Done!';

				echo json_encode($response);
				return;
			}
		}

		/**
		* unsubscribe from channel
		*/
		public function unsubscribeFromChannel($channel_tag){
			header("Content-type: application/json");
			session_start();

			if(empty($_SESSION['vid_user_id'])){
				$response['error'] = true;
				$response['location'] = '404.php';

				echo json_encode($response);
				return;
			}

			$user_id = $_SESSION['vid_user_id'];

			// validate if channel exist
			$validateChannel = "SELECT * FROM channels WHERE channel_tag = '".$channel_tag."' ";
			$validateChannel = mysqli_query($this->plug, $validateChannel);

			if(mysqli_num_rows($validateChannel) < 1){
				$response['error'] = true;
				$resonse['location'] = '404.php';

				echo json_encode($response);
				return;
			}

			$channelRow = mysqli_fetch_assoc($validateChannel);

			// validate if user has already subscribed to channel
			$checkSubscription = "SELECT * FROM subscriptions WHERE user_id = '".$user_id."' AND channel_id = '".$channelRow['id']."' ";
			$checkSubscription = mysqli_query($this->plug, $checkSubscription);
			if(mysqli_num_rows($checkSubscription) > 0){
				
				$subRow = mysqli_fetch_assoc($checkSubscription);

				// unsubscribe user from channel
				$unsubscribeUser = "DELETE FROM subscriptions WHERE id = '".$subRow['id']."' ";

				if(mysqli_query($this->plug, $unsubscribeUser)){
					$response['message'] = 'Done!';

					echo json_encode($response);
					return;
				}

					// if error occurs
					$response['error'] = true;
					$response['location'] = '404.php';

					echo json_encode($response);
					return;

			}else{
				$response['error'] = true;
				$response['location'] = '404.php';

				echo json_encode($response);
				return;
			}
		}

		/**
		* fetch all channel subscriptions
		*/
		public function fetchAllChannelSubscriptions(){
			session_start();
			$user_id = 0;
			if(empty($_SESSION['vid_user_id'])){
				$user_id = 0;
			}else{

				$user_id = $_SESSION['vid_user_id'];
			}

			// fetch records
			$fetchChannels = "SELECT * FROM subscriptions LEFT JOIN channels ON channels.id = subscriptions.channel_id WHERE subscriptions.user_id = '".$user_id."' ORDER BY subscriptions.created_at DESC";
			$fetchChannelsResult = mysqli_query($this->plug, $fetchChannels);

			echo '<div class="col-md-12">
                        <div class="main-title">
                           <h6>Subscriptions</h6>
                        </div>
                     </div>';
			while ($row = mysqli_fetch_assoc($fetchChannelsResult)) {
				# code...
				$getSubscribers = "SELECT * FROM subscriptions WHERE channel_id = '".$row['channel_id']."'";
				$getSubscribersResult = mysqli_query($this->plug, $getSubscribers);
				$getSubscribersOutput = mysqli_num_rows($getSubscribersResult);

				echo '<div class="col-xl-3 col-sm-6 mb-3">
                        <div class="channels-card">
                           <div class="channels-card-image">
                              <a href="single-channel.php?ch='.$row['channel_tag'].'"><img class="img-fluid" src="'.$row['profile_picture'].'" alt=""></a>';

                  if($row['user_id'] != $user_id){
                  		// check for subscription
                  		$checkSub = "SELECT * FROM subscriptions WHERE channel_id = '".$row['id']."' AND user_id = '".$user_id."' ";
                  		$checkSubResult = mysqli_query($this->plug, $checkSub);
                  		$checkSubOutput = mysqli_num_rows($checkSubResult);
                  		if($checkSubOutput > 0){
                  			echo '<div class="channels-card-image-btn"><a href="single-channel.php?ch='.$row['channel_tag'].'" class="btn btn-outline-danger btn-sm">UnSubscribe</a></div>';
                  		}else{
                  			
		                   	echo '<div class="channels-card-image-btn"><a href="single-channel.php?ch='.$row['channel_tag'].'" class="btn btn-outline-danger btn-sm">Subscribe</a></div>'; 
                  		}
                  }
                echo '</div>
                           <div class="channels-card-body">
                              <div class="channels-title">
                                 <a href="single-channel.php?ch='.$row['channel_tag'].'">'.$row['channel_name'].'</a>
                              </div>
                              <div class="channels-view">
                                 '.number_format($getSubscribersOutput).' subscribers
                              </div>
                           </div>
                        </div>
                     </div>';
			}
		}

		/**
		* fetch all user created channels
		*/
		public function fetchUserCreatedChannels(){
			session_start();
			$user_id = 0;
			if(empty($_SESSION['vid_user_id'])){
				$user_id = 0;
			}else{

				$user_id = $_SESSION['vid_user_id'];
			}

			// fetch records
			$fetchChannels = "SELECT * FROM channels WHERE user_id = '".$user_id."' ORDER BY created_at DESC";
			$fetchChannelsResult = mysqli_query($this->plug, $fetchChannels);

			echo '<div class="col-md-12">
                        <div class="main-title">
                           <h6>My Channels</h6>
                        </div>
                     </div>';
			while ($row = mysqli_fetch_assoc($fetchChannelsResult)) {
				# code...
				$getSubscribers = "SELECT * FROM subscriptions WHERE channel_id = '".$row['id']."'";
				$getSubscribersResult = mysqli_query($this->plug, $getSubscribers);
				$getSubscribersOutput = mysqli_num_rows($getSubscribersResult);

				echo '<div class="col-xl-3 col-sm-6 mb-3">
                        <div class="channels-card">
                           <div class="channels-card-image">
                              <a href="single-channel.php?ch='.$row['channel_tag'].'"><img class="img-fluid" src="'.$row['profile_picture'].'" alt=""></a>';
                echo '</div>
                           <div class="channels-card-body">
                              <div class="channels-title">
                                 <a href="single-channel.php?ch='.$row['channel_tag'].'">'.$row['channel_name'].'</a>
                              </div>
                              <div class="channels-view">
                                 '.number_format($getSubscribersOutput).' subscribers
                              </div>
                           </div>
                        </div>
                     </div>';
			}
		}

		/**
		* fetch all states
		*/
		public function fetchAllStates($country_id){
			session_start();
			if(!empty($_SESSION['vid_user_id'])){
				$user_id = $_SESSION['vid_user_id'];

				// get user details
				$userDetails = "SELECT * FROM users WHERE id = '".$user_id."' ";
				$userDetails = mysqli_query($this->plug, $userDetails);

				// user data
				$userData = mysqli_fetch_assoc($userDetails);

				// get user state
				$userState = "SELECT * FROM states WHERE id ='".$userData['state_id']."'";
				$userState = mysqli_query($this->plug, $userState);
				$stateRow = mysqli_fetch_assoc($userState);

				// get all states attached to country
				$userCountryState = "SELECT * FROM states WHERE country_id ='".$country_id."'";
				$userCountryState = mysqli_query($this->plug, $userCountryState);

				echo '<option value="">Select State</option>';

				while ($row = mysqli_fetch_assoc($userCountryState)) {
					# code...
					echo '<option value="'.$row['id'].'">'.$row['state'].'</option>';
				}
				exit();
			}
		}

		/**
		* update user profile
		*/
		public function updateUserProfile($firstname, $lastname, $phone, $state, $city, $address, $zip_code){
			session_start();
			header("Content-type: application/json");
			$user_id = $_SESSION['vid_user_id'];

			//update user profile
			$updateData = "UPDATE users SET firstname = '".$firstname."', lastname = '".$lastname."',  phone = '".$phone."', state_id = '".$state."', city = '".$city."', address = '".$address."', zip_code = '".$zip_code."' WHERE id = '".$user_id."' ";
			if(mysqli_query($this->plug, $updateData)){
				$success = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Profile Updated.</strong>
					</div>';

				$response['message'] = $success;
				echo json_encode($response);
				return;
			}else{
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Failed to update profile.</strong>
					</div>';

				$response['message'] = $error;
				echo json_encode($response);
				return;
			}
		}

		/**
		* change user password
		*/
		public function changePassword($old_password, $new_password){
			session_start();
			header("Content-type: application/json");
			$user_id = $_SESSION['vid_user_id'];

			// validate old password
			$validateOldPass = "SELECT * FROM users WHERE id = '".$user_id."'  AND password = '".$old_password."' ";
			$validateOldPass = mysqli_query($this->plug, $validateOldPass);
			$validateOldPassOutput = mysqli_num_rows($validateOldPass);

			if($validateOldPassOutput < 1){
				$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Failed to change passsword.</strong>
					</div>';

				$response['error'] = true;
				$response['message'] = $error;
				echo json_encode($response);
				return;	
			}else{
				// change user passsword
				$changePass = "UPDATE users SET password = '".$new_password."' WHERE id = '".$user_id."' ";
				if(mysqli_query($this->plug, $changePass)){
					$success = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Password changed Successfully Updated.</strong>
					</div>';

					$response['message'] = $success;
					echo json_encode($response);
					return;
				}else{
					$error = '<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
						<strong>Failed to change passsword.</strong>
					</div>';

					$response['message'] = $error;
					echo json_encode($response);
					return;
				}
			}
		}
	}
?>