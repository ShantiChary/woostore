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
define('DB_NAME', 'store');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '!ELxS#x0m8hK(sl1Ze!>~YG6Mun~BZO,ox]%a tb+(uHHda.+@l0s`(ug+![krvg');
define('SECURE_AUTH_KEY',  ';D!2Al90RH0Q`)6cGAFkX]7K*cDC,4D#+FwHg66)XJf/z.r5ovBSD?0ReB`&A|}V');
define('LOGGED_IN_KEY',    '%B 3Nk}$nFgd^3hEj?0_LZ$kx389 3z`c*9:Ig}}xE}+;GYHxN3gS>:K_.[R}eH@');
define('NONCE_KEY',        '*Z()G``~YrRVq<e](hK(@ wom,SGiKldI`;l`7{J:ZN1T@d<RC__I0{g7p,I/F;K');
define('AUTH_SALT',        'eNVK: 2.Q?#=t,pD/-}%l[IdR6+dW((!_ss&UD[tnbX#e_/K[Z/JuI- qP{7}JeU');
define('SECURE_AUTH_SALT', '>0cV*:Kq(]H6Klg,j~]7h<e?4e8UxOgZ|!]S#`r:_G17h8M6XGBIF<G(I`0WS%Lm');
define('LOGGED_IN_SALT',   'w.@{Dq=J`a4pWZGzD/=x!5ae:2]a`UZX_V@]uN2z8^9P=MmD*hO(..7$K)S!/+)z');
define('NONCE_SALT',       'hR;h=R-<C($S0hT`&?=r:5v|qMq^O{ci2/!%_r~bZ4+kH9gfy)VsSu/bs^~b7V/G');

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
