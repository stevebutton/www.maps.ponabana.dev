<?php 
global $error;
//$ap_settings = $this->ap_settings;
//$this->print_array($ap_settings['form_styles']);?>

<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:400,700|Open+Sans:400,700' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=<?php echo str_replace(' ','+',$ap_settings['form_styles']['label']['font']);?>:400,700|<?php echo str_replace(' ','+',$ap_settings['form_styles']['button']['font']);?>:400,700' rel='stylesheet' type='text/css'/>


<?php
$file_upload_counter = isset($_SESSION['file_uploader_counter'])?$_SESSION['file_uploader_counter']:0;
$each_upload_counter = 0;
//$this->print_array($error);
//$file_upload_counter = 0;
$form_title = ($ap_settings['form_title']=='')?'Anonymous Post':$ap_settings['form_title'];
$form ='<div class="ap-pro-front-form-wrapper">';
$form .='<h2 class="ap-pro-front-form-title">'.$form_title.'</h2>';
if(isset($_SESSION['ap_form_success_msg'],$_SESSION['ap_form_id']) && $ap_settings['redirect_url']=='' && $_SESSION['ap_form_id']==$form_id)
{
    $success_msg = $_SESSION['ap_form_success_msg'];
    unset($_SESSION['ap_form_success_msg']);
    unset($_SESSION['ap_form_id']);
    $form .='<div class="ap-pro-form-success-msg">'.$success_msg.'</div>';
}
//check_form_submittable()
$form .='<form method="post" action="" enctype="multipart/form-data" class="ap-pro-front-form" onsubmit="return check_form_submittable(\'ap-form-'.$form_id.'\');" id="ap-form-'.$form_id.'">';
foreach($ap_settings['form_fields'] as $field_title=>$field_array)
{
    if($field_array['show_form']==1):
    if(!isset($field_array['file_extension']))
    {
     $field_array = array_map('esc_attr',$field_array);    
    }
    
  switch ($field_array['field_type']){
   case 'field':
       switch ($field_title){
        /**
         * Post Title
         * */
        case 'post_title':
        $post_title_label = ($field_array['label']=='')?__('Post Title','anonymous-post-pro'):$field_array['label'];
        $form .='<div class="ap-pro-form-field-wrapper">';
        $form .='<div class="label-wrap"><label>'.$post_title_label.'</label>';
        if($field_array['notes_type']=='icon' && $field_array['notes']!='')
        {
            $form .='<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">'.$field_array['notes'].'</div></div>';
        }
        $required_message = ($field_array['required_message']=='')?__('This field is required.','anonymous-post-pro'):$field_array['required_message'];
        $form .='</div><div class="ap-pro-form-field">
                   <input type="text" name="ap_form_post_title" data-required-msg="'.$field_array['required_message'].'" class="ap-pro-textfield ap-required-field""/>
                   <input type="hidden" name="form_included_fields[]" value="post_title"/>';
        if($field_array['notes_type']=='tooltip' && $field_array['notes']!='')
        {
            $form .='<span class="ap-pro-tooltip-notes">'.$field_array['notes'].'</span>';
        }
        $error_title = (isset($error->title) && $error->form_id==$form_id)?$error->title:'';
        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error">'.$error_title.'</div>';             
        $form .='</div><!--ap-pro-form-field-wrapper-->';
        break;
        
        /**
         * Post Content
         * */
        case 'post_content':
        $post_content_label = ($field_array['label']=='')?__('Post Content','anonymous-post-pro'):$field_array['label'];
        $form .='<div class="ap-pro-form-field-wrapper">';
        $form .='<div class="label-wrap"><label>'.$post_content_label.'</label>';
        if($field_array['notes_type']=='icon' && $field_array['notes']!='')
        {
            $form .='<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">'.$field_array['notes'].'</div></div>';
        }
       
         //For grabbing the html of the wp editor and saving into variable 
         
         if($field_array['editor_type']=='simple')
         {
           $wp_editor = '<textarea name="ap_form_post_content" rows="5" class="ap-simple-textarea ap-form-content-editor"></textarea>';
               
         }
         else
         {
           $wp_editor = $this->get_wp_editor_html($field_array['editor_type']); 
         }
        $required_message = ($field_array['required_message']=='')?__('This field is required.','anonymous-post-pro'):$field_array['required_message'];
        $form .='</div><div class="ap-pro-form-field">';
        if((!is_user_logged_in() || !current_user_can('upload_files'))  && $ap_settings['anonymous_image_upload']==1 && ($field_array['editor_type']=='rich' || $field_array['editor_type']=='visual'))
        {
         $form .='<div id="ap-content-file-uploader"></div>';    
        }
        
        $form .= $wp_editor.'
                   <input type="hidden" name="form_included_fields[]" value="post_content"/>';
        if($field_array['notes_type']=='tooltip' && $field_array['notes']!='')
        {
            $form .='<span class="ap-pro-tooltip-notes">'.$field_array['notes'].'</span>';
        }
        $error_content = (isset($error->content) && $error->form_id==$form_id)?$error->content:'';
        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error ap-form-content-error" data-required-msg="'.$field_array['required_message'].'">'.$error_content.'</div>';             
        $form .='</div><!--ap-pro-form-field-wrapper-->';
        break;
        
        /**
         * Post Image
         * */
        case 'post_image':
        $post_image_label = ($field_array['label']=='')?__('Post Image','anonymous-post-pro'):$field_array['label'];
        $form .='<div class="ap-pro-form-field-wrapper">';
        $form .='<div class="label-wrap"><label>'.$post_image_label.'</label>';
        if($field_array['notes_type']=='icon' && $field_array['notes']!='')
        {
            $form .='<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">'.$field_array['notes'].'</div></div>';
        }
        $required = ($field_array['required']=='1')?' ap-required-field':'';
        $required_message = ($field_array['required_message']=='')?__('This field is required.','anonymous-post-pro'):$field_array['required_message'];
        $form .='</div><div class="ap-pro-form-field">
                   <input type="file" name="ap_form_post_image" data-required-msg="'.$field_array['required_message'].'" class="ap-pro-filefield'.$required.'"/>
                   <input type="hidden" name="form_included_fields[]" value="post_image"/>';
        if($field_array['notes_type']=='tooltip' && $field_array['notes']!='')
        {
            $form .='<span class="ap-pro-tooltip-notes">'.$field_array['notes'].'</span>';
        }
        $error_image = isset($error->image)?$error->image:'';
        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error">'.$error_image.'</div>';             
        $form .='</div><!--ap-pro-form-field-wrapper-->';
        break;
        
        /**
         * Post Excerpt
         * */
         case 'post_excerpt':
         $post_excerpt_label = ($field_array['label']=='')?__('Post Excerpt','anonymous-post-pro'):$field_array['label'];
        $form .='<div class="ap-pro-form-field-wrapper">';
        $form .='<div class="label-wrap"><label>'.$post_excerpt_label.'</label>';
        if($field_array['notes_type']=='icon' && $field_array['notes']!='')
        {
            $form .='<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">'.$field_array['notes'].'</div></div>';
        }
        $required = ($field_array['required']=='1')?' ap-required-field':'';
        $required_message = ($field_array['required_message']=='')?__('This field is required.','anonymous-post-pro'):$field_array['required_message'];
        $form .='</div><div class="ap-pro-form-field">
                   <textarea name="ap_form_post_excerpt" data-required-msg="'.$field_array['required_message'].'" class="ap-pro-textarea'.$required.'"></textarea>
                   <input type="hidden" name="form_included_fields[]" value="post_excerpt"/>';
        if($field_array['notes_type']=='tooltip' && $field_array['notes']!='')
        {
            $form .='<span class="ap-pro-tooltip-notes">'.$field_array['notes'].'</span>';
        }
        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';             
        $form .='</div><!--ap-pro-form-field-wrapper-->';
         break;
         /**
         * Post Tag Dropdown
         * */
         case 'post_tag_dropdown':
         $post_tag_dropdown_label = ($field_array['label']=='')?__('Post Tags Dropdown','anonymous-post-pro'):$field_array['label'];
        $form .='<div class="ap-pro-form-field-wrapper">';
        $form .='<div class="label-wrap"><label>'.$post_tag_dropdown_label.'</label>';
        if($field_array['notes_type']=='icon' && $field_array['notes']!='')
        {
            $form .='<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">'.$field_array['notes'].'</div></div>';
        }
        $required = ($field_array['required']=='1')?' ap-required-field':'';
        $required_message = ($field_array['required_message']=='')?__('This field is required.','anonymous-post-pro'):$field_array['required_message'];
        $form .='</div><div class="ap-pro-form-field">
                   <select name="ap_form_post_tag_dropdown[]" data-required-msg="'.$field_array['required_message'].'" class="ap-pro-tag-dropdown'.$required.'" multiple>
                     <option value="">'.__('Choose Tag','anonymous-post-pro').'</option>
                   ';
        $tags = get_terms('post_tag',array('hide_empty'=>0,'order'=>'ASC','orderby'=>'name'));
        if(!empty($tags))
        {
            foreach($tags as $tag)
            {
                $form .= '<option value="'.$tag->name.'">'.$tag->name.'</option>';
            }
        }
                   
        $form .='</select>
                   <input type="hidden" name="form_included_fields[]" value="post_tag_dropdown"/>';
        if($field_array['notes_type']=='tooltip' && $field_array['notes']!='')
        {
            $form .='<span class="ap-pro-tooltip-notes">'.$field_array['notes'].'</span>';
        }
        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';             
        $form .='</div><!--ap-pro-form-field-wrapper-->';
         break;
         
         /**
          * Author Name
          * */
          default:
          if($field_title=='author_name')
          {
            $author_label = ($field_array['label']=='')?__('Author Name','anonymous-post-pro'):$field_array['label'];  
          }
          if($field_title=='author_url')
          {
            $author_label = ($field_array['label']=='')?__('Author URL','anonymous-post-pro'):$field_array['label'];  
          }
          if($field_title=='author_email')
          {
            $author_label = ($field_array['label']=='')?__('Author Email','anonymous-post-pro'):$field_array['label'];  
          }
          
        $form .='<div class="ap-pro-form-field-wrapper">';
        $form .='<div class="label-wrap"><label>'.$author_label.'</label>';
        if($field_array['notes_type']=='icon' && $field_array['notes']!='')
        {
            $form .='<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">'.$field_array['notes'].'</div></div>';
        }
        $required = ($field_array['required']=='1')?' ap-required-field':'';
        $required_message = ($field_array['required_message']=='')?__('This field is required.','anonymous-post-pro'):$field_array['required_message'];
        $form .='</div><div class="ap-pro-form-field">
                   <input type="text" name="ap_form_'.$field_title.'" data-required-msg="'.$field_array['required_message'].'" class="ap-pro-textfield'.$required.'"/>
                   <input type="hidden" name="form_included_fields[]" value="'.$field_title.'"/>';
        if($field_array['notes_type']=='tooltip' && $field_array['notes']!='')
        {
            $form .='<span class="ap-pro-tooltip-notes">'.$field_array['notes'].'</span>';
        }
        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';             
        $form .='</div><!--ap-pro-form-field-wrapper-->';
       }//secondary switch close
   break;
   
   /**
    * Taxonomy Fields
    * */
   case 'taxonomy':
   $taxonomy_label = ($field_array['label']=='')?$field_label['taxonomy_label']:$field_array['label'];
        $form .='<div class="ap-pro-form-field-wrapper">';
        $form .='<div class="label-wrap"><label>'.$taxonomy_label.'</label>';
        if($field_array['notes_type']=='icon' && $field_array['notes']!='')
        {
            $form .='<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">'.$field_array['notes'].'</div></div>';
        }
        $required = ($field_array['required']=='1')?' ap-required-field':'';
        $required_message = ($field_array['required_message']=='')?__('This field is required.','anonymous-post-pro'):$field_array['required_message'];
        $form .='</div><div class="ap-pro-form-field">';
        if($field_array['hierarchical']==0)
        {
          $form .='<input type="text" name="'.$field_title.'" data-required-msg="'.$field_array['required_message'].'" class="ap-pro-textfield'.$required.'"/>';    
        }
        else
        {
            $first_opt_label = __('Choose','anonymous-post-pro').' '.$field_array['taxonomy_label'];
            $form .='<select name='.$field_title.' class="ap-pro-select'.$required.'" data-required-msg="'.$field_array['required_message'].'">
                     <option value="">'.$first_opt_label.'</option>';
            $terms = get_terms($field_title,array('hide_empty'=>0));
            if(count($terms)>0)
            {
                foreach($terms as $term)
                {
                    $form .='<option value="'.$term->term_id.'">'.$term->name.'</option>'; 
                }
            }
            $form .='</select>';
        }
        
        $form .='<input type="hidden" name="form_included_fields[]" value="'.$field_title.'"/>
                <input type="hidden" name="form_included_taxonomy[]" value="'.$field_title.'"/>';
        if($field_array['notes_type']=='tooltip' && $field_array['notes']!='')
        {
            $form .='<span class="ap-pro-tooltip-notes">'.$field_array['notes'].'</span>';
        }
        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';             
        $form .='</div><!--ap-pro-form-field-wrapper-->';
   break;
   
   /**
    * Custom Fields
    * */
   case 'custom':
   $custom_label = ($field_array['label']=='')?$field_array['custom_label']:$field_array['label'];
        $form .='<div class="ap-pro-form-field-wrapper">';
        $form .='<div class="label-wrap"><label>'.$custom_label.'</label>';
        if($field_array['notes_type']=='icon' && $field_array['notes']!='')
        {
            $form .='<div class="ap-pro-info-wrap"><span class="ap-pro-info-notes-icon">i</span><div class="ap-pro-info-notes">'.$field_array['notes'].'</div></div>';
        }
        $required = ($field_array['required']=='1')?' ap-required-field':'';
        $required_message = ($field_array['required_message']=='')?__('This field is required.','anonymous-post-pro'):$field_array['required_message'];
        $form .='</div><div class="ap-pro-form-field">';
        if($field_array['textbox_type']=='textarea')
        {
            $form .='<textarea name="'.$field_title.'" data-required-msg="'.$field_array['required_message'].'" class="ap-pro-textarea'.$required.'"></textarea>';
             
        }
        else if($field_array['textbox_type']=='file_uploader')
        {
            $file_upload_counter++;
            $each_upload_counter++;
            $upload_size = ($field_array['upload_size']=='')?8*1000000:$field_array['upload_size']*1000000;
            $file_types = (isset($field_array['file_extension']))?implode('|',$field_array['file_extension']):'gif|jpeg|png|jpg';
            $multiple_upload = (isset($field_array['multiple_upload']) && $field_array['multiple_upload']==1)?true:false;
            $form .='<div class="ap-file-uploader" id="ap-file-uploader-'.$file_upload_counter.'" data-extensions="'.$file_types.'" data-size="'.$upload_size.'" data-multiple="'.$multiple_upload.'">
                     </div>
                          ';
            $form .='<input type="hidden" name="'.$field_title.'" id="ap-pro-file-url-'.$file_upload_counter.'" class="'.$required.'" data-required-msg="'.$required_message.'" />';
            
        }
        else
        {
            if($field_array['textbox_type']=='datepicker')
            {
                $datepicker = 'ap-pro-datepicker';
            }
            else
            {
                $datepicker = '';
            }
         $form .='<input type="text" name="'.$field_title.'" data-required-msg="'.$field_array['required_message'].'" class="ap-pro-textfield'.$required.' '.$datepicker.'"/>';   
        }
        
        $form .='<input type="hidden" name="form_included_fields[]" value="'.$field_title.'"/>
                <input type="hidden" name="form_custom_fields[]" value="'.$field_title.'"/>';
        if($field_array['notes_type']=='tooltip' && $field_array['notes']!='')
        {
            $form .='<span class="ap-pro-tooltip-notes">'.$field_array['notes'].'</span>';
        }
        if($field_array['textbox_type']=='datepicker')
            {
                $form .='<span class="ap-datepicker-icon"></span>';
            }
            
        $form .= '</div><!--ap-pro-form-field-->
                 <div class="ap-form-error"></div>';             
        $form .='</div><!--ap-pro-form-field-wrapper-->';
   break;    
  }//switch close
  endif;  
}//foreach close
$_SESSION['file_uploader_counter'] = $file_upload_counter; 

/**
 * Captcha Conditions
 * */
if($ap_settings['captcha_settings']==1)
{
    if($ap_settings['captcha_type']=='human')
    {
        $captcha_label = ($ap_settings['math_captcha_label']=='')?__('Human Check'):esc_attr($ap_settings['math_captcha_label']);
         $form .='<div class="ap-pro-form-field-wrapper">
              <div class="label-wrap"><label>'.$captcha_label.'</label></div>
              <div class="ap-form-field math-captcha">
                <span class="ap-captcha-first-num">'.rand(1,9).'</span>+<span class="ap-captcha-second-num">'.rand(1,9).'</span>=<input type="text" id="ap-captcha-result" placeholder="'.__('Enter Sum','anonymous-post-pro').'" class="ap-required-field" data-required-msg="'.esc_attr($ap_settings['math_captcha_error_message']).'">
              </div>
              <div class="ap-form-error ap-captcha-error-msg"></div> 
            </div><!--ap-form-field-wrapper-->';
    }
    else
    {
        if($ap_settings['google_catpcha_public_key']!='' && $ap_settings['google_catpcha_private_key']!='')
        {
             include_once('recaptchalib.php');//including google captcha library
            $google_captcha_label = ($ap_settings['google_captcha_label']=='')?'Google Captcha':esc_attr($ap_settings['google_captcha_label']);
            $public_key = esc_attr($ap_settings['google_catpcha_public_key']);
            $form .='<div class="ap-form-field-wrapper">
                     <div class="label-wrap"><label>'.$google_captcha_label.'</label></div>
                     <div class="ap-form-field">
                     '.recaptcha_get_html($public_key).
                     '</div><!--ap-form-field-->
                     ';
            if(isset($error->captcha) && $error->form_id == $form_id)
            {
                $form .='<div class="ap-form-error-message">'.$error->captcha.'</div>';
            }                
            $form .='</div><!--ap-form-field-wrapper-->';
        }
    }
}
$submit_button_label = ($ap_settings['post_submit_label']=='')?__('Submit Post','anonymous-post-pro'):esc_attr($ap_settings['post_submit_label']);
$redirect_url = ($ap_settings['redirect_url']=='')?$this->curPageURL():esc_url($ap_settings['redirect_url']);
$captcha_type = ($ap_settings['captcha_settings']==1)?$ap_settings['captcha_type']:'';
$form .= '<div class="ap-pro-form-field-wrapper">
            <input type="hidden" name="redirect_url" value="'.$redirect_url.'"/>
            <input type="hidden" class="ap-captcha-type" value="'.$captcha_type.'"/>
            <input type="hidden" id="ap-pro-file-uploader-counter" value="'.$each_upload_counter.'"/>
            <input type="hidden" name="ap_form_id" value="'.$form_id.'"/>
            <input type="submit" name="ap_form_submit_button" value="'.$submit_button_label.'" class="ap-pro-submit-btn"/>
         </div>';
$form .=$this->get_nonce_field_html();
$form .= '</form><!--ap-pro-front-form-->
         </div><!--ap-pro-front-form-wrapper-->';