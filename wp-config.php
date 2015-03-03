<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ponabanaDBpvwq6');

/** MySQL database username */
define('DB_USER', 'ponabanaDBpvwq6');

/** MySQL database password */
define('DB_PASSWORD', '9FZTkQKbZq');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'UN:_[SZOOS5C-dhahW_]px_lp5]18C|dkORRZN-@hlsSZ|-_~|-GO:5qTa*.mtL;6');
define('SECURE_AUTH_KEY',  'tieW#*+t_piH92]3{.jbTXQIE^yqnfXU>u,$yqM3{IE6;qXPebTL<umyqi3{.*<');
define('LOGGED_IN_KEY',    'h:[8|~ZVOGC5:tldWZSK[_-|@wsNG:C4}[kcJRKC8-sZogdV1@wpmeW#*+]_pLD92');
define('NONCE_KEY',        '>>,UNFbYQ^yrn$ub7<,}zrMJB3I>jcYQK1[kdZRgNG!@woldV5:|[!~wS81NFC4');
define('AUTH_SALT',        '_OSKG9phdleK#_-twplH9#C81[ZRKdVC~wskhZS1[w|~-sC5:qiP{<*.+xqL2]6<');
define('SECURE_AUTH_SALT', 'OVN:|@!zwo80[1:|~OG8RKC4kdVTLD6meWpiaS.+x*xeA2;<6.+XTLDOH9~xptlda');
define('LOGGED_IN_SALT',   'JvcYnUN}G91taShdWO~wp-tl5;#wSOH9KC4-sZohdV|@w_-hC51[8|~6;<.eLETLH');
define('NONCE_SALT',       'qTeWS;#t_~xp91]5;#WPH9SLD5leWUME7nfXqjb{.$y^nfB3>7<XQIBbA+yqime');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
