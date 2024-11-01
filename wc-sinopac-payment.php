<?php
/**
 * Plugin Name: Payment Gateway for SinoPac Bank on WooCommerce
 * Plugin URI:  https://github.com/terrylinooo/wc-sinopac-payment
 * Description: Credit card and virtual account (ATM) payment methods powered by SinoPac bank.
 * Version:     1.1.3
 * Author:      Terry Lin
 * Author URI:  https://terryl.in/zh/
 * License:     GPL 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: wc-sinopac-payment
 * Domain Path: /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * WooCommerce SinoPac Payment plugin uses "wcsp" as the prefix on its functions.
 * WooCommerce SinoPac Payment plugin uses "WCSP" as the prefix on its constants.
 */

if ( ! defined( 'WCSP_INC' ) ) {
	define( 'WCSP_INC', true );
}

/**
 * CONSTANTS - WCSP stands for WooCommerce SinoPac Payment ^_^
 *
 * WCSP_PLUGIN_NAME          : Plugin's name.
 * WCSP_PLUGIN_DIR           : The absolute path of the WCSP plugin directory.
 * WCSP_PLUGIN_URL           : The URL of the WCSP plugin directory.
 * WCSP_PLUGIN_PATH          : The absolute path of the WCSP plugin launcher.
 * WCSP_PLUGIN_LANGUAGE_PACK : Translation Language pack.
 * WCSP_PLUGIN_VERSION       : WCSP plugin version number
 * WCSP_PLUGIN_TEXT_DOMAIN   : WCSP plugin text domain
 *
 * Expected values:
 *
 * WCSP_PLUGIN_DIR           : {absolute_path}/wp-content/plugins/
 * WCSP_PLUGIN_URL           : {protocal}://{domain_name}/wp-content/plugins/wc-sinopac-payment/
 * WCSP_PLUGIN_PATH          : {absolute_path}/wp-content/plugins/wc-sinopac-payment/wc-sinopac-payment.php
 * WCSP_PLUGIN_LANGUAGE_PACK : wc-sinopac-payment/languages
 */

define( 'WCSP_PLUGIN_NAME', plugin_basename( __FILE__ ) );
define( 'WCSP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WCSP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WCSP_PLUGIN_PATH', __FILE__ );
define( 'WCSP_PLUGIN_LANGUAGE_PACK', dirname( plugin_basename( __FILE__ ) ) . '/languages' );
define( 'WCSP_PLUGIN_VERSION', '1.1.3' );
define( 'WCSP_PHP_SDK_VERSION', '0.2.1' );
define( 'WCSP_PLUGIN_TEXT_DOMAIN', 'wc-sinopac-payment' );
define( 'WCSP_PLUGIN_FIRST_RELEASED', '2023-04-19' );

/**
 * Start to run WCSP plugin cores.
 */
function load_sinopac_payment_gateway() {
	// The minimum supported version of PHP.
	if ( version_compare( phpversion(), '7.1.0', '<' ) ) {
		return;
	}

	require_once WCSP_PLUGIN_DIR . 'includes/helpers.php';
	require_once WCSP_PLUGIN_DIR . 'vendor/autoload.php';
	require_once WCSP_PLUGIN_DIR . 'controllers/class-sinopac-payment.php';

	load_plugin_textdomain( WCSP_PLUGIN_TEXT_DOMAIN, false, WCSP_PLUGIN_LANGUAGE_PACK );

	$sinopac = new SinoPac_Payment();
	$sinopac->init();
}

add_action( 'woocommerce_loaded', 'load_sinopac_payment_gateway', 10, 1 );

/**
 * WooCommerce SinoPac Payment is open sourced at:
 * https://github.com/terrylinooo/wc-sinopac-payment
 *
 * If you have found any bugs or have any suggestions, please let me know.
 */
