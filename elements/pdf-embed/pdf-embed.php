<?php

if (!defined('ABSPATH')) {
    exit();
}

class KNK_PDF_Embed_Element extends \Bricks\Element
{
    public $category = 'general';
    public $name = 'knk-pdf-embed';
    public $icon = 'ti-file';
    public $css_selector = '.knk-pdf-embed';

    public function get_label()
    {
        return esc_html__('PDF Embed', 'bricks');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('knk-pdf-embed', KNK_BRICKS_ELEMENTS_URL . 'elements/pdf-embed/pdf-embed.css', [], KNK_BRICKS_ELEMENTS_VERSION);
    }

    public function set_controls()
    {
        $this->controls['pdf_file'] = [
            'tab' => 'content',
            'label' => esc_html__('PDF Datei', 'bricks'),
            'type' => 'image',
            'description' => esc_html__('Wählen Sie eine PDF-Datei aus der Mediathek aus.', 'bricks'),
        ];

        $this->controls['width'] = [
            'tab' => 'content',
            'label' => esc_html__('Breite', 'bricks'),
            'type' => 'number',
            'unit' => true,
            'default' => '100%',
            'description' => esc_html__('Breite des PDF-Viewers.', 'bricks'),
        ];

        $this->controls['height'] = [
            'tab' => 'content',
            'label' => esc_html__('Höhe', 'bricks'),
            'type' => 'number',
            'unit' => true,
            'default' => '600px',
            'description' => esc_html__('Höhe des PDF-Viewers.', 'bricks'),
        ];

        $this->controls['show_toolbar'] = [
            'tab' => 'content',
            'label' => esc_html__('Toolbar anzeigen', 'bricks'),
            'type' => 'checkbox',
            'inline' => true,
            'small' => true,
            'default' => true,
            'description' => esc_html__('Wenn aktiviert, wird die PDF-Toolbar angezeigt.', 'bricks'),
        ];
    }

    public function render()
    {
        $settings = $this->settings;
        $pdf_id = isset($settings['pdf_file']['id']) ? $settings['pdf_file']['id'] : null;
        
        if (!$pdf_id) {
            return $this->render_element_placeholder(
                [
                    'title' => esc_html__('Bitte wählen Sie eine PDF-Datei aus.', 'bricks'),
                ]
            );
        }

        $pdf_url = wp_get_attachment_url($pdf_id);
        
        if (!$pdf_url) {
            return $this->render_element_placeholder(
                [
                    'title' => esc_html__('Die ausgewählte PDF-Datei konnte nicht gefunden werden.', 'bricks'),
                ]
            );
        }

        // Get width and height
        $width = isset($settings['width']) ? $settings['width'] : '100%';
        $height = isset($settings['height']) ? $settings['height'] : '600px';
        
        // Show toolbar option
        $toolbar = isset($settings['show_toolbar']) && $settings['show_toolbar'] ? '#toolbar=1' : '#toolbar=0';

        echo '<div class="knk-pdf-embed">';
        echo '<object data="' . esc_url($pdf_url . $toolbar) . '" type="application/pdf" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '">';
        echo '<iframe src="' . esc_url($pdf_url . $toolbar) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" style="border: none;">';
        echo esc_html__('Dieser Browser unterstützt keine eingebetteten PDFs. Bitte laden Sie die PDF-Datei herunter: ', 'bricks');
        echo '<a href="' . esc_url($pdf_url) . '">' . esc_html__('PDF herunterladen', 'bricks') . '</a>';
        echo '</iframe>';
        echo '</object>';
        echo '</div>';
    }
}
