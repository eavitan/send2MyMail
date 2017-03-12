<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://netingit.fr
 * @since      1.0.0
 *
 * @package    B2reader
 * @subpackage B2reader/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    B2reader
 * @subpackage B2reader/includes
 * @author     Eyal Avitan <eyal@netingit.co.il>
 */
 if (!class_exists('s2mm_B2reader')) {
class s2mm_B2reader {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      B2reader_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'b2reader';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - B2reader_Loader. Orchestrates the hooks of the plugin.
	 * - B2reader_i18n. Defines internationalization functionality.
	 * - B2reader_Admin. Defines all hooks for the admin area.
	 * - s2mm_B2reader_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-b2reader-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-b2reader-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-b2reader-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-b2reader-public.php';

		$this->loader = new s2mm_B2reader_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the B2reader_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new s2mm_B2reader_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}



	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new s2mm_B2reader_Public( $this->get_plugin_name(), $this->get_version() );
		// Append our button
		//$this->loader->add_action( 'the_content', $plugin_public, 'append_the_button', 45 );
		$this->loader->add_action( 'the_content', $plugin_public, 'append_the_send_to_mail', 45 );

		// Save/unsave AJAX
		//$this->loader->add_action( 'wp_ajax_save_unsave_item', $plugin_public, 'save_unsave_item' );
		//$this->loader->add_action( 'wp_ajax_nopriv_save_unsave_item', $plugin_public, 'save_unsave_item' );

		// Add our Shortcodes
		//$this->loader->add_shortcode( 'toptal-save', $plugin_public, 'register_save_unsave_shortcode' );
		//$this->loader->add_shortcode( 'toptal-saved', $plugin_public, 'register_saved_shortcode' );

		$this->loader->add_shortcode( 'send-to-mail-section', $plugin_public, 'show_send_to_mail_input' );

		$this->loader->add_action( 'wp_ajax_fetch_form_with_email', $plugin_public, 'fetch_form_with_email' );
		$this->loader->add_action( 'wp_ajax_nopriv_fetch_form_with_email', $plugin_public, 'fetch_form_with_email' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    B2reader_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new s2mm_B2reader_Admin( $this->get_plugin_name(), $this->get_version() );

		// Hook our settings page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_settings_page' );

		// Hook our settings
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings_S2MM' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}
}
}
