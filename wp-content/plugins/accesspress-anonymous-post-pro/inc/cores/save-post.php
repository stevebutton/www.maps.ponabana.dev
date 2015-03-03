<?php 
defined('ABSPATH') or die("No script kiddies please!");
global $error;
global $wpdb;
$form_id = $_POST['ap_form_id'];
$table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
$forms = $wpdb->get_results("SELECT * FROM $table_name where ap_form_id = $form_id");
$form = $forms[0];
$ap_settings = unserialize($form->form_details);
//$ap_settings = $this->ap_settings;
//$this->print_array($_POST);
$ap_form_post_title = sanitize_text_field($_POST['ap_form_post_title']);
$ap_form_content = $_POST['ap_form_post_content'];
$error = new stdClass();
$error_flag = 0;
$error->form_id = $form_id;
//die();
//condition check if google captcha is enabled 
if(isset($_POST['recaptcha_response_field']) && $ap_settings['captcha_type']=='google')
{   
    include_once('recaptchalib.php');
    $privatekey = $ap_settings['google_catpcha_private_key'];
    $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
     if (!$resp->is_valid) {
        
        $error_flag = 1;
    // What happens when the CAPTCHA was entered incorrectly
    $error->captcha = ($ap_settings['google_captcha_error_message']=='')?__('The reCAPTCHA wasn\'t entered correctly. Please try it again.','anonymous-post-pro'):esc_attr($ap_settings['google_captcha_error_message']);
    
  }
  
    
    
}
//if captcha is disabled or captcha has been entered correctly
if($error_flag==0)
{
    if($ap_form_post_title=='')//if post title is left blank
    {
        $post_title_error = ($ap_settings['form_fields']['post_title']['required_message']=='')?__('This field is required','anonymous-post'):esc_attr($ap_settings['form_fields']['post_title']['required_message']);
        $error->title = $post_title_error;
        $error_flag = 1;
        
        
    }
    
    if($ap_form_content=='')//if post content is left blank
    {
        $post_content_error = ($ap_settings['form_fields']['post_content']['required_message']=='')?__('This field is required','anonymous-post'):esc_attr($ap_settings['form_fields']['post_content']['required_message']);
        $error->content = $post_content_error;
        $error_flag = 1;
        
        
    }
    if(in_array('post_image',$_POST['form_included_fields']))//if post image is enabled in form
    {
        if($_FILES['ap_form_post_image']['name']!='')//if user has uploaded the files
        {
            $image_name = $_FILES['ap_form_post_image']['name'];
            $image_name_array =explode('.',$image_name); 
            $ext = end($image_name_array);
            if(!($ext=='jpeg' || $ext=='png' || $ext=='jpg' || $ext=='gif' || $ext = 'JPEG' || $ext=='JPG' || $ext=='PNG' || $ext=='GIF'))//if users upload invalid file type
            {
              $error->image = __('Invalid File Type','anonymous-post-pro');
              $error_flag = 1;    
            }
            
        }
        
    
    }
    if($error_flag==0)
    {
        
        //uploading image to media 
        if(in_array('post_image',$_POST['form_included_fields']) && $_FILES['ap_form_post_image']['name']!='')
        {
            if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
            $uploadedfile = $_FILES['ap_form_post_image'];
            $upload_overrides = array( 'test_form' => false );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            //$this->print_array($movefile);
            if ( $movefile ) {
                include_once( ABSPATH . 'wp-admin/includes/image.php' );
                $wp_filetype = $movefile['type'];
                $filename = $movefile['file'];
                $wp_upload_dir = wp_upload_dir();
                $attachment = array(
                            'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
                            'post_mime_type' => $wp_filetype,
                            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                            'post_content' => '',
                            'post_status' => 'inherit'
                                    );
            $attach_id = wp_insert_attachment( $attachment, $filename);
            $attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
             wp_update_attachment_metadata($attach_id,$attach_data);
                
            }
        }
        
        $post_type = $ap_settings['post_type'];
        $publish_status = $ap_settings['publish_status'];
        if($ap_settings['login_check']==1)
        {
            $author = get_current_user_id();
        }
        else
        {
            $author = $ap_settings['post_author'];
        }
        $post_arguments = array('post_type'=>$post_type,
                                'post_title'=>$ap_form_post_title,
                                'post_content'=>$ap_form_content,
                                'post_status'=>$publish_status,
                                'post_author'=>$author
                                );
        if(isset($_POST['ap_form_post_excerpt']))
        {
            $post_arguments['post_excerpt'] = sanitize_text_field($_POST['ap_form_post_excerpt']);
        }
        $post_id = wp_insert_post($post_arguments);
        if($post_id && isset($attach_id))
        {
            add_post_meta($post_id, '_thumbnail_id', $attach_id, true);//adding featured image to post
        }
        
        if(isset($_POST['ap_form_post_tag_dropdown']))
        {
            $tags_array = $_POST['ap_form_post_tag_dropdown'];
            $tags = implode(',',$tags_array);
            if(!empty($post_id) && $tags!='')
            {
                $check = wp_set_post_terms($post_id,$tags,'post_tag');
                
                
            }
        }
        
        if(isset($_POST['form_included_taxonomy']) && !empty($_POST['form_included_taxonomy']) && $post_id)
        {
            foreach($_POST['form_included_taxonomy'] as $taxonomy)
            {
                
                if($ap_settings['form_fields'][$taxonomy]['hierarchical']==1)
                {
                    $term_id = sanitize_text_field($_POST[$taxonomy]);
                    if($term_id!='')
                      {
                        wp_set_post_terms( $post_id, array($term_id), $taxonomy);  
                      }
                }
                else
                {
                    $tags = sanitize_text_field($_POST[$taxonomy]);
                    if($tags!='')
                    {
                        wp_set_post_terms( $post_id, $tags, $taxonomy); 
                    }
                }    
                
            }
        }
        else
        {
            //if none of the taxonomies are included on the form and still admin wants to assign to specific taxonomy
            if($ap_settings['post_category']!='')
            {
                $post_category = $ap_settings['post_category'];
                $post_category_array = explode('|',$post_category);
                $post_category_id = $post_category_array[0];
                $post_taxonomy = $post_category_array[1];
                wp_set_post_terms( $post_id, array($post_category_id), $post_taxonomy);
            }
        }//else close
    if($post_id)
    {
        //adding author name as post meta field
        if(in_array('author_name',$_POST['form_included_fields']) && $_POST['ap_form_author_name']!='')
        {
            $author_name = sanitize_text_field($_POST['ap_form_author_name']);
            add_post_meta($post_id, 'ap_author_name', $author_name, false); 
        }
        
        if(in_array('author_url',$_POST['form_included_fields']) && $_POST['ap_form_author_url']!='')
        {
            $author_url = sanitize_text_field($_POST['ap_form_author_url']);
            add_post_meta($post_id, 'ap_author_url', $author_url, false);
        }
        if(in_array('author_email',$_POST['form_included_fields']) && $_POST['ap_form_author_email']!='')
        {
            $author_email = sanitize_email($_POST['ap_form_author_email']);
            add_post_meta($post_id, 'ap_author_email', $author_email, false);
        }
        if(isset($_POST['form_custom_fields']) && !empty($_POST['form_custom_fields']))
        {
            foreach($_POST['form_custom_fields'] as $key)
            {
                $meta_key = sanitize_text_field($key);
                $value = sanitize_text_field($_POST[$key]);
                if($value!='')
                {
                     add_post_meta($post_id, $meta_key, $value, false);
                }
            }
        }
        add_post_meta($post_id,'ap_form_id',$form_id,false);
        if($ap_settings['admin_notification'])
        {
            $this->send_admin_notification($post_id,$ap_form_post_title,$form_id);
        }
        $success = new stdClass();
        $success->msg = ($ap_settings['post_submission_message']=='')?__('Hi there, Thank you for submitting a post.','anonymous-post'):wp_kses_post($ap_settings['post_submission_message']);
        $_SESSION['ap_form_success_msg'] = $success->msg;
        $_SESSION['ap_form_id'] = $form_id;
        wp_redirect($_POST['redirect_url']);
        exit;
         
    }
    }//if close
    
}