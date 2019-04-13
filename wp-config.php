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
define( 'DB_NAME', 'fenoadss_wp869' );

/** MySQL database username */
define( 'DB_USER', 'fenoadss_wp869' );

/** MySQL database password */
define( 'DB_PASSWORD', '87K8Jpi()S' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'wz4euugbkfh4alobtz3xpno5o61efg39agqbt1fecqlj0l8vwos4fnblqtcwl7xw' );
define( 'SECURE_AUTH_KEY',  'vbphaxsmzdwfapgyscxxx5nwbtwtyxgztb56vlw6wnkb9dbhofntni5dpmbotzfx' );
define( 'LOGGED_IN_KEY',    'vflytj1b6fhpsc12zu0m7lyptk91zxdm6c5cicivwze768bryrp5zglsebupa4fe' );
define( 'NONCE_KEY',        'wttvtutolhgxn6jpmus0tf9koeflkfwe1qdepmrsnhx3qslhtogh0wyrr35np5og' );
define( 'AUTH_SALT',        'uqzehrqlkov0qwecsp7vn38eakpzsjrn5q20zar3rghll5ww5x0yhayb7qc3zmxp' );
define( 'SECURE_AUTH_SALT', '0iihzuxlfe5f2syqxjvitj6dpnmezhxeftte0qbyej9csj1k4xj1qfjpv6bnir9u' );
define( 'LOGGED_IN_SALT',   'lxsucygycwiiuhuw1exs0xy40pvmkyc4ho9pnj8sqaq4u9iqfoqh0i9fwdsi3z6j' );
define( 'NONCE_SALT',       'k5glypwqgmrm4obpwwoxwa2t1frrxkbmk5rlqeto6zktyntazh3ulwyrzdkqn2ij' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpgz_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
