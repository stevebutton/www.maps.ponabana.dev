<div class="ap-tabs-board" id="board-captcha-settings" style="display: none;">
  <h2><?php _e('Captcha Settings','anonymous-post-pro');?></h2>
  <div class="ap-tab-wrapper">
  <div class="ap-option-wrapper">
    <label>Enable Captcha</label>
    <div class="ap-optoin-field">
      <div class="ap-checkbox-form"><input type="checkbox" name="captcha_settings" value="1" <?php if($ap_settings['captcha_settings']==1){?>checked="checked"<?php }?>/></div>
      <div class="ap-option-note"><?php _e('Check if you want to enable captcha in the form','anonymous-post-pro');?></div>
     </div>
  </div>
    <div class="ap-option-wrapper">
      <div class="ap-option-field">
       <div class="ap-captcha-list-field"><div class="ap-checkbox-form"> <input type="radio" name="captcha_type" value="human" <?php if($ap_settings['captcha_type']=='human'){?>checked="checked"<?php }?> class="ap-captcha-selector"/></div><span><?php _e('Mathmatical Captcha','anonymous-post-pro')?></span></div>
       <div class="ap-captcha-list-field"><div class="ap-checkbox-form"> <input type="radio" name="captcha_type" value="google" <?php if($ap_settings['captcha_type']=='google'){?>checked="checked"<?php }?>  class="ap-captcha-selector"/></div><span><?php _e('Google reCaptcha','anonymous-post-pro')?></span></div>
     </div>
   </div>
   <div class="captcha-fields ap-google-captcha-fields" <?php if($ap_settings['captcha_type']=='human'){?>style="display:none"<?php }?>>
    <div class="ap-option-wrapper">
      <label><?php _e('Google reCaptcha Label','anonymous-post-pro');?></label>
      <div class="ap-option-field">
        <input type="text" name="google_captcha_label" value="<?php echo $ap_settings['google_captcha_label'];?>"/>
      </div>
    </div>
    <div class="ap-option-wrapper">
      <label><?php _e('Google reCaptcha Public Key','anonymous-post-pro');?></label>
      <div class="ap-option-field">
        <input type="text" name="google_captcha_public_key" value="<?php echo $ap_settings['google_catpcha_public_key'];?>"/>
      </div>
    </div>
    <div class="ap-option-wrapper">
      <label><?php _e('Google reCaptcha Private Key','anonymous-post-pro')?></label>
      <div class="ap-option-field">
        <input type="text" name="google_captcha_private_key" value="<?php echo $ap_settings['google_catpcha_private_key'];?>"/>
      </div>
    </div>
    <div class="ap-option-wrapper">
      <label><?php _e('Google reCaptcha Error Message','anonymous-post-pro');?></label>
      <div class="ap-option-field">
        <input type="text" name="google_captcha_error_message" value="<?php echo $ap_settings['google_captcha_error_message'];?>"/>
      </div>
    </div>
    <div class="ap-option-note ap-option-width"><?php _e('Captcha will only show up in form if you have enabled the google captcha and filled the valid google captcha private and public key. ','anonymous-post-pro');?></div>
  </div>
  <div class="captcha-fields ap-human-captcha-fields" <?php if($ap_settings['captcha_type']=='google'){?>style="display:none"<?php }?>>
    <div class="ap-option-wrapper">
      <label><?php _e('Mathmatical Captcha Label','anonymous-post-pro')?></label>
      <div class="ap-option-field">
        <input type="text" name="math_captcha_label" value="<?php echo $ap_settings['math_captcha_label'];?>"/>
      </div>
    </div>
    <div class="ap-option-wrapper">
      <label><?php _e('Mathmatical Captcha Error Message','anonymous-post-pro')?></label>
      <div class="ap-option-field">
        <input type="text" name="math_captcha_error_message" value="<?php echo $ap_settings['math_captcha_error_message'];?>"/>
      </div>
    </div>
  </div>
</div>
</div>