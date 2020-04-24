<?php
   include ('__functions/index.php');
   if(!isLoggedIn()){
      header("Location: 404.php");
   }

   include ('__config/connect.php');

   // echo rand_();
?>
<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Video Streaming Website | Create Channel</title>
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
      <?php include('layouts/navbar.php') ?>
      <div id="wrapper">
         <!-- Sidebar -->
         <?php include ('layouts/sidebar.php'); ?>
         <div id="content-wrapper">
            <div class="container-fluid upload-details">
               <div class="row">
                  <div class="col-md-12">
                     <div class="main-title">
                        <h6>Create Channel</h6>
                     </div>
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
               <form method="POST" id="channel_form" action="__factory/create_channel.php" enctype="multipart/form-data">
                  
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="osahan-form">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="category">Channel Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="category">Channel Cover Picture</label>
                                    <input type="file" name="cover_picture" id="cover_picture" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="category">Channel Category</label>
                                    <select id="category" name="category" class="custom-select">
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="channel_name">Channel Name</label>
                                    <input type="text" placeholder="Super Entertainment Channel." name="channel_name" id="channel_name" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="about">About (Description)</label>
                                    <textarea rows="3" id="about" name="about" class="form-control"></textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" id="location" class="form-control" placeholder="e.g (Florida)">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label>Business Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="e.g (channel@mail.com)">
                                 </div>
                              </div>
                           </div>
                           <div class="row ">
                              <div class="col-md-12">
                                 <div class="main-title">
                                    <h6>Social handle</h6>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label>Facebook</label>
                                    <input type="url" name="facebook_url" id="facebook_url" class="form-control" placeholder="e.g (https://facebook.com/page)">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label>Twitter</label>
                                    <input type="url" name="twitter_url" id="twitter_url" class="form-control" placeholder="e.g (https://twitter.com/account)">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label>Instagram</label>
                                    <input type="url" name="instagram_url" id="instagram_url" class="form-control" placeholder="e.g (https://instagram.com/account)">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="osahan-area text-center mt-3">
                           <button type="submit" class="btn btn-outline-primary">Save Changes</button>
                        </div>
                        <hr>
                        <div class="terms text-center">
                           <p class="mb-0"><a href="#">Terms of Service</a> and <a href="#">Community Guidelines</a>.</p>
                           <p class="hidden-xs mb-0"></p>
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
      <script src="js/channel_custom.js"></script>
      <script>
         
         $(document).ready(function() {
            // body...
            $.ajax({
               type:'GET',
               url:'__factory/fetch_categories.php',
               cache:false,
               success:function(res){
                  $("#category").append(res);
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