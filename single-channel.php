<?php 
   include('__functions/index.php');
   $channel_tag = $_GET['ch'];

   if(empty($channel_tag)){
      header("Location: 404.php");
   }

   include('__factory/get_channel_details.php');

   if(count($data) < 1){
      header("Location: 404.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Video Streaming Website | <?php echo $data['channel_name']; ?></title>
      <!-- Favicon Icon -->
      <link rel="icon" type="image/png" href="img/favicon.png">
      <!-- Bootstrap core CSS-->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom fonts for this template-->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <!-- Custom styles for this template-->
      <link href="css/osahan.css" rel="stylesheet">
      <!-- Owl Carousel -->
      <link rel="stylesheet" href="vendor/owl-carousel/owl.carousel.css">
      <link rel="stylesheet" href="vendor/owl-carousel/owl.theme.css">
   </head>
   <body id="page-top">
      <?php include('layouts/navbar.php'); ?>
      <div id="wrapper">
         <!-- Sidebar -->
      <?php include('layouts/sidebar.php'); ?>
         
         <div class="single-channel-page" id="content-wrapper">
            <div class="single-channel-image">
               <img class="img-fluid" alt="" style="height: 386px;" src="<?php echo $data['cover_picture']; ?>">
               <div class="channel-profile">
                  <img class="channel-profile-img" alt="" src="<?php echo $data['profile_picture']; ?>">
                  <div class="social hidden-xs">
                     <?php if(!empty($data['facebook_url']) || !empty($data['twitter_url']) || !empty($data['instagram_url'])){ ?>
                        Social &nbsp;
                     <?php } ?>
                     <?php if(!empty($data['facebook_url'])){ ?>
                        <a class="fb" href="<?php echo($data['facebook_url']); ?>">Facebook</a>
                     <?php } if (!empty($data['twitter_url'])) { ?>
                        <a class="tw" href="<?php echo($data['twitter_url']); ?>">Twitter</a>
                     <?php } if(!empty($data['instagram_url'])){ ?>
                        <a class="gp" href="<?php echo($data['instagram_url']); ?>">Instagram</a>
                     <?php } ?>
                  </div>
               </div>
            </div>
            <div class="single-channel-nav">
               <nav class="navbar navbar-expand-lg navbar-light">
                  <a class="channel-brand" href="#"> <?php echo $data['channel_name']; ?> <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                           <a class="nav-link" href="javascript:void(0);" id="vid_link">Videos <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="javascript:void(0);" id="about_link">About</a>
                        </li>
                     </ul>
                     <?php 
                        if(isLoggedIn()){
                      ?>
                        <?php if($data['user_id'] != $_SESSION['vid_user_id']){ ?>
                           <?php if(!$isSubscriber){ ?>
                              <form class="form-inline my-2 my-lg-0">
                              &nbsp;&nbsp;&nbsp; <button class="btn btn-outline-danger btn-sm" type="button" tag="<?php echo($data['channel_tag']); ?>" id="sub_btn">Subscribe <strong><?php echo number_format($subscribersCount['count(*)']); ?></strong></button>
                              </form>
                           <?php }else{ ?>
                              <form class="form-inline my-2 my-lg-0">
                              &nbsp;&nbsp;&nbsp; <button class="btn btn-outline-danger btn-sm" type="button" tag="<?php echo($data['channel_tag']); ?>" id="unsub_btn">UnSubscribe <strong><?php echo number_format($subscribersCount['count(*)']); ?></strong></button>
                              </form>
                           <?php } ?>
                        <?php }else{ ?>
                           <form class="form-inline my-2 my-lg-0">
                           &nbsp;&nbsp;&nbsp; <button class="btn btn-outline-danger btn-sm" type="button" style="cursor: default;" disabled>Subscribers <strong><?php echo number_format($subscribersCount['count(*)']); ?></strong></button>
                           </form>
                        <?php } ?>
                     <?php }else{ ?>
                        <form class="form-inline my-2 my-lg-0">
                        &nbsp;&nbsp;&nbsp; <a href="login.php" class="btn btn-outline-danger btn-sm">Subscribe <strong><?php echo number_format($subscribersCount['count(*)']); ?></strong></a>
                        </form>
                     <?php } ?>
                  </div>
               </nav>
            </div>
            <!-- video section -->
            <div class="container-fluid" id="video_sec">
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <h6>Videos</h6>
                        </div>
                     </div>

                     <?php foreach ($videos as $video){ ?>
                        <div class="col-xl-3 col-sm-6 mb-3">
                           <div class="video-card">
                              <div class="video-card-image">
                                 <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                 <a href="video-page.php?watch=<?php echo $video['video_tag']; ?>">
                                    <video controls id="vi" width="270" height="169" controlsList="nodownload">
                                       <source src="<?php echo $video['video']; ?>" type="video/mp4">
                                    </video>
                                 </a>
                              </div>
                              <div class="video-card-body">
                                 <div class="video-title">
                                    <a href="video-page.php?watch=<?php echo $video['video_tag']; ?>"><?php echo $video['video_title']; ?></a>
                                 </div>
                                 <div class="video-page text-success">
                                    <?php echo $video['category_name'] ?>  <!-- <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a> -->
                                 </div>
                                 <div class="video-view">
                                    <?php echo number_format($video['views']) ?> views &nbsp;
                                 </div>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
            <!-- // video section -->

            <!-- about section -->
            <div class="container-fluid" id="about_sec">
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <h4>About</h4>
                           <hr>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <p><?php echo $data['description'] ?></p>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <h6>Location</h6>
                        <p><?php echo $data['location'] ?></p>

                        <h6>Business Email</h6>
                        <p><?php echo $data['business_email'] ?></p>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <h4>Social Handle</h4>
                           <hr>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                     <?php if(!empty($data['facebook_url'])){ ?>
                        <a class="fb" href="<?php echo($data['facebook_url']); ?>">Facebook</a>
                     <?php } if (!empty($data['twitter_url'])) { ?>
                        <a class="tw" href="<?php echo($data['twitter_url']); ?>">Twitter</a>
                     <?php } if(!empty($data['instagram_url'])){ ?>
                        <a class="gp" href="<?php echo($data['instagram_url']); ?>">Instagram</a>
                     <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
            <!-- // about section -->

            <!-- /.container-fluid -->
            <!-- Sticky Footer -->
            <?php include('layouts/footer.php'); ?>
         </div>
         <!-- /.content-wrapper -->
      </div>
      <!-- /#wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      <!-- Logout Modal-->
      <?php include ('layouts/logout_modal.php'); ?>
      <!-- Bootstrap core JavaScript-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Owl Carousel -->
      <script src="vendor/owl-carousel/owl.carousel.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="js/custom.js"></script>
      <script>
         $(document).ready(function(){
            $('#about_sec').hide();

            // video link click event
            $('body').on('click', '#vid_link', function(){
               $('#about_sec').hide();
               $('#video_sec').show();
            });

            // about link click event
            $('body').on('click', '#about_link', function(){
               $('#video_sec').hide();
               $('#about_sec').show();
            });



            var allVideos = $('video');
            var videoDuration = $('.time');
            // console.log(videoDuration.html(4)[0]);
            // console.log(allVideos);

            // return;  
            // console.log(videoDuration[0].innerHTML)

            for (var i = 0; i < videoDuration.length; i++) {
               allVideos[i].controls = false;
               // console.log(allVideos[i].duration);
               // var duration = ""+allVideos[i].duration+"";
               // console.log(duration);

               // var splitVideoDuaration = duration.split('.');
               // console.log(splitVideoDuaration)
               // var divideOriginalDuartion = parseInt(splitVideoDuaration[0])/60;
               // divideOriginalDuartion = ""+divideOriginalDuartion+""
               // var modCal = parseInt(splitVideoDuaration[0])%60;
               // console.log(divideOriginalDuartion);

               // var splitDivideDuration = divideOriginalDuartion.split('.');
               // console.log(splitDivideDuration);

               // if(splitDivideDuration != 0){
               //    console.log(parseInt(splitDivideDuration[0])+":"+parseInt(modCal))
               //    videoDuration.html(parseInt(splitDivideDuration[0])+":"+parseInt(modCal))[i];
               // }else{
               //    videoDuration.html(parseInt(splitDivideDuration[0])+":"+parseInt(modCal))[i];

               // }
            }


            $('body').on('click', '#sub_btn', function(){
                  var channel_tag = $(this).attr('tag');

                  // proceed to subscribe user to channel
                  $.ajax({
                     type:"POST",
                     url:"__factory/channel_subscription.php",
                     data:{
                        channel_tag:channel_tag
                     },
                     cache:false,
                     success:function(res){
                        if(res.error == true){
                           window.location.href = res.location;
                        }else{
                           window.location.reload();
                        }
                     }
                  });
            });

            $('body').on('click', '#unsub_btn', function(){
                  var channel_tag = $(this).attr('tag');
                  
                  // proceed to unsubscribe user from channel
                  $.ajax({
                     type:"POST",
                     url:"__factory/channel_unsubscribe.php",
                     data:{
                        channel_tag:channel_tag
                     },
                     cache:false,
                     success:function(res){
                        if(res.error == true){
                           window.location.href = res.location;
                        }else{
                           window.location.reload();
                        }
                     }
                  });
            });
         });
         

      </script>
   </body>

</html>