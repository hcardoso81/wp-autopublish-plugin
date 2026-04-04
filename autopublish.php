<?php
/**
 * Plugin Name: AutoPublish
 * Plugin URI:  https://github.com/your-user/wp-autopublish-plugin
 * Description: Import HTML files and create draft WordPress posts automatically.
 * Version:     0.1.0
 * Author:      Cardoso Hernan
 * Author URI:  https://www.linkedin.com/in/cardosohernan/
 * Text Domain: autopublish
 */

namespace AutoPublish;

if (!defined('ABSPATH')) {
    exit;
}

// Constants
define('AUTOPUBLISH_PATH', plugin_dir_path(__FILE__));
define('AUTOPUBLISH_URL', plugin_dir_url(__FILE__));
define('AUTOPUBLISH_VERSION', '0.1.0');

// Bootstrap
require_once AUTOPUBLISH_PATH . 'bootstrap/admin.php';