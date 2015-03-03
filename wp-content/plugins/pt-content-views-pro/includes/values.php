<?php
/**
 * Define values for input, select...
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

if ( ! class_exists( 'PT_CV_Values_Pro' ) ) {

	/**
	 * @name PT_CV_Values_Pro
	 * @todo Define values for input, select...
	 */
	class PT_CV_Values_Pro {

		/**
		 * Get Bootstrap styles for thumbnail
		 */
		static function field_thumbnail_styles() {

			// All available thumbnail sizes
			$result = array(
				'img-none'      => __( 'No style', PT_CV_DOMAIN_PRO ),
				'img-rounded'   => __( 'Rounded', PT_CV_DOMAIN_PRO ),
				'img-thumbnail' => __( 'Thumbnail', PT_CV_DOMAIN_PRO ),
				'img-circle'    => __( 'Circle', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}

		/**
		 * Style color for button
		 *
		 * @param array $text
		 *
		 * @return array
		 */
		static function field_style_options( $text, $unset = array() ) {

			$styles = array( 'primary', 'info', 'success', 'danger', 'default', 'warning', 'link' );

			$result = array();
			foreach ( $styles as $style ) {
				if ( ! in_array( $style, (array) $unset ) ) {
					$result[$style] = PT_CV_Html::html_button( $style, $text, '', 'btn-sm' );
				}
			}

			return $result;
		}

		/**
		 * Return quick filter options for Woocommerce
		 */
		static function field_product_lists() {
			$result = array(
				''                      => __( 'No, let me choose (to filter by other settings)', PT_CV_DOMAIN_PRO ),
				'recent_products'       => __( 'Recent products', PT_CV_DOMAIN_PRO ),
				'best_selling_products' => __( 'Best selling products', PT_CV_DOMAIN_PRO ),
				'featured_products'     => __( 'Featured products', PT_CV_DOMAIN_PRO ),
				'top_rated_products'    => __( 'Top rated products', PT_CV_DOMAIN_PRO ),
				// 'sale_products'      => __( 'On sale products', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}

		/**
		 * Pro View types
		 *
		 * @return array
		 */
		static function view_type_pro() {
			$result = array(
				'pinterest' => __( 'Pinterest', PT_CV_DOMAIN_PRO ),
				'timeline'  => __( 'Timeline', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}

		/**
		 * Pagination alignment options
		 *
		 * @return array
		 */
		static function pagination_alignment() {

			$result = array(
				'left'   => __( 'Left', PT_CV_DOMAIN_PRO ),
				'center' => __( 'Center', PT_CV_DOMAIN_PRO ),
				'right'  => __( 'Right', PT_CV_DOMAIN_PRO ),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'pagination_alignment', $result );

			return $result;
		}

		/**
		 * Font families
		 *
		 * @return array
		 */
		static function font_families() {
			$fonts_data    = PT_CV_Functions_Pro::get_google_fonts();
			$font_families = array_keys( $fonts_data );

			$result     = array();
			$result[''] = __( '&mdash; Default font &mdash;', PT_CV_DOMAIN_PRO );

			foreach ( $font_families as $font ) {
				$result[$font] = $font;
			}

			return $result;
		}

		/**
		 * Font styles
		 *
		 * @return array
		 */
		static function font_styles() {
			$styles = array( '100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic' );

			$result     = array();
			$result[''] = __( '&mdash; Default style &mdash;', PT_CV_DOMAIN_PRO );

			foreach ( $styles as $style ) {
				$result[$style] = $style;
			}

			return $result;
		}

		/**
		 * Array of a - z characters
		 */
		static function array_a_z() {
			$characters = range( 'a', 'z' );

			$result = array_combine( $characters, $characters );

			return array_merge( array( __( 'Select character', PT_CV_DOMAIN_PRO ) ), $result );
		}

		/**
		 * Text direction
		 */
		static function text_direction() {
			$result = array(
				'ltr' => __( 'Left to Right', PT_CV_DOMAIN_PRO ),
				'rtl' => __( 'Right to Left', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}

		/**
		 * Taxonomy filter style
		 */
		static function taxonomy_filter_style( $class = 'filter-bar' ) {
			$items = array( 'Lorem', 'Taxo' );
			$class = PT_CV_PREFIX . $class;

			$result = array(
				'btn-group'         => PT_CV_Html_Pro::filter_html_btn_group( $class, $items ),
				'vertical-dropdown' => PT_CV_Html_Pro::filter_html_vertical_dropdown( $class, $items ),
				'breadcrumb'        => PT_CV_Html_Pro::filter_html_breadcrumb( $class, $items ),
				'group_by_taxonomy' => __( 'Group filter options by Taxonomy (Recommended when multiple taxonomies are selected)', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}

		/**
		 * Taxonomy filter position
		 */
		static function taxonomy_filter_position() {
			$result = array(
				'left'   => __( 'Left', PT_CV_DOMAIN_PRO ),
				'center' => __( 'Center', PT_CV_DOMAIN_PRO ),
				'right'  => __( 'Right', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}

		/**
		 * List of custom fields
		 */
		static function custom_fields() {
			global $wpdb;

			$keys = $wpdb->get_col(
				"SELECT meta_key
				FROM $wpdb->postmeta
				GROUP BY meta_key
				HAVING meta_key NOT LIKE '\_%'
				ORDER BY meta_key"
			);
			if ( $keys ) {
				natcasesort( $keys );
			}

			// Final result
			$result = array();
			foreach ( $keys as $key ) {
				if ( is_protected_meta( $key, 'post' ) ) {
					continue;
				}
				$result[esc_attr( $key )] = esc_html( $key );
			}

			// Sort values of param by saved order
			$result = apply_filters( PT_CV_PREFIX_ . 'settings_sort_single', $result, 'custom-fields-list' );

			return $result;
		}

		/**
		 * Post date options
		 */
		static function post_date() {
			$result = array(
				'today'       => __( 'Today', PT_CV_DOMAIN_PRO ),
				'this_week'   => __( 'This week', PT_CV_DOMAIN_PRO ),
				'yesterday'   => __( 'Yesterday', PT_CV_DOMAIN_PRO ),
				'this_month'  => __( 'This month', PT_CV_DOMAIN_PRO ),
				'week_ago'    => __( '1 week ago (to today)', PT_CV_DOMAIN_PRO ),
				'this_year'   => __( 'This year', PT_CV_DOMAIN_PRO ),
				'month_ago'   => __( '1 month ago (to today)', PT_CV_DOMAIN_PRO ),
				'custom_date' => __( 'Custom date', PT_CV_DOMAIN_PRO ),
				'year_ago'    => __( '1 year ago (to today)', PT_CV_DOMAIN_PRO ),
				'custom_time' => __( 'Custom time (from &rarr; to)', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}

		/**
		 * Post align options
		 */
		static function text_align() {
			$result = array(
				'left'    => __( 'Left', PT_CV_DOMAIN_PRO ),
				'center'  => __( 'Center', PT_CV_DOMAIN_PRO ),
				'justify' => __( 'Justify', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}

		/**
		 * Show what from parent page
		 */
		static function parent_page_info() {
			$result = array(
				''           => __( 'Nothing', PT_CV_DOMAIN_PRO ),
				'title'      => __( 'Title', PT_CV_DOMAIN_PRO ),
				'title_link' => __( 'Title & Link', PT_CV_DOMAIN_PRO ),
			);

			return $result;
		}
	}

}