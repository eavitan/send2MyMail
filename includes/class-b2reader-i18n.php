<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://netingit.fr
 * @since      1.0.0
 *
 * @package    B2reader
 * @subpackage B2reader/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    B2reader
 * @subpackage B2reader/includes
 * @author     Eyal Avitan <eyal@netingit.co.il>
 */
 if (!class_exists('s2mm_B2reader_i18n')) {
class s2mm_B2reader_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'b2reader',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
}
