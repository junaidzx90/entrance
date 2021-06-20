<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Entrance
 * @subpackage Entrance/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Entrance
 * @subpackage Entrance/admin
 * @author     Md Junayed <admin@easeare.com>
 */
class Entrance_Admin {

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
		if(isset($_GET['page']) && $_GET['page'] == 'entrance'){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/entrance-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if(isset($_GET['page']) && $_GET['page'] == 'entrance'){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/entrance-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	// Entrance menupage
	function entrance_menu_page(){
		add_menu_page( 'Entrance', 'Entrance', 'manage_options', 'entrance', [$this,'entrance_menupage'],'dashicons-migrate',45 );
		// For url
		add_settings_section( 'entrance_settings_section', '', '', 'entrance_settings_page' );
		// login page
		add_settings_field( 'entrance_login_page', 'Login page', [$this,'entrance_login_page_func'], 'entrance_settings_page', 'entrance_settings_section');
		register_setting( 'entrance_settings_section', 'entrance_login_page');
		// register page
		add_settings_field( 'entrance_registster_page', 'Registster page', [$this,'entrance_registster_page_func'], 'entrance_settings_page', 'entrance_settings_section');
		register_setting( 'entrance_settings_section', 'entrance_registster_page');
		// Redirect after social login url
		add_settings_field( 'entrance_redirect_url', 'Redirect after social login url', [$this,'entrance_redirect_url_func'], 'entrance_settings_page', 'entrance_settings_section');
		register_setting( 'entrance_settings_section', 'entrance_redirect_url');
		// Google Client ID
		add_settings_field( 'entrance_google_client_id', 'Google Client ID', [$this,'entrance_google_client_id_func'], 'entrance_settings_page', 'entrance_settings_section');
		register_setting( 'entrance_settings_section', 'entrance_google_client_id');
		// Google Client Secret
		add_settings_field( 'entrance_google_secret_id', 'Google Client Secret', [$this,'entrance_google_secret_id_func'], 'entrance_settings_page', 'entrance_settings_section');
		register_setting( 'entrance_settings_section', 'entrance_google_secret_id');
		// Facebook App ID
		add_settings_field( 'entrance_facebook_app_id', 'Facebook App ID', [$this,'entrance_facebook_app_id_func'], 'entrance_settings_page', 'entrance_settings_section');
		register_setting( 'entrance_settings_section', 'entrance_facebook_app_id');
		// Facebook Secret
		add_settings_field( 'entrance_facebook_app_secret', 'Facebook Secret', [$this,'entrance_facebook_app_secret_func'], 'entrance_settings_page', 'entrance_settings_section');
		register_setting( 'entrance_settings_section', 'entrance_facebook_app_secret');
	}

	// Login page inputs
	function entrance_login_page_func(){
		$dropdown_args = array(
			'post_type'        => 'page',
			'selected'         => get_option('entrance_login_page'),
			'name'             => 'entrance_login_page',
			'class'             => 'widefat',
			'show_option_none' => __('(Select a page)'),
			'sort_column'      => 'menu_order, post_title',
			'echo'             => 0,
		);
		
		echo wp_dropdown_pages( $dropdown_args );
		echo '<p><strong>[entrance_login]</strong></p>';
	}
	// Login page inputs
	function entrance_registster_page_func(){
		$dropdown_args = array(
			'post_type'        => 'page',
			'selected'         => get_option('entrance_registster_page'),
			'name'             => 'entrance_registster_page',
			'class'             => 'widefat',
			'show_option_none' => __('(Select a page)'),
			'sort_column'      => 'menu_order, post_title',
			'echo'             => 0,
		);
		
		echo wp_dropdown_pages( $dropdown_args );
		echo '<p><strong>[entrance_register]</strong></p>';
	}

	// redirect_url_
	function entrance_redirect_url_func(){
		echo '<input type="url" class="widefat" name="entrance_redirect_url" placeholder="Redirect url" value="'.get_option('entrance_redirect_url').'">';
	}
	// google_client_id
	function entrance_google_client_id_func(){
		echo '<input type="password" class="widefat" name="entrance_google_client_id" placeholder="Google client" value="'.get_option('entrance_google_client_id').'">';
	}
	// google_secret
	function entrance_google_secret_id_func(){
		echo '<input type="password" class="widefat" name="entrance_google_secret_id" placeholder="Google secret" value="'.get_option('entrance_google_secret_id').'">';
	}
	// google_secret
	function entrance_facebook_app_id_func(){
		echo '<input type="password" class="widefat" name="entrance_facebook_app_id" placeholder="Facebook app id" value="'.get_option('entrance_facebook_app_id').'">';
	}
	// google_secret
	function entrance_facebook_app_secret_func(){
		echo '<input type="password" class="widefat" name="entrance_facebook_app_secret" placeholder="Facebook secret" value="'.get_option('entrance_facebook_app_secret').'">';
	}

	//Menupage callback
	function entrance_menupage(){
		// Require seperate page for html view
		require_once plugin_dir_path( __FILE__ ).'partials/entrance-admin-display.php';
	}

	function entrance_logout_page(){
		unset($_SESSION['access_token']);
		unset($_SESSION['faccess_token']);
	}
}
