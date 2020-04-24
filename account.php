<?php include('__functions/index.php');
   if(!isLoggedIn()){
      header("Location: 404.php");
   }

   include('__config/connect.php');
   include('__factory/get_account_details.php');

?>
<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Video Streaming Website | Account</title>
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
         <?php include('layouts/sidebar.php'); ?>
         
         <div id="content-wrapper">
            <div class="container-fluid pb-0">
               <div class="row">
                  <div class="col-xl-3 col-sm-6 mb-3">
                     <div class="card text-white bg-primary o-hidden h-100 border-none">
                        <div class="card-body">
                           <div class="card-body-icon">
                              <i class="fas fa-fw fa-users"></i>
                           </div>
                           <div class="mr-5"><b><?php echo($basicData['totalChannels']); ?></b> <?php if($basicData['totalChannels'] == 0 || $basicData['totalChannels'] == 1){ echo 'Channel'; }else{ echo 'Channels';} ?></div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                        </a>
                     </div>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-3">
                     <div class="card text-white bg-warning o-hidden h-100 border-none">
                        <div class="card-body">
                           <div class="card-body-icon">
                              <i class="fas fa-fw fa-video"></i>
                           </div>
                           <div class="mr-5"><b><?php echo($basicData['totalVideos']); ?></b> <?php if($basicData['totalVideos'] == 0 || $basicData['totalVideos'] == 1){ echo 'Video'; }else{ echo 'Videos';} ?></div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                        </a>
                     </div>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-3">
                     <div class="card text-white bg-success o-hidden h-100 border-none">
                        <div class="card-body">
                           <div class="card-body-icon">
                              <i class="fas fa-fw fa-list-alt"></i>
                           </div>
                           <div class="mr-5"><b><?php echo($basicData['totalCategory']); ?></b> <?php if($basicData['totalCategory'] == 0 || $basicData['totalCategory'] == 1){ echo 'Category'; }else{ echo 'Categories';} ?></div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                        </a>
                     </div>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-3">
                     <div class="card text-white bg-danger o-hidden h-100 border-none">
                        <div class="card-body">
                           <div class="card-body-icon">
                              <i class="fas fa-fw fa-cloud-upload-alt"></i>
                           </div>
                           <div class="mr-5"><b><?php echo($basicData['totalNewVideos']); ?></b> <?php if($basicData['totalNewVideos'] == 0 || $basicData['totalNewVideos'] == 1){ echo 'New Video'; }else{ echo 'New Videos';} ?></div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                        </a>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <h6>My Videos</h6>
                        </div>
                     </div>
                     <?php foreach ($videos as $list) { ?>
                        <div class="col-xl-3 col-sm-6 mb-3">
                           <div class="video-card">
                              <div class="video-card-image">
                                 <a class="play-icon" href="video-page.php?watch=<?php echo $list['video_tag'] ?>"><i class="fas fa-play-circle"></i></a>
                                 <a href="video-page.php?watch=<?php echo $list['video_tag'] ?>">
                                    <video controls width="270" height="169">
                                       <source src="<?php echo $list['video'] ?>" type="">
                                    </video>
                                 </a>
                              </div>
                              <div class="video-card-body">
                                 <div class="video-title">
                                    <a href="video-page.php?watch=<?php echo $list['video_tag'] ?>"><?php echo $list['video_title'] ?></a>
                                 </div>
                                 <div class="video-page text-success">
                                    <?php echo $list['category_name']; ?>  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                 </div>
                                 <div class="video-view">
                                    <?php echo $list['views']; ?> views
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
               url:"__factory/fetch_user_channels.php",
               cache:false,
               success:function(res){

                  $("#channel_list").html(res);
               }
            });
         });
      </script>
   </body>

</html>