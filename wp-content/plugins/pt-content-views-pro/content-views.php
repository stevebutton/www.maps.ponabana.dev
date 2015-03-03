<?php
/**
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 *
 * @wordpress-plugin
 * Plugin Name:       Content Views Pro
 * Plugin URI:        http://www.contentviewspro.com/
 * Description:       Premium plugin which extends awesome features (more powerful settings, more amazing layouts) from the Content Views free plugin
 * Version:           1.4.3
 * Author:            PT Guy
 * Author URI:        http://www.contentviewspro.com/
 * Text Domain:       content-views-pro
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( class_exists( 'PT_Content_Views' ) ) {
	// If free version is active, load Pro
	if ( get_option( 'pt_cv_version' ) ) {

		/*
		 * Define Constant
		 */
		define( 'PT_CV_VERSION_PRO', '1.4.3' );
		define( 'PT_CV_FILE_PRO', __FILE__ );

		$pt_cv_path_pro = plugin_dir_path( __FILE__ );
		include_once( $pt_cv_path_pro . 'includes/defines.php' );

		/*
		 * Include other library files (name ASC)
		 */
		include_once( $pt_cv_path_pro . 'includes/functions.php' );
		include_once( $pt_cv_path_pro . 'includes/hooks.php' );
		include_once( $pt_cv_path_pro . 'includes/html-viewtype.php' );
		include_once( $pt_cv_path_pro . 'includes/html.php' );
		include_once( $pt_cv_path_pro . 'includes/settings.php' );
		include_once( $pt_cv_path_pro . 'includes/update.php' );
		include_once( $pt_cv_path_pro . 'includes/values.php' );
		include_once( $pt_cv_path_pro . 'includes/support/woocommerce.php' );
		include_once( $pt_cv_path_pro . 'includes/support/acf.php' );

		/*----------------------------------------------------------------------------*
		 * Public-Facing Functionality
		 *----------------------------------------------------------------------------*/

		/*
		 * the plugin's class file
		 */
		include_once( $pt_cv_path_pro . 'public/content-views.php' );

		/*
		 * Register hooks that are fired when the plugin is activated or deactivated.
		 * When the plugin is deleted, the uninstall.php file is loaded.
		 */
		register_activation_hook( __FILE__, array( 'PT_Content_Views_Pro', 'activate' ) );
		register_deactivation_hook( __FILE__, array( 'PT_Content_Views_Pro', 'deactivate' ) );

		add_action( 'plugins_loaded', array( 'PT_Content_Views_Pro', 'get_instance' ) );

		/*----------------------------------------------------------------------------*
		 * Dashboard and Administrative Functionality
		 *----------------------------------------------------------------------------*/

		/*
		 * the plugin's admin file
		 */
		//if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		if ( is_admin() ) {

			// Require Admin side functions
			include_once( $pt_cv_path_pro . 'admin/content-views-admin.php' );
			add_action( 'plugins_loaded', array( 'PT_Content_Views_Pro_Admin', 'get_instance' ) );

			// Settings page for the plugin
			include_once( $pt_cv_path_pro . 'admin/includes/plugin.php' );
		}

		/**
		* Update management
		*/
		$pt_cv_options = get_option( PT_CV_OPTION_NAME );
		$license_key   = isset( $pt_cv_options['license_key'] ) ? $pt_cv_options['license_key'] : '';

		require_once( 'wp-updates-plugin.php' );
		new WPUpdatesPluginUpdater_514( 'http://wp-updates.com/api/2/plugin', plugin_basename( __FILE__ ), $license_key );
	}
}

/**
 * Show message if Free plugin is not activated
 */
add_action( 'admin_notices', 'pt_cv_check_free_installed', 1 );
function pt_cv_check_free_installed() {
	if ( ! class_exists( 'PT_Content_Views' ) ) {
		?>
		<div class="error" style="padding: 20px 10px; ">
			<h2>Content Views Pro plugin requires Content Views free plugin to be activated, which is available free at
			<a href="https://wordpress.org/plugins/content-views-query-and-display-post-page/" target="_blank">wordpress.org</a>
			</h2>
			<h3>If you've already installed Content Views free, please activate it. Otherwise, please install it first.</h3>
		</div>
		<?php
	}
}