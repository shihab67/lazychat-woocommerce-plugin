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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'woocommerce-plugin' );

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
define( 'AUTH_KEY',         'Q,VQ=.baO^E<vZ/qaI/Ud)eQ3gU[0Kb2i=B~Ibv8F,d;X sGCEP8A()Tv9ewzej{' );
define( 'SECURE_AUTH_KEY',  ';d3CnjjJ^Z;nS![:>y!Zb8MIKz+APg0pxF#+CPF%jXM_-Ui`ma>&|t.&ByUqu,;Z' );
define( 'LOGGED_IN_KEY',    'Xjc18hTNOT:?$Behvbprw:p^[$VGJQa;Bz57a{lCBwUnQqS:aDI2*olhlcOd,;G[' );
define( 'NONCE_KEY',        '1Z+MJ%a]^H/jRFa%RU`qrL*~[3sstpLLUFH9r#ya8Y rvm2v083-#ZCC;IiN1`s[' );
define( 'AUTH_SALT',        '^;-R.M^O|c}hciy>]pJ->e_}?pSj9[H/].}-%d)hF@V`9~i@PtV[c-t}W_K9AihI' );
define( 'SECURE_AUTH_SALT', '6m+Y|oO(NPEN~9YTuy2fzS6<UB_6Jl:7e/cHxwPK5f-auj7W.mff968>)&HtwO,t' );
define( 'LOGGED_IN_SALT',   'M4 |)nRuN EyXOo#)#%.Y; NS@;OJ;?_r_uh_/e}|Q,%R]WujGgNPQW{M8!w^orG' );
define( 'NONCE_SALT',       '#)2^- t<$x7.%88z&|Ljx}ulpTj0w}2Op|S|sJ=1xlBB2m=}28Kpo&W)cn,dJqPP' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
