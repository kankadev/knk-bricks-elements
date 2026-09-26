<?php

if (!defined('ABSPATH')) {
    exit();
}

class KNK_Social_Media_Element extends KNK_Base_Element
{
    //public $category = 'knk';
    public $name = 'knk-social-media';
    public $icon = 'ti-facebook';
    public $css_selector = '.knk-social-media';

    public function get_label()
    {
        return esc_html__('Social Media', 'bricks');
    }

    public function set_control_groups() {}

    public function set_controls()
    {
        $this->controls['svgIcons'] = [
            'tab' => 'content',
            'label' => esc_html__('Use bundled SVG icons', 'knk-bricks-elements'),
            'type' => 'checkbox',
            'description' => esc_html__('Optional. Keeps saved selections; unsupported icons and modifiers retain their existing font output.', 'knk-bricks-elements'),
            'default' => false,
        ];
        $this->controls['iconSize'] = [
            'tab' => 'content',
            'label' => esc_html__('Icon Size', 'bricks'),
            'type' => 'number',
            'units' => ['px', 'em', 'rem'],
            'css' => [
                [
                    'property' => 'width',
                    'selector' => '.knk-social-icon',
                ],
                [
                    'property' => 'font-size',
                    'selector' => '.knk-social-icon::before, .knk-social-icon--svg',
                ],
            ],
            'default' => '1.5rem',
        ];

        $this->controls['iconColor'] = [
            'tab' => 'content',
            'label' => esc_html__('Icon Color', 'bricks'),
            'type' => 'color',
            'inline' => true,
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.knk-social-icon::before, .knk-social-icon--svg',
                ]
            ],
            'default' => [
                'hex' => '#3ce77b',
                'rgb' => 'rgba(60, 231, 123, 0.9)',
            ],
        ];
    }

    /** Only replace known plain icon classes; retain custom/modified font output. */
    public static function bundled_icon($classes)
    {
        if (!is_string($classes)) {
            return '';
        }
        $map = [
            'fa-whatsapp' => 'whatsapp', 'fa-skype' => 'skype',
            'fa-linkedin' => 'linkedin', 'fa-linkedin-in' => 'linkedin-in',
            'fa-github' => 'github', 'fa-xing' => 'xing',
            'fa-xing-square' => 'square-xing', 'fa-square-xing' => 'square-xing',
            'fa-telegram' => 'telegram',
        ];
        $name = '';
        foreach (preg_split('/\s+/', trim($classes)) as $token) {
            if (in_array($token, ['fa', 'fab', 'fa-brands'], true)) {
                continue;
            }
            if (!isset($map[$token]) || $name !== '') {
                return '';
            }
            $name = $map[$token];
        }
        if ($name === '') {
            return '';
        }
        $file = KNK_BRICKS_ELEMENTS_DIR . 'assets/social-icons/' . $name . '.svg';
        if (!is_readable($file)) {
            return '';
        }
        // Only plugin-shipped files, never uploaded SVGs or user-supplied markup.
        $svg = file_get_contents($file);
        if ($svg === false) {
            return '';
        }
        return str_replace('<svg ', '<svg width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false" ', $svg);
    }

    public function render()
    {
        $root_classes[] = 'knk-social-media';

        $this->set_attribute('_root', 'class', $root_classes);

        $options = get_option('knk-social-media');
        $repeater = isset($options['knk_social_media_repeater'])
            ? $options['knk_social_media_repeater']
            : [];


        if (is_array($repeater)) {
            echo "<div {$this->render_attributes('_root')}>";
            foreach ($repeater as $social_media) {
                $channel = isset($social_media['knk_social_media_kanal'])
                    ? $social_media['knk_social_media_kanal']
                    : '';
                $icon = isset($social_media['knk_social_media_icon'])
                    ? $social_media['knk_social_media_icon']
                    : '';
                $url = isset($social_media['knk_social_media_url'])
                    ? $social_media['knk_social_media_url']
                    : '';

                if (!empty($icon) && !empty($url)) {
                    $svg = !empty($this->settings['svgIcons']) ? self::bundled_icon($icon) : '';
                    if ($svg !== '') {
                        $skype = strtolower($channel) === 'skype';
                        $href = $skype ? 'skype:' . $url : $url;
                        $target = !$skype && preg_match('~^https?://~i', $url) ? ' target="_blank" rel="noopener noreferrer"' : '';
                        echo '<a href="' . esc_url($href, ['http', 'https', 'mailto', 'tel', 'skype']) . '"' . $target . ' class="knk-social-icon knk-social-icon--svg" title="' . esc_attr($channel) . '" aria-label="' . esc_attr($channel) . '">' . $svg . '</a>';
                        continue;
                    }
                    if (strtolower($channel) === 'skype') {
                        echo '<a href="skype:' .
                            esc_attr($url) .
                            '" class="knk-social-icon fa-brands ' .
                            esc_attr($icon) .
                            '" alt="' .
                            esc_attr($channel) .
                            '" title="' .
                            esc_attr($channel) .
                            '" aria-label="' .
                            esc_attr($channel) .
                            '" ></a>';
                    } else {
                        echo '<a href="' .
                            esc_url($url) .
                            '" target="_blank" class="knk-social-icon fa-brands ' .
                            esc_attr($icon) .
                            '" alt="' .
                            esc_attr($channel) .
                            '" title="' .
                            esc_attr($channel) .
                            '" aria-label="' .
                            esc_attr($channel) .
                            '"></a>';
                    }
                }
            }
            echo '</div>';
        }
    }
}
