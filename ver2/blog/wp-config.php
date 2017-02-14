<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'blog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'mydevsql129');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         ';}/BSk$;]g>~%s-aElc5{t-KTzInJG0E@N}#z-^96raatU`M16?!U;rc>2&In:O2');
define('SECURE_AUTH_KEY',  'oB~j*p-@W5Wc E mkU9IcXI=XAARN!d+ec:Ya#i-oO.2%&b8e0s]08$kB$t)DKCc');
define('LOGGED_IN_KEY',    'Qs~p-5dghB|!|Ri)n|<!5tFR:q_a+c|*iJ*4}- 1lpQ`FF{y_oi1:en4<w--!E)+');
define('NONCE_KEY',        '$D3!nY|q3Yc=?oa|U@ccbK[@wAKMA,`kq{+3#4v`4XL47eJ-U-Df+A/Eq+4`-NsK');
define('AUTH_SALT',        'sU$0@?^gTm,~`P0yQu@1w kY6suWby4<}Gs:n*x0AL ut(|=@{:9PAg]I(&*_m_r');
define('SECURE_AUTH_SALT', '_dOG:HJ_Bx,75PWBF-P6d&s&>6m](bk/F0`8P,&%n/IY?Im`;Yz,G8@-6<0?NywB');
define('LOGGED_IN_SALT',   'W-<dPuzNHPNcJIo=bgY3jc}]t2+MT|hx,G7 JC,N#`7-;qjQLjEnX#VHqS+EFz._');
define('NONCE_SALT',       '][RtnC@fb<2S}/xh/#~Eq^9TEr+dn4Eu2MNsU4r.9W+#|gpS 2!*-&<DqROsJk<J');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


define('FS_METHOD', 'direct');