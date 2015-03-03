<?php 
/**
 * POST PARAMETERS
 * 
 * 
 *  [action] => ap_settings_action
    [taxonomy_reference] => category
    [form_title] => Anonymous Post
    [publish_status] => draft
    [post_type] => post
    [admin_notification] => 1
    [post_category] => 
    [login_check] => 1
    [post_author] => 1
    [post_submission_message] => 
    [form_included_fields] => Array
        (
            [0] => post_title
            [1] => post_content
            [2] => post_image
            [3] => author_name
            [4] => author_url
            [5] => author_email
        )

    [form_included_taxonomy] => Array
        (
            [0] => category
            [1] => post_tag
        )

    [post_title_label] => 
    [post_content_label] => 
    [post_image_label] => 
    [category_label] => 
    [author_name_label] => 
    [author_url_label] => 
    [author_email_label] => 
    [post_submit_label] => 
    [captcha_settings] => 1
    [google_captcha_label] => Google Captcha
    [google_captcha_public_key] => 6LdluPkSAAAAAJu9ulagpAExZMuj8xUh7JmIIZ32
    [google_captcha_private_key] => 6LdluPkSAAAAAHcnImYWretYGyLjBHIFn9VuHZ1a
    [ap_settings_submit] => Save all changes
 * */
 

//$this->print_array($_POST);die();
//die();

/**
 * Changes all the posted fields into its respective variables from $_POST
 * */
 
 //for stripping unnecessary slashes
 $_POST = array_map( 'stripslashes_deep', $_POST );
 
foreach($_POST as $key=>$val)
        {
            
            switch($key){
                case 'form_fields':
                $value_new_array = array();
                
                foreach($val as $k=>$v)
                {
                    $v_new_array = array(); 
                    if(!isset($v['show_form']))
                    {
                        if($k=='post_title' || $k=='post_content')
                        {
                         $v['show_form'] = 1;    
                        }
                        else
                        {
                            $v['show_form'] = 0;
                        }
                    }                   
                   if(!isset($v['required']))
                    {
                        if($k=='post_title' || $k=='post_content')
                        {
                            $v['required'] = 1;
                        }
                        else
                        {
                            $v['required'] = 0;
                        }
                    }
                    foreach($v as $a=>$b)
                    {
                        if($a!='file_extension')
                        {
                            $b = sanitize_text_field($b);
                        }
                        $v_new_array[$a] = $b;
                    }
                    $value_new_array[$k] = $v_new_array;
                }
                $val = $value_new_array;
                break;
                case 'form_included_taxonomy':
                break;
                case 'form_field_order':
                break;
                case 'admin_email_list':
                $val = array_map('sanitize_email',$val);
                break;
                case 'user_notification_message':
                $val = $this->sanitize_escaping_linebreaks($val);
                break;
                case 'form_styles':
                $value_new_array = array();
                foreach($val as $k=>$v)
                {
                    $v_new_array = array();
                    foreach($v as $a=>$b)
                    {
                        $b = sanitize_text_field($b);
                        $v_new_array[$a] = $b;
                    }
                    $value_new_array[$k] = $v_new_array;
                }
                $val = $value_new_array;
                break;
                case 'post_submission_message':
                $val = $this->sanitize_escaping_linebreaks($val);
                break;
                case 'admin_notification_message':
                $val = $this->sanitize_escaping_linebreaks($val);
                break;
                case 'redirect_url':
                $val = esc_url($val);
                break;
                case 'login_message':
                $val = $this->sanitize_escaping_linebreaks($val);
                break;
                default:
                $val = sanitize_text_field($val);
                
            }
            
            //$$key = (!is_array($val))?$this->filter_field($val):$val;
            $$key = $val;
        }
 
$ap_settings = array();//array for saving all the plugin's settings in single array

/**
 * General Settings
 * */
 
$ap_settings['form_title'] = $form_title;
$ap_settings['publish_status'] = $publish_status;
$ap_settings['post_type'] = $post_type;
$ap_settings['admin_notification'] = isset($admin_notification)?1:0;
$ap_settings['admin_email_list'] = isset($admin_email_list)?$admin_email_list:array();
$ap_settings['admin_notification_message'] = $admin_notification_message;
$ap_settings['user_notification'] = isset($user_notification)?1:0;
$ap_settings['user_notification_message'] = $user_notification_message;
$ap_settings['login_check'] = isset($login_check)?1:0;
$ap_settings['login_type'] = isset($login_type)?$login_type:'';
$ap_settings['login_message'] = $login_message;
$ap_settings['login_link_text'] = $login_link_text;
$ap_settings['anonymous_image_upload'] = isset($anonymous_image_upload)?1:0;
$ap_settings['post_author'] = $post_author;
$ap_settings['redirect_url'] = $redirect_url;
$ap_settings['post_submission_message'] = $post_submission_message;
/**
 * Form Settings
 * */
$ap_settings['form_fields'] = $form_fields;
$ap_settings['post_submit_label'] = $post_submit_label;
$ap_settings['post_category'] = $post_category;
$ap_settings['taxonomy_reference'] = $taxonomy_reference;
$ap_settings['form_included_taxonomy'] = isset($form_included_taxonomy)?$form_included_taxonomy:array();
$ap_settings['form_field_order'] = $form_field_order;

/**
 * Form Style Settings
 * */
 $ap_settings['plugin_style_type'] = $plugin_style_type;
 $ap_settings['form_template'] = $form_template;
$ap_settings['form_styles'] = $form_styles;
$ap_settings['plugin_styles'] = (isset($plugin_styles))?1:0;


/**
 * Captcha Settings
 * */
 

$ap_settings['captcha_settings'] = isset($captcha_settings)?1:0;
$ap_settings['captcha_type'] = isset($captcha_type)?$captcha_type:'human';
$ap_settings['google_captcha_label'] = $google_captcha_label;
$ap_settings['google_catpcha_public_key'] = $google_captcha_public_key;
$ap_settings['google_catpcha_private_key'] = $google_captcha_private_key;
$ap_settings['google_captcha_error_message'] = $google_captcha_error_message;
$ap_settings['math_captcha_error_message'] = $math_captcha_error_message;
$ap_settings['math_captcha_label'] = $math_captcha_label;

/**
 * Add & Update Form
 * */
 global $wpdb;
$table_name = $wpdb->prefix . 'ap_pro_forms';
if(isset($_POST['ap_form_id']))
{
    $wpdb->update( 
	$table_name, 
	array( 
		'form_details' => serialize($ap_settings)
	),
    array('ap_form_id'=>$_POST['ap_form_id']), 
	array( 
		
        '%s' 
	),
     array('%d')
);
    $_SESSION['ap_message'] = __('Form Updated Successfully.','anonymous-post-pro');
    wp_redirect(admin_url().'admin.php?page=anonymous-post-pro&action=edit_form&form_id='.$_POST['ap_form_id']);
}
else
{
  $wpdb->insert( 
	$table_name, 
array( 
		'form_details' => serialize($ap_settings)
        
	),
	array( 
		
        '%s' 
	)
);
$_SESSION['ap_message'] = __('Form Added Successfully.','anonymous-post-pro');
wp_redirect(admin_url().'admin.php?page=anonymous-post-pro');    
}

//$this->print_array($ap_settings);
//$update_option_check = update_option('ap_pro_settings',$ap_settings);
//die();
 

exit;
//$this->print_array($ap_settings);


