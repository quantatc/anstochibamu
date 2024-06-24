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
define( 'AUTH_KEY',         '~JP5NUv6)ixf A}0_C?p=|)[*M3 =]ed5]!}F=QG(7i!:WK+xsW}#uz+xj,ir6$!' );
define( 'SECURE_AUTH_KEY',  '4jdY,yn-fE&_{N]e+}::ap)F&%|+I=QyW7$Q#f6>V!^m7rblIp_*c&h//)8Vs/br' );
define( 'LOGGED_IN_KEY',    'K?n%dyt5]x8~y}5ZQ]7b)@S^c%Bt%<jgq52>?46=,,9^#}yQO&xOKf3!cO,S$jo+' );
define( 'NONCE_KEY',        '0!Ce87=NAv&lYLP[<_4PU=Um*9.`D{Z~Kweyt :!#Wk#z4p7&N{oJQ&GI;+ud^pl' );
define( 'AUTH_SALT',        'RkTxtM^#<:.Frcv&=D)1%FUF)!}#O`t%e U,I!k)%1?et[WV6n?7!DSX6m~ b<E ' );
define( 'SECURE_AUTH_SALT', ';$qJ<<~V;[!@!A>(Vn#rm:&G=&ss[Tp>y`qMZ-$PmXR6PC4_!_8ZK[Krhwn?6ym>' );
define( 'LOGGED_IN_SALT',   'g(_WF$zE_<1(sT r[iTmGr<7?rdc:|fsCt}#QpH$Z$T$umsPE-1ps4G=*6udx->Y' );
define( 'NONCE_SALT',       'UOu(LP}~46^)[6l7Q<r:pHTSC%O2[%oZi<M82@ w&Jx*wNSK+ILxyMm{!1JYGt!&' );

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
