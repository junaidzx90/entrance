<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Entrance
 * @subpackage Entrance/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Entrance
 * @subpackage Entrance/includes
 * @author     Md Junayed <admin@easeare.com>
 */
class Entrance_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
		$entrance_pets = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}entrance_pets` (
			`ID` INT NOT NULL AUTO_INCREMENT,
			`user_id` INT NOT NULL,
			`pet_name` VARCHAR(255) NOT NULL,
			`pet_age` INT NOT NULL,
			`pet_birthday` DATE NOT NULL,
			`pet_breed` VARCHAR(255) NOT NULL,
			`pet_gender` VARCHAR(255) NOT NULL,
			PRIMARY KEY (`ID`)) ENGINE = InnoDB";
			dbDelta($entrance_pets);

		$entrance_breeds = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}entrance_breeds` (
			`ID` INT NOT NULL AUTO_INCREMENT,
			`breed_name` VARCHAR(255) NOT NULL,
			PRIMARY KEY (`ID`)) ENGINE = InnoDB";
			dbDelta($entrance_breeds);

		flush_rewrite_rules(true);
	}

}
