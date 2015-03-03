function check_form_submittable(form_id)
{
    if(jQuery('#'+form_id+' .ap-captcha-type').val()=='human')
    {
         var error_message = jQuery('#'+form_id+' #ap-captcha-result').attr('data-required-msg');
        if(error_message=='')
        {
            error_message = ap_captcha_error_message;
        }
        var first_num = jQuery('#'+form_id+' .ap-captcha-first-num').html();
        var second_num = jQuery('#'+form_id+' .ap-captcha-second-num').html();
        var result = parseInt(first_num)+parseInt(second_num);
        var user_result = jQuery('#'+form_id+' #ap-captcha-result').val();
        if(result==user_result)
        {
            
            return true;
        }
        else
        {
            jQuery('#'+form_id+' .ap-captcha-error-msg').html(error_message);
            return false;
        }
        return false;    
    }
    else
    {
        return true;
    }
    
}
 
(function ($) {
    $(function () {
      

        	//All js related for frontend
            //$('#ap_form_post_content').val('<img src="http://192.168.1.70/anonymous_post/wp-content/uploads/2014/09/registration-account7.jpg"/>');
            //tinyMCE.triggerSave();
            //Checking  required fields
            
            $('.ap-pro-front-form .ap-pro-submit-btn').click(function(){
            var error_flag = 0;
            var id = $(this).closest('.ap-pro-front-form').attr('id');
            if(!$('#'+id+' .ap-simple-textarea').length>0)
            {
              tinyMCE.triggerSave();    
            }
            
            $('#'+id+' input').each(function(){
               if($(this).hasClass('ap-required-field') && $(this).val()=='')
               {
                error_flag = 1;
                var error_msg = $(this).attr('data-required-msg');
                if(error_msg=='')
                {
                    error_msg = ap_form_required_message; 
                }
                $(this).closest('.ap-pro-form-field-wrapper').find('.ap-form-error').html(error_msg);
               }
               });
               if($('#'+id+' .ap-form-content-editor').val()=='')
               {
                error_flag = 1;
                var error_msg = $('#'+id+' .ap-form-content-error').attr('data-required-msg');
                if(error_msg=='')
                {
                    error_msg = ap_form_required_message;
                }
                $('#'+id+' .ap-form-content-error').html(error_msg);
               }
               $('#'+id+' textarea.ap-pro-textarea').each(function(){
                if($(this).hasClass('ap-required-field') && $(this).val()=='')
                {
                    error_msg = $(this).attr('data-required-msg');
                    if(error_msg=='')
                    {
                        error_msg = ap_form_required_message;
                    }
                     $(this).closest('.ap-pro-form-field-wrapper').find('.ap-form-error').html(error_msg);
                }
               }); 
               $('#'+id+' select').each(function(){
                if($(this).hasClass('ap-required-field') && $(this).val()=='')
                {
                    error_flag = 1;
                   error_msg = $(this).attr('data-required-msg');
                    if(error_msg=='')
                    {
                        error_msg = ap_form_required_message;
                    }
                    $(this).closest('.ap-pro-form-field-wrapper').find('.ap-form-error').html(error_msg);
                }
               })
            
            if(error_flag==1)
            {
                return false;
            }
            else
            {
                return true;
            }
            
        });
             $('.ap-pro-front-form input[type="text"]').keyup(function(){
                $(this).closest('.ap-pro-form-field-wrapper').find('.ap-form-error').html('');
             });
             
             $('.ap-pro-front-form textarea.ap-pro-textarea').keyup(function(){
                $(this).closest('.ap-pro-form-field-wrapper').find('.ap-form-error').html('');
             });
             $('.ap-form-content-editor').keyup(function(){
                $('.ap-form-content-error').html('');
             });
             
             $('.ap-pro-front-form select').change(function(){
                $(this).closest('.ap-pro-form-field-wrapper').find('.ap-form-error').html('');
             });
             $('.ap-form-content-editor').change(function(){
                $('.ap-form-content-error').html('');
             });
            
            $('.ap-pro-datepicker').datepicker();
            $('.ap-pro-datepicker').datepicker("option", "dateFormat","yy-mm-dd");
            
            /*----------File Uploader-----------------*/
            var uploader_counter = 0;
            var uploader = {};
            $('.ap-file-uploader').each(function(){
                uploader_counter++;
                var attr_element_id = $(this).attr('id');
                var arr_element_id = attr_element_id.split('-');
                var element_id = arr_element_id[3];
                var extensions = $(this).attr('data-extensions');
                var extensions_array = extensions.split('|');
                var size = $(this).attr('data-size');
                var multiple_upload = $(this).attr('data-multiple');
                uploader['uploader'+uploader_counter] = new qq.FileUploader({
                	element: document.getElementById('ap-file-uploader-'+uploader_counter),
				
				// path to server-side upload script
				// action: '/server/upload'
				action: ap_fileuploader.upload_url,
				params: {
				        action:'ap_file_upload_action',
                        file_uploader_nonce:ap_fileuploader.nonce,
				        allowedExtensions: extensions_array,
                        sizeLimit: size,
                        element_id:element_id
                        },
				 allowedExtensions: extensions_array,
				sizeLimit: size,	// 100mb
				minSizeLimit: 500,
                onSubmit: function(id, fileName){
                    
                 },
                onProgress: function(id, fileName, loaded, total){},
                onComplete: function(id, fileName, responseJSON){
                    
                console.log(responseJSON);
                if(responseJSON.success)
                {
                    //tinyMCE.triggerSave();
                    $('#ap-pro-file-url-'+element_id).closest('.ap-pro-form-field-wrapper').find('.ap-form-error').html('');
                    if(multiple_upload)
                    {
                        var url = responseJSON.url;
                        var previous_url = $('#ap-pro-file-url-'+element_id).val();
                        if(previous_url=='')
                        {
                            $('#ap-pro-file-url-'+element_id).val(url);
                        }
                        else
                        {
                            $('#ap-pro-file-url-'+element_id).val(previous_url+','+url);
                        }
                    }
                    else
                    {
                     $('#ap-pro-file-url-'+element_id).val(responseJSON.url);    
                    }
                    
                    //var content = $('#ap_form_post_content').val();
                    //content = content + '<img src="'+responseJSON.url+'"/>';
                    //$('#ap_form_post_content').val(content)
                    //tinyMCE.execCommand('mceInsertContent', false, '<img src="'+responseJSON.url+'"/>');
                    //$('#ap_form_post_content').append();
                    //tinyMCE.triggerSave();
                }
                    
                },
                onCancel: function(id, fileName){},
                onError: function(id, fileName, xhr){},
                messages:{
                    typeError: " {file} has invalid extension. Only {extensions} are allowed.",
                    sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
                    minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
                    emptyError: "{file} is empty, please select files again without it.",
                    onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
                },
                showMessage: function(message){ alert(message); },
                multiple:multiple_upload     
                }); 
            });
            if($('#ap-content-file-uploader').length>0)
            {
                var content_image_uploader = new qq.FileUploader({
                	element: document.getElementById('ap-content-file-uploader'),
				
				// path to server-side upload script
				// action: '/server/upload'
				action: ap_fileuploader.upload_url,
				params: {
				        action:'ap_file_upload_action',
                        file_uploader_nonce:ap_fileuploader.nonce,
				        allowedExtensions: ['jpg','png','gif','jpeg'],
                        sizeLimit: 3000000,
                        },
				 allowedExtensions: ['jpg','png','gif','jpeg'],
				sizeLimit: 3000000,	// 100mb
				minSizeLimit: 500,
                onSubmit: function(id, fileName){
                    
                 },
                onProgress: function(id, fileName, loaded, total){},
                onComplete: function(id, fileName, responseJSON){
                    
                console.log(responseJSON);
                if(responseJSON.success)
                {
                    //tinyMCE.triggerSave();
                   // $('#ap-pro-file-url-'+element_id).closest('.ap-pro-form-field-wrapper').find('.ap-form-error').html('');
                    //$('#ap-pro-file-url-'+element_id).val(responseJSON.url);
                    //var content = $('#ap_form_post_content').val();
                    //content = content + '<img src="'+responseJSON.url+'"/>';
                    //$('#ap_form_post_content').val(content)
                    tinyMCE.execCommand('mceInsertContent', false, '<img src="'+responseJSON.url+'"/>');
                    //$('#ap_form_post_content').append();
                    //tinyMCE.triggerSave();
                    $('#ap-content-file-uploader .qq-upload-list').html('');
                }
                    
                },
                onCancel: function(id, fileName){},
                onError: function(id, fileName, xhr){},
                messages:{
                    typeError: " {file} has invalid extension. Only {extensions} are allowed.",
                    sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
                    minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
                    emptyError: "{file} is empty, please select files again without it.",
                    onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
                },
                showMessage: function(message){ alert(message); },
                multiple:false     
                });
            }
             
            /*----------File Uploader-----------------*/
            
           // tinyMCE.execCommand('mceInsertContent', false, "some text");
//            tinyMCE.triggerSave();
            });
}(jQuery));