<?php
/**
 *
 * Plugin Name:     WAETAG Plugin
 * Plugin URI: 		  https://waetag.com
 * Description:     Custom addons and extensions for the WAETAG website
 * Version:         1.0.1.0
 * Text Domain:     waetag
 * Author:          Kevin Chancey
 * Author URI:      kevin@kevtech.net
 * Text Domain:     waetag
 * Domain Path:     /languages
 */

defined('ABSPATH') || exit;

$dir = plugin_dir_path( __FILE__ );
$dir_includes = $dir . 'includes/';

require_once($dir_includes . 'settings.php');
require_once($dir_includes . 'RestAPI.php');
require_once($dir_includes . 'Waetag.php');


add_action( 'plugins_loaded', function() {
  WAETAG\RestAPI::get_instance();
  WAETAG\Waetag::get_instance();
});

register_activation_hook(__FILE__, 'wa_activate');

function wa_activate()
{
    // Schedule the cron event to run daily
    if (!wp_next_scheduled('wa_cron_event')) {
        wp_schedule_event(time(), 'daily', 'wa_cron_event');
    }
}
?>