<?php
   include ('__functions/index.php');

   $limit = 8;
   include('__factory/fetch_latest_videos.php');

 ?>
<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Video Streaming Website | Home</title>
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
      <style type="text/css">
         video::-webkit-media-controls-enclosure {
           display:none !important;
         }
      </style>
   </head>
   <body id="page-top">
      <?php include('layouts/navbar.php'); ?>
      <div id="wrapper">
         <!-- Sidebar -->
         <?php include ('layouts/sidebar.php'); ?>
         <div id="content-wrapper">
            <div class="container-fluid pb-0">
               <div class="top-category section-padding mb-4">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <h6>Channels Categories</h6>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="owl-carousel owl-carousel-category">
                           <?php foreach($categoryInfo as $list){ ?>
                              <div class="item">
                                 <div class="category-item">
                                    <a href="channels.php">
                                       <img class="img-fluid" src="<?php echo $list['profile_picture']; ?>" alt="">
                                       <h6><?php echo $list['category_name']; ?></h6>
                                       <p><?php echo number_format($list['views']); ?> views</p>
                                    </a>
                                 </div>
                              </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <h6>Featured Videos</h6>
                        </div>
                     </div>
                     <?php foreach ($latest as $video) { ?>
                        <div class="col-xl-3 col-sm-6 mb-3">
                           <div class="video-card">
                              <div class="video-card-image">
                                 <a class="play-icon" href="video-page.php?watch=<?php echo $video['video_tag']; ?>"><i class="fas fa-play-circle"></i></a>
                                 <a href="video-page.php?watch=<?php echo $video['video_tag']; ?>">
                                    <video controls width="270" height="169">
                                       <source src="<?php echo $video['video']; ?>" type="">
                                    </video>
                                 </a>
                                 <!-- <div class="time">3:50</div> -->
                              </div>
                              <div class="video-card-body">
                                 <div class="video-title">
                                    <a href="video-page.php?watch=<?php echo $video['video_tag']; ?>"><?php echo $video['video_title']; ?></a>
                                 </div>
                                 <div class="video-page text-success">
                                    <?php echo $video['category_name']; ?>  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                 </div>
                                 <div class="video-view">
                                    <?php echo $video['views']; ?> views
                                 </div>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
               </div>
               <hr class="mt-0">
               <div class="video-block section-padding">
                  <div class="row" id="channel_list">
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
            // fetch all channels
            $.ajax({
               type:"GET",
               url:"__factory/fetch_popular_channels.php",
               cache:false,
               success:function(res){

                  $("#channel_list").html(res);
               }
            });
         });
      </script>
   </body>

</html>