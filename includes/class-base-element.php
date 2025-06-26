<?php
/**
 * Base Element Class for KNK Bricks Elements
 *
 * This class serves as a base for all custom Bricks elements,
 * providing common functionality like automatic script and style enqueuing.
 *
 * @category Core
 * @package  KNK_Bricks_Elements
 * @author   kanka.dev <mail@kanka.dev>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @link     https://kanka.dev
 */

if (!defined('ABSPATH')) {
    exit();
}

/**
 * Base Element Class
 *
 * @package KNK_Bricks_Elements
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Only define the class if Bricks is active and Element class exists
if (class_exists('\Bricks\Element')) {
    /**
     * Base Element Class for all KNK Bricks Elements
     * 
     * @category Core
     * @package  KNK_Bricks_Elements
     * @author   kanka.dev <mail@kanka.dev>
     * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
     * @link     https://kanka.dev
     */
    class KNK_Base_Element extends \Bricks\Element
    {
        /**
         * Standard-Kategorie für alle KNK-Elemente
         * 
         * @var string
         */
        public $category = 'knk';
        /**
         * Enqueue element styles and scripts
         * 
         * This method is automatically called by Bricks for elements used on the current page
         * 
         * @return void
         */
        public function enqueue_scripts()
        {
            // Get the element name from the class name
            $class_name = get_class($this);
            // Extrahiere den Namen und ersetze Unterstriche mit Bindestrichen für den Ordnernamen
            $element_name_raw = strtolower(str_replace('KNK_', '', str_replace('_Element', '', $class_name)));
            $element_name = str_replace('_', '-', $element_name_raw);
            
            // Element directory path
            $element_dir = KNK_BRICKS_ELEMENTS_DIR . 'elements/' . $element_name . '/';
            $element_url = KNK_BRICKS_ELEMENTS_URL . 'elements/' . $element_name . '/';
    
            // Check and enqueue CSS file
            $css_file = $element_dir . $element_name . '.css';
            
            if (file_exists($css_file)) {
                wp_enqueue_style(
                    'knk-' . $element_name,
                    $element_url . $element_name . '.css',
                    [],
                    KNK_BRICKS_ELEMENTS_VERSION
                );
            }
            
            // Check and enqueue JS file
            $js_file = $element_dir . $element_name . '.js';
            
            if (file_exists($js_file)) {
                wp_enqueue_script(
                    'knk-' . $element_name,
                    $element_url . $element_name . '.js',
                    ['jquery'],
                    KNK_BRICKS_ELEMENTS_VERSION,
                    true
                );
            }
        }
    }
} else {
    // Log if Bricks Element class is not available
    error_log('KNK Base Element: Bricks\Element class not found');
}
