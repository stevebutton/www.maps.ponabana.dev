<div class="ap-tabs-board" id="board-general-settings">
  <h2><?php _e('General Settings','anonymous-post-pro');?></h2>
  <div class="ap-tab-wrapper">
    <div class="ap-option-wrapper">
      <label><?php _e('Form Title','anonymous-post-pro');?></label>
      <div class="ap-option-field">
        <input type="text" name="form_title" value="<?php echo $ap_settings['form_title'];?>"/>
      </div>
    </div>
    <div class="ap-option-wrapper">
      <label><?php _e('Post Publish Status:','anonymous-post-pro');?></label>
      <div class="ap-option-field">
        <select name="publish_status">
          <option value="publish" <?php if($ap_settings['publish_status']=='publish'){?>selected="selected"<?php }?>>Publish</option>
          <option value="pending" <?php if($ap_settings['publish_status']=='pending'){?>selected="selected"<?php }?>>Pending</option>
          <option value="draft" <?php if($ap_settings['publish_status']=='draft'){?>selected="selected"<?php }?>>Draft</option>
        </select>
      </div>
    </div>
    <div class="ap-option-wrapper">
      <label>Submit post as:</label>
      <div class="ap-option-field">
       <?php $post_types = $this->get_registered_post_types();?> 
       <select name="post_type">
        <?php 
        foreach($post_types as $post_type)
        {
          ?>
          <option value="<?php echo $post_type;?>" <?php if($ap_settings['post_type']==$post_type){?>selected="selected"<?php }?>><?php echo ucfirst($post_type);?></option>            
          <?php
        }
        ?>
      </select>
    </div>
  </div>
  <div class="ap-option-wrapper">
    <label class="ap-check-login"><?php _e('Admin Notification:','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <div class="ap-option-checkbox-field"><div class="ap-checkbox-form"><input type="checkbox" name="admin_notification" value="1" <?php if($ap_settings['admin_notification']=='1'){?>checked="checked"<?php }?>/></div>
      <div class="ap-option-note"><?php _e('Check if you want admin to recieve notification email after submitting of a new post.','anonymous-post-pro');?></div>
    </div>
    <div class="ap-admin-email-list">
      <?php if(!empty($ap_settings['admin_email_list'])){
        foreach($ap_settings['admin_email_list'] as $email)
        {
          ?>
          <div class="ap-each-admin-email"><input type="text" name="admin_email_list[]" value="<?php echo $email?>" placeholder="Enter email address"/><span class="ap-remove-email-btn">X</span></div>
          <?php    
            }//foreach ends
          }//if ends?>
        </div>
        <div class="ap-admin-email-add-btn" <?php if(count($ap_settings['admin_email_list'])>=3){?>style="display:none;"<?php }?>>
        <input type="button" value="Add Email Address" class="button primary-button" id="ap-admin-email-add-trigger"/></div>
        <input type="hidden" id="ap-admin-email-counter" value="<?php echo count($ap_settings['admin_email_list']);?>"/>
        <div class="ap-option-note ap-option-width"><?php _e('Add upto 3 extra email address for the admin notification.Only Site Admin will recieve notification if you don\'t add any.','anonymous-post-pro');?></div>
      </div>
    </div>
    <div class="ap-option-wrapper">
      <label>Admin Notification Message</label>
      <div class="ap-option-field">
        <textarea rows="10" cols="41" name="admin_notification_message"><?php if($ap_settings['admin_notification_message']==''){
          _e('Hello There,
          
A new post has been submitted via AccessPress Anonymous post plugin in your '.get_bloginfo('name').' website. Please find details below:
            
Post Title: #post_title

_____

To take action (approve/reject) - please go here:
#post_admin_link
            
Thank you'
            ,'anonymous-post-pro'); 
        }else
        {
         echo $this->output_converting_br($ap_settings['admin_notification_message']); 
       }?></textarea>
       <div class="ap-option-note ap-option-width"><?php _e('You can use #post_title,#post_admin_link,#post_author_name,#post_author_email,#post_author_url codes in the above message to get the respective values in the email.','anonymous-post-pro');?></div>
     </div>
     
   </div>
   <div class="ap-option-wrapper">
     <label><?php _e('User Notification','anonymous-post');?></label>
     <div class="ap-option-field">
      <div class="ap-option-checkbox-field">
        <div class="ap-checkbox-form"><input type="checkbox" name="user_notification" value="1" <?php if(isset($ap_settings['user_notification']) && $ap_settings['user_notification']==1){?>checked="checked"<?php }?>/></div>
        <div class="ap-option-note"><?php _e('Check if you want to notify guest author via email after the post is published .','anonymous-post-pro');?></div>
      </div>
     </div>
   </div>
   <div class="ap-option-wrapper">
    <label><?php _e('User Notification Message','anonymous-post-pro');?></label>
    <div class="ap-option-field">
    <?php 
      $user_notification_message = $this->output_converting_br($ap_settings['user_notification_message']);
      
    ?>
      <textarea name="user_notification_message" rows="10" cols="41"><?php if($user_notification_message==''){
          _e('Hello There,
          
Your post has been published in '.get_bloginfo('name').' website. Please find details below:
            
Post Title: #post_title

_____

 To view your post in the site - please go here:
#post_link
            
Thank you'
            ,'anonymous-post-pro'); 
        }else
        {
         echo $user_notification_message; 
       }?></textarea>
      <div class="ap-option-note"><?php _e('Message sent to guest author after post published by admin.','anonymous-post-pro');?></div><br /><br />
      <div class="ap-option-note ap-option-width"><?php _e('<b>Note:</b>You can use #post_title,#post_link for sending respective values in the email.The email will only be sent to guest author if author email is also recieved from post submission form.','anonymous-post-pro');?></div>
    </div>
  </div>
   <div class="ap-option-wrapper">
    <label class="ap-check-login"><?php _e('Check Login','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <div class="ap-option-checkbox-field">
        <div class="ap-checkbox-form"><input type="checkbox" name="login_check" value="1" <?php if($ap_settings['login_check']==1){?>checked="checked"<?php }?>/></div>
        <div class="ap-option-note"><?php _e('Check if you want admin login to submit a new post.','anonymous-post-pro');?></div>
      </div>
    </div>
  </div>
  <div class="ap-option-wrapper">
    <label><?php _e('Login Type','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <div class="ap-option-checkbox-field">
        <div class="ap-checkbox-form">
          <div class="ap-row-half"><input type="radio" name="login_type" value="login_message" <?php if($ap_settings['login_type']=='login_message'){?>checked="checked"<?php }?> class="ap-login-type"/><span>Show Login Message</span></div>
          <div class="ap-row-half"><input type="radio" name="login_type" value="login_form" <?php if($ap_settings['login_type']=='login_form'){?>checked="checked"<?php }?> class="ap-login-type"/><span>Show Login Form</span></div>
        </div>
        <div class="ap-option-note ap-option-width"><?php _e('Choose any one if you have enabled login check to submit the post','anonymous-post-pro');?></div>
      </div>
    </div>
  </div>
  <div class="ap-login-type-wrapper" <?php if($ap_settings['login_type']!='login_message'){?>style="display:none"<?php }?>>
      <div class="ap-option-wrapper">
        <label><?php _e('Login Message','anonymous-post-pro');?></label>
        <div class="ap-option-field">
          <textarea name="login_message" rows="10" cols="41"><?php if(isset($ap_settings['login_message'])){ echo $this->output_converting_br($ap_settings['login_message']);}?></textarea>
        </div>
      </div>
      <div class="ap-option-wrapper">
        <label><?php _e('Login Link Text','anonymous-post-pro');?></label>
        <div class="ap-option-field">
          <input type="text" name="login_link_text" value="<?php echo $ap_settings['login_link_text'];?>"/>
        </div> 
      </div>
  </div>
  <div class="ap-option-wrapper">
    <label class="ap-check-login"><?php _e('Anonymous Image Upload','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <div class="ap-option-checkbox-field">
        <div class="ap-checkbox-form"><input type="checkbox" name="anonymous_image_upload" value="1" <?php if(isset($ap_settings['anonymous_image_upload']) && $ap_settings['anonymous_image_upload']==1){?>checked="checked"<?php }?>/></div>
        <div class="ap-option-note"><?php _e('Check if you want to allow the guest visitors to upload images in the text editor','anonymous-post-pro');?></div>
      </div>
    </div>
  </div>
  <div class="ap-option-wrapper">
    <label><?php _e('Assign Author','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <select name="post_author">
        <?php 
        $users = get_users();
        foreach($users as $user)
        {
          ?>
          <option value="<?php echo $user->ID;?>" <?php if($ap_settings['post_author']==$user->ID){?>selected="selected"<?php }?>><?php echo $user->data->user_nicename;?></option>
          <?php 
        }
        
        ?>
      </select>
    </div>
  </div>
  <div class="ap-option-wrapper">
    <label><?php _e('Redirect URL','anonymous-post-pro')?></label>
    <div class="ap-option-field">
      <input type="text" name="redirect_url" value="<?php echo $ap_settings['redirect_url'];?>"/>
      <div class="ap-option-note ap-option-width"><?php _e('URL to be redirected after successful post submission.If kept blank, it will be redirected to same page','anonymous-post-pro');?></div>
    </div>

  </div>
  <div class="ap-option-wrapper">
    <label><?php _e('Post Submission Message','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <textarea name="post_submission_message" rows="10" cols="41"><?php echo $this->output_converting_br($ap_settings['post_submission_message']);?></textarea>
      <div class="ap-option-note  ap-option-width"><?php _e('Message displayed after successful post submission.','anonymous-post-pro');?></div>
    </div>
  </div>
</div>
</div>