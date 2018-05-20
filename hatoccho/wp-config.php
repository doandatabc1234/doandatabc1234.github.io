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
define('DB_NAME', 'data_hatoccho');

/** MySQL database username */
define('DB_USER', 'data_hatoccho');

/** MySQL database password */
define('DB_PASSWORD', '@hamrong@2018');

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
define('AUTH_KEY',         'nxa.)sxVfF?ftu5a&f#j?|?UDZIV$^*j85#;@2HAE`0=&`+RTE EtejDzz(-JXbw');
define('SECURE_AUTH_KEY',  '1oT:b:PYMVD;kOl?/,j@?&%}vtLe<eA(ilS6KcA(De]cmQs(U2YYs%L46Ez[m *|');
define('LOGGED_IN_KEY',    '^)jl`c;3)SV-LF1Rvx7rP^f?SUTm+9P7>>ts6,^g@9lY*?z9[Jh3|xZMWvuC(=F]');
define('NONCE_KEY',        'N68W%>TSIzE_OW%q|DaUoOiqXMX,p#MT{}|^!Fovhd%!6f%vC0{9Hi8T*>>Fbl}_');
define('AUTH_SALT',        '|3=PVqq8}g]UY`S}{q,5|tpZOEAs[e8_hk1}rqvJ6X}:YS}8?N;%0uI{Y8_lN<Tv');
define('SECURE_AUTH_SALT', '_A::d}o*{Y7<GU[@}:sXI3*%ssA,CGaq$a_m`Y7SsWo42PzGj9[QzF%0FU>cYl#[');
define('LOGGED_IN_SALT',   '_9?xC];D Z(_L_,(qlt:O<OmX?xY:l;0ne%XkgnO(b*uFgw#c=d-~u6xM[~DCoGm');
define('NONCE_SALT',       'myX?1C8U|S~2Fn,wI]=68%Uj9BNKZsXF~,.6m{=9F~<jV}ROf6+jJu!+]fiJ8SYa');

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
