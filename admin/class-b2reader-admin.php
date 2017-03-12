<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://netingit.fr
 * @since      1.0.0
 *
 * @package    B2reader
 * @subpackage B2reader/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    B2reader
 * @subpackage B2reader/admin
 * @author     Eyal Avitan <eyal@netingit.co.il>
 */
 if (!class_exists('s2mm_B2reader_Admin')) {
class s2mm_B2reader_Admin {

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
	private $stylingexist = 0;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		 if ( 'tools_page_s2mm-save' != $hook && $this->stylingexist ) {
				return;
			}
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/b2reader-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if ( 'tools_page_s2mm-save' != $hook && $this->stylingexist) {
			return;
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/b2reader-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
 * Register the settings page for the admin area.
 *
 * @since    1.0.0
 */
	public function register_settings_page() {

		add_submenu_page(
			'tools.php',                             // parent slug
			__( 'Send 2 my mail', 'b2reader' ),      // page title
			__( 'Send 2 my mail', 'b2reader' ),      // menu title
			'manage_options',                        // capability
			'Send-2-my-mail',                        // menu_slug
			array( $this, 'display_settings_page' )  // callable function
		);
	}
	public function display_settings_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/b2reader-admin-display.php';
	}
	/**
 * Register the settings for our settings page.
 *
 * @since    1.0.0
 */
 public function register_settings_S2MM() {

 register_setting(
	 $this->plugin_name . '-settings',
	 $this->plugin_name . '-settings',
	 array( $this, 'sandbox_register_setting' )
 );

 add_settings_section(
	 $this->plugin_name . '-settings-send-to-mail',
	 __( 'Settings Send to mail', 'b2reader' ),
	 array( $this, 'sandbox_add_settings_section' ),
	 $this->plugin_name . '-settings'
 );
 add_settings_field(
	 'post-types',
	 __( 'Post Types', 'b2reader' ),
	 array( $this, 'sandbox_add_settings_field_multiple_checkbox' ),
	 $this->plugin_name . '-settings',
	 $this->plugin_name . '-settings-send-to-mail',
	 array(
		 'label_for' => 'post-types',
		 'description' => __( 'The email input wil append only the checked post types.', 'b2reader' )
	 )
 );
 add_settings_field(
	 'toggle-css-override',
	 __( 'Our Styles', 'b2reader' ),
	 array( $this, 'sandbox_add_settings_field_single_checkbox' ),
	 $this->plugin_name . '-settings',
	 $this->plugin_name . '-settings-send-to-mail',
	 array(
		 'label_for' => 'toggle-css-override',
		 'description' => __( 'If checked, our style will be used.', 'b2reader' )
	 )
 );
	add_settings_field(
	 'toggle-rtl',
	 __( 'Rtl', 'b2reader' ),
	 array( $this, 'sandbox_add_settings_field_single_checkbox' ),
	 $this->plugin_name . '-settings',
	 $this->plugin_name . '-settings-send-to-mail',
	 array(
		 'label_for' => 'toggle-rtl',
		 'description' => __( 'If checked, style will display Rtl version.', 'b2reader' )
	 )
 );
 add_settings_field(
 'send-to-mail-approval',
 __( 'Offer newsletter\'s registration.', 'b2reader' ),
 array( $this, 'sandbox_add_settings_field_input_text' ),
 $this->plugin_name . '-settings',
 $this->plugin_name . '-settings-send-to-mail',
 array(
	 'label_for' => 'send-to-mail-approval',
	 'default'   => __( 'I Approve accepting newsletters', 'b2reader' )
 )
 );


 add_settings_field(
	'offer-to-mail-content',
	__( 'Text before input:', 'b2reader' ),
	array( $this, 'sandbox_add_settings_field_textarea' ),
	$this->plugin_name . '-settings',
	$this->plugin_name . '-settings-send-to-mail',
	array(
		'label_for' => 'offer-to-mail-content',
		'default'   => __( 'Would you like to send yourself this article?', 'b2reader' )
	)
 );
 add_settings_field(
 'offer-to-mail-content-button',
 __( 'Input send button:', 'b2reader' ),
 array( $this, 'sandbox_add_settings_field_input_text' ),
 $this->plugin_name . '-settings',
 $this->plugin_name . '-settings-send-to-mail',
 array(
	 'label_for' => 'offer-to-mail-content-button',
	 'default'   => __( 'Send me the article', 'b2reader' )
 )
 );
 add_settings_field(
 'send-to-mail-email-input-placeholder',
 __( 'input placeholder:', 'b2reader' ),
 array( $this, 'sandbox_add_settings_field_input_text' ),
 $this->plugin_name . '-settings',
 $this->plugin_name . '-settings-send-to-mail',
 array(
	 'label_for' => 'send-to-mail-email-input-placeholder',
	 'default'   => __( 'email@domain.co.il', 'b2reader' )
 )
 );
 add_settings_section(
	 $this->plugin_name . '-settings-notifications-send-to-mail',
	 __( 'Notifications', 'b2reader' ),
	 array( $this, 'sandbox_add_settings_section' ),
	 $this->plugin_name . '-settings'
 );
 add_settings_field(
 'send-to-email-missing',
 __( 'Message if email missing.', 'b2reader' ),
 array( $this, 'sandbox_add_settings_field_input_text' ),
 $this->plugin_name . '-settings',
 $this->plugin_name . '-settings-notifications-send-to-mail',
 array(
	 'label_for' => 'send-to-email-missing',
	 'default'   => __( 'You forgot to enter an email address', 'b2reader' )
 )
 );

 add_settings_field(
 'send-to-no-approval',
 __( 'Message if reader doesnt approve newsletters.', 'b2reader' ),
 array( $this, 'sandbox_add_settings_field_input_text' ),
 $this->plugin_name . '-settings',
 $this->plugin_name . '-settings-notifications-send-to-mail',
 array(
	 'label_for' => 'send-to-no-approval',
	 'default'   => __( 'You need to accept us sending you this mail', 'b2reader' )
 )
 );
 add_settings_field(
 'send-to-item-sent',
 __( 'Message if article sent.', 'b2reader' ),
 array( $this, 'sandbox_add_settings_field_input_text' ),
 $this->plugin_name . '-settings',
 $this->plugin_name . '-settings-notifications-send-to-mail',
 array(
 	'label_for' => 'send-to-item-sent',
 	'default'   => __( 'we sent you the mail succesfuly', 'b2reader' )
 )
 );
 add_settings_section(
	 $this->plugin_name . '-settings-email-send-to-mail',
	 __( 'Email content', 'b2reader' ),
	 array( $this, 'sandbox_add_settings_section' ),
	 $this->plugin_name . '-settings'
 );
 add_settings_field(
 'send-to-mail-subject',
 __( 'Email Subject.', 'b2reader' ),
 array( $this, 'sandbox_add_settings_field_input_text' ),
 $this->plugin_name . '-settings',
 $this->plugin_name . '-settings-email-send-to-mail',
 array(
	 'label_for' => 'send-to-mail-subject',
	 'default'   => __( 'You wanted to read this article', 'b2reader' )
 )
 );
 add_settings_field(
	'send-to-mail-content',
	__( 'Email content.', 'b2reader' ),
	array( $this, 'sandbox_add_settings_field_textarea' ),
	$this->plugin_name . '-settings',
	$this->plugin_name . '-settings-email-send-to-mail',
	array(
		'label_for' => 'send-to-mail-content',
		'default'   => __( 'Hello sir, you wanted to read this article when you could find the right time.', 'b2reader' )
	)
 );
 }
/**
 * @since    1.0.0
 */
public function sandbox_register_setting( $input ) {

	$new_input = array();

	if ( isset( $input ) ) {
		foreach ( $input as $key => $value ) {
			if ( $key == 'post-types' ) {
				$new_input[ $key ] = $value;
			} else {
				$new_input[ $key ] = sanitize_text_field( $value );
			}
		}
	}

	return $new_input;

}

/**
 * @since    1.0.0
 */
public function sandbox_add_settings_section() {
	return;
}

/**
 * @since    1.0.0
 */
public function sandbox_add_settings_field_single_checkbox( $args ) {

	$field_id = $args['label_for'];
	$field_description = $args['description'];

	$options = get_option( $this->plugin_name . '-settings' );
	$option = 0;

	if ( ! empty( $options[ $field_id ] ) ) {
		$option = $options[ $field_id ];
	}
?>
		<label for="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . ']'; ?>">
			<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . ']'; ?>" <?php checked( $option, true, 1 ); ?> value="1" />
			<span class="description"><?php echo esc_html( $field_description ); ?></span>
		</label>
<?php
}
/**
 * Sandbox our multiple checkboxes
 *
 * @since    1.0.0
 */
public function sandbox_add_settings_field_multiple_checkbox( $args ) {
	$field_id = $args['label_for'];
	$field_description = $args['description'];
	$options = get_option( $this->plugin_name . '-settings' );
	$option = array();
	if ( ! empty( $options[ $field_id ] ) ) {
		$option = $options[ $field_id ];
	}
	if ( $field_id == 'post-types' ) {
		$args = array(
			'public' => true
		);
		$post_types = get_post_types( $args, 'objects' );
		foreach ( $post_types as $post_type ) {
			if ( $post_type->name != 'attachment' ) {
				if ( in_array( $post_type->name, $option ) ) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
				?>
					<fieldset>
						<label for="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . '][' . esc_attr($post_type->name) . ']'; ?>">
							<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . '][' . esc_attr($post_type->name) . ']'; ?>" value="<?php echo esc_attr( $post_type->name ); ?>" <?php echo $checked; ?> />
							<span class="description"><?php echo esc_html( $post_type->label ); ?></span>
						</label>
					</fieldset>
				<?php
			}
		}
	} else {
		$field_args = $args['options'];
		foreach ( $field_args as $field_arg_key => $field_arg_value ) {
			if ( in_array( $field_arg_key, $option ) ) {
				$checked = 'checked="checked"';
			} else {
				$checked = '';
			}
			?>

				<fieldset>
					<label for="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . '][' . esc_attr($field_arg_key) . ']'; ?>">
						<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . '][' . esc_attr($field_arg_key) . ']'; ?>" value="<?php echo esc_attr( $field_arg_key ); ?>" <?php echo $checked; ?> />
						<span class="description"><?php echo esc_html( $field_arg_value ); ?></span>
					</label>
				</fieldset>

			<?php
		}
	}
?>
		<p class="description"><?php echo esc_html( $field_description ); ?></p>
<?php
}
/**
 * @since    1.0.0
 */
 public function sandbox_add_settings_field_input_text( $args ) {
 	$field_id = $args['label_for'];
 	$field_default = $args['default'];
 	$options = get_option( $this->plugin_name . '-settings' );
 	$option = $field_default;
 	if ( ! empty( $options[ $field_id ] ) ) {
 		$option = $options[ $field_id ];
 	}
 	?>

 		<input type="text" name="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" class="regular-text" />

 	<?php
 }
 /**
  * Sandbox our Checkboxs with text
  *
  * @since    1.0.0
  */
 public function sandbox_add_settings_field_textarea( $args ) {
 	$field_id = $args['label_for'];
 	$field_default = $args['default'];
 	$options = get_option( $this->plugin_name . '-settings' );
 	$option = $field_default;
 	if ( ! empty( $options[ $field_id ] ) ) {
 		$option = $options[ $field_id ];
 	}
 	?>
	<textarea style="width: 350px;height: 60px;" name="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . ']'; ?>"  id="<?php echo $this->plugin_name . '-settings[' . esc_attr($field_id) . ']'; ?>" ><?php echo esc_attr( $option ); ?></textarea>
 	<?php
 }
}
}
