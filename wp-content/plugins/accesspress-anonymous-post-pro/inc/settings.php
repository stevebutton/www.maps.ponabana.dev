<?php 
  /**
   * Get Settings from DB
   * */
  global $ap_settings;
  global $wpdb;
  
  if(isset($_GET['form_id']))
  {
    $form_id = $_GET['form_id'];
    $table_name = $table_name = $wpdb->prefix . "ap_pro_forms";
    $forms = $wpdb->get_results("SELECT * FROM $table_name where ap_form_id = $form_id");
    $form = $forms[0];
   $ap_settings = unserialize($form->form_details);
   if(!isset($ap_settings['form_fields']['post_tag_dropdown']))
   {
    $ap_settings['form_fields']['post_tag_dropdown']= array('required_message' => '',
                                                                        'label' => '',
                                                                        'notes_type' => 0,
                                                                        'notes' => '',
                                                                        'field_type' => 'field',
                                                                        'show_form' => 0,
                                                                        'required' => 0
                                                                    );
   }  
  }
  else
  {
    $ap_settings = $this->get_default_settings();
  }
  
  //$this->print_array($ap_settings);

  ?>
  
  <div class="ap-settings-wrapper wrap">

    <div class="ap-settings-header">
      <div class="ap-logo">
        <img src="<?php echo AP_PRO_IMAGE_DIR;?>/logo.png" alt="<?php esc_attr_e('AccessPress Anonymous Post Pro','anonymous-post-pro'); ?>" />
      </div>

      <div class="ap-socials">
        <p><?php _e('Follow us for new updates','anonymous-post-pro') ?></p>
        <div class="social-bttns">

          <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FAccessPress-Themes%2F1396595907277967&amp;width&amp;layout=button&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35&amp;appId=1411139805828592" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px; width:50px " allowTransparency="true"></iframe>
          &nbsp;&nbsp;
          <a href="https://twitter.com/apthemes" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @apthemes</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          
        </div>
      </div>

      <div class="ap-title"><?php 
      if(isset($_GET['form_id']))
      {
        _e('Edit Anonymous Form','anonymous-post-pro');
      }
      else
      {
        _e('Add New Anonymous Form','anonymous-post-pro');  
      }
      ?></div>
    </div>


    <?php if(isset($_SESSION['ap_message'])){?>
    <div id="messages" class="update">
     <?php echo $_SESSION['ap_message'];unset($_SESSION['ap_message']);?>
   </div>
   <?php }?>
   
   <ul class="ap-settings-tabs">
    <li><a href="javascript:void(0)" id="general-settings" class="ap-tabs-trigger ap-active-tab"><?php _e('General Settings','anonymous-post-pro')?></a></li>
    <li><a href="javascript:void(0)" id="form-settings" class="ap-tabs-trigger"><?php _e('Form Settings','anonymous-post-pro');?></a></li>
    <li><a href="javascript:void(0)" id="captcha-settings" class="ap-tabs-trigger"><?php _e('Captcha Settings','anonymous-post-pro');?></a></li>
    <li><a href="javascript:void(0)" id="formstyle-settings" class="ap-tabs-trigger"><?php _e('Form Style Settings','anonymous-post-pro');?></a></li>
    <li><a href="javascript:void(0)" id="how_to_use-settings" class="ap-tabs-trigger"><?php _e('How to use','anonymous-post-pro');?></a></li>
    <li><a href="javascript:void(0)" id="about-settings" class="ap-tabs-trigger">About</a></li>
  </ul>

  <div class="metabox-holder">
    <div id="optionsframework" class="postbox">
      <form class="ap-settings-form" method="post" action="<?php echo admin_url().'admin-post.php'?>">
        <input type="hidden" name="action" value="ap_settings_action"/>
        <input type="hidden" name="taxonomy_reference" value="<?php echo $ap_settings['taxonomy_reference']?>"/>
        <?php 
      /**
       * General Settings 
       * */
      include_once('boards/general-settings.php');
      ?>
      
      <?php 
      /**
       * Form Settings
       * */
      include_once('boards/form-settings.php');
      ?>

      <?php 
       /**
        * Captcha Settings
        * */
       include_once('boards/captcha-settings.php');
       ?>
       <?php 
       /**
        * Form Styles Settings
        * */
       include_once('boards/form-styles.php');
       ?>
       <?php 
       /**
        * Form Styles Settings
        * */
       include_once('boards/how-to-use.php');
       ?>
       <?php 
       /**
        * About Tab
        * */
       include_once('boards/about.php');
       ?>
       <div id="optionsframework-submit" class="ap-settings-submit">
         <input type="submit" value="Save all changes" name="ap_settings_submit"/>
         <?php 
         $nonce = wp_create_nonce( 'aps-restore-default-nonce' );
         ?>
         
       </div>
       <?php if(isset($_GET['form_id'])){?>
       <input type="hidden" value="<?php echo $_GET['form_id'];?>" name="ap_form_id"/>
       <?php }?>
     </form>
     <div class="ap-extensions-clone" style="display: none;">
      <label>Choose File Extensions</label>
      <div class="ap-pro-fileuploader">
        <label>Images:</label>
        <ul>
          <li><input type="checkbox" name="" value="jpg"/><span>jpg</span></li>
          <li><input type="checkbox" name="" value="jpeg"/><span>jpeg</span></li>
          <li><input type="checkbox" name="" value="png"/><span>png</span></li>
          <li><input type="checkbox" name="" value="gif"/><span>gif</span></li>
        </ul>
      </div>
      <div class="ap-pro-fileuploader">
        <label>Documents:</label>
        <ul>
          <li><input type="checkbox" name="" value="pdf"/><span>pdf</span></li>
          <li><input type="checkbox" name="" value="doc|docx"/><span>doc/docx</span></li>
          <li><input type="checkbox" name="" value="xls|xlsx"/><span>xls/xlsx</span></li>
          <li><input type="checkbox" name="" value="odt"/><span>odt</span></li>
          <li><input type="checkbox" name="" value="ppt|pptx|pps|ppsx"/><span>ppt,pptx,pps,ppsx</span></li>
        </ul>
      </div>
      <div class="ap-pro-fileuploader">
        <label>Audio:</label>
        <ul>
          <li><input type="checkbox" name="" value="mp3"/><span>mp3</span></li>
          <li><input type="checkbox" name="" value="mp4"/><span>mp4</span></li>
          <li><input type="checkbox" name="" value="ogg"/><span>ogg</span></li>
          <li><input type="checkbox" name="" value="wav"/><span>wav</span></li>
        </ul>
      </div>
      <div class="ap-pro-fileuploader">
        <label>Video:</label>
        <ul>
          <li><input type="checkbox" name="" value="mp4"/><span>mp4</span></li>
          <li><input type="checkbox" name="" value="m4v"/><span>m4v</span></li>
          <li><input type="checkbox" name="" value="mov"/><span>mov</span></li>
          <li><input type="checkbox" name="" value="wmv"/><span>wmv</span></li>
          <li><input type="checkbox" name="" value="avi"/><span>avi</span></li>
          <li><input type="checkbox" name="" value="mpg"/><span>mpg</span></li>
          <li><input type="checkbox" name="" value="ogv"/><span>ogv</span></li>
          <li><input type="checkbox" name="" value="3gp"/><span>3gp</span></li>
          <li><input type="checkbox" name="" value="3g2"/><span>3g2</span></li>
        </ul>
      </div>
      <div class="ap-pro-file-upload-size">
        <label>Max Upload File Size</label>
        <input type="text" name="" class="ap-pro-file-upload-size"/>    
        <div class="ap-option-note ap-option-width"><?php _e('Please enter the max upload size in MB.Default max upload file size is 8MB','anonymous-post-pro');?></div>
      </div>
      <div class="ap-pro-file-upload-size">
        <label>Multiple File Upload</label>
        <input type="checkbox" name="" class="ap-pro-multiple-file-upload" value="1"/>    
        <div class="ap-option-note"><?php _e('Check if you want to allow the vistors to upload multiple files','anonymous-post-pro');?></div>
      </div>
      
    </div> 
  </div>  
  <div class="ap-pro-custom-field-adder" style="display: none;">
    <h3><?php _e('Custom Fields','anonymous-post-pro');?></h3>
    <div class="ap-tab-wrapper">
      <div class="ap-pro-custom-field-label">
        <label><?php _e('Label','anonymous-post-pro');?></label>
        <input type="text" id="ap-custom-field-label"/>
        <div class="ap-custom-error"></div>
      </div>
      <div class="ap-pro-custom-field-label">
        <label><?php _e('Meta Key','anonymous-post-pro');?></label>
        <input type="text" id="ap-custom-field-key"/>
        <div class="ap-custom-error"></div>
      </div>
      <div class="ap-pro-custom-field-label">
        <input type="button" class="button primary-button" id="ap-custom-field-submit" value="Add Field"/>
      </div>
    </div>
  </div>
</div>



</div>