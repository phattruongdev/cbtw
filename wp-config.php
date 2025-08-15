<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'St%SHz;=.Cf<oyIN0adQ7.:w<|vc<I09)=m%Pa! ??YOo9Uvo5c5>cJb%B70;)fL' );
define( 'SECURE_AUTH_KEY',   '@B:M<:(>);PYVznhlp-=7DYMe7~SKL5:H]1~ZuRLl^l}U[wJPMt<Q)*FzH4=h&O2' );
define( 'LOGGED_IN_KEY',     ';%:<3fH=]mW{T0{xRs< }>`UqPbCNB_pUf/E+kvTeQJ.B9ce_(gM~M0>fFuap%Ts' );
define( 'NONCE_KEY',         ';[l-5HZu{zYTts]Yd0*TI9qNM8-u-3rDa@03fy!!p2kWc-&NmCua<q.Azjy#7ASU' );
define( 'AUTH_SALT',         '[`HsGICBR_N ka{$k@d&jZpveIu18m|4mDmu}~yTqqm7NJ. =KU7LNVv&A`[}I.#' );
define( 'SECURE_AUTH_SALT',  '-7o%lJ`_CL{$my?gJ;%!o5z3O#;2;yR3:+3ivQfSfZg<P}=Zea=}bgSf5i4Ey*yR' );
define( 'LOGGED_IN_SALT',    'X!:Jr#e+9e.i,HJ)@h7Idk$@AltJX]QE~NNm4gSV:lPf+e%&&MB69k^Pgn8) nNR' );
define( 'NONCE_SALT',        '7m3Hg0LUrmeVshmJVGFL7#;)po) c~vqG<J`ciDU;C3.fa?GHQ/H`~R;5^eLL)Qd' );
define( 'WP_CACHE_KEY_SALT', '$m6NNKYqyqTBfcANs49INe@*yFN/|HWbt~WM}SkV|rOmk?tNk2a-03e}vI]HfKxZ' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
