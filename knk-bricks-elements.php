<?php
/**
 * Plugin Name: kanka.dev Bricks Elements
 * Plugin URI: https://github.com/kankadev/knk-bricks-elements
 * Description: Custom Bricks Builder elements by kanka.dev
 * Version: 1.0.13
 * Author: kanka.dev
 * Author URI: https://kanka.dev
 * Text Domain: knk-bricks-elements
 * GitHub Plugin URI: kankadev/knk-bricks-elements
 * GitHub Branch: main
 * Requires PHP: 7.4
 * Requires at least: 5.6
 *
 * @category Core
 * @package  KNK_Bricks_Elements
 * @author   kanka.dev <mail@kanka.dev>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @version  GIT: 1.0.13
 * @link     https://kanka.dev
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('KNK_BRICKS_ELEMENTS_SLUG', 'knk-bricks-elements');
define('KNK_BRICKS_ELEMENTS_VERSION', '1.0.13');
define('KNK_BRICKS_ELEMENTS_DIR', plugin_dir_path(__FILE__));
define('KNK_BRICKS_ELEMENTS_URL', plugin_dir_url(__FILE__));

// Include required files
require_once KNK_BRICKS_ELEMENTS_DIR . 'includes/class-github-updater.php';
require_once KNK_BRICKS_ELEMENTS_DIR . 'includes/class-settings.php';
require_once KNK_BRICKS_ELEMENTS_DIR . 'includes/dashboard-widget.php';

// Initialize GitHub Updater
if (class_exists('KNK_Bricks_Elements_GitHub_Updater')) {
    new KNK_Bricks_Elements_GitHub_Updater(
        __FILE__,
        'kankadev',
        KNK_BRICKS_ELEMENTS_SLUG
    );
}

/**
 * Check if Bricks is active
 *
 * @return bool True if dependencies are met, false otherwise
 */
function knk_bricks_elements_check_dependencies()
{
    if (!class_exists('\Bricks\Elements')) {
        add_action('admin_notices', 'knk_bricks_elements_admin_notice');
        return false;
    }
    return true;
}

/**
 * Load plugin text domain
 */
function knk_bricks_elements_load_textdomain() {
    load_plugin_textdomain(
        KNK_BRICKS_ELEMENTS_SLUG,
        false,
        dirname(KNK_BRICKS_ELEMENTS_SLUG) . '/languages'
    );
}
add_action('init', 'knk_bricks_elements_load_textdomain');

/**
 * Admin notice if Bricks is not active
 */
function knk_bricks_elements_admin_notice() {
    ?>
    <div class="notice notice-error">
        <p><?php echo esc_html__('kanka.dev Bricks Elements requires the Bricks Builder plugin to be installed and activated.', KNK_BRICKS_ELEMENTS_SLUG); ?></p>
    </div>
    <?php
}

/**
 * Register custom elements
 *
 * @return void
 */
function knk_bricks_elements_register()
{
    if (!knk_bricks_elements_check_dependencies()) {
        return;
    }
    
    // Stellen sicher, dass die Bricks\Element Klasse verfügbar ist
    if (!class_exists('\Bricks\Element')) {
        error_log('KNK Bricks Elements: Bricks\Element class not found during element registration');
        return;
    }
    
    require_once KNK_BRICKS_ELEMENTS_DIR . 'includes/class-base-element.php';

    $elements_dir = KNK_BRICKS_ELEMENTS_DIR . 'elements/';
    $elements = glob($elements_dir . '*', GLOB_ONLYDIR);

    foreach ($elements as $element) {
        $element_name = basename($element);
        $element_file = $element . '/' . $element_name . '.php';

        if (file_exists($element_file)) {
            \Bricks\Elements::register_element($element_file);
        }
    }
}
add_action('init', 'knk_bricks_elements_register', 11);

/**
 * Add text strings to builder
 */
add_filter('bricks/builder/i18n', function ($i18n) {
    // Für die Element-Kategorie 'knk'
    $i18n['knk'] = esc_html__('kanka.dev', KNK_BRICKS_ELEMENTS_SLUG);
    return $i18n;
});