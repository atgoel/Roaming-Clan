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
define('DB_NAME', 'roamin11_wp');

/** MySQL database username */
define('DB_USER', 'roamin11_wp');

/** MySQL database password */
define('DB_PASSWORD', '.6S51)PzVa');

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
define('AUTH_KEY',         'pu3asrdveyg0xhb6axjhoj1lwxfwl9vw7ior5ose4ya2ohzgdinathwmchfcusc0');
define('SECURE_AUTH_KEY',  'f0sj7hkqbga2bvt0pvjwkkjekbf9nxvc6bpu5scok9yoznhdkg0iwrfeqv0lgxx0');
define('LOGGED_IN_KEY',    '1noava2cgfoatu0np9glgsardmsxvg31l6dxn9j37sukggmnb7z5qp2l7ztv6ray');
define('NONCE_KEY',        '5o08kwrmvmf4f9whex56nbo0d66jcks3cpnzfydroxxyhexdx0erovoi5uqqltgi');
define('AUTH_SALT',        'ugwnctivvscmdbh9j48miipo2t9ec4w988kwkcpn393pjdtlmu5uixkwuln3ruwv');
define('SECURE_AUTH_SALT', 'fkfvwsq9eeyabsxwfqd4jlfhyjhvtsjkkkv7jk4og3ogejfvuytgaji7c5zcnyll');
define('LOGGED_IN_SALT',   'hv0mzaodnfisfpbxrywmaljhtqrbkib0w5xswxpcmqmbcg1encxrpkos3ydcnyea');
define('NONCE_SALT',       'p8n563bwji1hcdkfnm4hf6ghn69sxsw0dzsuwxsonjxh9xipc82ikhiyzrpflxdc');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpstg1_';//  = 'wp_';

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
define( 'WP_MEMORY_LIMIT', '128M' );


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
