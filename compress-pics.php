<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://clarify.nl
 * @since             1.0.0
 * @package           Compress_Pics
 *
 * @wordpress-plugin
 * Plugin Name:       CompressPics
 * Plugin URI:        https://clarify.nl
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Abel Schupp
 * Author URI:        https://clarify.nl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       compress-pics
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'COMPRESS_PICS_VERSION', '1.0.0' );

require __DIR__ . '/lib/autoload.php';


new \Abel\CompressPics\Loader();