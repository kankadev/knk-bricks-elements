<?php
/**
 * Opening Hours Element for Bricks Builder
 *
 * This element displays business/opening hours in a responsive grid layout
 * with customizable days and times.
 *
 * @category Bricks_Element
 * @package  KNK_Bricks_Elements
 * @author   kanka.dev <mail@kanka.dev>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @version  GIT: 1.0.5
 * @link     https://kanka.dev
 */

if (!defined('ABSPATH')) {
    exit();
}

/**
 * KNK_Opening_Hours_Element Class
 *
 * Provides functionality to display business/opening hours in a responsive layout
 */
class KNK_Opening_Hours_Element extends \Bricks\Element
{
    public $category = 'general';
    public $name = 'knk-opening-hours';
    public $icon = 'ti-time';
    public $css_selector = '.knk-opening-hours';

    /**
     * Get element label for builder
     *
     * @return string Element label
     */
    public function get_label()
    {
        return esc_html__("Öffnungszeiten", KNK_BRICKS_ELEMENTS_SLUG);
    }

    /**
     * Enqueue element styles
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('knk-opening-hours', KNK_BRICKS_ELEMENTS_URL . 'elements/opening-hours/opening-hours.css', [], KNK_BRICKS_ELEMENTS_VERSION);
    }

    /**
     * Set element controls
     *
     * @return void
     */
    public function set_controls()
    {
        // Title settings
        $this->controls['titleSeparator'] = [
            'tab' => 'content',
            'label' => esc_html__("Titel", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'separator',
        ];
        
        $this->controls['showTitle'] = [
            'tab' => 'content',
            'label' => esc_html__("Titel anzeigen", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'checkbox',
            'default' => false,
        ];
        
        $this->controls['title'] = [
            'tab' => 'content',
            'label' => esc_html__("Titel Text", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'text',
            'placeholder' => esc_html__("Öffnungszeiten", KNK_BRICKS_ELEMENTS_SLUG),
            'required' => ['showTitle', '=', true],
        ];
        
        $this->controls['titleTag'] = [
            'tab' => 'content',
            'label' => esc_html__("Titel HTML Tag", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'select',
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
            ],
            'default' => 'h3',
            'required' => ['showTitle', '=', true],
        ];
        
        // Days settings
        $this->controls['daysSeparator'] = [
            'tab' => 'content',
            'label' => esc_html__("Wochentage", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'separator',
        ];
        
        // Monday
        $this->controls['monday'] = [
            'tab' => 'content',
            'label' => esc_html__("Montag", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'repeater',
            'titleProperty' => 'time',
            'default' => [
                [
                    'time' => '09:00 - 18:00',
                    'note' => '',
                ],
            ],
            'fields' => [
                'time' => [
                    'label' => esc_html__("Öffnungszeit", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => '09:00 - 18:00',
                ],
                'note' => [
                    'label' => esc_html__("Notiz", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => esc_html__("z.B. Mittagspause", KNK_BRICKS_ELEMENTS_SLUG),
                ],
            ],
        ];
        
        // Tuesday
        $this->controls['tuesday'] = [
            'tab' => 'content',
            'label' => esc_html__("Dienstag", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'repeater',
            'titleProperty' => 'time',
            'default' => [
                [
                    'time' => '09:00 - 18:00',
                    'note' => '',
                ],
            ],
            'fields' => [
                'time' => [
                    'label' => esc_html__("Öffnungszeit", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => '09:00 - 18:00',
                ],
                'note' => [
                    'label' => esc_html__("Notiz", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => esc_html__("z.B. Mittagspause", KNK_BRICKS_ELEMENTS_SLUG),
                ],
            ],
        ];
        
        // Wednesday
        $this->controls['wednesday'] = [
            'tab' => 'content',
            'label' => esc_html__("Mittwoch", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'repeater',
            'titleProperty' => 'time',
            'default' => [
                [
                    'time' => '09:00 - 18:00',
                    'note' => '',
                ],
            ],
            'fields' => [
                'time' => [
                    'label' => esc_html__("Öffnungszeit", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => '09:00 - 18:00',
                ],
                'note' => [
                    'label' => esc_html__("Notiz", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => esc_html__("z.B. Mittagspause", KNK_BRICKS_ELEMENTS_SLUG),
                ],
            ],
        ];
        
        // Thursday
        $this->controls['thursday'] = [
            'tab' => 'content',
            'label' => esc_html__("Donnerstag", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'repeater',
            'titleProperty' => 'time',
            'default' => [
                [
                    'time' => '09:00 - 18:00',
                    'note' => '',
                ],
            ],
            'fields' => [
                'time' => [
                    'label' => esc_html__("Öffnungszeit", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => '09:00 - 18:00',
                ],
                'note' => [
                    'label' => esc_html__("Notiz", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => esc_html__("z.B. Mittagspause", KNK_BRICKS_ELEMENTS_SLUG),
                ],
            ],
        ];
        
        // Friday
        $this->controls['friday'] = [
            'tab' => 'content',
            'label' => esc_html__("Freitag", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'repeater',
            'titleProperty' => 'time',
            'default' => [
                [
                    'time' => '09:00 - 18:00',
                    'note' => '',
                ],
            ],
            'fields' => [
                'time' => [
                    'label' => esc_html__("Öffnungszeit", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => '09:00 - 18:00',
                ],
                'note' => [
                    'label' => esc_html__("Notiz", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => esc_html__("z.B. Mittagspause", KNK_BRICKS_ELEMENTS_SLUG),
                ],
            ],
        ];
        
        // Saturday
        $this->controls['saturday'] = [
            'tab' => 'content',
            'label' => esc_html__("Samstag", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'repeater',
            'titleProperty' => 'time',
            'default' => [
                [
                    'time' => '10:00 - 14:00',
                    'note' => '',
                ],
            ],
            'fields' => [
                'time' => [
                    'label' => esc_html__("Öffnungszeit", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => '10:00 - 14:00',
                ],
                'note' => [
                    'label' => esc_html__("Notiz", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => esc_html__("z.B. Mittagspause", KNK_BRICKS_ELEMENTS_SLUG),
                ],
            ],
        ];
        
        // Sunday
        $this->controls['sunday'] = [
            'tab' => 'content',
            'label' => esc_html__("Sonntag", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'repeater',
            'titleProperty' => 'time',
            'default' => [
                [
                    'time' => esc_html__("Geschlossen", KNK_BRICKS_ELEMENTS_SLUG),
                    'note' => '',
                ],
            ],
            'fields' => [
                'time' => [
                    'label' => esc_html__("Öffnungszeit", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => esc_html__("Geschlossen", KNK_BRICKS_ELEMENTS_SLUG),
                ],
                'note' => [
                    'label' => esc_html__("Notiz", KNK_BRICKS_ELEMENTS_SLUG),
                    'type' => 'text',
                    'placeholder' => '',
                ],
            ],
        ];
        
        // Layout settings
        $this->controls['layoutSeparator'] = [
            'tab' => 'content',
            'label' => esc_html__("Layout", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'separator',
        ];
        
        $this->controls['highlightToday'] = [
            'tab' => 'content',
            'label' => esc_html__("Heutigen Tag hervorheben", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'checkbox',
            'default' => true,
        ];
        
        $this->controls['showEmptyDays'] = [
            'tab' => 'content',
            'label' => esc_html__("Leere Tage anzeigen", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'checkbox',
            'default' => true,
            'description' => esc_html__("Wenn deaktiviert, werden Tage ohne Öffnungszeiten ausgeblendet", KNK_BRICKS_ELEMENTS_SLUG),
        ];
        
        // Style tab settings
        $this->controls['titleTypography'] = [
            'tab' => 'style',
            'label' => esc_html__("Titel Typografie", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'typography',
                    'selector' => '.knk-opening-hours-title',
                ],
            ],
            'required' => ['showTitle', '=', true],
        ];
        
        $this->controls['dayTypography'] = [
            'tab' => 'style',
            'label' => esc_html__("Wochentag Typografie", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'typography',
                    'selector' => '.knk-opening-hours-day',
                ],
            ],
        ];
        
        $this->controls['timeTypography'] = [
            'tab' => 'style',
            'label' => esc_html__("Öffnungszeit Typografie", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'typography',
                    'selector' => '.knk-opening-hours-time',
                ],
            ],
        ];
        
        $this->controls['noteTypography'] = [
            'tab' => 'style',
            'label' => esc_html__("Notiz Typografie", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'typography',
            'css' => [
                [
                    'property' => 'typography',
                    'selector' => '.knk-opening-hours-note',
                ],
            ],
        ];
        
        $this->controls['rowSpacing'] = [
            'tab' => 'style',
            'label' => esc_html__("Zeilenabstand", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'number',
            'units' => true,
            'css' => [
                [
                    'property' => 'margin-bottom',
                    'selector' => '.knk-opening-hours-row',
                ],
            ],
            'default' => '10px',
        ];
        
        $this->controls['todayBackground'] = [
            'tab' => 'style',
            'label' => esc_html__("Hintergrund für heutigen Tag", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'background-color',
                    'selector' => '.knk-opening-hours-row.today',
                ],
            ],
            'default' => 'rgba(0, 0, 0, 0.05)',
            'required' => ['highlightToday', '=', true],
        ];
    }

    /**
     * Render element HTML
     *
     * @return void
     */
    public function render()
    {
        $settings = $this->settings;
        $days = [
            'monday' => esc_html__("Montag", KNK_BRICKS_ELEMENTS_SLUG),
            'tuesday' => esc_html__("Dienstag", KNK_BRICKS_ELEMENTS_SLUG),
            'wednesday' => esc_html__("Mittwoch", KNK_BRICKS_ELEMENTS_SLUG),
            'thursday' => esc_html__("Donnerstag", KNK_BRICKS_ELEMENTS_SLUG),
            'friday' => esc_html__("Freitag", KNK_BRICKS_ELEMENTS_SLUG),
            'saturday' => esc_html__("Samstag", KNK_BRICKS_ELEMENTS_SLUG),
            'sunday' => esc_html__("Sonntag", KNK_BRICKS_ELEMENTS_SLUG),
        ];
        
        // Get current day of week (1 = Monday, 7 = Sunday)
        $current_day = intval(date('N'));
        $day_keys = array_keys($days);
        $current_day_key = $day_keys[$current_day - 1];
        
        echo '<div class="knk-opening-hours">';
        
        // Title
        if (isset($settings['showTitle']) && $settings['showTitle']) {
            $title_tag = isset($settings['titleTag']) ? $settings['titleTag'] : 'h3';
            $title_text = isset($settings['title']) && !empty($settings['title']) ? $settings['title'] : esc_html__("Öffnungszeiten", KNK_BRICKS_ELEMENTS_SLUG);
            
            echo '<' . $title_tag . ' class="knk-opening-hours-title">' . esc_html($title_text) . '</' . $title_tag . '>';
        }
        
        echo '<div class="knk-opening-hours-grid">';
        
        // Render each day
        foreach ($days as $day_key => $day_name) {
            // Skip empty days if showEmptyDays is false
            if (
                (!isset($settings['showEmptyDays']) || !$settings['showEmptyDays']) && 
                (!isset($settings[$day_key]) || empty($settings[$day_key]))
            ) {
                continue;
            }
            
            $is_today = ($day_key === $current_day_key && isset($settings['highlightToday']) && $settings['highlightToday']);
            $today_class = $is_today ? ' today' : '';
            
            echo '<div class="knk-opening-hours-row' . $today_class . '">';
            echo '<div class="knk-opening-hours-day">' . $day_name . '</div>';
            echo '<div class="knk-opening-hours-times">';
            
            if (isset($settings[$day_key]) && is_array($settings[$day_key])) {
                foreach ($settings[$day_key] as $time_slot) {
                    echo '<div class="knk-opening-hours-time-slot">';
                    
                    if (isset($time_slot['time'])) {
                        echo '<span class="knk-opening-hours-time">' . esc_html($time_slot['time']) . '</span>';
                    }
                    
                    if (isset($time_slot['note']) && !empty($time_slot['note'])) {
                        echo '<span class="knk-opening-hours-note">' . esc_html($time_slot['note']) . '</span>';
                    }
                    
                    echo '</div>';
                }
            } else {
                echo '<div class="knk-opening-hours-time-slot">';
                echo '<span class="knk-opening-hours-time">' . esc_html__("Geschlossen", KNK_BRICKS_ELEMENTS_SLUG) . '</span>';
                echo '</div>';
            }
            
            echo '</div>'; // End times
            echo '</div>'; // End row
        }
        
        echo '</div>'; // End grid
        echo '</div>'; // End opening hours
    }
}
