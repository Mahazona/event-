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
define( 'AUTH_KEY',          'LqO,x|=ZWF-7i?Y+t_|kS({$(r;u6FSipu4r][iRd/5M&{5(XWMaf^QqqGcA0:NF' );
define( 'SECURE_AUTH_KEY',   ')0vT8zP))X~r3)>USyK.DTJ6q9dse?(X!#B0h0wF[zp_ 8cLC297w&H.i2MHL+2=' );
define( 'LOGGED_IN_KEY',     ' mP=MrMC4?p;>*zki9~BR)FC+:I5/[[=B5QrKbA )*6In8gmrx_]r9!lnA_fN(J:' );
define( 'NONCE_KEY',         'S6xFt,q )gbuZf|x][u! m,fSAeJl*$Q05)2rK^3)>uBn>%=iV4?$dNQWwBoMH78' );
define( 'AUTH_SALT',         '@%LvL;<Z<U$]06;V,*4Fs6mYN%P<DeO!JyHX|[WVp+/D3SMi9Y~+|K-(fc7j@<cO' );
define( 'SECURE_AUTH_SALT',  ':l`$)|gy`<<Xradh(^t1K2Ot.}]|{4>E]{!`38]#H8Ip0>&dR^%krH23F/!3vG(l' );
define( 'LOGGED_IN_SALT',    '*B7/EIuhk31dTAS@8#^md5I*W4ez-1+: K1vhS?m%I4{d6mtS2J5[!:Q ib<k+[X' );
define( 'NONCE_SALT',        '8@vTQ(</unR]gvBq.{X~#SA9s~TNTtB`]Aqa ST#y,{v-TNH+s,|)jp~2cy)+?S5' );
define( 'WP_CACHE_KEY_SALT', 'oyHc+rsU2@}c`d:ja:~fK7G5</c((Ws8g}hV&#ospB7s%UV[(j0M{P4Y/QSZ.y&/' );


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
