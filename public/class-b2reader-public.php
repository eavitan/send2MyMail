<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://netingit.fr
 * @since      1.0.0
 *
 * @package    B2reader
 * @subpackage B2reader/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    B2reader
 * @subpackage B2reader/public
 * @author     Eyal Avitan <eyal@netingit.co.il>
 */
 if (!class_exists('s2mm_B2reader_Public')) {
class s2mm_B2reader_Public {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in B2reader_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The B2reader_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$options = get_option( $this->plugin_name . '-settings' );
		if ( ! empty( $options['toggle-css-override'] ) && $options['toggle-css-override'] == 1 ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/b2reader-public.css', array(), $this->version, 'all' );
		}

	}
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in B2reader_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The B2reader_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/b2reader-public.js', array( 'jquery' ), $this->version, false );

		// Get our options
		$options = get_option($this->plugin_name.'-settings');

		// Get our Text
		$item_save_text = $options['text-save'];
		$item_unsave_text = $options['text-unsave'];
		$item_saved_text = $options['text-saved'];
		$item_no_saved = $options['text-no-saved'];

		$email_missing = $options['send-to-email-missing'];
		$no_approval = $options['send-to-no-approval'];
		$item_sent = $options['send-to-item-sent'];

		wp_localize_script(
			$this->plugin_name,
			'send_2_my_mail',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'item_sent' => esc_js($item_sent),
				'email_missing' => esc_js($email_missing),
				'no_approval' => esc_js($no_approval)
			)
		);

	}
	/**
	 * Get if enabled only for logged in users
	 *
	 * @since    1.0.2
	 */
	public function get_user_status() {

		$options = get_option( $this->plugin_name . '-settings' );
		if ( ! empty( $options['toggle-status-override'] ) ) {
			$status = $options['toggle-status-override'];
		} else {
			$status = 0;
		}

		return $status;

	}
	/**
  * append the send to mail input.
  *
  * @since    1.0.0
  */
	public function append_the_send_to_mail( $content ) {
	 	$item_id = get_queried_object_id();
	 	$current_post_type = get_post_type( $item_id );
 		$post_types = array();
	 	$options = get_option( $this->plugin_name . '-settings' );
	 	if ( ! empty( $options['post-types'] ) ) {
	 		$post_types = $options['post-types'];
	 	}
		if(! empty($_POST['email_to_send_the_article']) ){
				$this->fetch_form_with_email();
		}elseif (  ! empty( $post_types )&& in_array( $current_post_type, $post_types ) ) {

	 		$custom_content = '';
	 		ob_start();
	 		echo $this->show_send_to_mail_input();
	 		$custom_content .= ob_get_contents();
	 		ob_end_clean();
	 		$content = $custom_content.$content;
	 	}
	 	return $content;
	 }
	/**
  * @since    1.0.0
  */
	public function show_send_to_mail_input( $item_id = '' ) {

 	if ( empty( $item_id ) ) {
 		$item_id = get_queried_object_id();
 	}

 	$options = get_option( $this->plugin_name . '-settings' );
 	$want_to_send_item = $options['offer-to-mail-content'];
	$want_to_send_item_button = $options['offer-to-mail-content-button'];
	$send_to_mail_approval = $options['send-to-mail-approval'];
	$rtl = $options['toggle-rtl'];
	$input_placeholder = $options['send-to-mail-email-input-placeholder'];

	if($rtl){
		$rtl = ' s2mm-rtl ';
	}

 	$status = $this->get_user_status();

 	if ( $status == 1 && is_user_logged_in() && is_singular() || $status == 0 && is_singular() ) {
 		return '
		<div id="send-to-mail-box" class="'.esc_attr($rtl).'"><form action="" method="post"  data-nonce="' .esc_attr( wp_create_nonce( 's2mm_nonce' )) . '" data-item-id="' . esc_attr( $item_id ) . '" >
		<p class="s2mm_top_content">' . esc_html( $want_to_send_item ) . '</p>
		<div>
		<input type="email" name="email_to_send_the_article" id="email_to_send_the_article" title="" value="" placeholder="' . esc_attr($input_placeholder) . '">
		<button type="submit" name="" id="" value="">'.esc_html($want_to_send_item_button).'</button>
		</div>
		<label class="approve-registration-s2mm"><input type="checkbox" name="approve-newsletters" id="approve-newsletters" title=""> <span>'.esc_html($send_to_mail_approval).'</span></label>
		</form></div>
		';
 	}

 }

	public function fetch_form_with_email(){
	$error = 0;
	$approval = 0;
	$options = get_option( $this->plugin_name . '-settings' );

	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 's2mm_nonce' ) ) {
		echo 'nonc';
		die;
	}

	if ( isset( $_REQUEST['item_id'])) {

		$item_id = intval( $_REQUEST['item_id'] );
		$item_url = get_permalink($item_id);
	} else {
		$item_id = 0;
		$error = 1;
	}

	$no_approval = $options['send-to-no-approval'];
	$email_missing = $options['send-to-email-missing'];
	$article_sent = $options['send-to-item-sent'];


	if(!empty($_POST['email_to_send_the_article'])){
		$send_to_mail_subject = $options['send-to-mail-subject'];
		$send_to_mail_content = $options['send-to-mail-content'];

		$to = sanitize_email($_POST['email_to_send_the_article']);
		$subject = sanitize_text_field($send_to_mail_subject);
		$message = esc_html($send_to_mail_content) . "\r\n" .esc_url($item_url);

		$adminEmail = get_option('admin_email');
		$siteName = get_option('blogname');
		$headers = 'From: '.$siteName.' <'.$adminEmail.'>';

		if($_POST['approve-newsletters'] == 'false'){
			$return = array(
				'is_sent' => 0,
				'msg' => esc_js($no_approval)  .' '.  esc_html($_POST['email_to_send_the_article'])
			);
			return wp_send_json( $return );
		}
		if(wp_mail($to,$subject,$message,$headers)){
			$return = array(
				'is_sent' => 1,
				'msg' => esc_js($article_sent) .' '. esc_html($_POST['email_to_send_the_article']),
				'item_url'=>$item_url
			);
		}else{
			$return = array(
				'is_sent' => 0,
				'msg' => __('Error sending to mail: ')  .' '.  esc_html($_POST['email_to_send_the_article']),
				'item_url'=>esc_url($item_url)
			);

		}
		return wp_send_json( $return );
	}else{
		$return = array(
			'is_sent' => 0,
			'msg' => esc_js($email_missing),
			'item_url'=> esc_url($item_url),
		);
		return wp_send_json( $return );
	}

}
}
}
