<?php
 
 function slide_panel_script() {
	wp_enqueue_script( 'SlidePanel', get_template_directory_uri() . '/js/ddajaxsidepanel.js', array(), true );
}
add_action( 'wp_enqueue_scripts', 'slide_panel_script' );

function webriti_remove_admin_bar_links() {
global $wp_admin_bar;

//Remove WordPress Logo Menu Items
$wp_admin_bar->remove_menu('wp-logo'); // Removes WP Logo and submenus completely, to remove individual items, use the below mentioned codes
$wp_admin_bar->remove_menu('about'); // 'About WordPress'
$wp_admin_bar->remove_menu('wporg'); // 'WordPress.org'
$wp_admin_bar->remove_menu('documentation'); // 'Documentation'
$wp_admin_bar->remove_menu('support-forums'); // 'Support Forums'
$wp_admin_bar->remove_menu('feedback'); // 'Feedback'

//Remove Site Name Items
/*$wp_admin_bar->remove_menu('site-name');*/ // Removes Site Name and submenus completely, To remove individual items, use the below mentioned codes
/*$wp_admin_bar->remove_menu('view-site'); // 'Visit Site'
*/$wp_admin_bar->remove_menu('dashboard'); // 'Dashboard'
$wp_admin_bar->remove_menu('themes'); // 'Themes'
$wp_admin_bar->remove_menu('widgets'); // 'Widgets'
$wp_admin_bar->remove_menu('menus'); // 'Menus'

// Remove Comments Bubble
$wp_admin_bar->remove_menu('comments');

//Remove Update Link if theme/plugin/core updates are available
$wp_admin_bar->remove_menu('updates');

//Remove '+ New' Menu Items
$wp_admin_bar->remove_menu('new-content'); // Removes '+ New' and submenus completely, to remove individual items, use the below mentioned codes
$wp_admin_bar->remove_menu('new-post'); // 'Post' Link
$wp_admin_bar->remove_menu('new-media'); // 'Media' Link
$wp_admin_bar->remove_menu('new-link'); // 'Link' Link
$wp_admin_bar->remove_menu('new-page'); // 'Page' Link
$wp_admin_bar->remove_menu('new-user'); // 'User' Link

// Remove 'Howdy, username' Menu Items
/*$wp_admin_bar->remove_menu('my-account');*/ // Removes 'Howdy, username' and Menu Items
/*$wp_admin_bar->remove_menu('user-actions');*/ // Removes Submenu Items Only
/*$wp_admin_bar->remove_menu('user-info'); */// 'username'
/*$wp_admin_bar->remove_menu('edit-profile');*/ // 'Edit My Profile'
/*$wp_admin_bar->remove_menu('logout');*/ // 'Log Out'

}
add_action( 'wp_before_admin_bar_render', 'webriti_remove_admin_bar_links' );
 
 
 
?>
