<?php
/**
 * Form, option group, option name, option fields
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

if ( ! class_exists( 'PT_CV_Plugin_Pro' ) ) {

	/**
	 * @name PT_CV_Plugin_Pro
	 */
	class PT_CV_Plugin_Pro {

		/**
		 * Add custom filters/actions
		 */
		static function init() {

			// Filters
			add_filter( PT_CV_PREFIX_ . 'settings_page_section_one', array( __CLASS__, 'filter_settings_page_section_one' ) );
			add_filter( PT_CV_PREFIX_ . 'settings_page_section_two', array( __CLASS__, 'filter_settings_page_section_two' ) );
			// Add more settings to Frontend assets group
			add_filter( PT_CV_PREFIX_ . 'frontend_assets_fields', array( __CLASS__, 'filter_frontend_assets_fields' ) );
			// Add current class to list of class to looking for callback function for a setting option
			add_filter( PT_CV_PREFIX_ . 'defined_in_class', array( __CLASS__, 'filter_defined_in_class' ) );

			// Actions
			add_action( PT_CV_PREFIX_ . 'settings_page', array( __CLASS__, 'action_settings_page' ) );
			add_action( 'init', array( __CLASS__, 'action_ck_lcs' ) );
		}

		/**
		 * Content Views Settings page : section 1
		 *
		 * @param string $text HTML settings for this section
		 *
		 * @return string HTML
		 */
		public static function filter_settings_page_section_one( $text ) {

			$file_path = plugin_dir_path( PT_CV_FILE_PRO ) . 'admin/includes/templates/settings-section-one.php';

			$text = PT_CV_Functions::file_include_content( $file_path );

			return balanceTags( $text );
		}

		/**
		 * Content Views Settings page : section 2
		 *
		 * @param string $text HTML settings for this section
		 *
		 * @return string HTML
		 */
		public static function filter_settings_page_section_two( $text ) {

			$file_path = plugin_dir_path( PT_CV_FILE_PRO ) . 'admin/includes/templates/settings-section-two.php';

			$text = PT_CV_Functions::file_include_content( $file_path );

			return balanceTags( $text );
		}

		/**
		 * Add more option to Frontend assets setting
		 *
		 * @param array $args Array of setting options
		 *
		 * @return array
		 */
		public static function filter_frontend_assets_fields( $args ) {

			// Load refined Bootstrap
			/**
			$args[] = array(
				'id'    => 'load_refined_bootstrap',
				'title' => '',
			);
			 * 
			 */

			// Unload Colorbox
			$args[] = array(
				'id'    => 'unload_colorbox',
				'title' => '',
			);

			return $args;
		}

		/**
		 * Add class which define callback function for setting option
		 *
		 * @param array $args Array of classes
		 *
		 * @return array
		 */
		public static function filter_defined_in_class( $args ) {

			// $args['load_refined_bootstrap'] = __CLASS__;
			$args['unload_colorbox']        = __CLASS__;

			return $args;
		}

		/**
		 * Add new setting Section
		 *
		 * @param string $section_slug
		 * @param array  $fields
		 */
		public static function _add_setting_section( $section_slug, $fields ) {
			// Add Section
			add_settings_section(
				$section_slug, // ID
				'', // Title
				array( __CLASS__, 'section_callback_' . $section_slug ), // Callback
				PT_CV_DOMAIN // Page
			);

			// Register Account fields
			foreach ( $fields as $field ) {
				PT_CV_Plugin::field_register( $field, $section_slug, __CLASS__ );
			}
		}

		/**
		 * Add more options to Form in Settings page
		 */
		public static function action_settings_page() {
			// Accessibility Section
			self::_add_setting_section(
				'setting_access', array(
					array(
						'id'    => 'access_role',
						'title' => '<strong>' . __( 'User role who can manage Views', PT_CV_DOMAIN_PRO ) . '</strong>',
					),
				)
			);

			// Account Section
			self::_add_setting_section(
				'setting_account', array(
				array(
					'id'    => 'license_key',
					'title' => '<strong>' . __( 'License key', PT_CV_DOMAIN_PRO ) . '</strong>',
				),
				)
			);
		}

		/**
		 * Refined Bootstrap assets load/unload field
		 */
		public static function field_callback_load_refined_bootstrap() {
			/**
			 * Since @ 1.3.3
			 * Don't show this field anymore. Auto load refined Bootstrap for Pro users by default
			 *
			$field_name = 'load_refined_bootstrap';
			PT_CV_Plugin::_field_print(
				$field_name,
				'checkbox',
				__( 'Load <b>refined Bootstrap</b> style which removed <b>font-size, color</b> properties of Bootstrap for Heading, Link...', PT_CV_DOMAIN_PRO ),
				__( 'Check this option if you see font size, color of elements in your website have been changed after activate Content Views plugin', PT_CV_DOMAIN_PRO )
			);
			 * 
			 */
		}

		/**
		 * Colorbox assets load/unload field
		 */
		public static function field_callback_unload_colorbox() {
			$field_name = 'unload_colorbox';

			PT_CV_Plugin::_field_print(
				$field_name,
				'checkbox',
				__( "Don't load <b>Colorbox</b> style & script (in frontend of website)", PT_CV_DOMAIN_PRO ),
				__( 'This library is required to open item in Lightbox. Only check this option if Colorbox has been loaded by active theme or other plugin', PT_CV_DOMAIN_PRO )
			);
		}

		/**
		 * User role field
		 */
		public static function field_callback_access_role() {
			$field_name = 'access_role';

			// Get saved value, if not, set the default value as 'administrator'
			$field_value = ! empty( PT_CV_Plugin::$options[$field_name] ) ? esc_attr( PT_CV_Plugin::$options[$field_name] ) : 'editor';

			ob_start();
			wp_dropdown_roles( $field_value );
			$options = ob_get_clean();

			self::_field_print_select( $field_name, $options );
		}

		/**
		 * License key field
		 */
		public static function field_callback_license_key() {
			$field_name = 'license_key';

			PT_CV_Plugin::_field_print( $field_name );
		}

		/**
		 * Print select field
		 *
		 * @param string $field_name The ID of field
		 * @param string $options    The HTML options of select box
		 */
		public static function _field_print_select( $field_name, $options ) {

			$field_id = esc_attr( $field_name );

			printf(
				'<select id="%1$s" name="%2$s[%1$s]">%3$s</select>',
				$field_id, PT_CV_OPTION_NAME, $options
			);

		}

		/**
		 * Print the text for User role Section
		 */
		public static function section_callback_setting_access() {

		}

		/**
		 * Print the text for Account Section
		 */
		public static function section_callback_setting_account() {
			printf( '<p id="%s">%s</p>', 'heading-setting-account', __( 'To update PRO plugin, please enter the license key you got when you purchased item', PT_CV_DOMAIN_PRO ) );
		}

		public static function action_ck_lcs() {
			$act_lcs = get_option( 'pt_cv_' . 'pro_lcs' );
			if ( ! $act_lcs ) {
				PT_Content_Views_Pro::request_sellwire( 'activate' );
			}
		}
	}

}