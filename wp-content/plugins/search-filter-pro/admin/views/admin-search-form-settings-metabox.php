<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      http://www.designsandcode.com/
 * @copyright 2014 Designs & Code
 */
 
?>

<div id="available-fields" class="widgets-search-filter-draggables ui-search-filter-sortable setup" data-allow-expand="0">
	<?php
		global $post;
	?>
	<p class="description"><?php _e("Settings &amp; Default Conditions for this Search Form.", $this->plugin_slug ); ?></p>
	
	<div class="tabs-container">
		<div class="tab-header sf_settings_tabs">
			<label for="tab-header-settings" class="active"><input data-radio-checked="1" class="meta_type_radio" id="tab-header-settings" name="tab-header" type="radio" value="settings"><?php _e("General", $this->plugin_slug ); ?></label> 
			<label for="tab-header-post-data"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-post-data" name="tab-header" type="radio" value="post_data"><?php _e("Posts", $this->plugin_slug ); ?></label>
			<label for="tab-header-taxonomies"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-taxonomies" name="tab-header" type="radio" value="taxonomies"><?php _e("Tags, Categories &amp; Taxonomies", $this->plugin_slug ); ?></label>
			<!--<label for="tab-header-post-meta"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-post-meta" name="tab-header" type="radio" value="post_meta">Post Meta</label>-->
			<!--<label for="tab-header-post-author"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-post-author" name="tab-header" type="radio" value="author">Author</label>-->
			
		</div>
		<br class="clear" />
		<div class="sf_field_data sf_tab_content_settings" style="display: block;">
			
			<!-- Post Types -->
			<table>
				<!--<tr>
					<td colspan="2">
						<strong><?php _e("Post Types", $this->plugin_slug ); ?></strong>
					</td>
				</tr>-->
				<tr>
					<td>
						<p><strong><?php _e("Search in the following post types:", $this->plugin_slug ); ?></strong></p>
					</td>
					<td>
						<div class="sf_post_types"><p>
						<?php
							$args = array(
							   'public'   => true
							);
							
							
							$post_types = get_post_types( $args, 'objects' ); 
							
							$is_default = false;
							if(isset($values['post_types']))
							{
								if(!is_array($values['post_types']))
								{
									$is_default = true;
									$values['post_types'] = array();
								}
							}
							else
							{
								$is_default = true;
								$values['post_types'] = array();
							}
							
							
							foreach ( $post_types as $post_type )
							{
								if($post_type->name!="attachment")
								{
									if($is_default)
									{
										if(($post_type->name=="post")||($post_type->name=="page"))
										{
											$values['post_types'][$post_type->name] = "1";
										}
										else
										{
											$values['post_types'][$post_type->name] = "";
										}
									}
									else if(!isset($values['post_types'][$post_type->name]))
									{
										$values['post_types'][$post_type->name] = "";
									}
									
									?>
									
									<input class="checkbox" type="checkbox" id="{0}[{1}][post_types][<?php echo $post_type->name; ?>]" value="<?php echo $post_type->name; ?>" name="settings_post_types[<?php echo $post_type->name; ?>]"<?php $this->set_checked($values['post_types'][$post_type->name]); ?>>
									<label for="{0}[{1}][post_types][<?php echo $post_type->name; ?>]"><?php _e($post_type->labels->name, $this->plugin_slug); ?></label>
									
									<?php
								}
							}
						?>
						</p></div>
					</td>
				</tr>
				
				<tr>
					<td>
						<label for="results_per_page"><?php _e("Results per page:", $this->plugin_slug ); ?></label>
					</td>
					<td>
						<input class="" id="results_per_page" name="results_per_page" type="text" size="7" value="<?php echo esc_attr($values['results_per_page']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="auto_submit"><?php _e("Auto submit form?", $this->plugin_slug ); ?><span class="hint--top hint--info" data-hint="<?php _e("Update the results whenever a user changes a value - no need for a submit button", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</td>
					<td>
						<input class="checkbox auto_submit" type="checkbox" id="auto_submit" name="auto_submit"<?php $this->set_checked($values['auto_submit']); ?>> 
						<!-- <input type="hidden" name="auto_submit" id="auto_submit_hidden" class="auto_submit_hidden" value="1"> -->
					</td>
				</tr>
				<tr>
					<td>
						<label for="maintain_state"><?php _e("Maintain Search Form State", $this->plugin_slug ); ?>
							<!--<span class="hint--top hint--info" data-hint="<?php _e("Update the results whenever a user changes a value - no need for a submit button", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>-->
							<br /><small>Prevents the Search Form from resetting when clicking through on to individual search results (modifies permalinks).</small>
						</label>
					</td>
					<td>
						<input class="checkbox maintain_state" type="checkbox" id="maintain_state" name="maintain_state"<?php $this->set_checked($values['maintain_state']); ?>> 
						<!-- <input type="hidden" name="maintain_state" id="auto_submit_hidden" class="auto_submit_hidden" value="1"> -->
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<hr />
						<br /><strong>Ajax</strong>
					</td>
					
				</tr>
				<tr>
					<td>
						<label for="use_ajax_toggle"><?php _e("Load results using Ajax?", $this->plugin_slug ); ?></label>
					</td>
					<td>
						<input class="checkbox use_ajax_toggle" type="checkbox" id="use_ajax_toggle" name="use_ajax_toggle"<?php $this->set_checked($values['use_ajax_toggle']); ?>> 
						<input type="hidden" name="use_ajax_toggle" id="use_ajax_toggle_hidden" class="use_ajax_toggle_hidden" value="1" disabled="disabled">
					</td>
				</tr>
				<!--<tr class="ajax-selectors">
					<td>
						<label for="use_ajax_toggle">
							<?php _e("Scroll to top?", $this->plugin_slug ); ?>
							<span class="hint--top hint--info" data-hint="<?php _e("Automatically scroll to the top of the page when performing a new search or when a user has clicked on a pagination link", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br /><small>
						</label>
					</td>
					<td>
						<input class="checkbox use_ajax_toggle" type="checkbox" id="use_ajax_toggle" name="use_ajax_toggle"<?php $this->set_checked($values['use_ajax_toggle']); ?>> 
						<input type="hidden" name="use_ajax_toggle" id="use_ajax_toggle_hidden" class="use_ajax_toggle_hidden" value="1" disabled="disabled">
					</td>
				</tr>-->
				
				<tr class="ajax-selectors">
					<td>
						<label for="use_results_shortcode">
							<?php _e("Use a Shortcode to display results?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("This is by far the easiest way to set up with Ajax - no need to specify a content selector - it just works!", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br /><small><?php _e("This option will be deprecated and enabled by default in future versions.", $this->plugin_slug); ?></small>
						</label>
					</td>
					<td>
						<input class="checkbox use_results_shortcode" type="checkbox" id="use_results_shortcode" name="use_results_shortcode"<?php $this->set_checked($values['use_results_shortcode']); ?>> 
						<input type="hidden"  name="use_results_shortcode" id="use_results_shortcode_hidden" class="use_results_shortcode_hidden"  value="1" disabled="disabled" />
					</td>
				</tr>
				<tr class="ajax-selectors">
					<td>
						<label for="update_ajax_url">
							<?php _e("Make searches bookmarkable?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("If using results shortcode then &quot;Results URL&quot; must be valid to enable this", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<small><?php _e("Changes the URL in the address bar as the user searches.", $this->plugin_slug); ?></small>
						</label>
					</td>
					<td>
						<input class="checkbox update_ajax_url" type="checkbox" id="update_ajax_url" name="update_ajax_url"<?php $this->set_checked($values['update_ajax_url']); ?>> 
						<input type="hidden"  name="update_ajax_url" id="update_ajax_url_hidden" class="update_ajax_url_hidden"  value="1" disabled="disabled" />
					</td>
				</tr>
				<tr class="ajax-selectors shortcode-selectors" style="display:none">
					<td>
						<label for="results_url">
							<?php _e("Results URL:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("The full URL of a page where your results shortcode can be found", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
							<br /><small><?php _e("This should the URL to a page where your results shortcode can be found", $this->plugin_slug); ?><br />*Redirect only used if the results shortcode cannot be found on the same page</small>
						</label>
					</td>
					<td>
						<input class="results_url" id="results_url" name="results_url" type="text" value="<?php echo esc_attr($values['results_url']); ?>" placeholder="http://www.yoursite.com/">
						<input type="hidden"  name="results_url" id="results_url_hidden" class="results_url_hidden"  value="<?php echo $values['results_url']; ?>" disabled="disabled" />
					</td>
				</tr>
				<tr class="ajax-selectors template-selectors" style="display:none">
					<td>
						<label for="ajax_target">
							<?php _e("Content selector:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("The ID or class of the container which your results are loaded in to", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
					</td>
					<td>
						<input class="ajax_target" id="ajax_target" name="ajax_target" type="text" value="<?php echo esc_attr($values['ajax_target']); ?>">
						<input type="hidden"  name="ajax_target" id="ajax_target_hidden" class="ajax_target_hidden"  value="<?php echo $values['ajax_target']; ?>" disabled="disabled" />
						<!-- <br /><em><?php _e("This should be an ID, ie - <code>#content</code> - or a unique class selector, ie - <code>.content-container</code>.", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
					
				
				<tr class="ajax-selectors template-selectors" style="display:none">
					<td>
						<label for="{0}[{1}][ajax_links_selector]">
							<?php _e("Pagination selector:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("to enable Ajax on your pagination links you must put the CSS selector here", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							
						</label>
					</td>
					<td>
						<input class="ajax_links_selector" id="ajax_links_selector" name="ajax_links_selector" type="text" value="<?php echo esc_attr($values['ajax_links_selector']); ?>">
						<input type="hidden"  name="ajax_links_selector" class="ajax_links_selector_hidden" id="ajax_links_selector_hidden"  value="<?php echo $values['ajax_links_selector']; ?>" disabled="disabled" />
						<!-- <br /><em><?php _e("This must be a selector targeting all pagination links on your page - ie, <code>.nav-links a</code>", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
				<tr class="page-template-options">
					<td colspan="2">
						<hr />
						<br /><strong>Page Template</strong>
					</td>
					
				</tr>
				<tr class="page-template-options">
					<td>
						<label for="use_template_manual_toggle">
							<?php _e("Use a custom template for results?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("if your meta key is not listed or not yet created enter here", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
							
						</label>
					</td>
					<td>
						<input class="checkbox use_template_manual_toggle" type="checkbox" id="use_template_manual_toggle" name="use_template_manual_toggle"<?php $this->set_checked($values['use_template_manual_toggle']); ?>> 
						<input type="hidden"  name="use_template_manual_toggle" class="use_template_manual_toggle_hidden" id="use_template_manual_toggle_hidden"  value="<?php echo $values['use_template_manual_toggle']; ?>" disabled="disabled" />
						<!-- <br /><em><?php _e("This must be a selector targeting all pagination links on your page - ie, <code>.nav-links a</code>", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
				
				<tr class="page-template-options sub-option">
					<td>
						<label for="template_name_manual">
							<?php _e("Enter the filename of the custom template:", $this->plugin_slug); ?>
							<br /><small><?php _e("The template will be loaded from your theme directory.", $this->plugin_slug); ?></small>
						</label>
					</td>
					<td>
						<input class="template_name_manual" id="template_name_manual" name="template_name_manual" type="text" value="<?php echo esc_attr($values['template_name_manual']); ?>" />
						<input type="hidden"  name="template_name_manual" class="template_name_manual_hidden" id="template_name_manual_hidden"  value="<?php echo $values['template_name_manual']; ?>" disabled="disabled" />
						<!-- <br /><em><?php _e("This must be a selector targeting all pagination links on your page - ie, <code>.nav-links a</code>", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
				
				<tr class="page-template-options sub-option">
					<td>
						<label for="page_slug">
							<?php _e("Set a slug?", $this->plugin_slug); ?>
						</label>
					</td>
					<td>
						<?php echo trailingslashit(home_url()); ?> <input class="page_slug" id="page_slug" name="page_slug" type="text" value="<?php echo esc_attr($values['page_slug']); ?>" placeholder="?sfid=<?php echo $post->ID; ?>"  />
						<input type="hidden"  name="page_slug" id="page_slug_hidden" class="page_slug_hidden"  value="<?php echo $values['page_slug']; ?>" disabled="disabled" />
						<!-- <br /><em><?php _e("This must be a selector targeting all pagination links on your page - ie, <code>.nav-links a</code>", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
				
				</table>
		
		</div>
		<div class="sf_field_data sf_tab_content_post_data">
			<table>
			<tr>
				<td>
					<?php _e("Post Status:", $this->plugin_slug ); ?>
				</td>
				<td>
					<div class="sf_post_types">
						<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][publish]" value="publish" name="settings_post_status[publish]"<?php $this->set_checked($values['post_status']['publish']); ?>>
						<label for="{0}[{1}][post_status][publish]"><?php _e('Published', $this->plugin_slug); ?></label>
						
						<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][pending]" value="pending" name="settings_post_status[pending]"<?php $this->set_checked($values['post_status']['pending']); ?>>
						<label for="{0}[{1}][post_status][pending]">
							<?php _e('Pending', $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("post is pending review", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
						
						<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][draft]" value="draft" name="settings_post_status[draft]"<?php $this->set_checked($values['post_status']['draft']); ?>>
						<label for="{0}[{1}][post_status][draft]">
							<?php _e('Draft', $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("a post in draft status", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
						
						<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][future]" value="future" name="settings_post_status[future]"<?php $this->set_checked($values['post_status']['future']); ?>>
						<label for="{0}[{1}][post_status][future]">
							<?php _e('Future', $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("a post to publish in the future", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
						
						<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][private]" value="private" name="settings_post_status[private]"<?php $this->set_checked($values['post_status']['private']); ?>>
						<label for="{0}[{1}][post_status][private]">
							<?php _e('Private', $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("not visible to users who are not logged in", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label for="exclude_post_ids">
					<?php _e("Exclude Post IDs:", $this->plugin_slug ); ?><span class="hint--top hint--info" data-hint="<?php _e("comma seperated list of post IDs to exclude - these can be of any post type", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
					</label>
				</td>
				<td>
					<input class="" id="exclude_post_ids" name="exclude_post_ids" type="text" size="20" value="<?php echo esc_attr($values['exclude_post_ids']); ?>">
				</td>
			</tr>
			<tr>
				<td>
					<label for="default_sort_by">
					<?php _e("Default Sort Order:", $this->plugin_slug ); ?>
					</label>
				</td>
				<td>
					<fieldset class="sitem">
						
						<select name="default_sort_by" class="default_sort_by" id="default_sort_by">
							<option value="0"><?php _e("Choose an option", $this->plugin_slug); ?></option>
							<option value="ID"<?php $this->set_selected($values['default_sort_by'], "ID"); ?>><?php _e("Post ID", $this->plugin_slug); ?></option>
							<option value="author"<?php $this->set_selected($values['default_sort_by'], "author"); ?>><?php _e("Author", $this->plugin_slug); ?></option>
							<option value="title"<?php $this->set_selected($values['default_sort_by'], "title"); ?>><?php _e("Title", $this->plugin_slug); ?></option>
							<option value="name"<?php $this->set_selected($values['default_sort_by'], "name"); ?>><?php _e("Name (Post Slug)", $this->plugin_slug); ?></option>
							<option value="date"<?php $this->set_selected($values['default_sort_by'], "date"); ?>><?php _e("Date", $this->plugin_slug); ?></option>
							<option value="modified"<?php $this->set_selected($values['default_sort_by'], "modified"); ?>><?php _e("Last Modified Date", $this->plugin_slug); ?></option>
							<option value="parent"<?php $this->set_selected($values['default_sort_by'], "parent"); ?>><?php _e("Parent ID", $this->plugin_slug); ?></option>
							<option value="rand"<?php $this->set_selected($values['default_sort_by'], "rand"); ?>><?php _e("Random Order", $this->plugin_slug); ?></option>
							<option value="comment_count"<?php $this->set_selected($values['default_sort_by'], "comment_count"); ?>><?php _e("Comment Count", $this->plugin_slug); ?></option>
							<option value="menu_order"<?php $this->set_selected($values['default_sort_by'], "menu_order"); ?>><?php _e("Menu Order", $this->plugin_slug); ?></option>
							<option value="meta_value"<?php $this->set_selected($values['default_sort_by'], "meta_value"); ?>><?php _e("Meta Value", $this->plugin_slug); ?></option>
						</select>
					
						<select name="default_sort_dir" class="meta_key" id="default_sort_dir">
							<option value="desc"<?php $this->set_selected($values['default_sort_dir'], "desc"); ?>><?php _e("Descending", $this->plugin_slug); ?></option>
							<option value="asc"<?php $this->set_selected($values['default_sort_dir'], "asc"); ?>><?php _e("Ascending", $this->plugin_slug); ?></option>
						</select>
						
					</fieldset>
				</td>
			</tr>
			<tr class="sort_by_meta_container">
				<td>
					<label for="default_meta_key">
					<?php _e("Sort By Meta Key:", $this->plugin_slug ); ?>
					</label>
				</td>
				<td>
					<fieldset>
						<?php
							$all_meta_keys = $this->get_all_post_meta_keys();
							echo '<select name="default_meta_key" class="meta_key" id="default_meta_key">';
							foreach($all_meta_keys as $v)
							{						
								echo '<option value="'.$v.'"'.$this->set_selected($values['default_meta_key'], $v, false).'>'.$v."</option>";
							}
							echo '</select> ';
							
						?> 
					
						<select name='default_sort_type' data-field-template-id='default_sort_type'>
							<option value="numeric"<?php $this->set_selected($values['default_sort_type'], "numeric"); ?>><?php _e("numeric", $this->plugin_slug); ?></option>
							<option value="alphabetic"<?php $this->set_selected($values['default_sort_type'], "alphabetic"); ?>><?php _e("alphabetic", $this->plugin_slug); ?></option>
						</select>
					</fieldset>
				</td>
			</tr>
			</table>
		</div>
		<div class="sf_field_data sf_tab_content_taxonomies">
		<p class="description">Include or Exclude results with specific tags, categories and taxonomy terms.</p>
			<table>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</th>
					<td>
						<strong><?php _e("Comma Seperated IDs", $this->plugin_slug ); ?></strong>
					</td>
				</tr>
				<?php
					$args = array(
					  'public'   => true
					);
					
					$output = 'object';
					$taxonomies = get_taxonomies( $args, $output );
					
					//check if hierarchical, if not, do not show drill down option [this taxonomy is not hierarchical so cannot be used as a drill down widget
					
					if(isset($taxonomies['category']))
					{
						unset($taxonomies['category']);
					}
					if(isset($taxonomies['post_tag']))
					{
						unset($taxonomies['post_tag']);
					}
				
					if(count($taxonomies)>0)
					{
						?>
						<tr>
							<td>
								<label for="post_tag_include_exclude">
									<?php _e("Tags:", $this->plugin_slug ); ?>
								</label>
							</td>
							<td>
								<?php
									
									$tval = "";
									$sval = "";
									
									if(isset($values['taxonomies_settings']['post_tag']))
									{
										if(isset($values['taxonomies_settings']['post_tag']['ids']))
										{
											$tval = $values['taxonomies_settings']['post_tag']['ids'];
										}
										
										if(isset($values['taxonomies_settings']['post_tag']['include_exclude']))
										{
											$sval = $values['taxonomies_settings']['post_tag']['include_exclude'];
										}
									}
									
									
									echo '<select name="settings_taxonomies[post_tag][include_exclude]" class="meta_key" id="post_tag_include_exclude">';
									echo '<option value="include"'.$this->set_selected($sval, "include", false).'>Include</option>';
									echo '<option value="exclude"'.$this->set_selected($sval, "exclude", false).'>Exclude</option>';
									echo '</select>';
									
								?>
							</td>
							<td>
								<input class="" id="post_tag_ids" name="settings_taxonomies[post_tag][ids]" type="text" size="20" value="<?php echo esc_attr($tval); ?>">
							</td>
						</tr>
						<tr>
							<td>
								<label for="category_include_exclude">
									<?php _e("Categories:", $this->plugin_slug ); ?>
								</label>
							</td>
							<td>
								<?php
									
									$tval = "";
									$sval = "";
									
									if(isset($values['taxonomies_settings']['category']))
									{
										if(isset($values['taxonomies_settings']['category']['ids']))
										{
											$tval = $values['taxonomies_settings']['category']['ids'];
										}
										if(isset($values['taxonomies_settings']['category']['include_exclude']))
										{
											$sval = $values['taxonomies_settings']['category']['include_exclude'];
										}
									}
									
									echo '<select name="settings_taxonomies[category][include_exclude]" class="meta_key" id="category_include_exclude">';
									echo '<option value="include"'.$this->set_selected($sval, "include", false).'>Include</option>';
									echo '<option value="exclude"'.$this->set_selected($sval, "exclude", false).'>Exclude</option>';
									echo '</select>';
									
									
								?>
							</td>
							<td>
								<input class="" id="category_ids" name="settings_taxonomies[category][ids]" type="text" size="20" value="<?php echo esc_attr($tval); ?>">
							</td>
						</tr>
						<?php
						$i = 2;
						foreach ($taxonomies as $taxonomy)
						{
							echo '<tr>';
							echo "<td>";
							echo '<label for="'.$taxonomy->name.'_include_exclude">';
							echo $taxonomy->label;
							echo '</label>';
							echo "</td>";
							echo "<td>";
							
							
							$tval = "";
							$sval = "";
							if(isset($values['taxonomies_settings'][$taxonomy->name]))
							{
								if(isset($values['taxonomies_settings'][$taxonomy->name]['ids']))
								{
									$tval = $values['taxonomies_settings'][$taxonomy->name]['ids'];
								}
								
								if(isset($values['taxonomies_settings'][$taxonomy->name]['include_exclude']))
								{
									$sval = $values['taxonomies_settings'][$taxonomy->name]['include_exclude'];
								}
							}
							
							echo '<select name="settings_taxonomies['.$taxonomy->name.'][include_exclude]" class="meta_key" id="'.$taxonomy->name.'_include_exclude">';
							echo '<option value="include"'.$this->set_selected($sval, "include", false).'>Include</option>';
							echo '<option value="exclude"'.$this->set_selected($sval, "exclude", false).'>Exclude</option>';
							echo '</select>';
							
							
							?>
							</td>
							<td>
							<input class="" id="category_ids" name="settings_taxonomies[<?php echo $taxonomy->name; ?>][ids]" type="text" size="20" value="<?php echo esc_attr($tval); ?>">
							<?php
							
							echo "</td>";
							echo "</td>";
							
							echo '</tr>';
							
							$i++;
						}
						
					}
				?>
			</table>
			
			
			
			<br class="clear" />
		</div>
		<div class="sf_field_data sf_tab_content_post_meta">
			<p class="description">Only return results which match specific post meta data.</p>
			
			<p>
				<a href="#" class="dashicons-plus add-option-button button-secondary">Add Condition</a>
			</p>
		</div>
		<div class="sf_field_data sf_tab_content_author">
		f
		</div>
	</div>
	
</div>


