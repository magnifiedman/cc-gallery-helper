<?php
/* Photo Gallery Helper Configuration File
 * Original Creation Date 04.2014
 * Wherein we define some constants for the system
 */

	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);

	// site paths
	define('BASE_URL','/cc-gallery-helper/');
	define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT'] . '/cc-gallery-helper/');*/
	/*define('BASE_URL','');
	define('ROOT_PATH','');*/

	// database connection - development
	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PASS','root');
	define('DB_NAME','devdb');*/

	// database connection - production
	/*define('DB_HOST','');
	define('DB_USER','');
	define('DB_PASS','');
	define('DB_NAME','');*/

	// database tables
	define('GALLERIES_TABLE','cc_galleries');
	define('ADMIN_USERS_TABLE','cc_galleries_users_admin');

	// data
	define('RESULTS_PERPAGE','50');