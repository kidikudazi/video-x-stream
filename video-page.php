<?php 
   include('__functions/index.php');
   $video_tag = $_GET['watch'];

   if(empty($video_tag)){
      header("Location: 404.html");
   }

   include('__factory/get_video_details.php');

   if(count($data) < 1){
      header("Location: 404.html");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Video Streaming Website</title>
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
      <?php include('layouts/navbar.php') ?>
      <div id="wrapper">
         <!-- Sidebar -->
      <?php include('layouts/sidebar.php') ?>
         
         <div id="content-wrapper">
            <div class="container-fluid pb-0">
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="single-video-left">
                           <div class="single-video">
                              <video controls id="vi" width="100%" height="315" controlsList="nodownload">
                                 <source src="<?php echo $data['video']; ?>" type="video/mp4">
                              </video>
                           </div>
                           <div class="single-video-title box mb-3">
                              <h2><a href="#"><?php echo $data['video_title'] ?></a></h2>
                              <p class="mb-0"><i class="fas fa-eye"></i> <?php echo number_format($data['views']) ?> views</p>
                           </div>
                           <div class="single-video-author box mb-3">
                              <?php 
                                 if(isLoggedIn()){
                               ?>
                                 <?php if($data['user_id'] != $_SESSION['vid_user_id']){ ?>
                                    <?php if(!$isSubscriber){ ?>
                                       <div class="float-right"><button class="btn btn-danger" type="button" tag="<?php echo($data['channel_tag']); ?>" id="sub_btn">Subscribe <strong><?php echo number_format($subscribersCount['count(*)']); ?></strong></button></div>
                                    <?php }else{ ?>
                                       <div class="float-right"><button class="btn btn-danger" type="button" tag="<?php echo($data['channel_tag']); ?>" id="unsub_btn">UnSubscribe <strong><?php echo number_format($subscribersCount['count(*)']); ?></strong></button></div>
                                    <?php } ?>
                                 <?php }else{ ?>
                                    <div class="float-right"><button class="btn btn-danger" type="button" style="cursor: default;" disabled>Subscribers <strong><?php echo number_format($subscribersCount['count(*)']); ?></strong></button></div>
                                 <?php } ?>
                              <?php }else{ ?>
                                 <div class="float-right"><a href="login.php" class="btn btn-danger">Subscribe <strong><?php echo number_format($subscribersCount['count(*)']); ?></strong></a></div>
                              <?php } ?>
                              <img class="img-fluid" src="<?php echo $data['profile_picture']; ?>" alt="">
                              <p><a href="single-channel.php?ch=<?php echo($data['channel_tag']); ?>"><strong><?php echo $data['channel_name'] ?></strong></a> <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></p>
                              <small>Published on <?php echo date('M d, Y', strtotime($data['created_at'])); ?></small>
                           </div>
                           <div class="single-video-info-content box mb-3">
                              <h6>Category :</h6>
                              <p><?php echo $data['category_name']; ?></p>
                              <h6>About :</h6>
                              <p><?php echo $data['about']; ?></p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="single-video-right">
                           <div class="row">
                              <div class="col-md-12">
                                 
                                 <div class="main-title">
                                    <h6>Up Next</h6>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <?php foreach ($videos as $list) { ?>
                                    <div class="video-card video-card-list">
                                       <div class="video-card-image">
                                          <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                          <a href="video-page.php?watch=<?php echo $list['video_tag']; ?>">
                                             <video id="vid" controls controlsList="nodownload" style="width: 130px; height: 130px;">
                                                <source src="<?php echo $list['video']; ?>" type="video/mp4">
                                             </video>
                                          </a>
                                          <!-- <div class="time">3:50</div> -->
                                       </div>
                                       <div class="video-card-body">
                                          <div class="video-title">
                                             <a href="video-page.php?watch=<?php echo $list['video_tag']; ?>"><?php echo $list['video_title']; ?></a>
                                          </div>
                                          <div class="video-page text-success">
                                             <?php echo $list['category_name']; ?>  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                          </div>
                                          <div class="video-view">
                                             <?php echo number_format($list['views']); ?> views <!-- &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago -->
                                          </div>
                                       </div>
                                    </div>
                                 <?php } ?>
                                 <div class="adblock mt-0">
                                    <div class="img">
                                       Google AdSense<br>
                                       <img src="ads/ad1.jpg" class="img-fluid" width="336" height="280">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
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
      <?php include('layouts/logout_modal.php'); ?>
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