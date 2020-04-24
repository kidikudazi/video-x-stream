
   $('#upload_form').validate({
      rules:{
         video: {required:true, extension: true, maxsize: 1048576},
         channel: {required: true},
         video_titile: {required:true},
         about: {required: true}
      },
      messages:{
         channel: {required: 'The Channel Name field is required.'},
         video:{
            required: 'The Video field is required.',
            extension: 'Invalid Extension format selected for the Video.',
            maxsize: 'Image cannot be greater than 1MB.'
         },
         video_titile: {required:'The Video Title field is required.'},
         about: {required: 'The About field is required.'}
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