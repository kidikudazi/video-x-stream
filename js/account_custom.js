$('#profile_form').validate({
   rules:{
      firstname: {required:true},
      lastname: {required:true},
      email: {required:true},
      phone: {required: true},
      country:{required:true},
      city:{required:true},
      state:{required:true},
      address:{required:true}
   },
   messages:{
      firstname:{ required: 'The First Name field is required.'},
      lastname:{required: 'The Last Name field is required.'},
      email: {required: 'The Email field is required.'},
      phone: {required: 'The Phone Number field is required.'},
      country: {required: 'The Country field is required.'},
      city: {required: 'The City field is required.'},
      state: {required: 'The State field is required.'},
      address: {required: 'The Address field is required.'}
   },
   errorClass: 'help-block',
   errorElement: 'strong',
   onblur:true,
   onfocus:true,
   highlight:function(element){
      $(element).closest('.form-group').addClass('has-error');
   },
   unhighlight:function(element){
      $(element).closest('.form-group').removeClass('has-error');
   },
   errorPlacement:function(error, element){
      if(element.parent('.input-group').length)
      {
         error.insertAfter(element.parent());
         return false;
      }
      else
      {
         error.insertAfter(element);
         return false;
      }
   },
   submitHandler:function () {
      // body...
      $("#update_btn").attr('disabled', true);
      $("#update_btn").html('Saving &nbsp;<i class="fa fa-spinner fa-spin"></i>');
      return updateUserProfile();
   }
});



$('#password_form').validate({
   rules:{
      old_password: {required:true},
      new_password: {required:true}
   },
   messages:{
      old_password:{ required: 'This field is required.'},
      new_password:{required: 'This field is required.'}
   },
   errorClass: 'help-block',
   errorElement: 'strong',
   onblur:true,
   onfocus:true,
   highlight:function(element){
      $(element).closest('.form-group').addClass('has-error');
   },
   unhighlight:function(element){
      $(element).closest('.form-group').removeClass('has-error');
   },
   errorPlacement:function(error, element){
      if(element.parent('.input-group').length)
      {
         error.insertAfter(element.parent());
         return false;
      }
      else
      {
         error.insertAfter(element);
         return false;
      }
   },
   submitHandler:function () {
      // body...
      $("#pass_btn").attr('disabled', true);
      $("#pass_btn").html('Updating &nbsp;<i class="fa fa-spinner fa-spin"></i>');
      return changePassword();
   }
});
   
   // update user 
   function updateUserProfile(){
      // collect data
      var firstname = $("#firstname").val();
      var lastname = $("#lastname").val();
      var phone = $("#phone").val();
      var state = $("#state").val();
      var city = $("#city").val();
      var address = $("#address").val();
      var zip_code = $("#zip_code").val();

      $.ajax({
         type:"POST",
         url:"__factory/update_user_profile.php",
         data:{
            firstname:firstname,
            lastname:lastname,
            phone:phone,
            state:state,
            city:city,
            address:address,
            zip_code:zip_code
         },
         cache:false,
         success:function(res){
            if(res.error == true){
               $("#update_btn").attr('disabled', false);
               $("#update_btn").html('Save Changes');

               // return error message
               $("#info_div").html(res.message);
            }else{
               $("#update_btn").attr('disabled', false);
               $("#update_btn").html('Save Changes');

               // return error message
               $("#info_div").html(res.message);
            }
         }
      });
   }

   // change password
   function changePassword(){
      var old_password = $("#old_password").val();
      var new_password = $("#new_password").val();

      $.ajax({
         type:"POST",
         url:"__factory/change_user_password.php",
         data:{
            old_password:old_password,
            new_password:new_password
         },
         cache:false,
         success:function(res){
            if(res.error == true){
               $("#pass_btn").attr('disabled', false);
               $("#pass_btn").html('Change Password');

               $("#pass_info").html(res.message);
            }else{
               $("#pass_btn").attr('disabled', false);
               $("#pass_btn").html('Change Password');

               $("#old_password").val('');
               $("#new_password").val('')
               $("#pass_info").html(res.message);
            }
         }
      });

   }