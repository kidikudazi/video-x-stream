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
      <title>Video Streaming Website | Settings</title>
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
                  <div class="col-lg-12">
                     <div class="main-title">
                        <h6>Settings</h6>
                     </div>
                  </div>
               </div>
               <div id="info_div"></div>
               <form method='POST' id="profile_form">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">First Name <span class="required">*</span></label>
                           <input class="form-control border-form-control" id="firstname" value="<?php echo $userDetails['firstname']; ?>" name="firstname" type="text">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Last Name <span class="required">*</span></label>
                           <input class="form-control border-form-control" id="lastname" value="<?php echo $userDetails['lastname']; ?>" name="lastname" type="text">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Phone <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="<?php echo $userDetails['phone']; ?>" name="phone" placeholder="123 456 7890" id="phone" type="number">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Email Address <span class="required">*</span></label>
                           <input class="form-control border-form-control" name="email" id="email" value="<?php echo $userDetails['email']; ?>" disabled type="email">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Country <span class="required">*</span></label>
                           <select  name="country" id="country" class="custom-select">
                              <option value="">Select Country</option>
                              <?php foreach ($countries as $country) { ?>
                                 <option value="<?php echo $country['id']; ?>"><?php echo $country['country']; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">City <span class="required">*</span></label>
                           <input type="text" name="city" id="city" class="form-control" value="<?php echo $userDetails['city']; ?>" placeholder="e.g (florida)">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Zip Code </label>
                           <input class="form-control border-form-control" name="zip_code" id="zip_code" value="<?php echo $userDetails['zip_code']; ?>" placeholder="e.g 123456" type="number">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">State <span class="required">*</span></label>
                           <select  id="state" name="state" class="custom-select">
                              <?php if (!empty($userDetails['state_id'])) {?>
                                 <option ><?php echo $userDetails['state']; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label class="control-label">Address <span class="required">*</span></label>
                           <textarea class="form-control border-form-control" id="address" name="address"><?php echo $userDetails['address']; ?></textarea>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 text-right">
                        <button type="button" class="btn btn-danger border-none"> Cancel </button>
                        <button type="submit" class="btn btn-success border-none" id="update_btn"> Save Changes </button>
                     </div>
                  </div>
               </form>
               <hr>
               <div class="row">
                  <div class="col-lg-12">
                     <div class="main-title">
                        <h6>Change Password</h6>
                     </div>
                  </div>
               </div>
               <div id="pass_info"></div>
               <form method='POST' id="password_form">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Old Password <span class="required">*</span></label>
                           <input class="form-control border-form-control" id="old_password" name="old_password" type="password">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">New Password <span class="required">*</span></label>
                           <input class="form-control border-form-control" id="new_password" name="new_password" type="password">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 text-right">
                        <button type="reset" class="btn btn-danger border-none"> Cancel </button>
                        <button type="submit" class="btn btn-success border-none" id="pass_btn"> Change Password </button>
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
      <script src="js/account_custom.js"></script>
      <script>
         $(document).ready(function(){

            // country change
            $('body').on('change', '#country', function(){
               var country_id = $(this).val();

               // fetch states
               $.ajax({
                  type:"GET",
                  url:"__factory/fetch_all_states.php",
                  data:{
                     country_id:country_id
                  },
                  cache:false,
                  success:function(res){
                     $("#state").html(res);
                  }
               });
            });
         });
      </script>
   </body>

</html>