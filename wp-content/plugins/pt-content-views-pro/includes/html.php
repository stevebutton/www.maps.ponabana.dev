<?php
/**
 * HTML output, class, id generating
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

if ( ! class_exists( 'PT_CV_Html_Pro' ) ) {

	/**
	 * @name PT_CV_Html_Pro
	 * @todo related HTML functions: Define HTML layout, Set class name...
	 */
	class PT_CV_Html_Pro {

		static $filter_item_class = 'filter-option';

		/**
		 * Scripts for Preview & WP frontend
		 */
		static function frontend_scripts() {

			// Public script
			PT_CV_Asset::enqueue(
				'public-pro', 'script', array(
					'src'  => plugins_url( 'public/assets/js/public.js', PT_CV_FILE_PRO ),
					'deps' => array( 'jquery' ),
					'ver'  => PT_CV_VERSION_PRO,
				)
			);

			// Lightbox

			// Get settings option
			$options = get_option( PT_CV_OPTION_NAME );

			if ( is_admin() || ! isset( $options['unload_colorbox'] ) ) {
				PT_CV_Asset::enqueue(
					'colorbox', 'script', array(
						'src' => plugins_url( 'assets/colorbox/colorbox.min.js', PT_CV_FILE_PRO ),
						'ver' => '1.5.9',
					)
				);
			}

			// Wookmark js
			PT_CV_Asset::enqueue(
				'wookmark', 'script', array(
					'src' => plugins_url( 'assets/wookmark/wookmark.min.js', PT_CV_FILE_PRO ),
					'ver' => '1.4.6',
				)
			);

			// Masonry js
			PT_CV_Asset::enqueue(
				'masonry', 'script', array(
					'src' => plugins_url( 'assets/masonry/masonry.min.js', PT_CV_FILE_PRO ),
					'ver' => '3.1.5',
				)
			);

			// Quicksand
			PT_CV_Asset::enqueue(
				'quicksand', 'script', array(
					'src' => plugins_url( 'assets/quicksand/jquery.quicksand.js', PT_CV_FILE_PRO ),
					'ver' => '1.4',
				)
			);

			// Livequery
			PT_CV_Asset::enqueue(
				'livequery', 'script', array(
					'src' => plugins_url( 'assets/livequery/jquery.livequery.min.js', PT_CV_FILE_PRO ),
					'ver' => '1.3.6',
				)
			);
		}

		/**
		 * Styles for Preview & WP frontend
		 */
		static function frontend_styles() {

			// Public style (some small line of codes are printed directly below)
			PT_CV_Asset::enqueue(
				'public-pro', 'style', array(
					'src' => plugins_url( 'public/assets/css/public.css', PT_CV_FILE_PRO ),
					'ver' => PT_CV_VERSION_PRO,
				)
			);

			// Lightbox

			// Get settings option
			$options = get_option( PT_CV_OPTION_NAME );

			if ( is_admin() || ! isset( $options['unload_colorbox'] ) ) {
				PT_CV_Asset::enqueue(
					'colorbox', 'style', array(
						'src' => plugins_url( 'assets/colorbox/colorbox.min.css', PT_CV_FILE_PRO ),
						'ver' => '1.5.4',
					)
				);
			}
		}

		/**
		 * Initialize global variable to store view data
		 */
		static function init_view_data() {
			global $pt_cv_view_data;
			$pt_cv_view_data = array();
		}

		/**
		 * Generate style for view with view id and font settings
		 *
		 * @param string $view_id     The unique id of view
		 * @param array  $view_styles The style settings of this view
		 *
		 * @return string The css of this view
		 */
		static function view_styles( $view_id, $view_styles ) {
			if ( ! isset( $view_styles['font'] ) ) {
				return '';
			}

			// Output Css
			$css = array();

			// Store link to google fonts
			$font_links = array();

			// Generate CSS of margin settings
			self::_style_margin( $view_id, $view_styles['margin'], $css );

			// Generate CSS of font settings
			$style_settings = apply_filters( PT_CV_PREFIX_ . 'style_settings_data', $view_styles['font'] );
			self::_style_font( $view_id, $style_settings, $css, $font_links );

			// Border radius
			if ( ! empty( $view_styles['border-radius'] ) ) {
				$border_radius = $view_styles['border-radius'];
				$css[]         = sprintf( '#%1$s .img-rounded { -webkit-border-radius: %2$spx %3$s; -moz-border-radius: %2$spx %3$s; border-radius: %2$spx %3$s; }', $view_id, (int) $border_radius, '!important' );
			}

			// Image custom size
			if ( ! empty( $view_styles['image-sizes'] ) ) {
				$dimensions = $view_styles['image-sizes'];
				$css[]      = sprintf( '#%1$s img, #%1$s iframe { width: %2$spx %4$s; height: %3$spx %4$s; }', $view_id, (int) $dimensions[0], (int) $dimensions[1], '!important' );
			}

			// Other styles
			if ( isset( $view_styles['others'] ) ) {
				$other_styles = $view_styles['others'];

				// Text align
				if ( ! empty( $other_styles['text-align'] ) ) {
					$css[] = sprintf( '#%s { text-align: %s; }', $view_id, $other_styles['text-align'] );
				}
			}

			return array(
				'css'   => implode( "\n", $css ),
				'links' => $font_links,
			);
		}

		/**
		 * Generate CSS of margin settings
		 *
		 * @param string $view_id The unique id of view
		 * @param array  $margin  The margin settings of this view
		 * @param type   $css     Store generated CSS
		 */
		static function _style_margin( $view_id, $margin, &$css ) {

			$options = array( 'top', 'left', 'bottom', 'right' );

			$margin_css = array();

			foreach ( $options as $option ) {
				if ( ! empty( $margin[$option] ) ) {
					$margin_css[] = sprintf( 'margin-%s: %spx !important;', $option, $margin[$option] );
				}
			}

			$css[] = sprintf( '#%s { %s }', $view_id, implode( ' ', $margin_css ) );
		}

		/**
		 * Generate CSS for font settings
		 *
		 * @param string $view_id    The unique id of view
		 * @param array  $fonts_data The font settings of this view
		 * @param type   $css        Store generated CSS
		 * @param type   $font_links Store generated font link to including
		 */
		static function _style_font( $view_id, $fonts_data, &$css, &$font_links ) {

			$properties = array( 'family', 'style', 'size', 'color', 'bgcolor' );

			// CSS selector for each field
			$view_related_selector = '#' . $view_id . ' ';
			$fields_selectors      = array(
				'title'         => 'a',
				'content'       => '',
				'meta-fields'   => '*:not(.glyphicon)',
				'custom-fields' => '*',
				'readmore'      => '',
				'more'          => array( '', $view_related_selector . ' + ' . '.' . PT_CV_PREFIX . 'pagination-wrapper' . ' ' ),
				'filter-bar'    => array( '*, .' . PT_CV_PREFIX . 'filter-title', '', 'append_selector' => ':not(.' . PT_CV_PREFIX . 'filter-group' . '):not(.breadcrumb)' ),
			);
			$fields                = array_keys( $fields_selectors );

			// Css properties of fields
			$fields_css = array();

			$font_css = array();

			// Get properties of fields from settings array
			foreach ( $fields as $field ) {
				foreach ( $properties as $property ) {
					if ( ! empty( $fonts_data["$property-$field"] ) ) {
						$fields_css[$field][$property] = $fonts_data["$property-$field"];
					}
				}
			}

			// Generate output font Css for fields
			foreach ( $fields as $field ) {
				$field_css = array();
				foreach ( $properties as $property ) {
					if ( ! empty( $fields_css[$field][$property] ) ) {
						switch ( $property ) {
							// Font family
							case 'family':
								$field_css[] = sprintf( "font-family: '%s', Arial, serif", $fields_css[$field][$property] );
								break;

							// Font style
							case 'style':
								$style = $fields_css[$field][$property];

								$font_weight = '400';
								$font_style  = 'normal';

								if ( $style === 'regular' ) {
								} else {
									if ( $style === 'italic' ) {
										$font_style = 'italic';
									} else {
										$font_style_ = substr( $style, - 6 );

										if ( $font_style_ === 'italic' ) {
											$font_weight = substr( $style, 0, strlen( $style ) - 6 );
											$font_style  = 'italic';
										} else {
											$font_weight = $style;
										}
									}
								}

								$field_css[] = sprintf( 'font-style: %s', $font_style );
								$field_css[] = sprintf( 'font-weight: %s', $font_weight );

								break;

							// Font size
							case 'size':
								$font_size   = (int) $fields_css[$field][$property];
								$field_css[] = sprintf( 'font-size: %spx', $font_size );

								// Auto add line-height if font-size >= 40
								if ( $font_size >= 40 ) {
									$field_css[] = sprintf( 'line-height: %spx', $font_size );
								}

								break;

							// Font color
							case 'color':
								$field_css[] = sprintf( 'color: %s', $fields_css[$field][$property] );
								break;

							// Background color
							case 'bgcolor':
								$field_css[] = sprintf( 'background: %s', $fields_css[$field][$property] );
								break;
						}
					}
				}

				// Force important to preventing overwritten by other styles
				foreach ( $field_css as $idx => $value ) {
					$field_css[$idx] = $value . ' !important;';
				}

				$field_selector   = (array) $fields_selectors[$field];
				$append_selector  = ! empty( $field_selector['append_selector'] ) ? $field_selector['append_selector'] : '';
				$font_css[$field] = sprintf( '.' . PT_CV_PREFIX . '%s %s { %s }', $field . $append_selector, $field_selector[0], implode( ' ', $field_css ) );

			}

			// Prepend view id to each css property
			foreach ( $font_css as $field => $value ) {
				$field_selector   = (array) $fields_selectors[$field];
				$prepend_selector = isset( $field_selector[1] ) ? $field_selector[1] : $view_related_selector;

				$css[] = $prepend_selector . $value;
			}

			// Generate font links
			foreach ( $fields as $field ) {
				$font_link = '';

				if ( ! empty( $fields_css[$field]['family'] ) ) {
					$font_link .= $fields_css[$field]['family'];
				}
				if ( ! empty( $font_link ) && ! empty( $fields_css[$field]['style'] ) ) {
					$font_link .= ':' . $fields_css[$field]['style'];
				}

				if ( ! empty( $font_link ) ) {
					$font_links[] = $font_link;
				}
			}
		}

		/**
		 * Filter output: buttons group
		 *
		 * @param string $class The wrapper class of group
		 * @param array  $items The content of buttons
		 * @param string $id    The ID of filter group
		 * @param string $style The style class of buttons
		 *
		 * @return string
		 */
		static function filter_html_btn_group( $class, $items, $id = 'sample', $style = 'primary' ) {
			$items_html = array();

			$all_text = __( 'All', PT_CV_DOMAIN_PRO );
			$items    = array( 'all' => $all_text ) + $items;

			$idx = 0;
			foreach ( $items as $key => $text ) {
				$items_html[] = sprintf( '<button type="button" class="btn btn-%s %s" data-value="%s">%s</button>', esc_attr( $style ), PT_CV_PREFIX . self::$filter_item_class . ' ' . ( ( $idx == 0 ) ? 'active' : '' ), esc_attr( $key ), $text );
				$idx ++;
			}
			$output = sprintf( '<div class="btn-group %s" id="%s">%s</div>', esc_attr( $class ), esc_attr( $id ), implode( '', $items_html ) );

			return $output;
		}

		/**
		 * Generate HTML output for array of items
		 *
		 * @param array $items Array of item
		 *
		 * @return array
		 */
		static function _filter_list( $items ) {
			$items_html = array();

			$all_text = __( 'All', PT_CV_DOMAIN_PRO );
			$items    = array( 'all' => $all_text ) + $items;

			$idx = 0;
			foreach ( $items as $key => $text ) {
				$items_html[] = sprintf( '<li class="%s"><a class="%s" href="#" data-value="%s">%s</a></li>', ( $idx == 0 ) ? 'active' : '', PT_CV_PREFIX . self::$filter_item_class, esc_attr( $key ), $text );
				$idx ++;
			}

			return $items_html;
		}

		/**
		 * Filter output: Breadcrumb
		 *
		 * @param string $class The wrapper class of group
		 * @param array  $items The content of buttons
		 *
		 * @return string
		 */
		static function filter_html_breadcrumb( $class, $items, $id = 'sample' ) {
			$items_html = self::_filter_list( $items );
			$output     = sprintf( '<ol class="breadcrumb %s" id="%s">%s</ol>', esc_attr( $class ), esc_attr( $id ), implode( '', $items_html ) );

			return $output;
		}

		/**
		 * Filter output: Vertical dropdown
		 *
		 * @param string $class The wrapper class of group
		 * @param array  $items The content of buttons
		 * @param type   $id    The ID of filter bar
		 * @param type   $style The style class of buttons
		 *
		 * @return string
		 */
		static function filter_html_vertical_dropdown( $class, $items, $id = 'dropdownMenu1', $style = 'primary' ) {
			$all_text = __( 'All', PT_CV_DOMAIN_PRO );

			$items_html = self::_filter_list( $items );
			$output     = sprintf(
				'<div class="dropdown btn-group %1$s" id="%2$s">
				<button class="btn btn-%3$s dropdown-toggle" type="button" data-toggle="dropdown">%4$s<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
				%5$s
				</ul>
			</div>', esc_attr( $class ), esc_attr( $id ), esc_attr( $style ), $all_text, implode( '', $items_html )
			);

			return $output;
		}
	}

}