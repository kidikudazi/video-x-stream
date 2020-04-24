 
   $('#reg_form').validate({
      rules:{
         firstname: {required:true},
         lastname: {required:true},
         email: {required:true},
         phone: {required: true},
         password: {required: true},
         confirm_password: {
            required: true,
            equalTo:'#password'
         }
      },
      messages:{
         firstname:{ required: 'The First Name field is required.'},
         lastname:{required: 'The Last Name field is required.'},
         email: {required: 'The Email field is required.'},
         phone: {required: 'The Phone Number field is required.'},
         password: {required: 'The Password field is  required.'},
         confirm_password: {
            required: 'The Confirm Password field is required.',
            equalTo: 'The Confirm Password and Password do not match.'
         }
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
         $("#reg_btn").attr('disabled', true);
         $("#reg_btn").html('Sign Up &nbsp;<i class="fa fa-spinner fa-spin"></i>');
         return registerUser();
      }
   });


   // register user 
   function registerUser() {
      // body...
      var firstname = $('#firstname').val();
      var lastname = $('#lastname').val();
      var email = $('#email').val();
      var phone = $('#phone').val();
      var password = $('#password').val();

      // send request
      $.ajax({
         type:"POST",
         url:"__factory/register_user.php",
         data:{
            firstname:firstname,
            lastname:lastname,
            email:email,
            phone:phone,
            password:password
         },
         cache:false,
         success:function(res){

            if(res.error == true){
               //enable button
               $("#reg_btn").attr('disabled', false);
               $("#reg_btn").html('Sign Up');

               $("#info_div").html(res.message);
            }else{
               // clear fields
               $('#firstname').val('');
               $('#lastname').val('');
               $('#email').val('');
               $('#phone').val('');
               $('#password').val('');
               $('#confirm_password').val('');

               //enable button
               $("#reg_btn").attr('disabled', false);
               $("#reg_btn").html('Sign Up');

               $("#info_div").html(res.message);
            }
         }
      });
   }