<?php
// Run with wp eval-file in a local WordPress installation with Bricks active.
if (!defined('WP_CLI') || !WP_CLI) {
    exit;
}

$original = hash('sha256', serialize(get_option('knk-social-media')));
$fixture = [
    'knk_social_media_repeater' => [
        ['knk_social_media_kanal' => 'WhatsApp', 'knk_social_media_icon' => 'fa fa-whatsapp', 'knk_social_media_url' => 'https://example.test/contact'],
        ['knk_social_media_kanal' => 'XING', 'knk_social_media_icon' => 'fa fa-xing-square', 'knk_social_media_url' => 'https://example.test/profile'],
        ['knk_social_media_kanal' => 'Custom', 'knk_social_media_icon' => 'fa fa-customer-icon', 'knk_social_media_url' => 'https://example.test/custom'],
        ['knk_social_media_kanal' => 'Animated', 'knk_social_media_icon' => 'fa fa-github fa-spin', 'knk_social_media_url' => 'https://example.test/animated'],
        ['knk_social_media_kanal' => 'Skype', 'knk_social_media_icon' => 'fa fa-skype', 'knk_social_media_url' => 'example.test'],
    ],
];
$filter = static function () use ($fixture) { return $fixture; };
$check = static function ($condition, $message) {
    if (!$condition) {
        throw new RuntimeException($message);
    }
};
add_filter('pre_option_knk-social-media', $filter);
try {
    $render = static function ($settings) {
        $element = new KNK_Social_Media_Element();
        $element->settings = $settings;
        ob_start();
        $element->render();
        return ob_get_clean();
    };
    $legacy = $render([]);
    $check(strpos($legacy, '<svg') === false, 'Default must retain font output');
    preg_match_all('/<a\b[^>]*>.*?<\/a>/s', $legacy, $legacy_links);
    $check(count($legacy_links[0]) === 5, 'All legacy choices survive');
    $explicit = $render(['svgIcons' => false]);
    preg_match_all('/<a\b[^>]*>.*?<\/a>/s', $explicit, $explicit_links);
    $check($legacy_links[0] === $explicit_links[0], 'Unset and disabled must match');
    $svg = $render(['svgIcons' => true]);
    $check(substr_count($svg, '<svg') === 3, 'Known icons and old aliases become SVG');
    $check(strpos($svg, $legacy_links[0][2]) !== false, 'Unknown icon fallback must be byte-identical');
    $check(strpos($svg, $legacy_links[0][3]) !== false, 'Modifier fallback must be byte-identical');
    $check(strpos($svg, 'href="skype:example.test"') !== false, 'Skype URI survives');
    $check(substr_count($svg, 'rel="noopener noreferrer"') === 2, 'External SVG anchors protected');
    foreach (['../whatsapp', 'fa-whatsapp fa-github', 'fa-whatsapp fa-spin', '<script>', '', 'fa-unknown'] as $invalid) {
        $check(KNK_Social_Media_Element::bundled_icon($invalid) === '', 'Unsafe or ambiguous input must not resolve');
    }
    foreach (['fa fa-whatsapp', 'fab fa-skype', 'fa-brands fa-linkedin', 'fa fa-linkedin-in', 'fa fa-github', 'fa fa-xing-square', 'fa-square-xing', 'fa-xing', 'fa-telegram'] as $valid) {
        $check(strpos(KNK_Social_Media_Element::bundled_icon($valid), '<svg') !== false, 'Bundled alias missing');
    }
    $element = new KNK_Social_Media_Element();
    $element->set_controls();
    $check($element->controls['svgIcons']['default'] === false, 'Opt-in must stay disabled by default');
    $check(strpos($element->controls['iconColor']['css'][0]['selector'], '.knk-social-icon--svg') !== false, 'Color control covers SVG');
} finally {
    remove_filter('pre_option_knk-social-media', $filter);
}
$check(hash('sha256', serialize(get_option('knk-social-media'))) === $original, 'Options must remain unchanged');
echo "PASS: defaults, opt-in, aliases, fallback, modifiers, URI, controls, trusted files and unchanged options\n";
