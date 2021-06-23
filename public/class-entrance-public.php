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
		add_action( 'woocommerce_checkout_before_customer_details', [$this,'checkout'] );
	}

	function checkout(){
		if(!is_user_logged_in(  )){
			wp_safe_redirect( 'http://localhost/junudev/entrance-register/' );
		}
	}

	public function public_filters(){
		// Page shortcode
		if(get_option( 'entrance_login_page' ) && get_option( 'entrance_registster_page' )){
			add_shortcode( 'entrance_login', [$this,'entrance_login_callback_function']);
			add_shortcode( 'entrance_register', [$this,'entrance_register_callback_function']);
		}
		$this->entrance_social_login('');
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $wp_query;
		if(isset( $wp_query->query_vars['my_pets'] )){
			wp_enqueue_style( 'dataTable', plugin_dir_url( __FILE__ ) . 'css/dataTable.css', array(), '', 'all' );
		}
		wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/entrance-public.css', array(), microtime(), 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $wp_query;
		if(isset( $wp_query->query_vars['my_pets'] )){
			wp_enqueue_script( 'dataTable', plugin_dir_url( __FILE__ ) . 'js/dataTable.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'datatable-con', plugin_dir_url( __FILE__ ) . 'js/datatable-con.js', array( 'dataTable' ), '', true );
		}
		wp_enqueue_script( 'ajaxform', plugin_dir_url( __FILE__ ) . 'js/ajaxform.js', array( 'jquery' ), microtime(), true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/entrance-public.js', array( 'jquery' ), microtime(), true );
		wp_localize_script($this->plugin_name, "submitform_ajaxurl", array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce'),
		));

	}
	
	function entrance_login_access($user_id){
		wp_clear_auth_cookie();
		wp_set_current_user($user_id);
		wp_set_auth_cookie($user_id);
	}

	function entrance_social_user_store($email,$fname,$lname = ''){
		$password = rand(1,10);
		
		$user = '';

		$user_id = 0;
		$user = get_user_by( 'email', $email );
		$user_id = $user->ID;

		if(!$user){
			$emailaddr = explode("@", $email , 2);
			$username = $emailaddr[0];

			$user_id = wc_create_new_customer( $email, $username, $password );

			update_user_meta( $user_id, "billing_first_name", $fname );
			update_user_meta( $user_id, "first_name", $fname );
			update_user_meta( $user_id, "shipping_first_name", $fname );

			update_user_meta( $user_id, "billing_last_name", $lname );
			update_user_meta( $user_id, "last_name", $lname );
			update_user_meta( $user_id, "shipping_last_name", $lname );
		}

		$this->entrance_login_access($user_id);
	}

	function entrance_social_login($btn){
		global $google_client,$facebook;
		$homeurl = !empty(get_option( 'entrance_redirect_url' ))?get_option( 'entrance_redirect_url' ):get_home_url();
		
		$facebook_helper = $facebook->getRedirectLoginHelper();

		if (isset($_GET['state'])) { 
			$facebook_helper->getPersistentDataHandler()->set('state', $_GET['state']); 
		}

		$permission = ['email'];
		$flogin_url = $facebook_helper->getLoginUrl($homeurl,$permission);

		$flogin_button = '<a class="facebook-loginbtn" href="'.$flogin_url.'"><i class="fab fa-facebook-f"></i></a>';
		$glogin_button = '<a class="google-loginbtn" href="'.$google_client->createAuthUrl().'"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="24px" height="24px"><path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg></a>';

		if(isset($_GET['code'])){
			if (isset($_GET['state'])) { 
				try{
					if(isset($_SESSION['faccess_token'])){
						$faccess_token = $_SESSION['faccess_token'];
					}else{
						$faccess_token = $facebook_helper->getAccessToken();
						$_SESSION['faccess_token'] = $faccess_token;
						$facebook->setDefaultAccessToken($_SESSION['faccess_token']);
					}

					$graph_response = $facebook->get('/me?fields=name,email',$faccess_token);
					$fuserinfo = $graph_response->getGraphUser();

					$_SESSION['fuser_first_name'] = $fuserinfo['name'];
					$_SESSION['fuser_email'] =  $fuserinfo['email'];
					if(isset($_SESSION['fuser_email']) && !empty($_SESSION['fuser_email'])){
						$this->entrance_social_user_store($_SESSION['fuser_email'], $_SESSION['fuser_first_name'],'');
					}else{
						unset($_SESSION['faccess_token']);
						wp_safe_redirect( get_the_permalink().'?error="This account doesn\'t use email address."' );
						
					}
				}catch(Exception $e){
					$e->getTraceAsString();
				}
			}else{
				try{
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
						if(isset($_SESSION['user_email'])){
							$this->entrance_social_user_store($_SESSION['user_email'], $_SESSION['user_first_name'], $_SESSION['user_last_name']);
						}
					}
				}catch(Exception $e){
					$e->getTraceAsString();
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
		if(!is_user_logged_in(  )){
			if(!isset($_SESSION['access_token'])){
				if(!isset($_SESSION['faccess_token'])){
					ob_start();
					// Include front view
					require_once plugin_dir_path( __FILE__ )."partials/entrance_login_page.php";
					$output = ob_get_contents();
					ob_get_clean();
					return $output;
				}else{
					print_r("You are already Logged in!");
				}
			}else{
				print_r("You are already Logged in!");
			}
		}else{
			print_r("You are already Logged in!");
		}
	}

	/**
	 * Entrance Register page view functionality
	 */
	function entrance_register_callback_function(){
		if(!is_user_logged_in(  )){
			if(!isset($_SESSION['access_token'])){
				if(!isset($_SESSION['faccess_token'])){
					ob_start();
					// Include front view
					require_once plugin_dir_path( __FILE__ )."partials/entrance_register_page.php";
					$output = ob_get_contents();
					ob_get_clean();
					return $output;
				}else{
					print_r("You are already Logged in!");
				}
			}else{
				print_r("You are already Logged in!");
			}
		}else{
			print_r("You are already Logged in!");
		}
	}

	function entrance_login_access_by_form(){
		// check the user's login with their password.
		if(isset($_POST['login_btn'])){
			if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])){
				$redirect = !empty(get_option( 'entrance_redirect_url' ))?get_option( 'entrance_redirect_url' ):get_home_url();

				$username = sanitize_text_field( $_POST['username'] );
				$password = sanitize_text_field( $_POST['password'] );
				$user = '';

				if(is_email($username)){
					$user = get_user_by( 'email', $username );
				}else{
					$user = get_user_by( 'login', $username );
				}

				if ( wp_check_password( $password, $user->user_pass, $user->ID ) ) {

					if(isset($_POST['stay_login'])){
						setcookie('username', $username, time() + (10 * 365 * 24 * 60 * 60), '/');
						setcookie('password', $password, time() + (10 * 365 * 24 * 60 * 60), '/');
					}

					$this->entrance_login_access($user->ID);
					if(is_user_logged_in(  )){
						wp_safe_redirect( $redirect );
						exit;
					}
				}else{
					return 'Invalid credentials.';
				}
			}else{
				return 'Invalid credentials.';
			}
		}
	}

	function entrance_registration_form_data_store(){
		if(!wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' )){
			die();
		}
		if(isset($_POST)){

			if(get_user_by( 'email', $_POST['email'])){
				echo wp_json_encode( array('error' => "This user already exist!") );
				die;
			}

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

			$pets = [];

			if(!empty($pet1)){
				$pets[] = $pet1;
			}
			if(!empty($pet2)){
				$pets[] = $pet2;
			}
			if(!empty($pet3)){
				$pets[] = $pet3;
			}
			
			if(!empty($yourdetails)){
				$emailaddr = explode("@", $yourdetails['email'], 2);
                $username = $emailaddr[0];

				if(!empty($yourdetails['email']) && !empty($yourdetails['password'])){
					$user_id = wc_create_new_customer( strtolower($yourdetails['email']), $username, $yourdetails['password'] );

					update_user_meta( $user_id, "billing_first_name", $yourdetails['firstname'] );
					update_user_meta( $user_id, "first_name", $yourdetails['firstname'] );
					update_user_meta( $user_id, "shipping_first_name", $yourdetails['firstname'] );

					update_user_meta( $user_id, "billing_last_name", $yourdetails['lastname'] );
					update_user_meta( $user_id, "last_name", $yourdetails['lastname'] );
					update_user_meta( $user_id, "shipping_last_name", $yourdetails['lastname'] );
					update_user_meta( $user_id, "billing_phone", $yourdetails['phone'] );
					update_user_meta( $user_id, "shipping_country", $yourdetails['country'] );

					if(!empty($shippingaddr)){
						update_user_meta( $user_id, "shipping_address_1", $shippingaddr['addr_1'] );
						update_user_meta( $user_id, "shipping_address_2", $shippingaddr['addr_2'] );
						update_user_meta( $user_id, "address_type", $shippingaddr['addr_type'] );
						update_user_meta( $user_id, "shipping_city", $shippingaddr['city'] );
						update_user_meta( $user_id, "billing_city", $shippingaddr['city'] );
						update_user_meta( $user_id, "shipping_postcode", $shippingaddr['pincode'] );
						update_user_meta( $user_id, "billing_postcode", $shippingaddr['pincode'] );
						update_user_meta( $user_id, "billing_address_1", $shippingaddr['addr_1'] );
						update_user_meta( $user_id, "billing_address_2", $shippingaddr['addr_2'] );
					}

					if(!empty($pets)){
						$redirect = get_home_url().'/checkout';

						foreach($pets as $pet){
							$pet_name = $pet['pet_name'];
							$petage = $pet['petage'];
							$birthday = $pet['birthday'];
							$breed = $pet['breed'];
							$gender = $pet['gender'];
							global $wpdb;
							$wpdb->insert($wpdb->prefix.'entrance_pets',array(
								'user_id' => $user_id, 
								'pet_name' => $pet_name,
								'pet_age' => $petage,
								'pet_birthday' => $birthday,
								'pet_breed' => $breed,
								'pet_gender' => $gender
							),array('%d','%s','%d','%s','%s','%s'));
						}
					}

					if(!is_wp_error( $wpdb )){
						$this->entrance_login_access($user_id);
						echo wp_json_encode( array('success' => $redirect) );
						die;
					}
					die;
				}
				die;
			}
			die;
		}
		die;
	}
}