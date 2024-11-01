<?php

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly      

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://vrodex.com
 * @since      1.0.0
 *
 * @package    Vrodex
 * @subpackage Vrodex/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vrodex
 * @subpackage Vrodex/admin
 * @author     Vrodex <support@vrodex.com>
 */
class Vrodex_Admin
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
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'vrodex_setting';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vrodex_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vrodex_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/vrodex-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vrodex_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vrodex_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/vrodex-admin.js', array('jquery'), $this->version, false);
	}
	/**
	 * Register the setting parameters
	 *
	 * @since  	1.0.0
	 * @access 	public
	 */
	public function register_vrodex_plugin_settings()
	{
		// Add a General section
		add_settings_section(
			$this->option_name . '_general',
			__('General', 'vrodex-booking-widget'),
			array($this, $this->option_name . '_general_cb'),
			$this->plugin_name
		);
		// Add a numeric field
		add_settings_field(
			$this->option_name . '_api_key',
			__('API Key', 'vrodex-booking-widget'),
			array($this, $this->option_name . '_api_key_cb'),
			$this->plugin_name,
			$this->option_name . '_general',
			array('label_for' => $this->option_name . '_api_key')
		);
		// Register the numeric field
		register_setting(
			$this->plugin_name,
			$this->option_name . '_api_key',
			array(
				'type' => 'string',
				'sanitize_callback' => array($this, 'sanitize_api_key'),
			)
		);
	}
	public function add_action_links($links)
	{

		$settings_link = array(
			'<a href="' . admin_url('?page=' . $this->plugin_name) . '">' . __('Settings', 'vrodex-booking-widget') . '</a>',
		);
		return array_merge($settings_link, $links);
	}
	public function vrodex_plugin_setup_menu()
	{
		add_menu_page('Vrodex Bookings settings', 'Vrodex Bookings', 'manage_options', 'vrodex-booking-widget', array($this, 'vrodex_init'), 'dashicons-book');
	}
	/**
	 * Render the text for the general section
	 *
	 * @since  	1.0.0
	 * @access 	public
	 */
	public function vrodex_setting_general_cb()
	{
		echo '<p>' . esc_html__('Link your Vrodex Booking Widget with your Vrodex Account', 'vrodex-booking-widget') . '</p>';
	}
	/**
	 * Render the number input for this plugin
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function vrodex_setting_api_key_cb()
	{
		$val = get_option($this->option_name . '_api_key');
		echo '<input class="regular-text" type="text" name="' . esc_html($this->option_name) . '_api_key' . '" id="' . esc_html($this->option_name) . '_number' . '" value="' . esc_html($val) . '"> ';
		echo '<p class="description">' . wp_kses_post(__('Your API Key can be found under \'Booking Widget Settings\' option in the <a href="https://vrodex.app/settings/booking-widget-settings"/>Vrodex app</a>.'), 'vrodex-booking-widget');
	}
	/**
	 * Include the setting page
	 *
	 * @since  1.0.0
	 * @access public
	 */
	function vrodex_init()
	{
		if (!current_user_can('manage_options')) {
			return;
		}
		include VRODEX_PATH . 'admin/partials/vrodex-admin-display.php';
	}

	public function check_onboarding_notice()
	{

		if (!current_user_can('administrator')) {
			return;
		}

		if (get_option($this->option_name . '_api_key', null) != null) {
			return;
		}
		/* translators: %s: link to plugin settings */
		echo '<div class="notice notice-warning is-dismissible"><p>' . sprintf(wp_kses_post(__('Configure your <a href="%s">booking widget</a> to link with your Vrodex account.', 'vrodex-booking-widget'), ), esc_url(admin_url('?page=' . $this->plugin_name))) . '</p></div>';
	}

	public function sanitize_api_key($input)
	{
		$val = sanitize_text_field($input);
		if (strlen($val) == 0) {
			add_settings_error('vrodex-booking-widget', 'invalid-api-key', esc_html__('API Key is required.', 'vrodex-booking-widget'));
		}
		return $val;
	}
}
