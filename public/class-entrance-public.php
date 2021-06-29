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

	function checkout_redirect_tologin(){
		if(!is_user_logged_in(  )){
			wp_safe_redirect(get_permalink(get_option('entrance_registster_page')).'?woo=true');
		}
	}

	public function public_filters(){
		// Page shortcode
		if(get_option( 'entrance_login_page' ) && get_option( 'entrance_registster_page' )){
			add_shortcode( 'entrance_login', [$this,'entrance_login_callback_function']);
			add_shortcode( 'entrance_register', [$this,'entrance_register_callback_function']);
		}
		$this->entrance_social_login('');
		add_filter ( 'woocommerce_account_menu_items', [$this,'entrance_my_profile'], 40 );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $wp_query;
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/entrance-public.css', array(), microtime(), 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $wp_query;
		wp_enqueue_script( 'ajaxform', plugin_dir_url( __FILE__ ) . 'js/ajaxform.js', array( 'jquery' ), microtime(), true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/entrance-public.js', array( 'jquery' ), microtime(), true );
		wp_localize_script($this->plugin_name, "submitform_ajaxurl", array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce'),
		));

	}


	function entrance_my_profile( $items ) {
		unset($items['dashboard']);
		unset($items['orders']);
		unset($items['downloads']);
		unset($items['edit-account']);
		unset($items['edit-address']);
		unset($items['customer-logout']);

		$items['edit-profile'] = __("Profile", "woocommerce");
		$items['my-pets'] = __("Pets", "woocommerce");
		$items['orders'] = __("Orders", "woocommerce");
		
		return $items;
	}

	function woo_after_myaccount_restrictions($woo){
		$allowed_endpoints = [ 'orders', 'edit-profile', 'my-pets' ];
	
		if (preg_match( '%^my\-account(?:/([^/]+)|)/?$%', $woo->request, $requ ) && ( empty( $requ[1] ) || !in_array( $requ[1], $allowed_endpoints ) )
		) {
			if(!is_user_logged_in(  )){
				wp_safe_redirect(get_permalink(get_option('entrance_login_page')));
				exit;
			}else{
				wp_redirect( site_url('/my-account/edit-profile/') );
				exit;
			}
		}
	}

	function entrance_woo_menus_endpoints() {
		add_rewrite_endpoint( 'edit-profile', EP_PAGES );
		add_rewrite_endpoint( 'my-pets', EP_PAGES );
	}

	function entrance_my_pets_endpoint_content() {
		require_once plugin_dir_path( __FILE__ )."partials/entrance-my-pets.php";
	}
	function entrance_edit_profile_endpoint_content() {
		require_once plugin_dir_path( __FILE__ )."partials/entrance-edit-profile.php";
	}

	function entrance_custom_orders_page($has_orders){
		if($has_orders){
			require_once plugin_dir_path( __FILE__ ).'partials/entrance_orders.php';
		}else{
			?>
			<style>
			body{
				background: linear-gradient(1deg, #E22B6E, #FC6266) !important;
			}
			h1.entry-title {
				display: none;
			}
			</style>
			<?php
			print_r("<h3 class='no-order-found'>No order placed.</h3>");
		}
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
			ob_start();
			// Include front view
			require_once plugin_dir_path( __FILE__ )."partials/entrance_register_page.php";
			$output = ob_get_contents();
			ob_get_clean();
			return $output;
		}else{
			print_r("You are already Logged in!");
		}
	}

	function entrance_login_access_by_form(){
		// check the user's login with their password.
		if(isset($_POST['login_btn'])){
			if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])){
				$redirect = !empty(get_option( 'entrance_redirect_url' ))?get_option( 'entrance_redirect_url' ):get_home_url();
                if(isset($_GET['woo'])){
                    $redirect = get_home_url().'/checkout';
                } 

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

	function entrance_get_country_name_by_code( $country_code ) {
		$countries = array(
			'AX' => 'Åland Islands',
			'AF' => 'Afghanistan',
			'AL' => 'Albania',
			'DZ' => 'Algeria',
			'AD' => 'Andorra',
			'AO' => 'Angola',
			'AI' => 'Anguilla',
			'AQ' => 'Antarctica',
			'AG' => 'Antigua and Barbuda',
			'AR' => 'Argentina',
			'AM' => 'Armenia',
			'AW' => 'Aruba',
			'AU' => 'Australia',
			'AT' => 'Austria',
			'AZ' => 'Azerbaijan',
			'BS' => 'Bahamas',
			'BH' => 'Bahrain',
			'BD' => 'Bangladesh',
			'BB' => 'Barbados',
			'BY' => 'Belarus',
			'PW' => 'Belau',
			'BE' => 'Belgium',
			'BZ' => 'Belize',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BT' => 'Bhutan',
			'BO' => 'Bolivia',
			'BQ' => 'Bonaire, Saint Eustatius and Saba',
			'BA' => 'Bosnia and Herzegovina',
			'BW' => 'Botswana',
			'BV' => 'Bouvet Island',
			'BR' => 'Brazil',
			'IO' => 'British Indian Ocean Territory',
			'VG' => 'British Virgin Islands',
			'BN' => 'Brunei',
			'BG' => 'Bulgaria',
			'BF' => 'Burkina Faso',
			'BI' => 'Burundi',
			'KH' => 'Cambodia',
			'CM' => 'Cameroon',
			'CA' => 'Canada',
			'CV' => 'Cape Verde',
			'KY' => 'Cayman Islands',
			'CF' => 'Central African Republic',
			'TD' => 'Chad',
			'CL' => 'Chile',
			'CN' => 'China',
			'CX' => 'Christmas Island',
			'CC' => 'Cocos (Keeling) Islands',
			'CO' => 'Colombia',
			'KM' => 'Comoros',
			'CG' => 'Congo (Brazzaville)',
			'CD' => 'Congo (Kinshasa)',
			'CK' => 'Cook Islands',
			'CR' => 'Costa Rica',
			'HR' => 'Croatia',
			'CU' => 'Cuba',
			'CW' => 'CuraÇao',
			'CY' => 'Cyprus',
			'CZ' => 'Czech Republic',
			'DK' => 'Denmark',
			'DJ' => 'Djibouti',
			'DM' => 'Dominica',
			'DO' => 'Dominican Republic',
			'EC' => 'Ecuador',
			'EG' => 'Egypt',
			'SV' => 'El Salvador',
			'GQ' => 'Equatorial Guinea',
			'ER' => 'Eritrea',
			'EE' => 'Estonia',
			'ET' => 'Ethiopia',
			'FK' => 'Falkland Islands',
			'FO' => 'Faroe Islands',
			'FJ' => 'Fiji',
			'FI' => 'Finland',
			'FR' => 'France',
			'GF' => 'French Guiana',
			'PF' => 'French Polynesia',
			'TF' => 'French Southern Territories',
			'GA' => 'Gabon',
			'GM' => 'Gambia',
			'GE' => 'Georgia',
			'DE' => 'Germany',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GR' => 'Greece',
			'GL' => 'Greenland',
			'GD' => 'Grenada',
			'GP' => 'Guadeloupe',
			'GT' => 'Guatemala',
			'GG' => 'Guernsey',
			'GN' => 'Guinea',
			'GW' => 'Guinea-Bissau',
			'GY' => 'Guyana',
			'HT' => 'Haiti',
			'HM' => 'Heard Island and McDonald Islands',
			'HN' => 'Honduras',
			'HK' => 'Hong Kong',
			'HU' => 'Hungary',
			'IS' => 'Iceland',
			'IN' => 'India',
			'ID' => 'Indonesia',
			'IR' => 'Iran',
			'IQ' => 'Iraq',
			'IM' => 'Isle of Man',
			'IL' => 'Israel',
			'IT' => 'Italy',
			'CI' => 'Ivory Coast',
			'JM' => 'Jamaica',
			'JP' => 'Japan',
			'JE' => 'Jersey',
			'JO' => 'Jordan',
			'KZ' => 'Kazakhstan',
			'KE' => 'Kenya',
			'KI' => 'Kiribati',
			'KW' => 'Kuwait',
			'KG' => 'Kyrgyzstan',
			'LA' => 'Laos',
			'LV' => 'Latvia',
			'LB' => 'Lebanon',
			'LS' => 'Lesotho',
			'LR' => 'Liberia',
			'LY' => 'Libya',
			'LI' => 'Liechtenstein',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MO' => 'Macao S.A.R., China',
			'MK' => 'Macedonia',
			'MG' => 'Madagascar',
			'MW' => 'Malawi',
			'MY' => 'Malaysia',
			'MV' => 'Maldives',
			'ML' => 'Mali',
			'MT' => 'Malta',
			'MH' => 'Marshall Islands',
			'MQ' => 'Martinique',
			'MR' => 'Mauritania',
			'MU' => 'Mauritius',
			'YT' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesia',
			'MD' => 'Moldova',
			'MC' => 'Monaco',
			'MN' => 'Mongolia',
			'ME' => 'Montenegro',
			'MS' => 'Montserrat',
			'MA' => 'Morocco',
			'MZ' => 'Mozambique',
			'MM' => 'Myanmar',
			'NA' => 'Namibia',
			'NR' => 'Nauru',
			'NP' => 'Nepal',
			'NL' => 'Netherlands',
			'AN' => 'Netherlands Antilles',
			'NC' => 'New Caledonia',
			'NZ' => 'New Zealand',
			'NI' => 'Nicaragua',
			'NE' => 'Niger',
			'NG' => 'Nigeria',
			'NU' => 'Niue',
			'NF' => 'Norfolk Island',
			'KP' => 'North Korea',
			'NO' => 'Norway',
			'OM' => 'Oman',
			'PK' => 'Pakistan',
			'PS' => 'Palestinian Territory',
			'PA' => 'Panama',
			'PG' => 'Papua New Guinea',
			'PY' => 'Paraguay',
			'PE' => 'Peru',
			'PH' => 'Philippines',
			'PN' => 'Pitcairn',
			'PL' => 'Poland',
			'PT' => 'Portugal',
			'QA' => 'Qatar',
			'IE' => 'Republic of Ireland',
			'RE' => 'Reunion',
			'RO' => 'Romania',
			'RU' => 'Russia',
			'RW' => 'Rwanda',
			'ST' => 'São Tomé and Príncipe',
			'BL' => 'Saint Barthélemy',
			'SH' => 'Saint Helena',
			'KN' => 'Saint Kitts and Nevis',
			'LC' => 'Saint Lucia',
			'SX' => 'Saint Martin (Dutch part)',
			'MF' => 'Saint Martin (French part)',
			'PM' => 'Saint Pierre and Miquelon',
			'VC' => 'Saint Vincent and the Grenadines',
			'SM' => 'San Marino',
			'SA' => 'Saudi Arabia',
			'SN' => 'Senegal',
			'RS' => 'Serbia',
			'SC' => 'Seychelles',
			'SL' => 'Sierra Leone',
			'SG' => 'Singapore',
			'SK' => 'Slovakia',
			'SI' => 'Slovenia',
			'SB' => 'Solomon Islands',
			'SO' => 'Somalia',
			'ZA' => 'South Africa',
			'GS' => 'South Georgia/Sandwich Islands',
			'KR' => 'South Korea',
			'SS' => 'South Sudan',
			'ES' => 'Spain',
			'LK' => 'Sri Lanka',
			'SD' => 'Sudan',
			'SR' => 'Suriname',
			'SJ' => 'Svalbard and Jan Mayen',
			'SZ' => 'Swaziland',
			'SE' => 'Sweden',
			'CH' => 'Switzerland',
			'SY' => 'Syria',
			'TW' => 'Taiwan',
			'TJ' => 'Tajikistan',
			'TZ' => 'Tanzania',
			'TH' => 'Thailand',
			'TL' => 'Timor-Leste',
			'TG' => 'Togo',
			'TK' => 'Tokelau',
			'TO' => 'Tonga',
			'TT' => 'Trinidad and Tobago',
			'TN' => 'Tunisia',
			'TR' => 'Turkey',
			'TM' => 'Turkmenistan',
			'TC' => 'Turks and Caicos Islands',
			'TV' => 'Tuvalu',
			'UG' => 'Uganda',
			'UA' => 'Ukraine',
			'AE' => 'United Arab Emirates',
			'GB' => 'United Kingdom (UK)',
			'US' => 'United States (US)',
			'UY' => 'Uruguay',
			'UZ' => 'Uzbekistan',
			'VU' => 'Vanuatu',
			'VA' => 'Vatican',
			'VE' => 'Venezuela',
			'VN' => 'Vietnam',
			'WF' => 'Wallis and Futuna',
			'EH' => 'Western Sahara',
			'WS' => 'Western Samoa',
			'YE' => 'Yemen',
			'ZM' => 'Zambia',
			'ZW' => 'Zimbabwe',
		);
		return ( isset( $countries[ $country_code ] ) ? $countries[ $country_code ] : false );
	}


	function entrance_get_mymail(){
		if(!wp_verify_nonce( $_GET['nonce'], 'ajax-nonce' )){
			die();
		}

		if(isset($_GET['email'])){
			$email = sanitize_email( $_GET['email'] );
			
			$user = get_user_by("email", $email);
			if($user){
				echo json_encode(array('exist' => "This user already exist!"));
				die;
			}else{
				echo json_encode(array('success' => "success"));
				die;
			}
		}
		die;
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
					update_user_meta( $user_id, "billing_country", $yourdetails['country'] );
					update_user_meta( $user_id, "billing_phone", $yourdetails['phone'] );
					update_user_meta( $user_id, "shipping_country", $this->entrance_get_country_name_by_code($yourdetails['country']) );
					

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

	function user_myaccount_add_pets(){
		if(!wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' )){
			die();
		}
		if(isset($_POST['data'])){
			global $wpdb,$current_user;
			$user_id = $current_user->ID;
			$data = $_POST['data'];
			if(is_user_logged_in(  )){
				$pet_name 		= $data['petname'];
				$petage 		= $data['petage'];
				$birthday 		= $data['birthday'];
				$breed 			= $data['breed'];
				$gender 		= $data['gender'];
				$inserted = $wpdb->insert($wpdb->prefix.'entrance_pets',array(
					'user_id' 		=> $user_id, 
					'pet_name' 		=> $pet_name,
					'pet_age' 		=> $petage,
					'pet_birthday' 	=> $birthday,
					'pet_breed' 	=> $breed,
					'pet_gender' 	=> $gender
				),array('%d','%s','%d','%s','%s','%s'));

				if($inserted){
					echo wp_json_encode( array('success' => 'success') );
					die;
				}else{
					echo wp_json_encode( array('error' => 'error') );
					die;
				}
			}else{
				die;
			}
			die;
		}
	}
}