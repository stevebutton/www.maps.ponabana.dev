(function ($) {
    $(function () {
	   //All the backend js for the plugin 
       
       /*
       Settings Tabs Switching 
       */
       $('.ap-tabs-trigger').click(function(){
        $('.ap-tabs-trigger').removeClass('ap-active-tab');
        $(this).addClass('ap-active-tab');
        var board_id = 'board-'+$(this).attr('id');
        $('.ap-tabs-board').hide();
        $('#'+board_id).show();
        if(board_id=='board-form-settings')
        {
            $('.ap-pro-custom-field-adder').show();
        }
        else
        {
            $('.ap-pro-custom-field-adder').hide();
        }
       });
       
	   //Get all the terms from a taxonomy of the respective post type
	   $('.ap-settings-form select[name="post_type"]').change(function(){
	       var post_type = $(this).val();
           $('.ap-pro-form-taxonomies').remove();
           $('select[name="post_category"] optgroup').remove();
           $.ajax({
            type:'post',
            url:ap_ajax_url,
            data:'action=get_terms_by_post_type&post_type='+post_type,
            success:function(res)
            {
                res = $.parseJSON(res);
                
                if(Object.getOwnPropertyNames(res).length != 0)
                {
                    
                    $('select[name="post_category"]').html(res.options);                   
                    var taxonomies = res.taxonomy;
                    var taxonomies_label = res.taxonomy_label;
                    var taxonomy_hierarchical = res.taxonomy_hierarchical;
                    var i;
                    var taxonomy_html = '';
                    var taxonomy_label_html = '';
                    var taxonomy_required_html= '';
                    var taxonomy_reference = taxonomies.join(',')
                    for(i=0;i<taxonomies.length;i++)
                    {
                        
                   taxonomy_html = taxonomy_html+'<li class="ap-pro-form-taxonomies ap-pro-li-sortable">'+
                   '<div class="dragicon"></div><div class="ap-pro-labels-head">'+taxonomies_label[i]+'<span class="ap-arrow-down ap-arrow">Down</span></div>'+
                   '<div class="ap-pro-labels-content" style="display: none;">'+
                   '<ul class="ap-pro-inner-configs">'+
                   '<li>'+
                   '<label>'+ap_show_form+'</label>'+
                   '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields['+taxonomies[i]+'][show_form]" value="1"/></div>'+
                   '</li>'+
                   '<li>'+
                   '<label>'+ap_custom_required+'</label>'+
                   '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields['+taxonomies[i]+'][required]" value="1"/></div>'+
                   '</li>'+
                   '<li>'+
                   '<label>'+ap_custom_required_message+'</label>'+
                   '<div class="ap-pro-textbox"><input type="text" name="form_fields['+taxonomies[i]+'][required_message]" value=""/></div>'+
                   '</li>'+
                   '<li>'+
                   '<label>'+ap_custom_label+'</label>'+
                   '<div class="ap-pro-textbox"><input type="text" name="form_fields['+taxonomies[i]+'][label]" value="'+taxonomies_label[i]+'"/></div>'+
                   '</li>'+
                   '<li>'+
                   '<li>'+
                   '<label>'+ap_field_notes+'</label>'+
                   '<div class="ap-pro-select">'+
                   ' <select name="form_fields['+taxonomies[i]+'][notes_type]">'+
                   ' <option value="0">'+ap_pro_notes_obj.dont_show+'</option>'+
                       '<option value="icon">'+ap_pro_notes_obj.icon+'</option>'+
                       '<option value="tooltip">'+ap_pro_notes_obj.tooltip+'</option>'+
                   ' </select>'+
                   '</div>'+
                   '</li>'+
                   '<label>'+ap_field_notes_textfield+'</label>'+
                   '<div class="ap-pro-textbox"><input type="text" name="form_fields['+taxonomies[i]+'][notes]" value=""/></div>'+
                   '<div class="ap-pro-notes">'+ap_field_notes_text+'</div>'+
                   '</li>'+
                   '</ul>'+
                   '<input type="hidden" name="form_included_taxonomy[]" value="'+taxonomies[i]+'"/>'+
                   '<input type="hidden" name="form_fields['+taxonomies[i]+'][hierarchical]" value="'+taxonomy_hierarchical[i]+'"/>'+
                   '<input type="hidden" name="form_field_order[]" value="'+taxonomies[i]+'|taxononmy"/>'+
                   '<input type="hidden" name="form_fields['+taxonomies[i]+'][field_type]" value="taxonomy"/>'+
                   '<input type="hidden" name="form_fields['+taxonomies[i]+'][taxonomy_label]" value="'+taxonomies_label[i]+'"/>'+
                   '</div>'+
                   '</li>';
                       //taxonomy_html = taxonomy_html+'<div class="ap-each-config-wrapper"><div class="ap-fields-label"><div class="ap-checkbox-form"><input type="checkbox" name="form_included_taxonomy[]" value="'+taxonomies[i]+'"/></div><span>'+taxonomies_label[i]+'</span>';
                       //taxonomy_required_html = taxonomy_required_html+'<div class="ap-checkbox-form"><input type="checkbox" name="form_required_fields[]" value="'+taxonomies[i]+'"/></div><span>'+taxonomies_label[i]+'</span>';
                       //taxonomy_label_html = taxonomy_label_html+'<div class="ap-option-wrapper"><label>'+taxonomies_label[i]+'</label><div class="ap-option-field"><input type="text" name="'+taxonomies[i]+'_label"/><div class="ap-option-note ap-option-width">This field will only show up in frontend if you have checked the taxonomy in included fields.</div></div></div>'; 
                    }
                    //$('.ap-taxonomy-required').html(taxonomy_required_html);
                    console.log(taxonomy_html);
                    $('.ap-pro-fields').append(taxonomy_html);
                    //$('.ap-form-taxonomies-wrapper').html(taxonomy_html);
                    //$('.post-taxonomy-wrapper').html(taxonomy_label_html);
                    $('input[name="taxonomy_reference"]').val(taxonomy_reference);
                }
                else
                {
                    
                }
                
                
                
                                
            }    
           });//ajax complete
	   });//change function complete
       
       //Captcha selection
       $('.ap-captcha-selector').click(function(){
        var captcha_type = $(this).val();
        $('.captcha-fields').hide();
        $('.ap-'+captcha_type+'-captcha-fields').show();
       });//captcha selection ends
       
       //admin email addition
       $('#ap-admin-email-add-trigger').click(function(){
        var email_counter = $('#ap-admin-email-counter').val();
        if(email_counter<3)
        {
            var email_field_html = '<div class="ap-each-admin-email"><input type="text" name="admin_email_list[]" placeholder="'+ap_admin_list_placeholder+'"/><span class="ap-remove-email-btn">X</span></div>';
            $('.ap-admin-email-list').append(email_field_html);
            email_counter++;
            $('#ap-admin-email-counter').val(email_counter);
        }
        else
        {
             $('.ap-admin-email-add-btn').hide();
        }
       });
       
       //removing admin email field
       $('.ap-admin-email-list').on('click','.ap-remove-email-btn',function(){
        var email_counter = $('#ap-admin-email-counter').val();
        email_counter--;
        $('#ap-admin-email-counter').val(email_counter);
        if(email_counter<3)
        {
            $('.ap-admin-email-add-btn').show();
        }
        $(this).parent().remove();
       });
       	
       //initializing color picker
       $('.ap-color-field').wpColorPicker();
       
       //For uploading form background image
       jQuery('#ap-background-upload-button').click(function() {
         formfield = jQuery('#ap-background-image').attr('name');
         tb_show('', 'media-upload.php?type=image&TB_iframe=true');
         return false;
        });
        window.send_to_editor = function(html) {
         imgurl = jQuery('img',html).attr('src');
         jQuery('#ap-background-image').val(imgurl);
         tb_remove();
        }
        
        //Form settings options show hide
        $('body').on('click','.ap-pro-labels-head',function(){
            if($(this).parent().find('.ap-arrow').hasClass('ap-arrow-down'))
            {
                $(this).parent().find('.ap-arrow').removeClass('ap-arrow-down').addClass('ap-arrow-up');
            }
            else
            {
                $(this).parent().find('.ap-arrow').removeClass('ap-arrow-up').addClass('ap-arrow-down');
            }
            $(this).parent().find('.ap-pro-labels-content').slideToggle(500);
            
        });
        //sortable form fields
        $('.ap-pro-fields').sortable();
        
        $('#ap-custom-field-submit').click(function(){
           var error_flag = 0;
           var label = $('#ap-custom-field-label').val();
           var key = $('#ap-custom-field-key').val(); 
           if(label=='')
           {
            $('#ap-custom-field-label').next('.ap-custom-error').html(ap_form_required_message);
            error_flag = 1;
           }
           if(key=='')
           {
            error_flag = 1;
            $('#ap-custom-field-key').next('.ap-custom-error').html(ap_form_required_message);
           }
           if(error_flag==0)
           {
            var append_li = '<li class="ap-pro-li-sortable">'+
            '<div class="dragicon"></div><div class="ap-pro-labels-head">'+label+'<span class="ap-arrow-down ap-arrow">Down</span><span class="ap-custom-li-delete">Delete</span></div>'+
             '<div class="ap-pro-labels-content" style="display: none;">'+
             ' <ul class="ap-pro-inner-configs">'+
               ' <li>'+
                 ' <label>'+ap_show_form+'</label>'+
                   '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields['+key+'][show_form]" value="1" checked="checked"/></div>'+
                   '</li>'+
                 '<li>'+
                 ' <label>'+ap_custom_required+'</label>'+
                   '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields['+key+'][required]" value="1"/></div>'+
                   '</li>'+
                 '<li>'+
                 ' <label>'+ap_custom_required_message+'</label>'+
                   '<div class="ap-pro-textbox"><input type="text" name="form_fields['+key+'][required_message]"/></div>'+
                   '</li>'+
                 '<li>'+
                 ' <label>'+ap_custom_label+'</label>'+
                   '<div class="ap-pro-textbox"><input type="text" name="form_fields['+key+'][label]" value="'+label+'"/></div>'+
                   '</li>'+
                 '<li>'+
                    '<label>'+ap_custom_textbox_type+'</label>'+
                    '<div class="ap-pro-select">'+
                     '<select name="form_fields['+key+'][textbox_type]" class="ap-pro-custom-field-type" data-key="'+key+'">'+
                     ' <option value="textfield">Text Field</option>'+
                     ' <option value="textarea">Text Area</option>'+
                     '<option value="datepicker">Date Picker</option>'+
                     '<option value="file_uploader">File Uploader</option>'+
                     '</select>'+
                     '</div>'+
                     '<div class="ap-pro-file-extensions" style="display:none"></div>'+
                     '</li>'+
                     '<li>'+
                     '<li>'+
                     '<label>'+ap_field_notes+'</label>'+
                   '<div class="ap-pro-select">'+
                   ' <select name="form_fields['+key+'][notes_type]" data-key="'+key+'">'+
                     ' <option value="0">'+ap_pro_notes_obj.dont_show+'</option>'+
                       '<option value="icon">'+ap_pro_notes_obj.icon+'</option>'+
                       '<option value="tooltip">'+ap_pro_notes_obj.tooltip+'</option>'+
                       '</select>'+
                     '</div>'+
                   '</li>'+ 
                 ' <label>'+ap_field_notes_textfield+'</label>'+
                   '<div class="ap-pro-textbox"><input type="text" name="form_fields['+key+'][notes]"/></div>'+
                   '<div class="ap-pro-notes">'+ap_field_notes_text+'</div>'+
                   '</li>'+
                 '</ul>'+
               '<input type="hidden" name="form_field_order[]" value="'+key+'|custom"/>'+
               '<input type="hidden" name="form_fields['+key+'][field_type]" value="custom"/>'+
               '<input type="hidden" name="form_fields['+key+'][custom_label]" value="'+label+'"/>'+
               '</div>'+
           '</li>';
           $('.ap-pro-fields').append(append_li);
            $('#ap-custom-field-label').val('');
           $('#ap-custom-field-key').val(''); 
           }
        });
        
        $('body').on('click','.ap-custom-li-delete',function(){
            if(confirm('Are you sure you want to delete this field?'))
            {
                var selector = $(this).closest('.ap-pro-li-sortable');
             $(this).closest('.ap-pro-li-sortable').fadeOut(500,function(){
                selector.remove();
             });     
            }
            return false;
            
        });
        
        $('.ap-login-type').click(function(){
            if($(this).val()=='login_message')
           {
            $('.ap-login-type-wrapper').show();
           }
           else
           {
            $('.ap-login-type-wrapper').hide();
           } 
        });
        //Google Font selecting
        var label_font = $('#ap-label-font').val();
        $('.form-style-label-font option[value="'+label_font+'"]').attr('selected','selected');
        var button_font = $('#ap-form-button-font').val();
        $('.form-styles-button-font option[value="'+button_font+'"]').attr('selected','selected');
         $("#ap-label-font-style").html('.ap-label-font-text { font-size: 16px; font-family: "'+ label_font +'" !important; }');
		  $("#ap-button-font-style").html('.ap-button-font-text { font-size: 16px; font-family: "'+ button_font +'" !important; }');
          WebFont.load({
			    google: {
			      families: [label_font, button_font]
			    }
			});
       
       //google font switching
        $('.form-style-label-font,.form-styles-button-font').change(function(){
           var label_font = $('.form-style-label-font').val();
           var  button_font = $('.form-styles-button-font').val();
           $("#ap-label-font-style").html('.ap-label-font-text { font-size: 16px; font-family: "'+ label_font +'" !important; }');
		  $("#ap-button-font-style").html('.ap-button-font-text { font-size: 16px; font-family: "'+ button_font +'" !important; }');
          WebFont.load({
			    google: {
			      families: [label_font, button_font]
			    }
			});
        });
        $('select[name="plugin_style_type"]').change(function(){
           if($(this).val()=='template')
           {
            $('.template-selector,.ap-template-preview-wrapper').show();
            $('.ap-form-styler-wrapper').hide();
           }
           else
           {
             $('.template-selector,.ap-template-preview-wrapper').hide();
            $('.ap-form-styler-wrapper').show();
           } 
        });
        
        $('select[name="form_template"]').change(function(){
            var template = $(this).val();
            $('.ap-template-image-wrapper').hide();
            $('.'+template+'-preview').show();
        });
        
       $('body').on('change','.ap-pro-custom-field-type',function(){
        if($(this).val()=='file_uploader')
        {
            var key = $(this).attr('data-key');
        $('.ap-extensions-clone input[type="checkbox"]').attr('name','form_fields['+key+'][file_extension][]');
        $('.ap-extensions-clone .ap-pro-file-upload-size').attr('name','form_fields['+key+'][upload_size]');
        $('.ap-extensions-clone .ap-pro-multiple-file-upload').attr('name','form_fields['+key+'][multiple_upload]');
        var append_html = $('.ap-extensions-clone').html();
        $(this).closest('li').find('.ap-pro-file-extensions').show().append(append_html);    
        }
        else
        {
            $(this).closest('li').find('.ap-pro-file-extensions').hide().html('');
        }
        
       }); 
	});
}(jQuery));
