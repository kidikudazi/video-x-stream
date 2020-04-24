
   $('#login_form').validate({
      rules:{
         email: {required:true},
         password: {required: true}
      },
      messages:{
         email: {required: 'The Email field is required.'},
         password: {required: 'The Password field is  required.'}
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
         // // body...
         $("#login_btn").attr('disabled', true);
         $("#login_btn").html('Sign In &nbsp;<i class="fa fa-spinner fa-spin"></i>');
         return loginUser();
      }
   });


   // login user 
   function loginUser() {
      // body...
      var email = $('#email').val();
      var password = $('#password').val();

      // send request
      $.ajax({
         type:"POST",
         url:"__factory/login_user.php",
         data:{
            email:email,
            password:password
         },
         cache:false,
         success:function(res){

            if(res.error == true){
               //enable button
               $("#login_btn").attr('disabled', false);
               $("#login_btn").html('Sign In');

               $("#info_div").html(res.message);
            }else{
               // clear fields
               $('#email').val('');
               $('#password').val('');

               //enable button
               $("#login_btn").attr('disabled', false);
               $("#login_btn").html('Sign In');

               // redirect to home page
               window.location.href = res.location;
            }
         }
      });
   }