<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://vrodex.com
 * @since             1.0.0
 * @package           Vrodex
 *
 * @Vrodex
 * Plugin Name:       Vrodex Booking Widget
 * Plugin URI:        https://vrodex.com/wordpress-booking-plugin/
 * Description:       Integrate the Vrodex Booking Widget effortlessly onto your website and transform visitors into customers.
 * Version:           1.0.5
 * Author:            Vrodex
 * Author URI:        https://vrodex.com
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vrodex-booking-widget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('ABSPATH'))
	exit; // Exit if accessed directly      

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('VRODEX_VERSION', '1.0.5');
!defined('VRODEX_PATH') && define('VRODEX_PATH', plugin_dir_path(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vrodex-activator.php
 */
function vrodex_activate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-vrodex-activator.php';
	Vrodex_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vrodex-deactivator.php
 */
function vrodex_deactivate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-vrodex-deactivator.php';
	Vrodex_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'vrodex_activate');
register_deactivation_hook(__FILE__, 'vrodex_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-vrodex.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function vrodex_run()
{

	$plugin = new Vrodex();
	$plugin->run();
}
vrodex_run();
