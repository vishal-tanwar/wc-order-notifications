<?php 
/**
 * Plugin Name: WC Order Notifications
 * Plugin URI: https://github.com/vishal-tanwar/wc-order-notifications
 * Version: 0.0.1
 * Description: This Helps in send SMS/WhatsApp notifications to vendor and customers for new orders and status of order.  
 * Author: Vishal Tanwar
 * Author URI: https://github.com/vishal-tanwar
 * Requires at least: 5.4
 * Requires PHP:      7.2
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wc-order-notifications
 */
namespace WCON;
// Restrict to Direct Access
defined('ABSPATH') or die('Direct Access Denied!');

// define plugin constants
define('WCON_PLUGIN_FILE', __FILE__ );
define('WCON_PLUGIN_DIR', __DIR__ . DIRECTORY_SEPARATOR );
define('WCON_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define('WCON_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('WCON_PLUGIN_VERSION', '0.0.1' );
define('WCON_PLUGIN_NAME', 'WC Order Notifications' );
define('WCON_PLUGIN_TEXTDOMAIN', 'wc-order-notifications' );
// Define Directories
define('WCON_PLUGIN_ASSETS', WCON_PLUGIN_DIR . 'assets/' );
define('WCON_PLUGIN_INC', WCON_PLUGIN_DIR . 'inc/' );
define('WCON_PLUGIN_TEMPLATES', WCON_PLUGIN_DIR . 'templates/' );

// Check if WooCommerce installed and activated
if( is_plugin_active('woocommerce/woocommerce.php') ){
    require 'classes/Abstract/Settings.php';
    require 'classes/settings.php';
    require 'classes/Templates.php';
    require 'classes/SMS.php';
}

else{
    add_action('admin_notices', function () {
        $message = esc_html__('WC Order Notifications needs woocommerce Please install and active WooCommerce plugin.', 'WCON_PLUGIN_TEXTDOMAIN');
        printf('<div class="%1$s"><p>%2$s</p></div>', 'notice notice-error', $message);
    });
}

