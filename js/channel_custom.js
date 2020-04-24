
   $('#channel_form').validate({
      rules:{
         profile_picture: {required:true, extension: true, maxsize: 1048576},
         cover_picture: {required:true, extension: true, maxsize: 1048576},
         category: {required:true},
         channel_name: {required: true},
         about: {required: true},
         location: {required: true},
         email: {required: true}
      },
      messages:{
         profile_picture:{
            required: 'The Channel Profile Picture field is required.',
            extension: 'Invalid Extension format selected for the Images.',
            maxsize: 'Image cannot be greater than 1MB.'
         },
         cover_picture:{
            required: 'The Channel Cover Picture field is required.',
            extension: 'Invalid Extension format selected for the Images.',
            maxsize: 'Image cannot be greater than 1MB.'
         },
         category: {required:'The Category field is required.'},
         channel_name: {required: 'The Channel Name field is required.'},
         about: {required: 'The About field is required.'},
         location: {required: 'The Location field is required.'},
         email: {required: 'The Business Email field is required'}
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
      }
   });