<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://vrodex.com
 * @since      1.0.0
 *
 * @package    Vrodex
 * @subpackage Vrodex/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Vrodex
 * @subpackage Vrodex/public
 * @author     Vrodex <support@vrodex.com>
 */
class Vrodex_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
	}

	public function add_header_widget()
	{
		$api_key = get_option('vrodex_setting_api_key', null);
		if ($api_key == null) {
			return;
		}

		echo '<!-- Vrodex Booking Widget -->';
		echo '<script id="vrodex-booking-script" data-language="nl" data-token="' . esc_js($api_key) . '" async src="https://bookingwidget.vrodex.app/js/index.js"></script>';

		echo '</script>';
		echo '<!-- // Vrodex Booking Widget -->';
	}
}
