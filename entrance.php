<?php
ob_start();
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.fiverr.com/junaidzx90
 * @since             1.0.0
 * @package           Entrance
 *
 * @wordpress-plugin
 * Plugin Name:       Entrance
 * Plugin URI:        https://github.com/junaidzx90/entrance
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Md Junayed
 * Author URI:        https://www.fiverr.com/junaidzx90
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       entrance
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
$homeurl = !empty(get_option( 'entrance_redirect_url' ))?get_option( 'entrance_redirect_url' ):get_home_url();
require_once 'vendor/autoload.php';
$google_client = new Google_Client();
$google_client->setClientId(get_option('entrance_google_client_id','demo'));
$google_client->setClientSecret(get_option('entrance_google_secret_id','demo'));
$google_client->setRedirectUri("$homeurl");
$google_client->addScope('email');
$google_client->addScope('profile');

$facebook = new \Facebook\Facebook([
	'app_id'	=>	get_option('entrance_facebook_app_id','demo'),
	'app_secret'	=>	get_option('entrance_facebook_app_secret','demo'),
	'default_graph_version'	=>	'v2.10'
]);


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ENTRANCE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-entrance-activator.php
 */
function activate_entrance() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-entrance-activator.php';
	Entrance_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-entrance-deactivator.php
 */
function deactivate_entrance() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-entrance-deactivator.php';
	Entrance_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_entrance' );
register_deactivation_hook( __FILE__, 'deactivate_entrance' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-entrance.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_entrance() {

	$plugin = new Entrance();
	$plugin->run();

}
run_entrance();
