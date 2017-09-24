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
define('DB_NAME', 'wih');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'garbage');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         '#oWA1d9:>i,iH_5xuQ>D(Sfbqq6suNz^QpjKh9/=fD:=V0B+G<[b<j-JTnjfCC;k');
define('SECURE_AUTH_KEY',  '.!F9e`PzHS`[cZ42$Ov6sL/rLxQ9P2jY:>B6^w_M@C$J,5#Rm>X8}d#_`si93|~7');
define('LOGGED_IN_KEY',    '@UNd`bx4}R!5eiUKT^x`oBlGmwf7,vPXbT4A@JV3aM;ng&6m}<wq%PiAf7+Wj,1|');
define('NONCE_KEY',        'l>qRxOag(IE!])X:DymhfPqfZ4vee6lXr}t}bmFtFl?4P!-PPZ;d@lX/<KnCw:vu');
define('AUTH_SALT',        'h<d:4#SH]}):#oBZ5hD)8*hRME`oF@TCtX.?R8Ndc@,?q&?&C] &NKsK?M4]DxLl');
define('SECURE_AUTH_SALT', '{~j?aAXiw3u]SU#]c5gJ(cMnbJm[DVDT1JVBB/kY-{(M0ry:lio$uBTfzkA I!0E');
define('LOGGED_IN_SALT',   '=^Z(:A=L)0Hm$3:~jntPO(~_*1^=o1M2=0*PMt8YG:k?6M~PZJ:)|*X&wD&)mlN^');
define('NONCE_SALT',       '|S?xxI0b{h=I3#_+Onz{#&HXwhvnP$p!bv9c1_8b;sDJ<H=QSlTa(q`_Df bc5-%');
//define('AUTOSAVE_INTERVAL', 300 ); // seconds
define('WP_POST_REVISIONS', false );
define('WP_HOME','http://wih/');
define('WP_SITEURL','http://wih/');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wih_';

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
