<?php
/**
 * Content Views Admin
 *
 * @package   PT_Content_Views_Pro_Admin
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

class PT_Content_Views_Pro_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		$plugin            = PT_Content_Views_Pro::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		$this->priority = 12;

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ), $this->priority );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), $this->priority );
		add_action( 'admin_print_styles', array( $this, 'admin_print_styles' ), $this->priority );

		// Filter Setting options
		add_filter( PT_CV_PREFIX_ . 'view_row_actions', array( $this, 'filter_view_row_actions' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'view_actions', array( $this, 'filter_view_actions' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'custom_filters', array( $this, 'filter_custom_filters' ) );
		add_filter( PT_CV_PREFIX_ . 'post_parent_settings', array( $this, 'filter_post_parent_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'after_limit_option', array( $this, 'filter_after_limit_option' ) );
		add_filter( PT_CV_PREFIX_ . 'post_types', array( $this, 'filter_post_types' ) );
		add_filter( PT_CV_PREFIX_ . 'orderby', array( $this, 'filter_orderby' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type', array( $this, 'filter_view_type' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type_settings', array( $this, 'filter_view_type_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type_settings_grid', array( $this, 'filter_view_type_settings_grid' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type_settings_collapsible', array( $this, 'filter_view_type_settings_collapsible' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type_settings_scrollable', array( $this, 'filter_view_type_settings_scrollable' ) );
		add_filter( PT_CV_PREFIX_ . 'list_layouts', array( $this, 'filter_list_layouts' ) );
		add_filter( PT_CV_PREFIX_ . 'open_in', array( $this, 'filter_open_in' ) );
		add_filter( PT_CV_PREFIX_ . 'field_display', array( $this, 'filter_field_display' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'field_thumbnail_sizes', array( $this, 'filter_field_thumbnail_sizes' ) );
		add_filter( PT_CV_PREFIX_ . 'field_thumbnail_settings', array( $this, 'filter_field_thumbnail_settings' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'settings_other', array( $this, 'filter_settings_other' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'pagination_styles', array( $this, 'filter_pagination_styles' ) );
		add_filter( PT_CV_PREFIX_ . 'meta_numeric_values', array( $this, 'filter_meta_numeric_values' ) );
		add_filter( PT_CV_PREFIX_ . 'settings_sort', array( $this, 'filter_settings_sort' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'settings_sort_single', array( $this, 'filter_settings_sort_single' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'settings_sort_text', array( $this, 'filter_settings_sort_text' ) );
		add_filter( PT_CV_PREFIX_ . 'settings_taxonomies_display', array( $this, 'filter_settings_taxonomies_display' ) );
		add_filter( PT_CV_PREFIX_ . 'excerpt_settings', array( $this, 'filter_excerpt_settings' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'settings_pagination', array( $this, 'filter_settings_pagination' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'term_quick_filter', array( $this, 'filter_term_quick_filter' ) );
		add_filter( PT_CV_PREFIX_ . 'options_description', array( $this, 'filter_options_description' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'exclude_sticky_posts_setting', array( $this, 'filter_exclude_sticky_posts_setting' ) );
		add_filter( PT_CV_PREFIX_ . 'field_settings', array( $this, 'filter_field_settings' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'advanced_settings', array( $this, 'filter_advanced_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'advanced_settings_panel', array( $this, 'filter_advanced_settings_panel' ) );

		// Custom hooks for both preview & frontend
		PT_CV_Hooks_Pro::init();

		// Custom settings page
		PT_CV_Plugin_Pro::init();

		// Add action before edit/trash View
		add_action( 'wp_trash_post', array( $this, 'action_before_delete_view' ) );
		add_action( 'before_delete_post', array( $this, 'action_before_delete_view' ) );
		// Initialize global variable to store view data, such as view id & font settings
		add_action( PT_CV_PREFIX_ . 'preview_header', array( 'PT_CV_Html_Pro', 'init_view_data' ) );
		// Add Tabs to Add/Edit View page
		add_action( PT_CV_PREFIX_ . 'setting_tabs_header', array( $this, 'action_setting_tabs_header' ) );
		add_action( PT_CV_PREFIX_ . 'setting_tabs_content', array( $this, 'action_setting_tabs_content' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		$screen = get_current_screen();
		if ( strpos( $screen->id, PT_CV_DOMAIN ) !== false ) {

			// Main admin style
			PT_CV_Asset::enqueue(
				'admin', 'style', array(
					'src' => plugins_url( 'assets/css/admin.css', __FILE__ ),
				), PT_CV_PREFIX_PRO
			);

			// For Preview
			PT_CV_Html_Pro::frontend_styles();
		}
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		$screen = get_current_screen();
		if ( strpos( $screen->id, PT_CV_DOMAIN ) !== false ) {

			// Main admin script
			PT_CV_Asset::enqueue(
				'admin', 'script', array(
					'src'  => plugins_url( 'assets/js/admin.js', __FILE__ ),
					'deps' => array( 'jquery' ),
				), PT_CV_PREFIX_PRO
			);

			// Localize strings
			PT_CV_Asset::localize_script(
				'admin', PT_CV_PREFIX_UPPER . 'ADMIN_PRO', array(
					'fonts' => array(
						'google' => json_encode( PT_CV_Functions_Pro::get_google_fonts() ),
					),
					'message' => array(
						'delete' => __( 'Delete this?', PT_CV_DOMAIN_PRO )
					),
					'custom_field' => array(
						'type_operator' => array(
							'CHAR' => array( '=', '!=', 'LIKE', 'NOT LIKE' ),
							'NUMERIC' => array( '=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' ),
							'DATE' => array( '=', '!=', '>', '>=', '<', '<=', 'BETWEEN', 'NOT BETWEEN' ),
							'BINARY' => array( '=', '!=', ),
						)
					),
				), PT_CV_PREFIX_PRO
			);

			// Datepicker
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ) );

			// Select2 sortable
			PT_CV_Asset::enqueue(
				'select2.sortable', 'script', array(
					'src' => plugins_url( 'assets/select2.sortable/select2.sortable.js', PT_CV_FILE_PRO ),
					'ver' => '1.0',
				)
			);

			// For Preview
			PT_CV_Html_Pro::frontend_scripts();
		}
	}

	/**
	 * Print custom style in Admin
	 *
	 * @since     1.0.0
	 *
	 * @return    null
	 */
	public function admin_print_styles() {

		$screen = get_current_screen();
		if ( strpos( $screen->id, PT_CV_DOMAIN ) !== false ) {

			// Datepicker
			wp_enqueue_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );

			// For Google Font
			echo "<style>\n";
			echo balanceTags( PT_CV_Functions_Pro::get_google_fonts_background_position() );
			echo "\n</style>";
		}
	}

	/**
	 * Add more actions to All Views page : Duplicate
	 *
	 * @param array  $args    Array of actions
	 * @param string $view_id The View ID
	 *
	 * @return array
	 */
	public function filter_view_row_actions( $args, $view_id ) {
		$duplicate_link    = PT_CV_Functions::view_link( $view_id, array( 'action' => 'duplicate' ) );
		$args['duplicate'] = '<a href="' . esc_url( $duplicate_link ) . '" target="_blank" title="' . esc_attr( __( 'Duplicate this item', PT_CV_DOMAIN_PRO ) ) . '">' . __( 'Duplicate', PT_CV_DOMAIN_PRO ) . '</a>';

		return $args;
	}

	/**
	 * Add view action buttons: Duplicate
	 *
	 * @param array  $args
	 * @param string $view_id The View ID
	 *
	 * @return string
	 */
	public function filter_view_actions( $args, $view_id ) {
		$args = sprintf( '<a class="btn btn-info" href="%s" style="float: right;">%s</a>', PT_CV_Functions::view_link( $view_id, array( 'action' => 'duplicate' ) ), __( 'Duplicate this view', PT_CV_DOMAIN_PRO ) );

		return $args;
	}

	/**
	 * Filter common filter: Add select Products
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_custom_filters( $args ) {
		// Products
		$args = array(
			'label'      => array(
				'text' => __( 'WooCommerce filters', PT_CV_DOMAIN_PRO ),
			),
			'params'     => array(
				array(
					'type'    => 'radio',
					'name'    => 'products-list',
					'options' => PT_CV_Values_Pro::field_product_lists(),
					'std'     => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::field_product_lists() ),
					'desc'    => __( 'Quick filter to get WooCommerce products', PT_CV_DOMAIN_PRO ),
				),
			),
			'dependence' => array( 'content-type', 'product' ),
		);

		return $args;
	}

	/**
	 * Add options for Parent page
	 *
	 * @param array $args
	 */
	public function filter_post_parent_settings( $args ) {

		$args = array(
			'label'  => array(
				'text' => '',
			),
			'extra_setting' => array(
				'params' => array(
					'wrap-id' => PT_CV_Html::html_group_id( 'parent-page' ),
				),
			),
			'params' => array(
				array(
					'type'   => 'group',
					'params' => array(

						// Auto get current page
						array(
							'label'         => array(
								'text' => __( '', PT_CV_DOMAIN ),
							),
							'extra_setting' => array(
								'params' => array(
									'width' => 12,
								),
							),
							'params'        => array(
								array(
									'type'    => 'checkbox',
									'name'    => 'post_parent-auto',
									'options' => PT_CV_Values::yes_no( 'yes', __( 'Or automatically set current page (or its parent) as Parent for the list', PT_CV_DOMAIN_PRO ) ),
									'std'     => 'yes',
								),
							),
						),

						// Show what from parent page
						array(
							'label'  => array(
								'text' => __( "Prepend parent page's info to the output", PT_CV_DOMAIN_PRO ),
							),
							'extra_setting' => array(
								'params' => array(
									'width' => 6,
								),
							),
							'params' => array(
								array(
									'type'    => 'select',
									'name'    => 'post_parent-auto-info',
									'options' => PT_CV_Values_Pro::parent_page_info(),
									'std'     => '',
								),
							),
						),
					),
				),
			),
			'dependence' => array( 'content-type', 'page' ),
		);

		return $args;
	}

	/**
	 * Filter common filter: Add Offset
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_after_limit_option( $args ) {
		// Offset
		$args = array(
			'label'  => array(
				'text' => __( 'Offset', PT_CV_DOMAIN_PRO ),
			),
			'params' => array(
				array(
					'type'        => 'number',
					'name'        => 'offset',
					'std'         => '',
					'min'         => '0',
					'append_text' => '0 &rarr; 999',
					'desc'        => __( 'The number of posts to displace or pass over. Leaving it blank to start from the first post', PT_CV_DOMAIN_PRO ),
				),
			),
		);

		return $args;
	}

	/**
	 * Filter post types: Get all registered post types
	 *
	 * @param array $args Array to filter
	 *
	 * @return boolean
	 */
	public function filter_post_types( $args ) {
		unset( $args['_builtin'] );

		return $args;
	}

	/**
	 * Filter orderby: Add advanced options
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_orderby( $args ) {

		$args['advanced'] = array(
			array(
				'label'      => array(
					'text' => __( 'Order by', PT_CV_DOMAIN_PRO ),
				),
				'params'     => array(
					array(
						'type'     => 'panel_group',
						'settings' => array(
							'no_panel'      => 1,
							'show_only_one' => 1,
						),
						'params'   => PT_CV_Settings_Pro::orderby(),
					),
				),
				'dependence' => array( 'content-type', 'product' ),
			),
			array(
				'label'      => array(
					'text' => __( 'Order', PT_CV_DOMAIN_PRO ),
				),
				'params'     => array(
					array(
						'type'    => 'radio',
						'name'    => 'advanced-order',
						'options' => PT_CV_Values::orders(),
						'std'     => 'asc',
					),
				),
				'dependence' => array( 'content-type', 'product' ),
			),
		);

		return $args;
	}

	/**
	 * Filter view type : Add timeline, calendar ...
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_view_type( $args ) {
		$args = array_merge( $args, PT_CV_Values_Pro::view_type_pro() );

		return $args;
	}

	/**
	 * Filter view type settings : Add Scrollable List, Pinterest, Timeline ... settings
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_view_type_settings( $args ) {

		// Settings of Pinterest type
		$args['pinterest'] = PT_CV_Settings_Pro::view_type_settings_pinterest();

		// Settings of Timeline type
		$args['timeline'] = PT_CV_Settings_Pro::view_type_settings_timeline();

		return $args;
	}

	/**
	 * Filter settings for Grid
	 * @param type $args
	 */
	public function filter_view_type_settings_grid( $args ) {
		$prefix = 'grid-';

		$args[] = array(
			'label'         => array(
				'text' => '',
			),
			'extra_setting' => array(
				'params' => array(
					'width' => 12,
				),
			),
			'params'        => array(
				array(
					'type'    => 'checkbox',
					'name'    => $prefix . 'same-height',
					'options' => PT_CV_Values::yes_no( 'yes', __( 'Set same height for each type of fields (Title, Content...) across items', PT_CV_DOMAIN_PRO ) ),
					'std'     => '',
				),
			),
		);

		return $args;
	}

	/**
	 * Filter settings for Collapsible List
	 * @param array $args
	 * @return array
	 */
	public function filter_view_type_settings_collapsible( $args ) {

		$prefix = 'collapsible-';

		$args = array(

			// Open first item at page load
			array(
				'label'         => array(
					'text' => '',
				),
				'extra_setting' => array(
					'params' => array(
						'width' => 12,
					),
				),
				'params'        => array(
					array(
						'type'    => 'checkbox',
						'name'    => $prefix . 'open-first-item',
						'options' => PT_CV_Values::yes_no( 'yes', __( 'Open first item at page load', PT_CV_DOMAIN_PRO ) ),
						'std'     => 'yes',
					),
				),
			),

			// Open multiple items at once
			array(
				'label'         => array(
					'text' => '',
				),
				'extra_setting' => array(
					'params' => array(
						'width' => 12,
					),
				),
				'params'        => array(
					array(
						'type'    => 'checkbox',
						'name'    => $prefix . 'open-multiple',
						'options' => PT_CV_Values::yes_no( 'yes', __( 'Open multiple items at once', PT_CV_DOMAIN_PRO ) ),
						'std'     => '',
					),
				),
			),
		);

		return $args;
	}


	/**
	 * Settings of View type = Scrollable
	 *
	 * @return array
	 */
	public function filter_view_type_settings_scrollable( $args ) {

		$prefix = 'scrollable-';

		$args = array(

			// Number of columns
			array(
				'label'  => array(
					'text' => __( 'Items per row', PT_CV_DOMAIN_PRO ),
				),
				'params' => array(
					array(
						'type'        => 'number',
						'name'        => $prefix . 'number-columns',
						'std'         => '2',
						'append_text' => '1 &rarr; 4',
						'desc'        => __( 'The number of items on each row of a slide', PT_CV_DOMAIN_PRO ),
					),
				),
			),

			// Number of rows
			array(
				'label'  => array(
					'text' => __( 'Rows count', PT_CV_DOMAIN_PRO ),
				),
				'params' => array(
					array(
						'type'        => 'number',
						'name'        => $prefix . 'number-rows',
						'std'         => '2',
						'append_text' => '1 &rarr; 10',
						'desc'        => __( 'The number of rows on each slide', PT_CV_DOMAIN_PRO ),
					),
				),
			),

			// Automatical cycle
			array(
				'label'  => array(
					'text' => __( 'Automatic cycle', PT_CV_DOMAIN_PRO ),
				),
				'params' => array(
					array(
						'type'    => 'checkbox',
						'name'    => $prefix . 'auto-cycle',
						'options' => PT_CV_Values::yes_no( 'yes' ),
						'std'     => 'yes',
					),
				),
			),

			// Interval
			array(
				'label'      => array(
					'text' => __( 'Interval (seconds)', PT_CV_DOMAIN_PRO ),
				),
				'params'     => array(
					array(
						'type'        => 'number',
						'name'        => $prefix . 'interval',
						'std'         => '5',
						'min'         => '1',
						'append_text' => '1 &rarr; 999',
						'desc'        => __( 'The amount of seconds to delay between automatically cycling an item', PT_CV_DOMAIN_PRO ),
					),
				),
				'dependence' => array( $prefix . 'auto-cycle', 'yes' ),
			),

			// Indicators
			array(
				'label'  => array(
					'text' => __( 'Show indicator', PT_CV_DOMAIN_PRO ),
				),
				'params' => array(
					array(
						'type'    => 'checkbox',
						'name'    => $prefix . 'indicator',
						'options' => PT_CV_Values::yes_no( 'yes' ),
						'std'     => 'yes',
					),
				),
			),

			// (Navigation) Controls
			array(
				'label'  => array(
					'text' => __( 'Show navigation', PT_CV_DOMAIN_PRO ),
				),
				'params' => array(
					array(
						'type'    => 'checkbox',
						'name'    => $prefix . 'navigation',
						'options' => PT_CV_Values::yes_no( 'yes' ),
						'std'     => 'yes',
					),
				),
			),

		);

		return $args;
	}

	/**
	 * Filter List layouts : Add Pinterest, Portfolio ...
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_list_layouts( $args ) {
		$args = array_merge(
			$args, array(
				'pinterest' => __( 'Pinterest', PT_CV_DOMAIN_PRO ),
			)
		);

		return $args;
	}

	/**
	 * Filter Open in: Add Lightbox
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_open_in( $args ) {
		$args = array_merge(
			$args, array(
				PT_CV_PREFIX . 'window'   => __( 'New window', PT_CV_DOMAIN_PRO ),
				PT_CV_PREFIX . 'lightbox' => __( 'Light box', PT_CV_DOMAIN_PRO ),
				PT_CV_PREFIX . 'none'     => __( 'None (no link, no click action)', PT_CV_DOMAIN_PRO ),
			)
		);

		return $args;
	}

	/**
	 * Filter Field Display options: Add Show Price & Add to cart button
	 *
	 * @param array  $args
	 * @param string $prefix The prefix for name of option
	 *
	 * @return array
	 */
	public function filter_field_display( $args, $prefix ) {
		// Show Price
		$args[] = array(
			'label'         => array(
				'text' => '',
			),
			'extra_setting' => array(
				'params' => array(
					'width' => 12,
				),
			),
			'params'        => array(
				array(
					'type'    => 'checkbox',
					'name'    => $prefix . 'price',
					'options' => PT_CV_Values::yes_no( 'yes', __( 'Show Price & Add to cart', PT_CV_DOMAIN_PRO ) ),
					'std'     => 'yes',
				),
			),
			'dependence'    => array( 'content-type', 'product' ),
		);

		// Show Custom fields
		$args[] = array(
			'label'         => array(
				'text' => '',
			),
			'extra_setting' => array(
				'params' => array(
					'width' => 12,
				),
			),
			'params'        => array(
				array(
					'type'    => 'checkbox',
					'name'    => $prefix . 'custom-fields',
					'options' => PT_CV_Values::yes_no( 'yes', __( 'Show Custom Fields', PT_CV_DOMAIN_PRO ) ),
					'std'     => '',
				),
			),
		);

		return $args;
	}

	/**
	 * Filter Thumbnail Sizes: Add Custom Size, Auto Fit
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_field_thumbnail_sizes( $args ) {

		$args[PT_CV_PREFIX . 'custom'] = __( '&mdash; Custom size &mdash;', PT_CV_DOMAIN_PRO );

		return $args;
	}

	/**
	 * Filter Thumbnail Settings: Add Custom Size Settings, Thumbnail Style
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_field_thumbnail_settings( $args, $prefix ) {

		$args = array_merge(
			$args,
			array(

				// Custom Size
				array(
					'label'         => array(
						'text' => __( 'Custom size', PT_CV_DOMAIN_PRO ),
					),
					'extra_setting' => array(
						'params' => array(
							'width'      => 9,
							'wrap-class' => 'form-inline',
						),
					),
					'params'        => array(
						array(
							'type'   => 'group',
							'params' => array(

								// Width
								array(
									'label'  => array(
										'text' => __( 'Width', PT_CV_DOMAIN_PRO ),
									),
									'params' => array(
										array(
											'type'        => 'number',
											'name'        => $prefix . 'thumbnail-size-custom-width',
											'std'         => '',
											'append_text' => 'px',
										),
									),
								),

								// Height
								array(
									'label'  => array(
										'text' => __( 'Height', PT_CV_DOMAIN_PRO ),
									),
									'params' => array(
										array(
											'type'        => 'number',
											'name'        => $prefix . 'thumbnail-size-custom-height',
											'std'         => '',
											'append_text' => 'px',
										),
									),
								),
							),
						),
					),
					'dependence'    => array( $prefix . 'thumbnail-size', PT_CV_PREFIX . 'custom' ),
				),

				// Style
				array(
					'label'         => array(
						'text' => __( 'Thumbnail style', PT_CV_DOMAIN_PRO ),
					),
					'extra_setting' => array(
						'params' => array(
							'width' => 9,
						),
					),
					'params'        => array(
						array(
							'type'    => 'radio',
							'name'    => $prefix . 'thumbnail-style',
							'options' => PT_CV_Values_Pro::field_thumbnail_styles(),
							'std'     => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::field_thumbnail_styles() ),
						),
					),
				),

				// Custom border radius
				array(
					'label'         => array(
						'text' => __( 'Border radius', PT_CV_DOMAIN_PRO ),
					),
					'extra_setting' => array(
						'params' => array(
							'width' => 9,
						),
					),
					'params'        => array(
						array(
							'type'        => 'number',
							'name'        => 'thumbnail-border-radius',
							'std'         => '6',
							'append_text' => 'px',
						),
					),
					'dependence'    => array( $prefix . 'thumbnail-style', 'img-rounded' ),
				),
			)
		);

		return $args;
	}

	/**
	 * Filter View Type Other settings: Add Lightbox Size option
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_settings_other( $args, $prefix ) {

		/**
		 * Text direction
		 */
		$text_direction = array(
			'label'  => array(
				'text' => __( 'Text direction', PT_CV_DOMAIN_PRO ),
			),
			'params' => array(
				array(
					'type'    => 'radio',
					'name'    => 'text-direction',
					'options' => PT_CV_Values_Pro::text_direction(),
					'std'     => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::text_direction() ),
				),
			),
		);

		array_unshift( $args, $text_direction );


		/**
		 * Window Size
		 */

		$prefix2 = $prefix . 'window-';

		$args = array_merge(
			$args,
			array(

				array(
					'label'         => array(
						'text' => __( 'Window size', PT_CV_DOMAIN_PRO ),
					),
					'extra_setting' => array(
						'params' => array(
							'wrap-class' => 'form-inline',
						),
					),
					'params'        => array(
						array(
							'type'   => 'group',
							'params' => array(

								// Width
								array(
									'label'  => array(
										'text' => __( 'Width', PT_CV_DOMAIN_PRO ),
									),
									'params' => array(
										array(
											'type'        => 'number',
											'name'        => $prefix2 . 'size-width',
											'std'         => '600',
											'placeholder' => 'e.g. 600',
											'min'         => '100',
											'append_text' => 'px',
										),
									),
								),

								// Height
								array(
									'label'  => array(
										'text' => __( 'Height', PT_CV_DOMAIN_PRO ),
									),
									'params' => array(
										array(
											'type'        => 'number',
											'name'        => $prefix2 . 'size-height',
											'std'         => '400',
											'placeholder' => 'e.g. 400',
											'min'         => '100',
											'append_text' => 'px',
										),
									),
								),
							),
						),
					),
					'dependence'    => array( $prefix . 'open-in', PT_CV_PREFIX . 'window' ),
				),
			)
		);

		/**
		 * Lightbox size
		 */

		$prefix2 = $prefix . 'lightbox-';

		$args = array_merge(
			$args,
			array(

				// Lightbox size
				array(
					'label'         => array(
						'text' => __( 'Lightbox size', PT_CV_DOMAIN_PRO ),
					),
					'extra_setting' => array(
						'params' => array(
							'wrap-class' => 'form-inline',
						),
					),
					'params'        => array(
						array(
							'type'   => 'group',
							'params' => array(

								// Width
								array(
									'label'  => array(
										'text' => __( 'Width', PT_CV_DOMAIN_PRO ),
									),
									'params' => array(
										array(
											'type'        => 'number',
											'name'        => $prefix2 . 'size-width',
											'std'         => '75',
											'placeholder' => 'e.g. 75',
											'append_text' => '%',
										),
									),
								),

								// Height
								array(
									'label'  => array(
										'text' => __( 'Height', PT_CV_DOMAIN_PRO ),
									),
									'params' => array(
										array(
											'type'        => 'number',
											'name'        => $prefix2 . 'size-height',
											'std'         => '75',
											'placeholder' => 'e.g. 75',
											'append_text' => '%',
										),
									),
								),
							),
						),
					),
					'dependence'    => array( $prefix . 'open-in', PT_CV_PREFIX . 'lightbox' ),
				),

				// Lightbox content id
				array(
					'label'      => array(
						'text' => __( 'Content selector', PT_CV_DOMAIN ),
					),
					'params'     => array(
						array(
							'type' => 'text',
							'name' => $prefix2 . 'content-selector',
							'std'  => '',
							'desc' => __( 'By default, whole page will be loaded in Lightbox (Header, Content, Footer)<br>If you want to load only Content in Lightbox, please enter a jQuery selector that determines the content to be loaded (e.g. #content)', PT_CV_DOMAIN ),
						),
					),
					'dependence' => array( $prefix . 'open-in', PT_CV_PREFIX . 'lightbox' ),
				),
			)
		);

		return $args;
	}

	/**
	 * Filter Pagination Style: add Load more option
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_pagination_styles( $args ) {

		$args['loadmore'] = __( 'Load more button', PT_CV_DOMAIN_PRO );
		$args['infinite'] = __( 'Infinite scrolling', PT_CV_DOMAIN_PRO );

		return $args;
	}

	/**
	 * Filter meta fields which is numeric value for content types
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_meta_numeric_values( $args ) {

		$args['product'] = array( 'price' => '_price' );

		return $args;
	}

	/**
	 * Sort array of settings by saved order
	 *
	 * @param array  $args
	 * @param string $prefix
	 */
	public function filter_settings_sort( $args, $prefix ) {

		// Get settings of current View
		global $pt_cv_admin_settings;

		if ( is_array( $pt_cv_admin_settings ) ) {
			$args = PT_CV_Functions_Pro::settings_sort( $prefix, $args, array_keys( $pt_cv_admin_settings ) );
		}

		return $args;
	}

	/**
	 * Sort values inside a single option
	 *
	 * @param array $args
	 * @param string $option_name Name of parameter
	 * @return array
	 */
	public function filter_settings_sort_single( $args, $option_name ) {
		// Get settings of current View
		global $pt_cv_admin_settings;

		$saved_data = isset( $pt_cv_admin_settings[PT_CV_PREFIX . $option_name] ) ? $pt_cv_admin_settings[PT_CV_PREFIX . $option_name] : '';

		if ( ! $saved_data )
			return $args;

		$result = array();

		// Get value of saved key
		foreach ( $saved_data as $key ) {
			$result[$key] = $args[$key];
			unset( $args[$key] );
		}

		// Append other keys to result
		$result = $result + $args;

		if ( $result ) {
			$args = $result;
		}

		return $args;
	}

	/**
	 * Filter description to sorting fields
	 *
	 * @param string $args
	 *
	 * @return string
	 */
	public function filter_settings_sort_text( $args ) {
		$args = __( 'Drag & drop to change the display order of fields', PT_CV_DOMAIN_PRO );

		return $args;
	}

	/**
	 * Add custom settings for Taxonomies display
	 *
	 * @param array $args
	 */
	public function filter_settings_taxonomies_display( $args ) {
		$args = array(
			'label'  => array(
				'text' => '',
			),
			'params' => array(
				array(
					'type'   => 'group',
					'params' => array(
						// Taxonomies display
						array(
							'label'         => array(
								'text' => __( 'Taxonomies display', PT_CV_DOMAIN_PRO ),
							),
							'extra_setting' => array(
								'params' => array(
									'wrap-class' => PT_CV_PREFIX . 'full-fields',
									'width'      => 9,
								),
							),
							'params'        => array(
								array(
									'type'    => 'checkbox',
									'name'    => 'meta-fields-' . 'taxonomy-' . 'dis-o-checked',
									'options' => PT_CV_Values::yes_no( 'yes', __( 'Show only terms of selected taxonomy', PT_CV_DOMAIN_PRO ) ),
									'std'     => '',
									'popover' => sprintf( "<img src='%s'>", plugins_url( 'admin/assets/images/popover/selected_taxonomy.png', PT_CV_FILE_PRO ) ),
								),
							),
							'dependence'    => array( array( 'meta-fields-' . 'taxonomy', 'yes' ), array( 'show-field-' . 'meta-fields', 'yes' ) ),
						),

						// Use icon
						array(
							'label'         => array(
								'text' => __( 'Icons', PT_CV_DOMAIN_PRO ),
							),
							'extra_setting' => array(
								'params' => array(
									'wrap-class' => PT_CV_PREFIX . 'full-fields',
									'width'      => 9,
								),
							),
							'params'        => array(
								array(
									'type'    => 'checkbox',
									'name'    => 'meta-fields-' . 'taxonomy-' . 'use-icons',
									'options' => PT_CV_Values::yes_no( 'yes', __( 'Add icon before each meta field', PT_CV_DOMAIN_PRO ) ),
									'std'     => 'yes',
								),
							),
							'dependence'    => array( array( 'meta-fields-' . 'taxonomy', 'yes' ), array( 'show-field-' . 'meta-fields', 'yes' ) ),
						),
					),
				),
			),

		);

		return $args;
	}

	/**
	 * Filter Exceprt settings
	 *
	 * @param array  $args   The setting options of Exceprt
	 * @param string $prefix The prefix string for option name
	 */
	public function filter_excerpt_settings( $args, $prefix ) {

		// Auto get manual excerpt if it is available
		$args[] = array(
			'label'         => array(
				'text' => '',
			),
			'extra_setting' => array(
				'params' => array(
					'wrap-class' => PT_CV_PREFIX . 'full-fields',
					'width'      => 9,
				),
			),
			'params'        => array(
				array(
					'type'    => 'checkbox',
					'name'    => $prefix . 'manual',
					'options' => PT_CV_Values::yes_no( 'yes', __( 'Use manual excerpt if it exists (instead of generating an excerpt automatically)', PT_CV_DOMAIN_PRO ) ),
					'std'     => 'yes',
				),
				array(
					'type'    => 'checkbox',
					'name'    => $prefix . 'hide_dots',
					'options' => PT_CV_Values::yes_no( 'yes', __( "Don't append '...' to the tail of excerpt", PT_CV_DOMAIN_PRO ) ),
					'std'     => 'yes',
				),
			),
		);

		// Read more button/link
		$args[] = array(
			'label'         => array(
				'text' => __( 'Read more', PT_CV_DOMAIN_PRO ),
			),
			'extra_setting' => array(
				'params' => array(
					'width' => 9,
				),
			),
			'params'        => array(
				array(
					'type'    => 'checkbox',
					'name'    => $prefix . 'readmore',
					'options' => PT_CV_Values::yes_no( 'yes', __( 'Show read more text/button', PT_CV_DOMAIN_PRO ) ),
					'std'     => 'yes',
				),
			),
		);

		$args[] = array(
			'label'         => array(
				'text' => '',
			),
			'extra_setting' => array(
				'params' => array(
					'width' => 9,
				),
			),
			'params'        => array(
				array(
					'type'   => 'group',
					'params' => array(

						// Read more text
						array(
							'label'         => array(
								'text' => __( 'Text', PT_CV_DOMAIN_PRO ),
							),
							'extra_setting' => array(
								'params' => array(
									'width' => 10,
								),
							),
							'params'        => array(
								array(
									'type'        => 'text',
									'name'        => $prefix . 'readmore' . '-text',
									'std'         => __( 'Read More', PT_CV_DOMAIN_PRO ),
									'placeholder' => 'e.g. ' . __( 'Read More', PT_CV_DOMAIN_PRO ),
								),
							),
						),
					),
				),
			),
			'dependence'    => array( $prefix . 'readmore', 'yes' ),
		);

		return $args;
	}

	/**
	 * Filter Pagination settings
	 *
	 * @param array  $args   The setting options of Exceprt
	 * @param string $prefix The prefix string for option name
	 */
	public function filter_settings_pagination( $args, $prefix ) {

		// Load more text
		$args[] = array(
			'label'         => array(
				'text' => '',
			),
			'extra_setting' => array(
				'params' => array(
					'width' => 9,
				),
			),
			'params'        => array(
				array(
					'type'   => 'group',
					'params' => array(

						// Load more text
						array(
							'label'         => array(
								'text' => __( 'Text', PT_CV_DOMAIN_PRO ),
							),
							'extra_setting' => array(
								'params' => array(
									'width' => 10,
								),
							),
							'params'        => array(
								array(
									'type'        => 'text',
									'name'        => $prefix . 'loadmore' . '-text',
									'std'         => __( 'More', PT_CV_DOMAIN_PRO ),
									'placeholder' => 'e.g. ' . __( 'More', PT_CV_DOMAIN_PRO ),
								),
							),
						),
					),
				),
			),
			'dependence'    => array( $prefix . 'style', 'loadmore' ),
		);

		// Alignment
		$args[] = array(
			'label'      => array(
				'text' => __( 'Alignment', PT_CV_DOMAIN_PRO ),
			),
			'params'     => array(
				array(
					'type'    => 'radio',
					'name'    => $prefix . 'alignment',
					'options' => PT_CV_Values_Pro::pagination_alignment(),
					'std'     => 'left',
				),
			),
			'dependence' => array( 'enable-pagination', 'yes' ),
		);

		return $args;
	}

	/**
	 * Filter setting to quick filter Terms
	 *
	 * @param array $args
	 */
	public function filter_term_quick_filter( $args ) {


		$args = array(
			'label'  => array(
				'text' => '',
			),
			'params' => array(
				array(
					'type'   => 'group',
					'params' => array(

						// Start with
						array(
							'label'         => array(
								'text' => __( 'Start with character', PT_CV_DOMAIN_PRO ),
							),
							'extra_setting' => array(
								'params' => array(
									'width' => 8,
								),
							),
							'params'        => array(
								array(
									'type'    => 'select',
									'name'    => 'term_filter_start_with',
									'options' => PT_CV_Values_Pro::array_a_z(),
									'std'     => '',
									'class'   => 'select2',
									'desc'    => __( 'Get all terms which their name starts with selected character (non case-sensitive)', PT_CV_DOMAIN_PRO ),
								),
							),
						),

						// End with
						array(
							'label'         => array(
								'text' => __( 'OR End with character', PT_CV_DOMAIN_PRO ),
							),
							'extra_setting' => array(
								'params' => array(
									'width' => 8,
								),
							),
							'params'        => array(
								array(
									'type'    => 'select',
									'name'    => 'term_filter_end_with',
									'options' => PT_CV_Values_Pro::array_a_z(),
									'std'     => '',
									'class'   => 'select2',
									'desc'    => __( 'Get all terms which their name ends with selected character (non case-sensitive)', PT_CV_DOMAIN_PRO ),
								),
							),
						),
					),
				),
			),
		);

		return $args;
	}

	/**
	 * Filter description of each setting option
	 *
	 * @param string $args  The content of description
	 * @param type   $param The setting array of this option
	 */
	public function filter_options_description( $args, $param ) {

		if ( ! empty( $param['popover'] ) ) {
			$args .= sprintf( ' <span class="glyphicon glyphicon-question-sign pop-over-trigger" rel="popover" data-content="%s" title="" data-original-title=""></span>', balanceTags( $param['popover'] ) );
		}

		return $args;
	}

	/**
	 * Add option to choose whether or not to exclude sticky post
	 *
	 * @param array $args
	 */
	public function filter_exclude_sticky_posts_setting( $args ) {

		// Ignore sticky post
		$args = array(
			'label'         => array(
				'text' => __( 'Sticky posts', PT_CV_DOMAIN_PRO ),
			),
			'extra_setting' => array(
				'params' => array(
					'wrap-class' => PT_CV_PREFIX . 'full-fields',
					'width'      => 10,
				),
			),
			'params'        => array(
				array(
					'type'    => 'checkbox',
					'name'    => 'exclude-sticky-posts',
					'options' => PT_CV_Values::yes_no( 'yes', __( 'Excludes sticky posts from output', PT_CV_DOMAIN_PRO ) ),
					'std'     => 'yes',
				),
			),
		);


		return $args;
	}

	/**
	 * Append more settings to Field settings
	 *
	 * @param array  $args
	 * @param string $prefix2
	 */
	public function filter_field_settings( $args, $prefix2 ) {

		// Custom fields settings
		$args[] = array(
			'label'      => array(
				'text' => __( 'Custom fields settings', PT_CV_DOMAIN_PRO ),
			),
			'params'     => array(
				array(
					'type'   => 'group',
					'params' => array(
						// Select fields
						array(
							'label'  => array(
								'text' => __( 'Select fields', PT_CV_DOMAIN_PRO ),
							),
							'params' => array(
								array(
									'type'     => 'select',
									'name'     => 'custom-fields-list',
									'options'  => PT_CV_Values_Pro::custom_fields(),
									'std'      => '',
									'class'    => 'select2-sortable',
									'multiple' => '1',
									'desc'     => __( 'Drag & drop to change display order of selected fields', PT_CV_DOMAIN_PRO ),
								),
							),
						),

						// Show field name?
						array(
							'label'  => array(
								'text' => __( 'Show name', PT_CV_DOMAIN_PRO ),
							),
							'params' => array(
								array(
									'type'    => 'checkbox',
									'name'    => 'custom-fields-show-name',
									'options' => PT_CV_Values::yes_no( 'yes', __( 'Yes', PT_CV_DOMAIN_PRO ) ),
									'std'     => '',
									'desc'    => __( 'By default, only value of field is displayed<br>Check this option to show both name & value of selected field', PT_CV_DOMAIN_PRO ),
								),
							),
						),
					),
				),
			),
			'dependence' => array( $prefix2 . 'custom-fields', 'yes' ),
		);

		return $args;
	}

	/**
	 * Add Filter by Time
	 *
	 * @param type $args
	 */
	public function filter_advanced_settings( $args ) {

		$args['date'] = __( 'Date', PT_CV_DOMAIN_PRO );
		$args['custom_field'] = __( 'Custom fields', PT_CV_DOMAIN_PRO );

		return $args;
	}

	/**
	 * Add settings panel for Date
	 *
	 * @param type $args
	 */
	public function filter_advanced_settings_panel( $args ) {

		// Filter by Date
		$date = PT_CV_Settings_Pro::filter_date_settings();

		// Filter by Custom Fields
		$custom_field = PT_CV_Settings_Pro::filter_custom_field_settings();

		// Move settings of Date, Custom Fields to 2nd, 3rd position, right after Taxonomy settings
		$args = array_slice( $args, 0, 1, true ) + $date + $custom_field + array_slice( $args, 1, count( $args ) - 1, true );

		return $args;
	}

	/**
	 * Do action before delete/trash View
	 */
	public function action_before_delete_view( $post_id ) {
		global $post_type;

		if ( $post_type == PT_CV_POST_TYPE ) {
			$user_can = PT_CV_Functions_Pro::check_user_role();

			if ( ! $user_can ) {
				wp_die( __( 'You do not have sufficient permissions to access this page.', PT_CV_DOMAIN_PRO ) );
			}
		}
	}

	/**
	 * Add settings tab header
	 */
	public function action_setting_tabs_header() {
		?>
		<li>
			<a href="#<?php echo esc_attr( PT_CV_PREFIX ); ?>taxonomy-filter" data-toggle="tab"><span class="glyphicon glyphicon-random"></span><?php _e( 'Shuffle Filter', PT_CV_DOMAIN_PRO ); ?>
			</a>
		</li>
		<li>
			<a href="#<?php echo esc_attr( PT_CV_PREFIX ); ?>animation-settings" data-toggle="tab"><span class="glyphicon glyphicon-flash"></span><?php _e( 'Animation & Effect', PT_CV_DOMAIN_PRO ); ?>
			</a>
		</li>
		<li>
			<a href="#<?php echo esc_attr( PT_CV_PREFIX ); ?>style-settings" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span><?php _e( 'Style Setttings', PT_CV_DOMAIN_PRO ); ?>
			</a>
		</li>
	<?php
	}

	/**
	 * Add settings tab content
	 *
	 * @param array $settings
	 */
	public function action_setting_tabs_content( $settings ) {
		echo balanceTags( self::_tab_shuffle_filter( $settings ) );
		echo balanceTags( self::_tab_animation_settings( $settings ) );
		echo balanceTags( self::_tab_style_settings( $settings ) );
	}

	/**
	 * Setting HTML of "Shuffle Filter" tab
	 *
	 * @return string
	 */
	static function _tab_shuffle_filter( $settings ) {
		ob_start();
		?>
		<div class="tab-pane" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>taxonomy-filter">
			<?php
			$prefix = 'taxonomy-filter';
			$options = array(

				// Enable
				array(
					'label'         => array(
						'text' => '',
					),
					'extra_setting' => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'        => array(
						array(
							'type'    => 'checkbox',
							'name'    => 'enable-' . $prefix,
							'options' => PT_CV_Values::yes_no( 'yes', __( 'Enable reorder and filter posts with a nice shuffling animation', PT_CV_DOMAIN_PRO ) ),
							'std'     => '',
							'desc'    => __( 'Only works with "View type" as <strong>Grid, Pinterest</strong> and "Pagination" is <strong>disabled</strong>.<br>Options to filter posts are <strong>selected terms</strong> OR <strong>all terms of selected taxonomy</strong>', PT_CV_DOMAIN_PRO ),
							'popover' => sprintf( "<img src='%s'>", plugins_url( 'admin/assets/images/popover/selected_terms.png', PT_CV_FILE_PRO ) ),
						),
					),
				),

				// Style
				array(
					'label'         => array(
						'text' => __( 'Type', PT_CV_DOMAIN_PRO ),
					),
					'extra_setting' => array(
						'params' => array(
							'wrap-class' => PT_CV_PREFIX . 'shuffle-filter-type',
						),
					),
					'params'        => array(
						array(
							'type'    => 'radio',
							'name'    => $prefix . '-type',
							'options' => PT_CV_Values_Pro::taxonomy_filter_style( 'filter-bar-sample' ),
							'std'     => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::taxonomy_filter_style() ),
						),
					),
					'dependence'    => array( 'enable-' . $prefix, 'yes' ),
				),

				// Item spacing
				array(
					'label'      => array(
						'text' => '',
					),
					'params'     => array(
						array(
							'type'   => 'group',
							'params' => array(
								array(
									'label'         => array(
										'text' => __( 'Space', PT_CV_DOMAIN_PRO ),
									),
									'extra_setting' => array(
										'params' => array(
											'width' => 10,
										),
									),
									'params'        => array(
										array(
											'type'        => 'number',
											'name'        => $prefix . '-space',
											'std'         => '10',
											'append_text' => 'px',
											'desc'        => __( 'Spacing between the filter options', PT_CV_DOMAIN_PRO ),
										),
									),
									'dependence'    => array( $prefix . '-type', 'btn-group' ),
								),
							),
						),
					),
					'dependence' => array( 'enable-' . $prefix, 'yes' ),
				),

				// Margin
				array(
					'label'      => array(
						'text' => __( 'Bottom margin', PT_CV_DOMAIN_PRO ),
					),
					'params'     => array(
						array(
							'type'        => 'number',
							'name'        => $prefix . '-margin-bottom',
							'std'         => '20',
							'append_text' => 'px',
							'desc'        => __( 'Spacing between the filter options bar and the result', PT_CV_DOMAIN_PRO ),
						),
					),
					'dependence' => array( 'enable-' . $prefix, 'yes' ),
				),

				// Position
				array(
					'label'      => array(
						'text' => __( 'Position', PT_CV_DOMAIN_PRO ),
					),
					'params'     => array(
						array(
							'type'    => 'radio',
							'name'    => $prefix . '-position',
							'options' => PT_CV_Values_Pro::taxonomy_filter_position(),
							'std'     => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::taxonomy_filter_position() ),
							'desc'    => __( 'The position of filter options bar', PT_CV_DOMAIN_PRO ),
						),
					),
					'dependence' => array( 'enable-' . $prefix, 'yes' ),
				),

			);
			$options = apply_filters( PT_CV_PREFIX_ . 'taxonomy_filter_settings', $options );
			echo balanceTags( PT_Options_Framework::do_settings( $options, $settings ) );
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Setting HTML of "Style Setttings" tab
	 *
	 * @return string
	 */
	static function _tab_style_settings( $settings ) {
		ob_start();
		?>
		<div class="tab-pane" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>style-settings">
			<?php
			$prefix = 'style-settings';

			$options = array();

			// Font settings
			$options[] = PT_CV_Settings_Pro::field_font_settings_group( 'show-field-' );

			// View style: Margin. Border. Background color
			$options[] = PT_CV_Settings_Pro::view_style_settings();

			$options = apply_filters( PT_CV_PREFIX_ . 'style_settings', $options );
			echo balanceTags( PT_Options_Framework::do_settings( $options, $settings ) );
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Setting HTML of "Animation & Effect" tab
	 *
	 * @return string
	 */
	static function _tab_animation_settings( $settings ) {
		ob_start();
		?>
		<div class="tab-pane" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>animation-settings">
			<?php
			$prefix = 'animation-settings';

			$options = PT_CV_Settings_Pro::animation_settings();

			$options = apply_filters( PT_CV_PREFIX_ . 'animation_settings', $options );
			echo balanceTags( PT_Options_Framework::do_settings( $options, $settings ) );
			?>
		</div>
		<?php
		return ob_get_clean();
	}
}
