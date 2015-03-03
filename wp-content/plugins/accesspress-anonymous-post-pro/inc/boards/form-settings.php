<div class="ap-tabs-board" id="board-form-settings" style="display: none;">

  <div class="ap-form-config">
    <h2><?php _e('Form field configurations','anonymous-post');?></h2>
    <div class="ap-tab-wrapper">
      <div class="ap-option-wrapper">
        <div class="ap-form-configuration-wrapper">
         <ul class="ap-pro-fields">
           <?php 
           $post_label_array = array('post_title'=>__('Post Title','anonymous-post-pro'),
             'post_content'=>__('Post Content','anonymous-post-pro'),
             'post_excerpt'=>__('Post Excerpt','anonymous-post-pro'),
             'post_image'=>__('Post Image','anonymous-post-pro'),
             'author_name'=>__('Author Name','anonymous-post-pro'),
             'author_url'=>__('Author URL','anonymous-post-pro'),
             'author_email'=>__('Author Email','anonymous-post-pro'),
             'post_tag_dropdown'=>__('Post Tags Dropdown','anonymous-post-pro')
             );
         //$this->print_array($ap_settings['form_fields']);
           foreach($ap_settings['form_fields'] as $field_title=>$field_array)
           {
            $field_title = esc_attr($field_title);
            if(isset($field_array['file_extension']))
            {
              $file_extensions = $field_array['file_extension'];
            }
            $field_array = array_map('esc_attr',$field_array);
            if(isset($file_extensions))
            {
             $field_array['file_extension'] = $file_extensions;    
           }
           
            //$this->print_array($field_array);
            //echo $field_title;
           switch($field_array['field_type']){
            case 'taxonomy':
            ?>
            <li class="ap-pro-form-taxonomies ap-pro-li-sortable">
              <div class="dragicon"></div>
              <div class="ap-pro-labels-head">
               <?php echo $field_array['taxonomy_label'];?>
               <span class="ap-arrow-down ap-arrow">Down</span>
             </div>
             
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title;?>][show_form]" value="1" <?php if($field_array['show_form']==1){?>checked="checked"<?php }?>/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title?>][required]" value="1" <?php if($field_array['required']==1){?>checked="checked"<?php }?>/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title?>][required_message]" value="<?php echo $field_array['required_message']?>"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title?>][label]" value="<?php echo $field_array['label'];?>"/></div>
                 </li>
                 <li>
                   <li>
                     <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                     <div class="ap-pro-select">
                       <select name="form_fields[<?php echo $field_title?>][notes_type]">
                         <option value="0" <?php if($field_array['notes_type']=="0"){?>selected="selected"<?php }?>><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                         <option value="icon" <?php if($field_array['notes_type']=="icon"){?>selected="selected"<?php }?>><?php _e('Show as info icon','anonymous-post-pro');?></option>
                         <option value="tooltip" <?php if($field_array['notes_type']=="tooltip"){?>selected="selected"<?php }?>><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                       </select>
                     </div>
                   </li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title;?>][notes]" value="<?php echo $field_array['notes'];?>"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields ','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_included_taxonomy[]" value="<?php echo $field_title;?>"/>
               <input type="hidden" name="form_fields[<?php echo $field_title;?>][hierarchical]" value="<?php echo $field_array['hierarchical'];?>"/>
               <input type="hidden" name="form_field_order[]" value="<?php echo $field_title;?>|taxononmy"/>
               <input type="hidden" name="form_fields[<?php echo $field_title;?>][field_type]" value="taxonomy"/>
               <input type="hidden" name="form_fields[<?php echo $field_title;?>][taxonomy_label]" value="<?php echo $field_array['taxonomy_label']?>"/>
             </div>
           </li>
           <?php 
           break;
           case 'field':
           ?>
           <li class="ap-pro-li-sortable">
            <div class="dragicon"></div>
            <div class="ap-pro-labels-head">
              <?php echo $post_label_array[$field_title];?>
              <span class="ap-arrow-down ap-arrow">Down</span>    
            </div>
            
            <div class="ap-pro-labels-content" style="display: none;">
             <ul class="ap-pro-inner-configs">
               <li>
                 <label><?php _e('Show on form','anonymous-post-pro');?></label>
                 <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title?>][show_form]" value="1"  <?php if($field_title=='post_title' || $field_array['show_form']==1 || $field_title=='post_content'){?>checked="checked"<?php }?> <?php if($field_title=='post_content' || $field_title=='post_title'){?>onclick="return false;"<?php }?>/></div>
               </li>
               <li>
                 <label><?php _e('Required','anonymous-post-pro');?></label>
                 <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title?>][required]" value="1"  <?php if($field_title=='post_title' || $field_array['required']==1){?>checked="checked"<?php }?> <?php if($field_title=='post_content' || $field_title=='post_title'){?>onclick="return false;"<?php }?>/></div>
               </li>
               <li>
                 <label><?php _e('Custom required message');?></label>
                 <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title?>][required_message]" value="<?php echo $field_array['required_message'];?>"/></div>
               </li>
               <li>
                 <label><?php _e('Label','anonymous-post-pro');?></label>
                 <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title?>][label]" value="<?php echo $field_array['label'];?>"/></div>
               </li>
               <li>
                 <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                 <div class="ap-pro-select">
                   <select name="form_fields[<?php echo $field_title?>][notes_type]">
                     <option value="0" <?php if($field_array['notes_type']=='0'){?>selected="selected"<?php }?>><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                     <option value="icon" <?php if($field_array['notes_type']=='icon'){?>selected="selected"<?php }?>><?php _e('Show as info icon','anonymous-post-pro');?></option>
                     <option value="tooltip" <?php if($field_array['notes_type']=='tooltip'){?>selected="selected"<?php }?>><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                   </select>
                 </div>
               </li>
               <li>
                 <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                 <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title?>][notes]" value="<?php echo $field_array['notes'];?>"/></div>
                 <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields','anonymous-post-pro');?></div>
               </li>
               <?php if($field_title=='post_content'){?>
               <li>
                 <label><?php _e('Editor Type','anonymous-post-pro');?></label>
                 <div class="ap-pro-select">
                   <select name="form_fields[<?php echo $field_title?>][editor_type]">
                     <option value="simple" <?php if($field_array['editor_type']=='simple'){?>selected='selected'<?php }?>>Simple Textarea</option>
                     <option value="rich" <?php if($field_array['editor_type']=='rich'){?>selected='selected'<?php }?>>Rich Text Editor</option>
                     <option value="visual" <?php if($field_array['editor_type']=='visual'){?>selected='selected'<?php }?>>Visual Editor</option>
                     <option value="html" <?php if($field_array['editor_type']=='html'){?>selected='selected'<?php }?>>HTML Editor</option>
                   </select>
                 </div>
               </li>
               <?php }?>
             </ul>
             <input type="hidden" name="form_field_order[]" value="<?php echo $field_title?>|field"/>
             <input type="hidden" name="form_fields[<?php echo $field_title?>][field_type]" value="field"/>
           </div>
         </li>
         <?php 
         break;
         
           /**
            * Custom Fields
            * */
           case 'custom':
           ?>
           <li class="ap-pro-li-sortable">
            <div class="dragicon"></div>
            <div class="ap-pro-labels-head"><?php echo $field_array['custom_label'];?>
              <span class="ap-arrow-down ap-arrow">Down</span>
              <span class="ap-custom-li-delete">Delete</span>
            </div>
            
            <div class="ap-pro-labels-content" style="display: none;">
              <ul class="ap-pro-inner-configs">
                <li>
                  <label><?php _e('Show on form','anonymous-post-pro');?></label>
                  <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title;?>][show_form]" value="1" checked="checked"/></div>
                </li>
                <li>
                  <label><?php _e('Required','anonymous-post-pro');?></label>
                  <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[<?php echo $field_title;?>][required]" value="1" <?php if( $field_array['required']==1){?>checked="checked"<?php }?>/></div>
                </li>
                <li>
                  <label><?php _e('Required Message','anonymous-post-pro');?></label>
                  <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title;?>][required_message]" value="<?php echo $field_array['required_message'];?>"/></div>
                </li>
                <li>
                  <label><?php _e('Label','anonymous-post-pro');?></label>
                  <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title;?>][label]" value="<?php echo $field_array['label'];?>"/></div>
                </li>
                <li>
                  <label><?php _e('Field Type','anonymous-post-pro');?></label>
                  <div class="ap-pro-select">
                   <select name="form_fields[<?php echo $field_title;?>][textbox_type]" data-key="<?php echo $field_title;?>" class="ap-pro-custom-field-type">
                    <option value="textfield" <?php if($field_array['textbox_type']=='textfield'){?>selected="selected"<?php }?>>Text Field</option>
                    <option value="textarea" <?php if($field_array['textbox_type']=='textarea'){?>selected="selected"<?php }?>>Text Area</option>
                    <option value="datepicker" <?php if($field_array['textbox_type']=='datepicker'){?>selected="selected"<?php }?>>Date Picker</option>
                    <option value="file_uploader" <?php if($field_array['textbox_type']=='file_uploader'){?>selected="selected"<?php }?>>File Uploader</option>
                  </select>
                </div>
                <div class="ap-pro-file-extensions" <?php if($field_array['textbox_type']!='file_uploader'){?>style="display: none;"<?php }?>>
                  <?php if($field_array['textbox_type']=='file_uploader'){?>
                  <label>Choose File Extensions</label>
                  <div class="ap-pro-fileuploader">
                    <label>Images:</label>
                    <ul>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="jpg" <?php  if(in_array('jpg',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>jpg</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="jpeg" <?php if(in_array('jpeg',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>jpeg</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="png" <?php if(in_array('png',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>png</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="gif" <?php if(in_array('gif',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>gif</span></li>
                    </ul>
                  </div>
                  <div class="ap-pro-fileuploader">
                    <label>Documents:</label>
                    <ul>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="pdf" <?php if(in_array('pdf',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>pdf</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="doc|docx" <?php if(in_array('doc|docx',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>doc/docx</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="xls|xlsx" <?php if(in_array('xls|xlsx',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>xls/xlsx</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="odt" <?php if(in_array('odt',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>odt</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="ppt|pptx|pps|ppsx" <?php if(in_array('ppt|pptx|pps|ppsx',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>ppt,pptx,pps,ppsx</span></li>
                    </ul>
                  </div>
                  <div class="ap-pro-fileuploader">
                    <label>Audio:</label>
                    <ul>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="mp3" <?php if(in_array('mp3',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>mp3</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="mp4" <?php if(in_array('mp4',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>mp4</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="ogg" <?php if(in_array('ogg',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>ogg</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="wav" <?php if(in_array('wav',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>wav</span></li>
                    </ul>
                  </div>
                  <div class="ap-pro-fileuploader">
                    <label>Video:</label>
                    <ul>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="mp4" <?php if(in_array('mp4',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>mp4</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="m4v" <?php if(in_array('m4v',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>m4v</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="mov" <?php if(in_array('mov',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>mov</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="wmv" <?php if(in_array('wmv',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>wmv</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="avi" <?php if(in_array('avi',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>avi</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="mpg" <?php if(in_array('mpg',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>mpg</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="ogv" <?php if(in_array('ogv',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>ogv</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="3gp" <?php if(in_array('3gp',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>3gp</span></li>
                      <li><input type="checkbox" name="form_fields[<?php echo $field_title?>][file_extension][]" value="3g2" <?php if(in_array('3g2',$field_array['file_extension'])){?>checked="checked"<?php }?>/><span>3g2</span></li>
                    </ul>
                  </div>

                  <div class="ap-pro-file-upload-size">
                    <label>Max Upload File Size</label>
                    <input type="text" name="form_fields[<?php echo $field_title?>][upload_size]" class="ap-pro-file-upload-size" value="<?php echo $field_array['upload_size']?>"/>
                    <div class="ap-option-note ap-option-width"><?php _e('Please enter the max upload size in MB.Default file size is 8MB','anonymous-post-pro');?></div>
                  </div>
                  <div class="ap-pro-file-upload-size">
                    <label>Multiple Image Upload</label>
                    <input type="checkbox" name="form_fields[<?php echo $field_title?>][multiple_upload]" class="ap-pro-multiple-file-upload" value="1" <?php if(isset($field_array['multiple_upload']) && $field_array['multiple_upload']==1){?>checked="checked"<?php }?>/>    
                    <div class="ap-option-note"><?php _e('Check if you want to allow the vistiors to upload multiple files','anonymous-post-pro');?></div>
                  </div>
                  
                  <?php }?>
                </div>
              </li>
              <li>
               <li>
                <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                <div class="ap-pro-select">
                 <select name="form_fields[<?php echo $field_title?>][notes_type]">
                   <option value="0" <?php if($field_array['notes_type']=='0'){?>selected="selected"<?php }?>><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                   <option value="icon" <?php if($field_array['notes_type']=='icon'){?>selected="selected"<?php }?>><?php _e('Show as info icon','anonymous-post-pro');?></option>
                   <option value="tooltip" <?php if($field_array['notes_type']=='tooltip'){?>selected="selected"<?php }?>><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                 </select>
               </div>
             </li> 
             <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
             <div class="ap-pro-textbox"><input type="text" name="form_fields[<?php echo $field_title;?>][notes]" value="<?php echo $field_array['notes']?>"/></div>
             <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields','anonymous-post-pro');?></div>
           </li>
         </ul>
         <input type="hidden" name="form_field_order[]" value="<?php echo $field_title;?>|custom"/>
         <input type="hidden" name="form_fields[<?php echo $field_title;?>][field_type]" value="custom"/>
         <input type="hidden" name="form_fields[<?php echo $field_title;?>][custom_label]" value="<?php echo $field_array['custom_label'];?>"/>
       </div>
     </li>
     <?php 
     break;
     
            }//main switch case ends
           }//foreach ends
           ?>
         <?php /*
         include_once('form-fields-html.php');
          */?>
        </ul>
        <div class="ap-option-note ap-option-width"><?php _e('Post Title and Post Content are mandatory.','anonymous-post');?></div>
        
      </div><!--ap-form-configuration-wrapper-->
    </div><!--ap-option-wrapper-->
  </div>
  

  
</div><!--Form Configurations-->
<div class="line"></div>
<!--Form Labels-->
<div class="ap-form-labels">
  <h3><?php _e('Form Extra Settings','anonymous-post-pro');?></h3>
  <div class="ap-tab-wrapper">
   <div class="ap-option-wrapper">
    <label><?php _e('Post Categories','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <select name="post_category">
        <?php 
        echo $this->get_terms_for_category_drodown($ap_settings['post_type'],$ap_settings['post_category']);
        ?>
      </select>
      <div class="ap-option-note ap-option-width"><?php _e('Choose any  only if you don\'t include to show the category selecting options in the form','anonymous-post-pro');?></div>

    </div>
  </div>
  
</div>
<!--Submit Button-->
<div class="ap-tab-wrapper">
  <div class="ap-option-wrapper">
    <label><?php _e('Submit Button Label','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <input type="text" name="post_submit_label" value="<?php echo $ap_settings['post_submit_label'];?>"/>
    </div>
  </div>
</div>
<!--Submit Button-->
</div><!--ap-form-label-->
<!--Form Labels-->



</div>