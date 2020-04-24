<?php 
   include ('__functions/index.php');
   if(!isLoggedIn()){
      header("Location: 404.php");
   }
   include ('__config/connect.php');
?>
<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Video Streaming Website | Video Upload</title>
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
      <style>
         .has-error{
             color: red;
         }
      </style>
   </head>
   <body id="page-top">
      <?php include('layouts/navbar.php'); ?>
      <div id="wrapper">
         <!-- Sidebar -->
      <?php include('layouts/sidebar.php'); ?>
         
         <div id="content-wrapper">
            <div class="container-fluid upload-details">
               <div class="row">
                  <div class="col-md-8 mx-auto text-center upload-video pt-5 pb-5">
                     <h1><i class="fas fa-file-upload text-primary"></i></h1>
                     <h4 class="mt-5">Select Video file to upload</h4>
                  </div>
               </div>
               <hr>
               <?php 
                  if(!empty($_SESSION['error'])){
                     echo $_SESSION['error'];
                  }

                  if(!empty($_SESSION['success'])){
                     echo $_SESSION['success'];
                  }
               ?>
               <form method="POST" action="__factory/upload_video.php" enctype="multipart/form-data" id="upload_form">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="osahan-form">
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="channel">Channel</label>
                                    <select id="channel" name="channel" class="custom-select">
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="video">Upload Video (.mp4)</label>
                                    <input type="file" name="video" class="form-control">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <label for="video_title">Video Title</label>
                                    <input type="text" placeholder="Contrary to popular belief, Lorem Ipsum (2020)." id="video_title" name="video_title" class="form-control">
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <label for="about">About</label>
                                    <textarea rows="3" id="about" name="about" class="form-control"></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="osahan-area text-center mt-3">
                           <button type="submit" class="btn btn-outline-primary">Upload Video</button>
                        </div>
                        <hr>
                        <div class="terms text-center">
                           <p class="mb-0"><a href="#">Terms of Service</a> and <a href="#">Community Guidelines</a>.</p>
                        </div>
                     </div>
                  </div>
               </form>
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
      <script src="js/jquery.validate.min.js"></script>
      <script src="js/upload_custom.js"></script>

      <script>
         
         $(document).ready(function(){
            // fetch all channels
            $.ajax({
               type:'GET',
               url:'__factory/fetch_channels_dropdown.php',
               cache:false,
               success:function(res){
                  $('#channel').html(res);
               }
            });

            $('body').on('click', '.close', function(){
               $.ajax({
                  type:'GET',
                  url:'__functions/flash_session.php',
                  cache:false,
                  success:function(res){
                  }
               })
            });
         });
      </script>
   </body>

</html>