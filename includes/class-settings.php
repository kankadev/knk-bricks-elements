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
        // Register the hide widget setting
        register_setting(
            KNK_BRICKS_ELEMENTS_SLUG . '-settings-group',
            'knk_bricks_elements_hide_widget',
            array(
                'type' => 'boolean',
                'default' => false,
                'sanitize_callback' => 'rest_sanitize_boolean'
            )
        );
        
        add_settings_section(
            'general_section',
            __('General Settings', KNK_BRICKS_ELEMENTS_SLUG),
            array($this, 'render_general_section'),
            KNK_BRICKS_ELEMENTS_SLUG . '-settings'
        );
        
        add_settings_field(
            'knk_bricks_elements_hide_widget',
            __('Hide Dashboard Widget', KNK_BRICKS_ELEMENTS_SLUG),
            array($this, 'render_hide_widget_field'),
            KNK_BRICKS_ELEMENTS_SLUG . '-settings',
            'general_section'
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
     * Render hide widget field
     *
     * @return void
     */
    public function render_hide_widget_field() {
        $hide_widget = get_option('knk_bricks_elements_hide_widget', false);
        ?>
        <input type="checkbox" 
               id="knk_bricks_elements_hide_widget" 
               name="knk_bricks_elements_hide_widget" 
               value="1" 
               <?php checked($hide_widget, true); ?> />
        <label for="knk_bricks_elements_hide_widget">
            <?php esc_html_e('Hide the developer info widget from the dashboard', KNK_BRICKS_ELEMENTS_SLUG); ?>
        </label>
        <?php
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
