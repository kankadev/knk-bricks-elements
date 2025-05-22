<?php
/**
 * Settings Class
 *
 * @category Core
 * @package  KNK_Bricks_Elements
 * @author   kanka.dev <mail@kanka.dev>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @version  GIT: 1.0.0
 * @link     https://kanka.dev
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class to handle plugin settings
 */
class KNK_Bricks_Elements_Settings {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Add settings page to admin menu
     *
     * @return void
     */
    public function add_settings_page() {
        add_options_page(
            __('kanka.dev Bricks Elements Settings', KNK_BRICKS_ELEMENTS_SLUG),
            __('kanka.dev Bricks Elements', KNK_BRICKS_ELEMENTS_SLUG),
            'manage_options',
            KNK_BRICKS_ELEMENTS_SLUG . '-settings',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register settings
     *
     * @return void
     */
    public function register_settings() {
        // Hier können in Zukunft Plugin-Einstellungen registriert werden
        
        add_settings_section(
            'general_section',
            __('General Settings', KNK_BRICKS_ELEMENTS_SLUG),
            array($this, 'render_general_section'),
            KNK_BRICKS_ELEMENTS_SLUG . '-settings'
        );
    }

    /**
     * Render general section
     *
     * @return void
     */
    public function render_general_section() {
        echo '<p>' . esc_html__('General settings for the plugin.', KNK_BRICKS_ELEMENTS_SLUG) . '</p>';
    }

    /**
     * Render settings page
     *
     * @return void
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields(KNK_BRICKS_ELEMENTS_SLUG . '-settings-group');
                do_settings_sections(KNK_BRICKS_ELEMENTS_SLUG . '-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // Hier können in Zukunft Getter-Methoden für Plugin-Einstellungen hinzugefügt werden
}

// Initialize settings
new KNK_Bricks_Elements_Settings();
