<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://netingit.fr
 * @since      1.0.0
 *
 * @package    B2reader
 * @subpackage B2reader/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    B2reader
 * @subpackage B2reader/includes
 * @author     Eyal Avitan <eyal@netingit.co.il>
 */
class b2reader_save {
  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_admin_hooks() {

  	$plugin_admin = new B2reader_Admin( $this->get_plugin_name(), $this->get_version() );

  	// Hook our settings page
  	$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_settings_page' );

  	// Hook our settings
  	$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );

  	$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
  	$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

  }

}
