<?php
/**
 * PDF Embed Element for Bricks Builder
 *
 * This element allows embedding PDF files from the WordPress media library
 * with customizable display options and a download button.
 *
 * @category Bricks_Element
 * @package  KNK_Bricks_Elements
 * @author   kanka.dev <mail@kanka.dev>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @version  1.0.0
 * @link     https://kanka.dev
 */

if (!defined('ABSPATH')) {
    exit();
}

/**
 * KNK_PDF_Embed_Element Class
 *
 * Provides functionality to embed PDF files from the media library
 * with customizable display options.
 */
class KNK_PDF_Embed_Element extends \Bricks\Element
{
    public $category = 'general';
    public $name = 'knk-pdf-embed';
    public $icon = 'ti-file';
    public $css_selector = '.knk-pdf-embed';

    /**
     * Get element label for builder
     *
     * @return string Element label
     */
    public function get_label()
    {
        return esc_html__("PDF Embed", KNK_BRICKS_ELEMENTS_SLUG);
    }

    /**
     * Enqueue element styles
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('knk-pdf-embed', KNK_BRICKS_ELEMENTS_URL . 'elements/pdf-embed/pdf-embed.css', [], KNK_BRICKS_ELEMENTS_VERSION);
    }

    /**
     * Set element controls
     *
     * @return void
     */
    public function set_controls()
    {
        $this->controls['pdf_file'] = [
            'tab' => 'content',
            'label' => esc_html__("PDF Datei", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'file',
            'fileExtensions' => ['pdf'],
            'description' => esc_html__("Wählen Sie eine PDF-Datei aus der Mediathek aus.", KNK_BRICKS_ELEMENTS_SLUG),
        ];

        $this->controls['width'] = [
            'tab' => 'content',
            'label' => esc_html__("Breite", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'number',
            'unit' => true,
            'default' => '100%',
            'description' => esc_html__("Breite des PDF-Viewers.", KNK_BRICKS_ELEMENTS_SLUG),
        ];

        $this->controls['height'] = [
            'tab' => 'content',
            'label' => esc_html__("Höhe", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'number',
            'unit' => true,
            'default' => '600px',
            'description' => esc_html__("Höhe des PDF-Viewers.", KNK_BRICKS_ELEMENTS_SLUG),
        ];

        $this->controls['show_toolbar'] = [
            'tab' => 'content',
            'label' => esc_html__("Toolbar anzeigen", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'checkbox',
            'inline' => true,
            'small' => true,
            'default' => true,
            'description' => esc_html__("Wenn aktiviert, wird die PDF-Toolbar angezeigt.", KNK_BRICKS_ELEMENTS_SLUG),
        ];

        $this->controls['show_download'] = [
            'tab' => 'content',
            'label' => esc_html__("Download-Button anzeigen", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'checkbox',
            'inline' => true,
            'small' => true,
            'default' => true,
            'description' => esc_html__("Wenn aktiviert, wird ein Download-Button unter dem PDF angezeigt.", KNK_BRICKS_ELEMENTS_SLUG),
        ];
        
        $this->controls['download_text'] = [
            'tab' => 'content',
            'label' => esc_html__("Download-Button Text", KNK_BRICKS_ELEMENTS_SLUG),
            'type' => 'text',
            'placeholder' => esc_html__("PDF herunterladen", KNK_BRICKS_ELEMENTS_SLUG),
            'description' => esc_html__("Text für den Download-Button. Standardmäßig 'PDF herunterladen'.", KNK_BRICKS_ELEMENTS_SLUG),
            'required' => ['show_download', '=', true],
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
        $pdf_id = isset($settings['pdf_file']['id']) ? $settings['pdf_file']['id'] : null;
        
        if (!$pdf_id) {
            return $this->render_element_placeholder(
                [
                    'title' => esc_html__("Bitte wählen Sie eine PDF-Datei aus.", KNK_BRICKS_ELEMENTS_SLUG),
                ]
            );
        }

        $pdf_url = wp_get_attachment_url($pdf_id);
        
        if (!$pdf_url) {
            return $this->render_element_placeholder(
                [
                    'title' => esc_html__("Die ausgewählte PDF-Datei konnte nicht gefunden werden.", KNK_BRICKS_ELEMENTS_SLUG),
                ]
            );
        }

        // Get width and height
        $width = isset($settings['width']) ? $settings['width'] : '100%';
        $height = isset($settings['height']) ? $settings['height'] : '600px';
        
        // Show toolbar option
        $toolbar = isset($settings['show_toolbar']) && $settings['show_toolbar'] ? '#toolbar=1' : '#toolbar=0';
        
        // Show download button option
        $show_download = isset($settings['show_download']) ? $settings['show_download'] : false;
        
        // Get download button text
        $download_text = isset($settings['download_text']) && !empty($settings['download_text']) 
            ? $settings['download_text'] 
            : esc_html__("PDF herunterladen", KNK_BRICKS_ELEMENTS_SLUG);
        
        // Get PDF filename for download button
        $pdf_filename = basename(get_attached_file($pdf_id));

        echo '<div class="knk-pdf-embed" style="width: ' . esc_attr($width) . ';">';
        echo '<div class="knk-pdf-embed-container" style="height: ' . esc_attr($height) . ';">';
        echo '<object data="' . esc_url($pdf_url . $toolbar) . '" type="application/pdf" width="100%" height="100%">';
        echo '<iframe src="' . esc_url($pdf_url . $toolbar) . '" width="100%" height="100%" style="border: none;">';
        echo esc_html__("Dieser Browser unterstützt keine eingebetteten PDFs. Bitte laden Sie die PDF-Datei herunter: ", KNK_BRICKS_ELEMENTS_SLUG);
        echo '<a href="' . esc_url($pdf_url) . '">' . esc_html__("PDF herunterladen", KNK_BRICKS_ELEMENTS_SLUG) . '</a>';
        echo '</iframe>';
        echo '</object>';
        echo '</div>';
        
        // Download button
        if ($show_download) {
            echo '<div class="knk-pdf-download-button">';
            echo '<a href="' . esc_url($pdf_url) . '" download="' . esc_attr($pdf_filename) . '" class="knk-pdf-download brxe-button bricks-button bricks-background-primary">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>';
            echo ' ' . $download_text;
            echo '</a>';
            echo '</div>';
        }
        
        echo '</div>';
    }
}
