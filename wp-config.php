<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'quantatcwpsite_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'Gd.`wqKM,s8vH%ruP]b7x2@6L$})`E$TWWl5h&opv<oP2S-[pNe(4$5})e}j}5&P' );
define( 'SECURE_AUTH_KEY',  '(q;9i8c})m:!1E[gb)>UWGN[4j[Q csU9;zCBso9c]qq$fx@vX9TpI+xTw;& ON6' );
define( 'LOGGED_IN_KEY',    'J*d%bhv+2LJjsi?63Myk!?}*6U>.o&8uJ+ODHqX51{hDT_}|Tf,?d5HH>}g9dDM/' );
define( 'NONCE_KEY',        'uE,M`,L}e!j FBfgRWkF=v#t=d$&lE-~1ruuJXo{w4#^(ftO%Y#~RcFBoyLv-b57' );
define( 'AUTH_SALT',        'MXl/5}$=8;%rU2)v<9T!V0@@d~*$sB+4Bmttui!|G/qP.{>L+h#Y@0w[,;z5.x:J' );
define( 'SECURE_AUTH_SALT', '2R}Sl|WDXZA71:HfpRb|lqoezS=K={42kH*g>9!(?at~g<DQ11G>#~qafUoyX`A?' );
define( 'LOGGED_IN_SALT',   '=Zd1$@{H =>C*|}9|+i^YL+*TM6<2O4]Q5{4INJ3P*^OD+?nebhr<_{c:<sv+t]V' );
define( 'NONCE_SALT',       'pmr^RxUFN8Q(Klde2hb1u1XWwePM:e{u;4+[&a8llP7m4SH^9Xeg!p6PH;!pp=#?' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
