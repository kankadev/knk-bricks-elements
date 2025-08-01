<?php
/**
 * Dashboard Widget
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
 * Show developer info in dashboard
 *
 * @return void
 */
function knk_bricks_elements_add_dashboard_widget() {
    // Check if widget should be hidden
    $hide_widget = get_option('knk_bricks_elements_hide_widget', false);
    
    if (!$hide_widget) {
        wp_add_dashboard_widget(
            'knk_bricks_elements_dashboard_widget',
            'Designer & Developer Info',
            'knk_bricks_elements_dashboard_info'
        );
    }
}

add_action('wp_dashboard_setup', 'knk_bricks_elements_add_dashboard_widget');

/**
 * Display dashboard widget content
 *
 * @return void
 */
function knk_bricks_elements_dashboard_info() {
    echo '<div class="knk-dashboard-widget">';
    echo '<a href="https://kanka.dev" title="kanka.dev" target="_blank">'
        . '<img src="' . KNK_BRICKS_ELEMENTS_URL . '/assets/img/kanka.dev_logo.svg" alt="kanka.dev Logo" class="knk-logo"></a>';
    echo '<ul>
        <li><strong>Entwickelt von:</strong> <a href="https://kanka.dev" target="_blank">kanka.dev</a></li>
        <li><strong>E-Mail:</strong> <a href="mailto:mail@kanka.dev">mail@kanka.dev</a></li>
        <li><strong>Mobil:</strong> <a href="tel:+905342302226">+90 534 230 22 26</a></li>
        <li><strong>Web:</strong> <a href="https://kanka.dev" title="kanka.dev" target="_blank">kanka.dev</a></li>
        </ul></div>';
    echo '<style>
        .knk-dashboard-widget {
            background-color: #FFFFFF;
            color: #000000;
            padding: 1rem;
        }
        .knk-dashboard-widget a {
            color: #000000;
            text-decoration: underline;
            font-size: 1.2rem;
        }
        .knk-dashboard-widget li {
            font-size: 1.2rem;
        }
        .knk-logo {
            width: 374px;
            height: auto;
            max-width: 95%;
        }
    </style>';
}
