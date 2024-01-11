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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "wordpress" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "test" );

/** Database hostname */
define( 'DB_HOST', "db" ); 

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
define( 'AUTH_KEY',         'ofdJ4Rj|J*:K+y>|uK^~@:FL3`c(UrJnd&SQU!;Hh77^nuy[ETkDUb2c/DQI<U`P' );
define( 'SECURE_AUTH_KEY',  'e?r:D$:@mA,Uk-~H|0id?Z|31;iO/xJ*7l;+Ct4tSBe8ASVQjls:r><np.,OlYL%' );
define( 'LOGGED_IN_KEY',    '[o|B#!hBl!_LS}>);f[HLvM0WLigV>C[C=IE5[aa)YXH1DQkpPCU%-q@W6a.8=m&' );
define( 'NONCE_KEY',        '@QBb`#PsBRV--Kv< 1&8$kp4o_gJ-Y<42ITS+b6x.0&ob[lzQCA*UVfUC~_-Ct;9' );
define( 'AUTH_SALT',        'zW&>]l4jEC`Ek<kbdKt1Z>E~~ejZC^Vf<7Yb!?<dX3d0#**7<F/P+ *D<d}.vY-W' );
define( 'SECURE_AUTH_SALT', 'J|,Lk7|STtSD,+}M>/5C_q)Z?N@eOPdU~TCg1qsY-<}v<b6I~j4emzB_^h=|_IBo' );
define( 'LOGGED_IN_SALT',   '<.1Uv$}G> a|(;ip5oUrhHJf!hAnC?uL!jC!d+C(;:dK AUR;zY86f*b=*!RS^#H' );
define( 'NONCE_SALT',       ')w3fMyg4P9>-nDo/8VMs?-q87!obJXW=FZcmcvS/~N5%DpFt^Ax?7={e]f5E9sN/' );

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
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
