<?php

if (!defined('ABSPATH')) {
    exit();
}

class KNK_Contact_Info_Element extends KNK_Base_Element
{
    public $name = 'knk-contact-info';
    public $icon = 'ti-info-alt';
    public $css_selector = '.knk-contact-info';

    public function get_label()
    {
        return esc_html__('Kontaktinformation', 'bricks');
    }

    public function set_controls()
    {
        $options = get_option('knk-kontaktinformationen');
        $choices = [];

        if (is_array($options)) {
            foreach ($options as $key => $value) {
                if (!empty($value)) {
                    $choices[$key] = ucfirst(str_replace('_', ' ', $key));
                }
            }
        }

        $this->controls['info_type'] = [
            'tab' => 'content',
            'label' => esc_html__('Kontaktinformation', 'bricks'),
            'type' => 'select',
            'options' => $choices,
            'default' => key($choices),
            'clearable' => false,
            'description' => __('Welche Information aus <a href="/wp-admin/admin.php?page=knk-kontaktinformationen" target="_blank">KNK Optionen > Kontaktinformationen</a> soll angezeigt werden?', 'bricks'),
        ];

        $this->controls['linking'] = [
            'tab' => 'content',
            'label' => esc_html__('Verlinken?', 'bricks'),
            'type' => 'checkbox',
            'inline' => true,
            'small' => true,
            'default' => true,
            'description' => esc_html__('Wenn aktiviert, wird die Kontaktinformation verlinkt.', 'bricks'),
        ];

        $this->controls['icons'] = [
            'tab' => 'content',
            'label' => esc_html__('Icon anzeigen?', 'bricks'),
            'type' => 'checkbox',
            'inline' => true,
            'small' => true,
            'default' => true,
            'description' => esc_html__('Wenn aktiviert, wird das Icon angezeigt.', 'bricks'),
        ];
    }

    public function render()
    {
        $options = get_option('knk-kontaktinformationen');
        $info_type = $this->settings['info_type'];

        echo '<div class="knk-contact-info ' . $info_type . '">';

        if (isset($this->settings['linking']) && $this->settings['linking'] && $info_type !== 'knk_address') {

            if ($info_type === 'knk_email') {
                echo '<a href="mailto:' . esc_attr($options[$info_type]) . '" title="E-Mail an ' . esc_attr($options[$info_type]) . ' schreiben.">';
            } elseif ($info_type === 'knk_phonenumber_view' || $info_type === 'knk_phonenumber_value') {
                echo '<a href="tel:' . esc_attr($options['knk_phonenumber_value']) . '" title="' . esc_attr($options['knk_phonenumber_view']) . '">';
            } else {
                echo '<a href="' . esc_url($options[$info_type]) . '">';
            }
        }

        if (isset($this->settings['icons']) && $this->settings['icons']) {
            switch ($info_type) {
                case 'knk_email':
                    echo '<i class="fa-solid fa-envelope"></i>';
                    break;
                case 'knk_phonenumber_view':
                    echo '<i class="fa-solid fa-phone"></i>';
                    break;
                case 'knk_phonenumber_value':
                    echo '<i class="fa-solid fa-phone"></i>';
                    break;
                case 'knk_address':
                    echo '<i class="fa-solid fa-map-marker-alt"></i>';
                    break;
            }
        }


        echo isset($options[$info_type]) ? ($info_type === 'knk_address' ? nl2br(esc_html($options[$info_type])) : esc_html($options[$info_type])) : '';

        if (isset($this->settings['linking']) && $this->settings['linking']) {
            echo '</a>';
        }
        echo '</div>';
    }
}
