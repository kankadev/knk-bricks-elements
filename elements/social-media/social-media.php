<?php

if (!defined('ABSPATH')) {
    exit();
}

class KNK_Social_Media_Element extends \Bricks\Element
{
    public $category = 'general';
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
                    'selector' => '.knk-social-icon::before',
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
                    'selector' => '.knk-social-icon::before',
                ]
            ],
            'default' => [
                'hex' => '#3ce77b',
                'rgb' => 'rgba(60, 231, 123, 0.9)',
            ],
        ];
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('knk-social-media', get_stylesheet_directory_uri() . '/elements/social-media/social-media.css', [], '1.0.0');
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
