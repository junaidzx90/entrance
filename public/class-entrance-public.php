<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Entrance
 * @subpackage Entrance/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Entrance
 * @subpackage Entrance/public
 * @author     Md Junayed <admin@easeare.com>
 */
class Entrance_Public {

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

	public function public_filters(){
		// Page shortcode
		if(get_option( 'entrance_login_page' ) && get_option( 'entrance_registster_page' )){
			add_shortcode( 'entrance_login', [$this,'entrance_login_callback_function']);
			add_shortcode( 'entrance_register', [$this,'entrance_register_callback_function']);
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/entrance-public.css', array(), microtime(), 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'ajaxform', plugin_dir_url( __FILE__ ) . 'js/ajaxform.js', array( 'jquery' ), microtime(), true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/entrance-public.js', array( 'jquery' ), microtime(), true );
		wp_localize_script($this->plugin_name, "submitform_ajaxurl", array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce'),
		));

	}
	
	function entrance_social_login($btn){
		global $google_client,$facebook;
		$homeurl = !empty(get_option( 'entrance_redirect_url' ))?get_option( 'entrance_redirect_url' ):get_home_url();
		
		$facebook_helper = $facebook->getRedirectLoginHelper();
		$permission = ['email'];
		$flogin_url = $facebook_helper->getLoginUrl($homeurl,$permission);
		try{
			$ftoken = $facebook_helper->getAccessToken();
			if(!isset($_SESSION['faccess_token'])){
				$_SESSION['faccess_token'] = $ftoken;
			}
		}catch(Exception $e){
			$e->getTraceAsString();
		}

		if(isset($_SESSION['faccess_token'])){
			try{
				$facebook->getDefaultAccessToken($_SESSION['faccess_token']);
				$results = $facebook->get("/me?fields=name,email");
				$fuser = $facebook->getGraphUser();
			}catch(Exception $e){
				$e->getTraceAsString();
			}
		}

		if(isset($_SESSION['faccess_token'])){
			$_SESSION['user_first_name'] = $fuser->getField('name');
			$_SESSION['user_email'] =  $fuser->getField('email');
			header("Location:".$homeurl);
		}

		$flogin_button = '<a class="facebook-loginbtn" href="'.$flogin_url.'"><i class="fab fa-facebook-f"></i></a>';
		$glogin_button = '<a class="google-loginbtn" href="'.$google_client->createAuthUrl().'"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="24px" height="24px"><path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg></a>';

		if(isset($_GET['code'])){
			$gtoken = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

			if(!isset($gtoken['error'])){
				$google_client->setAccessToken($gtoken);
				$_SESSION['access_token'] = $gtoken['access_token'];

				$google_service = new Google_Service_Oauth2($google_client);
				$userData = $google_service->userinfo->get();

				if(!empty($userData['given_name'])){
					$_SESSION['user_first_name'] = $userData['given_name'];
				}
				if(!empty($userData['family_name'])){
					$_SESSION['user_last_name'] = $userData['family_name'];
				}
				if(!empty($userData['email'])){
					$_SESSION['user_email'] = $userData['email'];
				}
			}
		}

		if($btn == 'fb'){
			return $flogin_button;
		}
		if($btn == 'g'){
			return $glogin_button;
		}
	}

	/**
	 * Entrance Login page view functionality
	 */
	function entrance_login_callback_function(){
		if(!is_user_logged_in(  ) || !isset($_SESSION['access_token']) || !isset($_SESSION['faccess_token'])){
			ob_start();
			// Include front view
			require_once plugin_dir_path( __FILE__ )."partials/entrance_login_page.php";
			$output = ob_get_contents();
			ob_get_clean();
			return $output;
		}
	}

	/**
	 * Entrance Register page view functionality
	 */
	function entrance_register_callback_function(){
		if(!is_user_logged_in(  ) || !isset($_SESSION['access_token']) || !isset($_SESSION['faccess_token'])){
			ob_start();
			// Include front view
			require_once plugin_dir_path( __FILE__ )."partials/entrance_register_page.php";
			$output = ob_get_contents();
			ob_get_clean();
			return $output;
		}
	}

	function entrance_registration_form_data_store(){
		if(!wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' )){
			die();
		}
		if(isset($_POST)){
			$yourdetails = [];
			$shippingaddr = [];
			$pet1 = [];
			$pet2 = [];
			$pet3 = [];
			$data = $_POST;

			// yourdetails
			if(isset($data['firstname'])){
				$yourdetails['firstname'] = sanitize_text_field( $data['firstname'] );
			}
			if(isset($data['lastname'])){
				$yourdetails['lastname'] = sanitize_text_field($data['lastname']);
			}
			if(isset($data['phone'])){
				$yourdetails['phone'] = intval($data['phone']);
			}
			if(isset($data['country'])){
				$yourdetails['country'] = sanitize_text_field($data['country']);
			}
			if(isset($data['email'])){
				$yourdetails['email'] = sanitize_email($data['email']);
			}
			if(isset($data['password'])){
				$yourdetails['password'] = sanitize_text_field($data['password']);
			}

			// pet 1
			if(isset($data['pet_name'])){
				$pet1['pet_name'] = sanitize_text_field($data['pet_name']);
			}
			if(isset($data['petage'])){
				$pet1['petage'] = sanitize_text_field($data['petage']);
			}
			if(isset($data['birthday'])){
				$pet1['birthday'] = sanitize_text_field($data['birthday']);
			}
			if(isset($data['breed'])){
				$pet1['breed'] = sanitize_text_field($data['breed']);
			}
			if(isset($data['gender'])){
				$pet1['gender'] = sanitize_text_field($data['gender']);
			}

			// pet 2
			if(isset($data['pet_name_2'])){
				$pet2['pet_name'] = sanitize_text_field($data['pet_name_2']);
			}
			if(isset($data['petage_2'])){
				$pet2['petage'] = sanitize_text_field($data['petage_2']);
			}
			if(isset($data['birthday_2'])){
				$pet2['birthday'] = sanitize_text_field($data['birthday_2']);
			}
			if(isset($data['breed_2'])){
				$pet2['breed'] = sanitize_text_field($data['breed_2']);
			}
			if(isset($data['gender_2'])){
				$pet2['gender'] = sanitize_text_field($data['gender_2']);
			}

			// pet 3
			if(isset($data['pet_name_3'])){
				$pet3['pet_name'] = sanitize_text_field($data['pet_name_3']);
			}
			if(isset($data['petage_3'])){
				$pet3['petage'] = sanitize_text_field($data['petage_3']);
			}
			if(isset($data['birthday_3'])){
				$pet3['birthday'] = sanitize_text_field($data['birthday_3']);
			}
			if(isset($data['breed_3'])){
				$pet3['breed'] = sanitize_text_field($data['breed_3']);
			}
			if(isset($data['gender_3'])){
				$pet3['gender'] = sanitize_text_field($data['gender_3']);
			}

			// Shipping details
			if(isset($data['addr_1'])){
				$shippingaddr['addr_1'] = sanitize_text_field($data['addr_1']);
			}
			if(isset($data['addr_2'])){
				$shippingaddr['addr_2'] = sanitize_text_field($data['addr_2']);
			}
			if(isset($data['pincode'])){
				$shippingaddr['pincode'] = intval($data['pincode']);
			}
			if(isset($data['city'])){
				$shippingaddr['city'] = sanitize_text_field($data['city']);
			}
			if(isset($data['addr_type'])){
				$shippingaddr['addr_type'] = sanitize_text_field($data['addr_type']);
			}


		}
		var_dump($pet1);
		die;
	}
}
