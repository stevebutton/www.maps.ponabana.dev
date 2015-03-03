<?php
/**
 * Contain main functions to work with plugin, post, custom fields...
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

if ( ! class_exists( 'PT_CV_Functions_Pro' ) ) {

	/**
	 * @name PT_CV_Functions_Pro
	 * @todo Utility functions
	 */
	class PT_CV_Functions_Pro {

		/**
		 * Check if current user has role to manage Views
		 */
		static function check_user_role() {
			// Check user role
			$user_can = 0;
			if ( current_user_can( 'administrator' ) ) {
				$user_can = 1;
			} else {
				// Get settings option
				$options = get_option( PT_CV_OPTION_NAME );

				// Get required user role to manage Views
				$required_role = ! isset( $options['access_role'] ) ? 'edit_posts' : $options['access_role'];

				$user_can = current_user_can( $required_role );
			}

			return $user_can;
		}

		/**
		 * Get thumbnail dimensions
		 *
		 * @param array $fargs The settings of thumbnail
		 *
		 * @return array
		 */
		static function field_thumbnail_dimensions( $fargs ) {
			$dimensions = array( 0, 0 );

			switch ( $fargs['size'] ) {
				case PT_CV_PREFIX . 'custom':
					$dimensions = array( (int) $fargs['size-custom-width'], (int) $fargs['size-custom-height'] );
					break;
			}

			return $dimensions;
		}

		/**
		 * Convert $options array to array with: key as 'name' of each parameter, value as settings of that parameters
		 *
		 * @param string $prefix  The prefix in name of settings
		 * @param array  $options The options array (contain full paramaters of settings)
		 */
		static function settings_pre_sort( $options ) {
			$result = array();
			foreach ( $options as $option ) {
				if ( $option['params'] ) {
					foreach ( $option['params'] as $params ) {
						// If name of setting match with prefix string, add new value is $option with key is that name
						if ( isset( $params['name'] ) ) {
							$result[PT_CV_PREFIX . $params['name']] = $option;
						}
					}
				}
			}

			return $result;
		}

		/**
		 * Sort $options array by the order of key in $settings_key array
		 *
		 * @param string $prefix       The prefix in name of settings
		 * @param array  $options      The options array (contain full paramaters of settings)
		 * @param array  $settings_key The array of settings key
		 */
		static function settings_sort( $prefix, $options, $settings_key ) {
			if ( ! $settings_key ) {
				return $options;
			}

			$result = array();

			$options = self::settings_pre_sort( $options );

			foreach ( $settings_key as $setting ) {
				// If name of setting match with prefix string, got it name
				if ( isset( $options[$setting] ) && substr( $setting, 0, strlen( $prefix ) ) === $prefix ) {
					$result[$setting] = $options[$setting];
					unset( $options[$setting] );
				}
			}

			// Append key which is not in $settings_key to beginning of $result
			$result = array_merge( $options, $result );

			return $result;
		}

		/**
		 * Read top Google fonts
		 *
		 * @return array
		 */
		static function get_google_fonts() {
			// Limit top 50 fonts
			$limit     = 50;
			$font_data = array();

			// Google fonts data file
			$file_path = plugin_dir_path( PT_CV_FILE_PRO ) . 'admin/includes/google-fonts.data';

			if ( file_exists( $file_path ) ) {
				$fp = @fopen( $file_path, 'r' );

				// Read all fonts data
				$contents = '';
				while ( ! feof( $fp ) ) {
					$contents .= fread( $fp, 8192 );
				}

				$data  = json_decode( $contents, true );
				$items = isset( $data['items'] ) ? $data['items'] : array();

				// Get top fonts
				$top_fonts = array_slice( (array) $items, 0, $limit );

				// Get font family, variants

				foreach ( $top_fonts as $font ) {
					$font_data[$font['family']] = $font['variants'];
				}

				fclose( $fp );
			}

			return $font_data;
		}

		/**
		 * Generate background position for each Google font
		 */
		static function get_google_fonts_background_position() {

			$css = array();

			// Get font list
			$fonts_list = PT_CV_Values_Pro::font_families();
			$fonts_name = array_keys( $fonts_list );

			// Set background for each font by font name
			foreach ( $fonts_name as $idx => $name ) {
				$css[] = sprintf( '.select2-results li.%s { background-position: 0 -%spx }', PT_CV_PREFIX . 'font-' . sanitize_title( $name ), ( 40 * $idx + 10 ) );
			}

			return implode( "\n", $css );
		}

		/**
		 * Get selected terms or all terms of selected taxonomies
		 *
		 * @global array $pt_query_args
		 *
		 * @param array  $taxonomies_to_get Array of taxonomies
		 *
		 * @return array
		 */
		public static function get_selected_terms( $taxonomies_to_get ) {
			global $pt_query_args;

			$terms_info = isset( $pt_query_args['tax_query'] ) ? $pt_query_args['tax_query'] : array();
			if ( isset( $terms_info['relation'] ) ) {
				unset( $terms_info['relation'] );
			}

			// Get all terms of selected taxonomy
			$terms_of_taxonomies = array();
			foreach ( $taxonomies_to_get as $taxonomy ) {
				PT_CV_Values::term_of_taxonomy( $taxonomy, $terms_of_taxonomies );
			}

			// If select some terms in one/some taxonomy
			if ( $terms_info ) {
				foreach ( $terms_info as $term_info ) {
					if ( is_array( $term_info['terms'] ) ) {
						// If "NOT IN" this list
						if ( $term_info['operator'] == 'NOT IN' ) {
							foreach ( $term_info['terms'] as $term_slug ) {
								unset( $terms_of_taxonomies[$term_info['taxonomy']][$term_slug] );
							}
						} else {
							$all_terms_of_taxo = $terms_of_taxonomies[$term_info['taxonomy']];
							unset( $terms_of_taxonomies[$term_info['taxonomy']] );
							foreach ( $term_info['terms'] as $term_slug ) {
								$terms_of_taxonomies[$term_info['taxonomy']][$term_slug] = $all_terms_of_taxo[$term_slug];
							}
						}
					}
				}
			}

			return $terms_of_taxonomies;
		}

		/**
		 * Get column width (col-sm-*) for Small devices Tablets (>=768px)
		 *
		 * @param int $md_span
		 *
		 * @return int
		 */
		static function get_sm_width( $md_span ) {
			// Always display an even number of items per row in smaller device (to remove gap/space in rows)
			return ( $md_span <= 6 ) ? 6 : 12;
		}

		/**
		 * Get column width (col-xs-*) for Extra small devices (<768px)
		 *
		 * @param int $md_span
		 *
		 * @return int
		 */
		static function get_xs_width( $md_span ) {

			return ( $md_span <= 6 ) ? 6 : 12;
		}

		/**
		 * Shuffle array but reserver keys
		 *
		 * @param array $array The array to shuffle
		 *
		 * @return array
		 */
		static function shuffle_assoc( $array ) {
			// Initialize
			$shuffled_array = array();


			// Get array's keys and shuffle them.
			$shuffled_keys = array_keys( $array );
			shuffle( $shuffled_keys );


			// Create same array, but in shuffled order.
			foreach ( $shuffled_keys AS $shuffled_key ) {

				$shuffled_array[$shuffled_key] = $array[$shuffled_key];
			} // foreach
			// Return
			return $shuffled_array;
		}

		/**
		 * Overwrite output of WordPress template file
		 * // replace while ... endwhile; by line below:
		 * echo PT_CV_Functions_Pro::view_overwrite_tpl( '6f75e9b246' );
		 *
		 * @global object $post
		 *
		 * @param int     $id The View ID
		 * @param array   $posts The array of posts (ID or object)
		 */
		static function view_overwrite_tpl( $id, $posts = array() ) {

			// Get View settings
			global $pt_view_settings;
			$pt_view_settings = PT_CV_Functions::view_get_settings( $id );

			// Get view type
			$view_type = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'view-type', $pt_view_settings );

			// Setup global variables for display
			global $dargs;
			$dargs = PT_CV_Functions::view_display_settings( $view_type );

			// Filter
			$dargs = apply_filters( PT_CV_PREFIX_ . 'all_display_settings', $dargs );

			// Store HTML output of each item
			$content_items = array();

			if ( $posts ) {
				foreach ( $posts as $post ) {
					if ( is_object( $post ) ) {
						setup_postdata( $post );
						// Output HTML for this item
						$content_items[$post->ID] = PT_CV_Html::view_type_output( $view_type, $post );
					}
				}
			} else {
				// The Loop
				while ( have_posts() ) : the_post();

					global $post;

					// Output HTML for this item
					$content_items[$post->ID] = PT_CV_Html::view_type_output( $view_type, $post );

				endwhile;
			}

			// Filter array of items
			$content_items = apply_filters( PT_CV_PREFIX_ . 'content_items', $content_items );

			$html = PT_CV_Html::content_items_wrap( $content_items, 1, count( $content_items ), $id );

			// Clear to prevent the element to shift up in the remaining space
			$html .= sprintf( '<div style="clear: both;"></div>' );

			return $html;
		}

		/**
		 * Get width, height of a size name (thumbnail, full, custom-size...)
		 *
		 * @global type  $_wp_additional_image_sizes
		 *
		 * @param string $size_name The size name
		 *
		 * @return array
		 */
		static function get_dimensions_of_size( $size_name ) {
			// All available thumbnail sizes
			global $_wp_additional_image_sizes;

			$this_size = array();
			if ( in_array( $size_name, array( 'thumbnail', 'medium', 'large' ) ) ) {
				$this_size[] = get_option( $size_name . '_size_w' );
				$this_size[] = get_option( $size_name . '_size_h' );
			} else {
				if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[$size_name] ) ) {
					$this_size['width']  = $_wp_additional_image_sizes[$size_name]['width'];
					$this_size['height'] = $_wp_additional_image_sizes[$size_name]['height'];
				} else {
					$this_size = array( 0, 0 );
				}
			}

			return $this_size;
		}

		/**
		 * Filter by date
		 *
		 * @param array $args
		 */
		static function filter_by_date( &$args ) {
			global $pt_view_settings;

			$advanced_settings = (array) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'advanced-settings', $pt_view_settings );

			if ( in_array( 'date', $advanced_settings ) ) {
				$date_fields = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . 'post_date_' );
				if ( $date_fields ) {
					// Get filter value
					$date_value = isset( $date_fields['value'] ) ? $date_fields['value'] : '';
					if ( $date_value ) {
						$date_query = array();

						switch ( $date_value ) {
							case 'today':
								$date       = getdate();
								$date_query = array(
									'year'  => $date['year'],
									'month' => $date['mon'],
									'day'   => $date['mday'],
								);
								break;

							case 'yesterday':
								$today     = date( 'm/d/Y' );
								$yesterday = date( 'm/d/Y', strtotime( '-1 day', strtotime( $today ) ) );
								$date      = date_parse( $yesterday );

								$date_query = array(
									'year'  => $date['year'],
									'month' => $date['month'],
									'day'   => $date['day'],
								);
								break;

							case 'this_week':
								$date_query = array(
									'year' => date( 'Y' ),
									'week' => date( 'W' ),
								);
								break;

							case 'this_month':
								$date_query = array(
									'year'  => date( 'Y' ),
									'month' => date( 'n' ),
								);
								break;

							case 'this_year':
								$date_query = array(
									'year' => date( 'Y' ),
								);
								break;

							// Time Ago
							case 'week_ago':
							case 'month_ago':
							case 'year_ago':
								$date_query = array(
									'column' => 'post_date',
									'after'  => sprintf( '1 %s ago', str_replace( '_ago', '', $date_value ) ),
								);
								break;

							// Custom date
							case 'custom_date':
								if ( $date = date_parse( $date_fields['custom_date'] ) ) {
									$date_query = array(
										'year'  => $date['year'],
										'month' => $date['month'],
										'day'   => $date['day'],
									);
								}
								break;

							// Custom From - To
							case 'custom_time':
								$from = date_parse( $date_fields['from'] );
								$to   = date_parse( $date_fields['to'] );

								if ( $from && $to ) {
									$date_query = array(
										'after'     => array(
											'year'  => $from['year'],
											'month' => $from['month'],
											'day'   => $from['day'],
										),
										'before'    => array(
											'year'  => $to['year'],
											'month' => $to['month'],
											'day'   => $to['day'],
										),
										'inclusive' => true,
									);
								}
								break;
						}

						if ( $date_query ) {
							$args['date_query'] = array( $date_query );
						}
					}
				}
			}
		}
	}

}