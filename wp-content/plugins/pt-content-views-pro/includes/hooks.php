<?php
/**
 * Custom filters/actions
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

if ( ! class_exists( 'PT_CV_Hooks_Pro' ) ) {

	/**
	 * @name PT_CV_Hooks_Pro
	 */
	class PT_CV_Hooks_Pro {

		/**
		 * Add custom filters/actions
		 */
		static function init() {
			// Filter Output
			add_filter( PT_CV_PREFIX_ . 'regular_orderby', array( __CLASS__, 'filter_regular_orderby' ) );
			add_filter( PT_CV_PREFIX_ . 'found_posts', array( __CLASS__, 'filter_found_posts' ) );
			add_filter( PT_CV_PREFIX_ . 'settings_args_offset', array( __CLASS__, 'filter_settings_args_offset' ) );
			add_filter( PT_CV_PREFIX_ . 'field_thumbnail_dimension_output', array( __CLASS__, 'filter_field_thumbnail_dimension_output' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'field_thumbnail_not_found', array( __CLASS__, 'filter_field_thumbnail_not_found' ), 10, 4 );
			add_filter( PT_CV_PREFIX_ . 'btn_more_html', array( __CLASS__, 'filter_btn_more_html' ), 10, 3 );
			add_filter( PT_CV_PREFIX_ . 'pagination_output', array( __CLASS__, 'filter_pagination_output' ) );
			add_filter( PT_CV_PREFIX_ . 'field_href_attrs', array( __CLASS__, 'filter_field_href_attrs' ), 10, 3 );
			add_filter( PT_CV_PREFIX_ . 'field_href_no_link', array( __CLASS__, 'filter_field_href_no_link' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'field_meta_author_html', array( __CLASS__, 'filter_field_meta_author_html' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'field_meta_merge_fields', array( __CLASS__, 'filter_field_meta_merge_fields' ) );
			add_filter( PT_CV_PREFIX_ . 'field_meta_seperator', array( __CLASS__, 'filter_field_meta_seperator' ) );
			add_filter( PT_CV_PREFIX_ . 'field_meta_prefix_text', array( __CLASS__, 'filter_field_meta_prefix_text' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'field_item_html', array( __CLASS__, 'filter_field_item_html' ), 10, 3 );
			add_filter( PT_CV_PREFIX_ . 'field_content_readmore_enable', array( __CLASS__, 'filter_field_content_readmore_enable' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'field_content_readmore_text', array( __CLASS__, 'filter_field_content_readmore_text' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'field_content_result', array( __CLASS__, 'filter_field_content_result' ), 10, 3 );
			add_filter( PT_CV_PREFIX_ . 'field_excerpt_dots', array( __CLASS__, 'filter_field_excerpt_dots' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'field_thumbnail_setting_values', array( __CLASS__, 'filter_field_thumbnail_setting_values' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'view_type_asset', array( __CLASS__, 'filter_view_type_asset' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'view_type_dir', array( __CLASS__, 'filter_view_type_dir' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'scrollable_toggle_icon', array( __CLASS__, 'filter_scrollable_toggle_icon' ) );
			add_filter( PT_CV_PREFIX_ . 'scrollable_interval', array( __CLASS__, 'filter_scrollable_interval' ) );
			add_filter( PT_CV_PREFIX_ . 'collapsible_data_attr', array( __CLASS__, 'filter_collapsible_data_attr' ) );
			add_filter( PT_CV_PREFIX_ . 'page_attr', array( __CLASS__, 'filter_page_attr' ), 10, 3 );
			add_filter( PT_CV_PREFIX_ . 'wrap_in_page', array( __CLASS__, 'filter_wrap_in_page' ) );
			add_filter( PT_CV_PREFIX_ . 'content_items_wrap', array( __CLASS__, 'filter_content_items_wrap' ), 10, 4 );
			add_filter( PT_CV_PREFIX_ . 'all_display_settings', array( __CLASS__, 'filter_all_display_settings' ) );
			add_filter( PT_CV_PREFIX_ . 'order_setting', array( __CLASS__, 'filter_order_setting' ) );
			add_filter( PT_CV_PREFIX_ . 'other_settings', array( __CLASS__, 'filter_other_settings' ) );
			add_filter( PT_CV_PREFIX_ . 'validate_settings', array( __CLASS__, 'filter_validate_settings' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'query_parameters', array( __CLASS__, 'filter_query_parameters' ) );
			add_filter( PT_CV_PREFIX_ . 'taxonomies_list', array( __CLASS__, 'filter_taxonomies_list' ) );
			add_filter( PT_CV_PREFIX_ . 'taxonomy_query_args', array( __CLASS__, 'filter_taxonomy_query_args' ) );
			add_filter( PT_CV_PREFIX_ . 'shortcode_params', array( __CLASS__, 'filter_shortcode_params' ) );
			add_filter( PT_CV_PREFIX_ . 'view_class', array( __CLASS__, 'filter_view_class' ) );
			add_filter( PT_CV_PREFIX_ . 'assets_files', array( __CLASS__, 'filter_assets_files' ) );
			add_filter( PT_CV_PREFIX_ . 'before_output_html', array( __CLASS__, 'filter_before_output_html' ) );
			add_filter( PT_CV_PREFIX_ . 'content_item_filter_value', array( __CLASS__, 'filter_content_item_filter_value' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'content_items', array( __CLASS__, 'filter_content_items' ) );
			add_filter( PT_CV_PREFIX_ . 'item_col_class', array( __CLASS__, 'filter_item_col_class' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'post__not_in', array( __CLASS__, 'filter_post__not_in' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'post_parent_id', array( __CLASS__, 'filter_post_parent_id' ) );
			add_filter( PT_CV_PREFIX_ . 'show_this_post', array( __CLASS__, 'filter_show_this_post' ) );
			add_filter( PT_CV_PREFIX_ . 'search_terms', array( __CLASS__, 'filter_search_terms' ) );
			add_filter( PT_CV_PREFIX_ . 'style_settings_data', array( __CLASS__, 'filter_style_settings_data' ) );

			// Do action
			add_action( PT_CV_PREFIX_ . 'store_view_data', array( __CLASS__, 'action_store_view_data' ) );
			add_action( PT_CV_PREFIX_ . 'print_view_style', array( __CLASS__, 'action_print_view_style' ) );
			add_action( PT_CV_PREFIX_ . 'before_query', array( __CLASS__, 'action_before_query' ) );
			add_action( PT_CV_PREFIX_ . 'after_query', array( __CLASS__, 'action_after_query' ) );
			add_action( PT_CV_PREFIX_ . 'add_global_variables', array( __CLASS__, 'action_add_global_variables' ) );
			add_action( PT_CV_PREFIX_ . 'handle_teaser', array( __CLASS__, 'action_handle_teaser' ) );
		}

		/**
		 * Get offset setting value
		 *
		 * @return int
		 */
		static function get_offset_setting() {
			global $pt_view_settings;

			$offset = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'offset', $pt_view_settings, 0 );

			return ( $offset < 0 ) ? 0 : $offset;
		}

		/**
		 * Filter regular orderby: Add meta key option
		 *
		 * @param array $args Array to filter
		 *
		 * @return array
		 */
		static function filter_regular_orderby( $args ) {

			$args = array_merge(
				$args, array(
					'rand'          => __( 'Random order', PT_CV_DOMAIN_PRO ),
					'comment_count' => __( 'Comment count', PT_CV_DOMAIN_PRO ),
					'menu_order'    => __( 'Page Order', PT_CV_DOMAIN_PRO ),
					'view_count'    => __( 'View count', PT_CV_DOMAIN_PRO ),
					// 'meta_key_orderby' => __( 'Meta key', PT_CV_DOMAIN_PRO ),
				)
			);

			return $args;
		}

		/**
		 * Filter total founds post
		 *
		 * @param int $found_posts Total found posts $wp_query->found_posts
		 */
		public static function filter_found_posts( $found_posts ) {
			global $pt_view_settings;

			// Get offset
			$offset = self::get_offset_setting( $pt_view_settings );

			// deduct the custom offset from $wp_query->found_posts
			$found_posts -= $offset;

			return $found_posts;
		}

		/**
		 * Filter offset for pagination
		 *
		 * @param int $offset The offset value
		 */
		public static function filter_settings_args_offset( $offset ) {
			global $pt_view_settings;

			// Get offset
			$offset_option = self::get_offset_setting( $pt_view_settings );

			$offset += $offset_option;

			return $offset;
		}

		/**
		 * Filter thumbnail output
		 *
		 * @param string $args  The dimensions (sizes) of thumbnail
		 * @param array  $fargs The settings of this field
		 *
		 * @return array
		 */
		public static function filter_field_thumbnail_dimension_output( $args, $fargs ) {
			global $dargs;

			switch ( $fargs['size'] ) {
				case PT_CV_PREFIX . 'custom':
					$args = PT_CV_Functions_Pro::field_thumbnail_dimensions( $fargs );

					break;
			}

			// For pinterest
			if ( $dargs['view-type'] == 'pinterest' ) {
				// wp_is_mobile() is 3.4 or higher
				if ( wp_is_mobile() ) {
					$args = 'full';
				}
			}

			return $args;
		}

		/**
		 * Filter thumbnail output when no thumbnail found
		 *
		 * @param string $args       HTML output of thumbnail field
		 * @param object $post       The post object
		 * @param array  $dimensions The dimensions of thumbnail
		 * @param array  $gargs      The settings of get_the_post_thumbnail function
		 *
		 * @return array
		 */
		public static function filter_field_thumbnail_not_found( $args, $post, $dimensions, $gargs ) {

			// Get size from name: thumbnail, full, ...
			if ( count( $dimensions ) == 1 ) {
				$dimensions = PT_CV_Functions_Pro::get_dimensions_of_size( $dimensions[0] );
			}

			//====== Get first image in post content
			preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
			$first_img = isset( $matches[1][0] ) ? $matches[1][0] : '';

			if ( ! empty( $first_img ) ) {
				$width_height = is_array( $dimensions ) ? sprintf( 'width="%s" height="%s"', $dimensions[0], $dimensions[1] ) : '';

				$args = sprintf( '<img src="%s" class="%s" %s/>', esc_attr( $first_img ), esc_attr( $gargs['class'] ), $width_height );
			}

			//====== Get Media URL: Youtube, Vimeo, Dailymotion, Soundcloud
			preg_match_all( '|https?://[^\s"]+|im', $post->post_content, $matches );

			// Get URL to embed
			$media_url = '';
			if ( isset( $matches[0] ) ) {
				foreach ( $matches[0] as $url ) {
					// If is one of: Youtube, Vimeo, Dailymotion, Soundcloud
					if ( preg_match( '(youtube\.com|youtu\.be|vimeo\.com|dailymotion\.com|soundcloud\.com)', $url ) ) {
						$media_url = $url;
						break;
					}
				}
			}

			// Embed url
			if ( $media_url ) {
				$args = wp_oembed_get( trim( $media_url, '.' ), array( 'width' => $dimensions[0], 'height' => $dimensions[1] ) );
			}

			return $args;
		}

		/**
		 * Filter thumbnail output when no thumbnail found
		 *
		 * @param string $args          HTML output of thumbnail field
		 * @param string $max_num_pages The total of pages
		 * @param string $session_id    The session id of current view
		 *
		 * @return string
		 */
		public static function filter_btn_more_html( $args, $max_num_pages, $session_id ) {
			global $dargs;
			$dargs_pagination = $dargs['pagination-settings'];

			// Get class of more button
			$more_class = apply_filters( PT_CV_PREFIX_ . 'btn_more_class', PT_CV_PREFIX . 'more' . ' ' . 'btn btn-primary btn-sm' );

			// Get text of more button
			$more_text = ! empty( $dargs_pagination['loadmore-text'] ) ? $dargs_pagination['loadmore-text'] : __( 'More', PT_CV_DOMAIN_PRO );
			$more_text = apply_filters( PT_CV_PREFIX_ . 'btn_more_text', $more_text );

			$args = sprintf(
				'<button class="%s" data-totalpages="%s" data-nextpages="%s" data-sid="%s">%s <span class="caret"></span></button>',
				esc_attr( $more_class ), esc_attr( $max_num_pages ), 2, esc_attr( $session_id ), esc_html( $more_text )
			);

			return $args;
		}

		/**
		 * Filter output for pagination: Add wrapper
		 *
		 * @param string $args The HTML output of pagination
		 */
		public static function filter_pagination_output( $args ) {
			global $dargs;
			$dargs_pagination = $dargs['pagination-settings'];

			$alignment = isset( $dargs_pagination['alignment'] ) ? $dargs_pagination['alignment'] : 'left';

			$wrapper_class = sprintf( 'text-%s', $alignment );

			return sprintf( '<div class="%s">%s</div>', $wrapper_class . ' ' . PT_CV_PREFIX . 'pagination-wrapper', $args );
		}

		/**
		 * Filter class for <a> tag
		 *
		 * @param array  $custom_attr Custom attributes
		 * @param string $open_in     Open in attribute
		 * @param array  $oargs       The array of Other settings
		 */
		public static function filter_field_href_attrs( $custom_attr, $open_in, $oargs = array() ) {

			$arr = array( PT_CV_PREFIX . 'window', PT_CV_PREFIX . 'lightbox' );

			if ( in_array( $open_in, $arr ) ) {
				$width          = ! empty( $oargs['size-width'] ) ? $oargs['size-width'] : '75';
				$height         = ! empty( $oargs['size-height'] ) ? $oargs['size-height'] : '75';
				$custom_attr [] = sprintf( 'data-width="%s"', esc_attr( $width ) );
				$custom_attr [] = sprintf( 'data-height="%s"', esc_attr( $height ) );

				if ( isset( $oargs['content-selector'] ) ) {
					$custom_attr[] = sprintf( 'data-content-selector="%s"', esc_attr( $oargs['content-selector'] ) );
				}
			}

			return $custom_attr;
		}

		/**
		 * Whether or not wrap a link, depends on $open_in value
		 *
		 * @param boolean $args    Whether or not wrap a link
		 * @param string  $open_in Open in attribute
		 *
		 * @return string
		 */
		public static function filter_field_href_no_link( $args, $open_in ) {
			if ( $open_in == PT_CV_PREFIX . 'none' ) {
				$args = 1;
			}

			return $args;
		}

		/**
		 * Filter HTML output of author
		 *
		 * @param string $args The HTML output of author
		 * @param object $post The post object
		 */
		public static function filter_field_meta_author_html( $args, $post ) {
			global $dargs;

			$view_type = $dargs['view-type'] | '';
			if ( $view_type === 'timeline' ) {
				// Sets up global post data
				setup_postdata( $post );

				$author_id = get_the_author_meta( 'ID' );
				$args      = sprintf( '<a href="%s" title="%s %s">%s</a>', esc_url( get_author_posts_url( $author_id ) ), __( 'Posted by', PT_CV_DOMAIN_PRO ), get_the_author(), get_avatar( $author_id, 40 ) );
			}

			return $args;
		}

		/**
		 * Merge fields, or let them as seperate items in array
		 *
		 * @param bool $args Whether or not to merge
		 */
		public static function filter_field_meta_merge_fields( $args ) {
			global $dargs;

			$view_type = $dargs['view-type'] | '';
			if ( $view_type === 'timeline' ) {
				$args = false;
			}

			return $args;
		}


		/**
		 * Remove seperator between meta fields
		 *
		 * @param string $args The seperator between meta fields
		 */
		public static function filter_field_meta_seperator( $args ) {

			global $dargs;

			if ( ! isset( $dargs['field-settings']['meta-fields']['taxonomy-use-icons'] ) ) {
				return $args;
			}

			$args = '';

			return $args;
		}

		/**
		 * Remove prefix text of meta fields
		 *
		 * @param string $args       The current prefix text of meta fields
		 * @param string $meta_field The meta field name
		 *
		 * @return string
		 */
		public static function filter_field_meta_prefix_text( $args, $meta_field ) {

			global $dargs;

			if ( ! isset( $dargs['field-settings']['meta-fields']['taxonomy-use-icons'] ) ) {
				return $args;
			}

			$class = '';
			switch ( $meta_field ) {
				case 'author':
					$class = 'user';
					break;
				case 'date':
					$class = 'time';
					break;
				case 'terms':
					$class = 'bookmark';
					break;
				case 'comment':
					$class = 'comment';
					break;
			}

			$args = sprintf( '<span class="glyphicon glyphicon-%s"></span>', $class );

			return $args;
		}


		/**
		 * Filter HTML output of a field (thumbnail, title, content, meta fields, Price)
		 *
		 * @param string $html       The output HTML
		 * @param string $field_     The type of field
		 * @param object $post       The post object
		 */
		public static function filter_field_item_html( $html, $field_, $post ) {
			switch ( $field_ ) {
				// Show Price
				case 'price':
					$post_type = get_post_type( $post );
					if ( $post_type === 'product' ) {
						$html = do_shortcode( sprintf( '[add_to_cart id="%s"]', $post->ID ) );
					} else {
						$html = '';
					}

					break;

				// Show Custom Fields
				case 'custom-fields':
					$custom_fields_st = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'custom-fields-' );
					if ( $custom_fields_st && ! empty( $custom_fields_st['list'] ) ) {
						$list      = (array) $custom_fields_st['list'];
						$show_name = isset( $custom_fields_st['show-name'] ) ? $custom_fields_st['show-name'] : '';
						$result    = array();

						// Get all meta data of this post
						$metadata = get_metadata( 'post', $post->ID );

						$wanted_keys = array_intersect( $list, array_keys( $metadata ) );

						// Get (name) vaue of custom fields
						foreach ( $wanted_keys as $key ) {

							// ACF support
							if ( function_exists( 'get_field_object' ) ) {
								$field_object = get_field_object( $key, $post->ID );
								$field_value  = PT_CV_ACF::display_output( $field_object );
								$field_name   = $field_object['label'];
							}
							if ( empty( $field_value ) ) {
								$field_value = implode( ', ', $metadata[$key] );
							}
							if ( empty( $field_name ) ) {
								$field_name  = esc_html( $key );
							}

							$name     = $show_name ? sprintf( '<span class="%s">%s</span>', PT_CV_PREFIX . 'ctf-name', $field_name ) : '';
							$value    = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'ctf-value', balanceTags( $field_value ) );
							$result[] = sprintf( '<div class="%s">%s%s</div>', PT_CV_PREFIX . 'custom-fields' . ' ' . PT_CV_PREFIX . 'ctf-' . $key, $name, $value );
						}

						$html = balanceTags( implode( '', $result ) );
					}
					break;
			}

			return $html;
		}

		/**
		 * Enable/Disable Read more button
		 *
		 * @param string $args      The readmore text
		 * @param array  $fargs     The settings of Content
		 */
		public static function filter_field_content_readmore_enable( $args, $fargs ) {
			// not empty => true => show
			$args = ! empty( $fargs['readmore'] );

			return $args;
		}

		/**
		 * Filter Read more button
		 *
		 * @param string $args      The readmore text
		 * @param array  $fargs     The settings of Content
		 */
		public static function filter_field_content_readmore_text( $args, $fargs ) {
			// If enable read more
			if ( ! empty( $fargs['readmore'] ) ) {
				$args = ! empty( $fargs['readmore-text'] ) ? $fargs['readmore-text'] : __( 'Read More', PT_CV_DOMAIN );
			}

			return $args;
		}

		/**
		 * Filter post excerpt
		 *
		 * @param string $args  The excerpt output
		 * @param type   $fargs The field display settings
		 * @param type   $post  The post object
		 *
		 * @return string
		 */
		public static function filter_field_content_result( $args, $fargs, $post ) {
			// If 'Use manual excerpt' & Manual excerpt is not empty
			if ( ! empty( $fargs['content']['manual'] ) && ! empty( $post->post_excerpt ) ) {
				$args = $post->post_excerpt;
			}

			return $args;
		}

		/**
		 * Append ... to Excerpt or not
		 *
		 * @param array $args
		 */
		public static function filter_field_excerpt_dots( $args, $fargs ) {
			return empty( $fargs['content']['hide_dots'] );
		}

		/**
		 * Filter thumbnail settings: Add custom size info
		 *
		 * @param array  $args   Array of parameters
		 * @param string $prefix The prefix in name of setting
		 */
		public static function filter_field_thumbnail_setting_values( $args, $prefix ) {
			global $pt_view_settings;

			// Get custom size if need
			if ( $args['size'] == PT_CV_PREFIX . 'custom' ) {
				$fields = array( 'size-custom-width', 'size-custom-height' );
				PT_CV_Functions::settings_values( $fields, $args, $pt_view_settings, $prefix );
			}

			return $args;
		}

		/**
		 * Modify assets folder of View type
		 *
		 * @param string $args      The path to assets folder of view type
		 * @param string $view_type The view type
		 */
		public static function filter_view_type_asset( $args, $view_type ) {
			$path = PT_CV_VIEW_TYPE_OUTPUT_PRO . $view_type;

			if ( is_dir( $path ) ) {
				$args = $path;
			}

			return $args;
		}

		/**
		 * Filter directory of Pro View type
		 *
		 * @param string $args      The path to main folder of view type
		 * @param string $view_type The view type
		 *
		 * @return string
		 */
		public static function filter_view_type_dir( $args, $view_type ) {

			$view_types_pro = array_keys( PT_CV_Values_Pro::view_type_pro() );
			if ( in_array( $view_type, $view_types_pro ) ) {
				$args = PT_CV_VIEW_TYPE_OUTPUT_PRO;
			}

			return $args;
		}

		/**
		 * Add toggle icon to Scrollable item
		 *
		 * @param string $args HTML of toggle icon
		 *
		 * @return string
		 */
		public static function filter_scrollable_toggle_icon( $args ) {

			$args = '<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-plus"></i></span>';

			return $args;
		}

		/**
		 * Filter interval for Scrollable List
		 *
		 * @param string $args The interval value
		 */
		public static function filter_scrollable_interval( $args ) {
			global $dargs;

			$carousel_settings = ! empty( $dargs['view-type-settings'] ) ? $dargs['view-type-settings'] : array();
			$interval          = isset( $carousel_settings['interval'] ) ? (int) $carousel_settings['interval'] : 5;
			$args              = ! isset( $carousel_settings['auto-cycle'] ) ? 'false' : $interval * 1000;

			return $args;
		}

		/**
		 * Add custom data- to wrapper div of Collapsible list
		 *
		 * @param string $args
		 *
		 * @return string
		 */
		public static function filter_collapsible_data_attr( $args ) {
			global $dargs;

			$data_attr   = array();
			$data_attr[] = ( isset( $dargs['view-type-settings']['open-multiple'] ) && $dargs['view-type-settings']['open-multiple'] == 'yes' ) ? 'data-multiple-open="yes"' : '';
			$data_attr[] = ( isset( $dargs['view-type-settings']['open-first-item'] ) && $dargs['view-type-settings']['open-first-item'] == 'yes' ) ? 'data-first-open="yes"' : '';

			$args = implode( ' ', array_filter( $data_attr ) );

			return $args;
		}

		/**
		 * Filter custom data attributes for a page
		 *
		 * @param string $view_type     The view type
		 * @param array  $content_items The items array
		 */
		public static function filter_page_attr( $args, $view_type, $content_items ) {
			global $dargs;

			switch ( $view_type ) {
				case 'pinterest':
					$columns = ( (int) $dargs['number-columns'] < count( $content_items ) ) ? (int) $dargs['number-columns'] : count( $content_items );
					$args    = sprintf( 'data-row-item="%s"', esc_attr( $columns ) );
					break;
			}

			return $args;
		}

		/**
		 * Whether or not to wrap items in a page
		 *
		 * @param bool $args Wrap or not
		 */
		public static function filter_wrap_in_page( $args ) {
			global $dargs;

			// Get Pagination style
			$pagination_style = isset( $dargs['pagination-settings']['style'] ) ? $dargs['pagination-settings']['style'] : 'regular';

			if ( in_array( $pagination_style, array( 'loadmore', 'infinite' ) ) ) {
				$args = false;
			}

			if ( $dargs['view-type'] === 'timeline' ) {
				$args = false;
			}

			return $args;
		}

		/**
		 * Filter wrapper HTML of list of items by view type
		 *
		 * @param array $content       The output array
		 * @param array $content_items The array of Raw HTML output (is not wrapped) of each item
		 * @param int   $current_page  The current page
		 * @param int   $post_per_page The number of posts per page
		 */
		public static function filter_content_items_wrap( $content, $content_items, $current_page, $post_per_page ) {
			global $dargs;

			$view_type = $dargs['view-type'] | '';
			if ( $view_type === 'timeline' ) {
				$content = PT_CV_Html_ViewType_Pro::timeline_wrapper( $content_items, $current_page, $post_per_page );
			}

			return $content;
		}

		/**
		 * Filter display settings value
		 *
		 * @param array $args The settings array of Fields
		 */
		public static function filter_all_display_settings( $args ) {
			global $pt_view_settings, $dargs;

			$args['view-style'] = array();

			$args['view-style']['font'] = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'font-' );

			$args['view-style']['margin'] = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'margin-value-' );

			$args['view-style']['others'] = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'style-' );

			// Border radius
			$thumbnail_settings = isset( $dargs['field-settings']['thumbnail'] ) ? $dargs['field-settings']['thumbnail'] : array();
			if ( isset( $thumbnail_settings['style'] ) && $thumbnail_settings['style'] == 'img-rounded' ) {
				$args['view-style']['border-radius'] = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'thumbnail-border-radius', $pt_view_settings );
			}

			// Custom image size
			if ( $thumbnail_settings && $thumbnail_settings['size'] == PT_CV_PREFIX . 'custom' ) {
				// Get thumbnail dimensions
				$dimensions = PT_CV_Functions::field_thumbnail_dimensions( $thumbnail_settings );
				$dimensions = (array) apply_filters( PT_CV_PREFIX_ . 'field_thumbnail_dimension_output', $dimensions, $thumbnail_settings );

				$args['view-style']['image-sizes'] = $dimensions;
			}

			$args['taxonomy-filter'] = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy', $pt_view_settings );

			return $args;
		}

		/**
		 * Order settings args
		 *
		 * @param array $args
		 */
		public static function filter_order_setting( $args ) {
			global $pt_view_settings, $pt_content_type;

			extract( $args );

			// Custom order by view_count
			if ( $args['orderby'] == 'view_count' ) {
				$key     = PT_CV_META_VIEW_COUNT;
				$orderby = 'meta_value_num';
			}

			// Custom order for post type, e.g. Price for Woocommerce Product
			if ( $meta_key = PT_CV_Functions::setting_value( PT_CV_PREFIX . $pt_content_type . '-orderby', $pt_view_settings ) ) {
				// Use 'meta_value_num' for numeric values
				$all_values = apply_filters( PT_CV_PREFIX_ . 'meta_numeric_values', array() );

				// Get numeric values of selected content type
				$values  = isset( $all_values[$pt_content_type] ) ? $all_values[$pt_content_type] : array();
				$orderby = array_key_exists( $meta_key, (array) $values ) ? 'meta_value_num' : 'meta_value';

				$key   = isset( $values[$meta_key] ) ? $values[$meta_key] : $meta_key;
				$order = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-order', $pt_view_settings );
			}

			// Update the params
			if ( isset( $key ) ) {
				$args = array(
					'meta_key' => $key,
					'orderby'  => $orderby,
					'order'    => $order,
				);
			}

			return $args;
		}


		/**
		 * Filter other settings
		 *
		 * @param array $args Array to filter
		 *
		 * @return array
		 */
		public static function filter_other_settings( $args ) {
			$arr = array( PT_CV_PREFIX . 'window', PT_CV_PREFIX . 'lightbox' );

			if ( isset( $args['open-in'] ) && in_array( $args['open-in'], $arr ) ) {
				$key = str_replace( PT_CV_PREFIX, '', $args['open-in'] );
				$args += (array) PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'other-' . $key . '-' );
			}

			return $args;
		}

		/**
		 * Validate settings filter
		 *
		 * @param string $error The error message
		 * @param array  $args  The Query parameters array
		 */
		public static function filter_validate_settings( $errors, $args ) {
			global $dargs;

			// Prefix string for error message
			$messages = array(
				'field' => array(
					'select' => __( 'Please select an option in : ', PT_CV_DOMAIN ),
					'text'   => __( 'Please set value in : ', PT_CV_DOMAIN ),
				),
				'tab'   => array(
					'filter'  => __( 'Filter Settings', PT_CV_DOMAIN ),
					'display' => __( 'Display Settings', PT_CV_DOMAIN ),
				),
			);

			// View type
			if ( ! empty( $dargs['view-type'] ) ) {
				switch ( $dargs['view-type'] ) {
					case 'scrollable':
						if ( empty( $dargs['number-columns'] ) ) {
							$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'View type settings', PT_CV_DOMAIN ) . ' > ' . __( 'Items per row', PT_CV_DOMAIN );
						}
						if ( empty( $dargs['number-rows'] ) ) {
							$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'View type settings', PT_CV_DOMAIN ) . ' > ' . __( 'Rows count', PT_CV_DOMAIN );
						}
						break;

					case 'pinterest':
						if ( empty( $dargs['number-columns'] ) ) {
							$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'View type settings', PT_CV_DOMAIN ) . ' > ' . __( 'Items per row', PT_CV_DOMAIN );
						}
						break;
				}
			}

			// Thumbnail custom dimensions
			if ( ! empty( $dargs['field-settings']['thumbnail'] ) ) {
				$thumbnail_settings = $dargs['field-settings']['thumbnail'];
				if ( isset( $thumbnail_settings['size'] ) ) {
					if ( $thumbnail_settings['size'] === PT_CV_PREFIX . 'custom' ) {
						if ( empty( $thumbnail_settings['size-custom-width'] ) ) {
							$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'Fields settings', PT_CV_DOMAIN ) . ' > ' . __( 'Thumbnail settings', PT_CV_DOMAIN ) . ' > ' . __( 'Custom size', PT_CV_DOMAIN_PRO ) . ' > ' . __( 'Width', PT_CV_DOMAIN_PRO );
						}
						if ( empty( $thumbnail_settings['size-custom-height'] ) ) {
							$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'Fields settings', PT_CV_DOMAIN ) . ' > ' . __( 'Thumbnail settings', PT_CV_DOMAIN ) . ' > ' . __( 'Custom size', PT_CV_DOMAIN_PRO ) . ' > ' . __( 'Height', PT_CV_DOMAIN_PRO );
						}
					}
				}
			}

			// Open in : Width/Height of Window/Lightbox size
			if ( ! empty( $dargs['other-settings'] ) ) {
				$other_settings = $dargs['other-settings'];
				if ( $other_settings['open-in'] === PT_CV_PREFIX . 'window' ) {
					if ( empty( $other_settings['size-width'] ) ) {
						$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'Other settings', PT_CV_DOMAIN ) . ' > ' . __( 'Window size', PT_CV_DOMAIN_PRO ) . ' > ' . __( 'Width', PT_CV_DOMAIN_PRO );
					}
					if ( empty( $other_settings['size-height'] ) ) {
						$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'Other settings', PT_CV_DOMAIN ) . ' > ' . __( 'Window size', PT_CV_DOMAIN_PRO ) . ' > ' . __( 'Height', PT_CV_DOMAIN_PRO );
					}
				}
				if ( $other_settings['open-in'] === PT_CV_PREFIX . 'lightbox' ) {
					if ( empty( $other_settings['size-width'] ) ) {
						$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'Other settings', PT_CV_DOMAIN ) . ' > ' . __( 'Lightbox size', PT_CV_DOMAIN_PRO ) . ' > ' . __( 'Width', PT_CV_DOMAIN_PRO );
					}
					if ( empty( $other_settings['size-height'] ) ) {
						$errors[] = $messages['field']['text'] . $messages['tab']['display'] . ' > ' . __( 'Other settings', PT_CV_DOMAIN ) . ' > ' . __( 'Lightbox size', PT_CV_DOMAIN_PRO ) . ' > ' . __( 'Height', PT_CV_DOMAIN_PRO );
					}
				}
			}

			return array_filter( $errors );
		}

		/**
		 * Filter array of parameters for Wp_Query
		 *
		 * @param type $args The Query parameters array
		 *
		 * @return array $args
		 */
		public static function filter_query_parameters( $args ) {
			global $pt_view_settings, $pt_cv_shortcode_params;

			// Filter by Date
			PT_CV_Functions_Pro::filter_by_date( $args );

			// Get content type
			$content_type = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'content-type', $pt_view_settings );

			// Quick filter WooCommerce Product (featured/best seller/... products)
			if ( $content_type == 'product' ) {
				$products_list = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'products-list', $pt_view_settings );
				// Append query parameters
				$args = array_merge( $args, PT_CV_WooCommerce::query_parameters( $products_list ) );
			}

			// Filter Taxonomy by shortcode parameters
			$args = self::filter_taxonomy_setting( $args );

			// Custom Field filter
			$args = self::filter_by_custom_field( $args );

			return $args;
		}

		/**
		 * Add parameters to filter by Custom Field
		 *
		 * @param array $args
		 * @return array
		 */
		private static function filter_by_custom_field( $args ) {
			// Get saved settings of Custom fields
			$saved_ctf = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'ctf-filter-', true );

			$number_of_fields = isset( $saved_ctf['key'] ) ? count( $saved_ctf['key'] ) : 0;

			$ctf_query = array();

			for ( $idx = 0; $idx < $number_of_fields; $idx++ ) {
				if ( ! isset( $saved_ctf['value'][$idx] ) ) {
					continue;
				}

				$value   = preg_replace( '/\s+/', '', $saved_ctf['value'][$idx] );
				$arr_val = explode( ',', $value );

				// Prevent duplicate key
				$key = $saved_ctf['key'][$idx];

				// Get operator to compare
				$compare = $saved_ctf['operator'][$idx];

				// Get type of custom field
				$type = $saved_ctf['type'][$idx];

				// Only process if value is not empty
				if ( $value ) {
					// Check if require array of value
					$require_arr = 0;

					// Validate input which requires 2 values
					if ( in_array( $compare, array( 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' ) ) ) {
						$require_arr = 1;
						if ( count( $arr_val ) <= 1 ) {
							die( __( 'You have to give 2 different values for the custom field', PT_CV_DOMAIN_PRO ) . ': ' . $key );
						}
					}

					// Validate date value
					if ( $type == 'DATE' ) {
						// If all dates are valid, convert to Ymd format
						$arr_dates = array();
						foreach ( $arr_val as $date ) {
							$date = DateTime::createFromFormat( 'm/d/Y', $date );
							if ( $date ) {
								$arr_dates[] = $date->format( 'Ymd' );
							} else {
								die( __( 'One of date value is invalid, for the custom field', PT_CV_DOMAIN_PRO ) . ': ' . $key );
							}
						}
						$arr_val = $arr_dates;
					}

					// Create query array for this custom field
					$ctf_query[$key] = array(
						'key'     => $key,
						'value'   => $require_arr ? $arr_val : $arr_val[0],
						'type'    => $type,
						'compare' => $compare,
					);
				}
			}

			// Get Relation if filtered by more than 1 custom field
			if ( count( $ctf_query ) > 1 ) {
				$ctf_query['relation'] = $saved_ctf['relation'];
			}

			$args = array_merge( $args, array( 'meta_query' => $ctf_query ) );

			return $args;
		}

		/**
		 * Filter when get list of taxonomies
		 *
		 * @param array $args The settings array to get taxonomies
		 */
		public static function filter_taxonomies_list( $args ) {
			global $dargs;

			if ( isset( $dargs['field-settings']['meta-fields']['taxonomy-dis-o-checked'] ) ) {
				$taxonomies_to_get = isset( $dargs['taxonomy-filter'] ) ? $dargs['taxonomy-filter'] : NULL;

				if ( is_array( $taxonomies_to_get ) ) {
					$args = $taxonomies_to_get;
				}
			}

			return $args;
		}


		/**
		 * Filter taxonomy: Get all registered taxonomies
		 *
		 * @param array $args Array to filter
		 *
		 * @return boolean
		 */
		public static function filter_taxonomy_query_args( $args ) {
			if ( isset( $args['show_ui'] ) ) {
				unset( $args['show_ui'] );
			}
			if ( isset( $args['_builtin'] ) ) {
				unset( $args['_builtin'] );
			}

			return $args;
		}

		/**
		 * Add parameters for View shortcode
		 *
		 * @param array $args
		 */
		public static function filter_shortcode_params( $args ) {
			// Parameters for replace WordPress layout
			$args['replace_tpl'] = 0;
			$args['view_class']  = '';

			// Parameters for Taxonomy filter
			$args['cat']      = '';
			$args['tag']      = '';
			$args['taxonomy'] = '';
			$args['terms']    = '';
			$args['operator'] = 'IN'; // IN, NOT IN, AND

			return $args;
		}

		/**
		 * Add wrapper class of View
		 *
		 * @param array $args
		 *
		 * @return int
		 */
		public static function filter_view_class( $args ) {
			global $pt_cv_shortcode_params;
			if ( ! empty( $pt_cv_shortcode_params['view_class'] ) ) {
				$args[] = esc_attr( $pt_cv_shortcode_params['view_class'] );
			}

			global $pt_view_settings;
			// Get view type
			$view_type = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'view-type', $pt_view_settings );
			if ( $view_type == 'pinterest' ) {
				// Auto add opacity 0 class, to hide the Pinterest layout, before finish rendering
				$args[] = PT_CV_PREFIX . 'opacity-hidden';

				$style  = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'pinterest-box-style', $pt_view_settings, 'shadow' );
				$args[] = esc_attr( PT_CV_PREFIX . $style );
			}

			// Animation class
			global $animation_settings;
			$animation_settings = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'anm' . '-' );
			if ( isset( $animation_settings['content-hover'] ) ) {
				$args[] = esc_attr( PT_CV_PREFIX . 'content-hover' );
			}

			// Set same height for each type of fields (Title, Content...) across items
			$grid_settings = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'grid' . '-' );
			if ( isset( $grid_settings['same-height'] ) ) {
				$args[] = esc_attr( PT_CV_PREFIX . 'same-height' );
			}

			// Infinite loading
			global $dargs;
			$dargs_pagination = isset( $dargs['pagination-settings'] ) ? $dargs['pagination-settings'] : array();
			if ( $dargs_pagination && $dargs_pagination['style'] == 'infinite' ) {
				$args[] = esc_attr( PT_CV_PREFIX . 'infinite-load' );
			}

			return $args;
		}

		/**
		 * Filter asset files to include in Preview/Front-end
		 *
		 * @param array $args
		 */
		public static function filter_assets_files( $args ) {
			global $pt_view_settings;

			$rtl = isset( $pt_view_settings[PT_CV_PREFIX . 'text-direction'] ) && $pt_view_settings[PT_CV_PREFIX . 'text-direction'] == 'rtl';

			if ( $rtl ) {
				$args['css'][] = plugins_url( 'public/assets/css/rtl.css', PT_CV_FILE_PRO );
			}

			return $args;
		}

		/**
		 * Add custom HTML before list of items
		 *
		 * @param string $args
		 */
		public static function filter_before_output_html( $args ) {
			global $pt_view_settings, $dargs, $pt_cv_enable_filter;

			// Show Title of Parent page
			if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post_parent-auto', $pt_view_settings ) ) {
				// Show info of Parent page
				if ( $show_what = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post_parent-auto-info', $pt_view_settings ) ) {
					global $pt_cv_page_parent;

					if ( $pt_cv_page_parent ) {
						$parent       = get_post( $pt_cv_page_parent );
						$parent_title = $parent->post_title;

						if ( $show_what == 'title' ) {
							// Show Title
							$args = sprintf( '<h3 class="%s">%s</h3>', PT_CV_PREFIX . 'parent-title', $parent_title );
						} else {
							// Show Title & Link
							$args = sprintf( '<h3 class="%s"><a href="%s">%s</a></h3>', PT_CV_PREFIX . 'parent-title', get_permalink( $parent->ID ) , $parent_title );
						}
					}
				}
			}

			// Enable filter
			if ( $pt_cv_enable_filter == 'yes' ) {

				// Check if Taxonomy is selected in Advanced filters
				$advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings', $pt_view_settings );
				if ( ! in_array( 'taxonomy', $advanced_settings ) ) {
					return sprintf( '<div class="alert alert-danger">%s</div>', __( 'Please check the "Taxonomy" checkbox in "Advanced filters"' ) );
				}

				// Get selected taxonomy
				$taxonomies_to_get = isset( $dargs['taxonomy-filter'] ) ? $dargs['taxonomy-filter'] : NULL;

				if ( ! is_array( $taxonomies_to_get ) ) {
					return sprintf( '<div class="alert alert-danger">%s</div>', __( 'Please select at least one taxonomy in "Advanced filters" > "Taxonomy Settings"' ) );
				}

				// Get selected terms or all terms of selected taxonomies
				$selected_terms_of_taxonomies = (array) PT_CV_Functions_Pro::get_selected_terms( $taxonomies_to_get );

				if ( ! $selected_terms_of_taxonomies ) {
					return sprintf( '<div class="alert alert-info">%s</div>', __( 'There is no terms to filter' ) );
				}

				// Get filter settings
				$prefix          = 'taxonomy-filter';
				$filter_settings = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . $prefix . '-' );

				$class     = PT_CV_PREFIX . 'filter-bar';
				$random_id = $class . '-' . PT_CV_Functions::string_random();

				// Margin bottom
				$margin_bottom = $filter_settings['margin-bottom'];
				if ( ! empty( $margin_bottom ) ) {
					$custom_css = sprintf( '#%s {margin-bottom: %spx !important}', $random_id, $margin_bottom );
					printf( PT_CV_Html::inline_style( $custom_css ) );
				}

				// Style
				$style = 'none';

				// Show Filter bar for each Taxonomy
				$output = array();

				if ( $filter_settings['type'] != 'group_by_taxonomy' ) {
					// Get position
					$position = $filter_settings['position'];

					switch ( $position ) {
						case 'left':
							$class .= ' pull-left';
							break;
						case 'center':
							$class .= ' ' . PT_CV_PREFIX . 'center';
							break;
						case 'right':
							$class .= ' pull-right';
							break;
					}

					foreach ( $selected_terms_of_taxonomies as $selected_terms ) {
						switch ( $filter_settings['type'] ) {
							case 'btn-group':
								// Custom css
								$space      = $filter_settings['space'];
								$custom_css = sprintf( '#%s .btn {margin-right: %spx}', $random_id, $space );
								printf( PT_CV_Html::inline_style( $custom_css ) );

								$output[] = PT_CV_Html_Pro::filter_html_btn_group( $class, $selected_terms, $random_id, $style );
								break;
							case 'breadcrumb':
								$output[] = PT_CV_Html_Pro::filter_html_breadcrumb( $class, $selected_terms, $random_id );
								break;
							case 'vertical-dropdown':
								$output[] = PT_CV_Html_Pro::filter_html_vertical_dropdown( $class, $selected_terms, $random_id, $style );
								break;
						}
					}
				} else {
					$class .= ' ' . PT_CV_PREFIX . 'filter-group';

					// Group options by Taxonomy
					list( $columns, $span_width_last, $span_width, $span_class, $row_class ) = PT_CV_Html_ViewType::process_column_width( $selected_terms_of_taxonomies );

					// Get all current taxonomies
					$all_taxonomies = PT_CV_Values::taxonomy_list();

					$row_html = array();
					foreach ( $selected_terms_of_taxonomies as $taxonomy => $terms ) {
						$column_html = array();

						// Column header
						$filter_title_class = apply_filters( PT_CV_PREFIX_ . 'shuffle_title_class', PT_CV_PREFIX . 'filter-title' );
						$column_html[]      = sprintf( '<h2 class="%s">%s</h2>', esc_attr( $filter_title_class ), esc_html( $all_taxonomies[$taxonomy] ) );

						// Column body: list of terms
						$terms_html = array();

						$all_text = __( 'All', PT_CV_DOMAIN_PRO );
						$terms    = array( 'all' => $all_text ) + $terms;

						foreach ( $terms as $term => $name ) {
							$terms_html[] = sprintf( '<li><a href="#" data-value="%s">%s</a></li>', esc_attr( $term ), esc_html( $name ) );
						}
						$column_html[] = sprintf( '<ul>%s</ul>', balanceTags( implode( "\n", $terms_html ) ) );

						// Get HTML of each column
						$row_html[] = sprintf( '<div class="%s">%s</div>', esc_attr( $span_class . $span_width ), balanceTags( implode( "\n", $column_html ) ) );
					}

					// Wrap columns of Taxonomies group to a row
					$output[] = sprintf( '<div class="%s">%s</div>', esc_attr( $row_class . ' ' . $class ), balanceTags( implode( "\n", $row_html ) ) );
				}

				$args = implode( '', $output );
			}

			return $args;
		}

		/**
		 * Show data-type of each post
		 *
		 * @param string $args    The output HTML
		 * @param string $post_id The post ID
		 *
		 * @return string
		 */
		public static function filter_content_item_filter_value( $args, $post_id ) {
			global $pt_post_terms;

			global $pt_cv_enable_filter;

			// Get data-id for current post
			global $pt_view_sid;
			$session_id = $pt_view_sid;

			$data_id = 0;
			if ( $session_id ) {
				$data_id = ( false === ( $saved_data_id = get_transient( PT_CV_PREFIX . 'view-data-id-' . $session_id ) ) ) ? $data_id : $saved_data_id;
			}

			// Increase data id by 1
			$data_id += 1;

			// Store data id for next item
			set_transient( PT_CV_PREFIX . 'view-data-id-' . $session_id, $data_id, 30 * MINUTE_IN_SECONDS );

			// Enable filter
			if ( $pt_cv_enable_filter == 'yes' ) {
				// Get terms of post
				if ( ! isset( $pt_post_terms[$post_id] ) ) {
					PT_CV_Functions::post_terms( $post_id );
				}
				$terms_of_post = isset( $pt_post_terms[$post_id] ) ? $pt_post_terms[$post_id] : array();

				$args = sprintf( 'data-type="%s" data-id="%s"', implode( ' ', array_keys( $terms_of_post ) ), esc_attr( $data_id ) );
			}

			return $args;
		}

		/**
		 * Filter $content_items variable before display
		 *
		 * @param type $args
		 */
		public static function filter_content_items( $args ) {

			global $pt_cv_enable_filter, $pt_query_args;

			// Enable filter
			if ( $pt_cv_enable_filter == 'yes' ) {
				// If not order by, shuffle items to have a nice filter animation
				if ( ! isset( $pt_query_args['orderby'] ) ) {
					$args = PT_CV_Functions_Pro::shuffle_assoc( $args );
				}
			}

			return $args;
		}

		/**
		 * Filter span with
		 *
		 * @param int $args
		 * @param int $span_width
		 *
		 * @return int
		 */
		public static function filter_item_col_class( $args, $span_width ) {
			$span_width_sm = PT_CV_Functions_Pro::get_sm_width( $span_width );
			$span_width_xs = PT_CV_Functions_Pro::get_xs_width( $span_width );

			$args[] = 'col-sm-' . $span_width_sm;

			// $args[] = 'col-xs-' . $span_width_xs;

			return $args;
		}

		/**
		 * Exclude sticky posts completely
		 *
		 * @param int   $args
		 * @param array $settings The settings array of View
		 *
		 * @return int
		 */
		public static function filter_post__not_in( $args, $settings ) {

			$exclude = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'exclude-sticky-posts', $settings );

			if ( ! empty( $exclude ) && $exclude == 'yes' ) {
				$args = (array) $args + get_option( 'sticky_posts' );
			}

			return $args;
		}

		/**
		 * Filter parent page ID
		 *
		 * @param array $args
		 */
		public static function filter_post_parent_id( $args ) {
			global $post, $pt_view_settings, $pt_cv_page_parent, $pt_cv_page_current;

			// Current page of WP front-end
			$pt_cv_page_current = 0;

			if ( $post && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post_parent-auto', $pt_view_settings ) ) {
				$args = ! empty( $post->post_parent ) ? $post->post_parent : $post->ID;
				$pt_cv_page_current = $post->ID;
			}

			// Parent page ID
			$pt_cv_page_parent = $args;

			return $args;
		}

		/**
		 * Show this post or not
		 *
		 * @param array $args
		 * @return array
		 */
		public static function filter_show_this_post( $args ) {
			// Current page of WP front-end
			global $pt_cv_page_current;

			// If this post is same as current page, hide it
			if ( ! empty( $pt_cv_page_current ) && $args == $pt_cv_page_current ) {
				$args = 0;
			}

			return $args;
		}

		/**
		 * Filter by multiple terms
		 *
		 * @param array $args
		 * @return array
		 */
		public static function filter_search_terms( $args ) {
			$args = strpos( $args, '+' ) !== false ? explode( '+', $args ) : $args;

			return $args;
		}

		/**
		 * Customize value of Style Settings
		 *
		 * @param array $args
		 */
		public static function filter_style_settings_data( $args ) {
			global $animation_settings;
			if ( isset( $animation_settings['content-hover'] ) ) {
				$args['bgcolor-content'] = ! empty( $args['bgcolor-content'] ) ? $args['bgcolor-content'] : '#fcfcfc';
			}

			return $args;
		}

		/**
		 * Filter taxonomy query parameters
		 * [pt_view id="A" cat="foo,bar,content"]
		 * [pt_view id="A" tag="foo,bar,content"]
		 * [pt_view id="A" cat="1,2,3"]
		 * [pt_view id="A" tag="1,2,3"]
		 * [pt_view id="A" taxonomy="testimonial" terms="foo,bar"]
		 * [pt_view id="A" taxonomy="testimonial" terms="foo,bar" operator="NOT IN"] operator: in/IN, and/AND, not in/NOT IN
		 *
		 * @param array $args
		 *
		 * @return int
		 */
		public static function filter_taxonomy_setting( $args ) {
			global $pt_cv_shortcode_params;

			if ( ! $pt_cv_shortcode_params ) {
				return $args;
			}

			// Store taxonomy filter query parameters
			$filter_taxonomy = array();

			// Filter by category
			if ( ! empty( $pt_cv_shortcode_params['cat'] ) ) {
				// Filter by category
				$taxonomy = 'category';
				$terms    = explode( ',', preg_replace( '/\s+/', '', $pt_cv_shortcode_params['cat'] ) );
			} else {
				if ( ! empty( $pt_cv_shortcode_params['tag'] ) ) {
					// Filter by tag
					$taxonomy = 'post_tag';
					$terms    = explode( ',', preg_replace( '/\s+/', '', $pt_cv_shortcode_params['tag'] ) );
				} else {
					if ( ! empty( $pt_cv_shortcode_params['taxonomy'] ) ) {
						// Filter by custom taxonomy
						$taxonomy = esc_sql( $pt_cv_shortcode_params['taxonomy'] );
						$terms    = explode( ',', preg_replace( '/\s+/', '', $pt_cv_shortcode_params['terms'] ) );
					}
				}
			}

			// Only filter if $taxonomy & $terms are configed
			if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
				$terms_check = array_map( 'intval', $terms );
				$field       = ( $terms_check[0] != 0 ) ? 'id' : 'slug';

				$filter_taxonomy = array(
					'taxonomy' => $taxonomy,
					'field'    => $field,
					'terms'    => (array) $terms,
				);

				// Get join operator
				$filter_taxonomy['operator'] = strtoupper( ! empty( $pt_cv_shortcode_params['operator'] ) ? $pt_cv_shortcode_params['operator'] : 'IN' );
				if ( ! in_array( $filter_taxonomy['operator'], array( 'IN', 'NOT IN', 'AND' ) ) ) {
					$filter_taxonomy['operator'] = 'IN';
				}

				// Overwrite tax_query
				$args['tax_query'] = array( $filter_taxonomy );
			}

			return $args;
		}

		/**
		 * Do custom action when generate view output
		 *
		 * @param string $view_id The unique id of view
		 */
		public static function action_store_view_data( $view_id ) {
			global $dargs, $pt_cv_view_data;

			$pt_cv_view_data[$view_id] = array(
				'view-style' => isset( $dargs['view-style'] ) ? $dargs['view-style'] : array(),
			);
		}

		/**
		 * Print style of views
		 */
		public static function action_print_view_style() {

			global $pt_cv_view_data;

			if ( ! $pt_cv_view_data ) {
				return '';
			}

			foreach ( $pt_cv_view_data as $view_id => $data ) {
				if ( isset( $data['view-style'] ) ) {
					$style_fonts = PT_CV_Html_Pro::view_styles( $view_id, $data['view-style'] );

					// Print inline style (font family, font style, font size...)
					if ( ! empty( $style_fonts['css'] ) ) {
						printf( PT_CV_Html::inline_style( $style_fonts['css'] ) );
					}

					// Attach link of google fonts if have
					if ( $style_fonts && is_array( $style_fonts['links'] ) ) {
						foreach ( $style_fonts['links'] as $link ) {
							printf( "<link href='http://fonts.googleapis.com/css?family=%s' rel='stylesheet' type='text/css'>", $link );
						}
					}
				}
			}
		}

		/**
		 * Filter before run : new WP_Query( $args )
		 *
		 */
		public static function action_before_query() {
			global $pt_view_settings;

			// Get content type
			$content_type = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'content-type', $pt_view_settings );

			if ( $content_type == 'product' ) {
				$products_list = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'products-list', $pt_view_settings );
				if ( $products_list == 'top_rated_products' ) {
					add_filter( 'posts_clauses', array( 'PT_CV_WooCommerce', 'order_by_rating_post_clauses' ) );
				}
			}
		}

		/**
		 * Filter after run : new WP_Query( $args )
		 *
		 */
		public static function action_after_query() {
			global $pt_view_settings;

			// Get content type
			$content_type = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'content-type', $pt_view_settings );

			if ( $content_type == 'product' ) {
				$products_list = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'products-list', $pt_view_settings );
				if ( $products_list == 'top_rated_products' ) {
					remove_filter( 'posts_clauses', array( 'PT_CV_WooCommerce', 'order_by_rating_post_clauses' ) );
				}
			}
		}

		/**
		 * Add custom global variables
		 */
		public static function action_add_global_variables() {
			global $pt_view_settings, $pt_cv_enable_filter;

			$prefix              = 'taxonomy-filter';
			$pt_cv_enable_filter = isset( $pt_view_settings[PT_CV_PREFIX . 'enable-' . $prefix] ) ? $pt_view_settings[PT_CV_PREFIX . 'enable-' . $prefix] : '';
		}

		/**
		 * Handle more tag bug (if show Full content, will see more tag in Preview, but not in front-end)
		 */
		public static function action_handle_teaser() {
			global $more;
			$more = 0;
		}
	}

}
