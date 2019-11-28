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
if (file_exists(dirname(__FILE__) . '/local.php')) {
	// local database settings
	define( 'DB_NAME', 'local' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASSWORD', 'root' );
	define( 'DB_HOST', 'localhost' );

}	else 	{

	// live database settings
	define( 'DB_NAME', 'siwatt29_universitydata' );
	define( 'DB_USER', 'siwatt29_wp114' );
	define( 'DB_PASSWORD', '26245rc6brb4' );
	define( 'DB_HOST', 'localhost' );

}




/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'w0OP1>{S ie)?.-_*h>b.Sr7F&WkO1lJy{(&r|Ds80Y(UlA?~JKL$w_?M>m3(Nr/');
define('SECURE_AUTH_KEY',  '8(G{:Ci}YI,|418+R$%q?KcEH+Y7Qg@dmEA5E9-z/]/#FQz-54{]Idf+WPwOxu<Z');
define('LOGGED_IN_KEY',    'm3b8E=|~zMyS^ATG]O<5(|LR#:S^E04{Jvvy_BAk{R^y]16/z,ffo[o @~1Hr$t#');
define('NONCE_KEY',        'u9u-A<4 -JrBCNE+X)(A+fjpfHvMC9~EOKz!VEz--C3`$WkBY9z5PeQ]3r<w Y.v');
define('AUTH_SALT',        'hBZ:1vj*d tc[0+-k+aWES#MwF;s9+aM^+SPc7n3`,^.||_!KVFTLD`U9hmK?1p+');
define('SECURE_AUTH_SALT', '2-QE`Sx)OiL(tm_D|gNiU<uttYiC>sKyko7J|Zj<gDF_n|gMlty4I-ipvifXW!u)');
define('LOGGED_IN_SALT',   'T @6|}_]wI|9dol-$1i18bZs}vU!}}y%(KdyB?eni37<xV+$ulB?>nhpFt9:=%z`');
define('NONCE_SALT',       '=Wc,*lwgaw:P+vWBfz;ra=.}jEn9`@!e,8;%o_t2#~Ey+|-DFXuiONp]KSt?J>@Y');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
