# kanka.dev Bricks Elements

Custom Bricks Builder elements by [kanka.dev](https://kanka.dev) that can be easily updated across multiple projects.

## Description

This plugin contains custom elements for the Bricks Builder WordPress theme. Instead of embedding these elements directly in your child theme, this plugin allows you to:

1. Maintain elements in a single repository
2. Update all your websites automatically when you update the plugin
3. Keep your elements consistent across all your projects

## Installation

### Manual Installation

1. Download the plugin as a ZIP file from the GitHub repository
2. Upload the ZIP file via the WordPress admin plugins page
3. Activate the plugin

### Via GitHub

1. Install the [GitHub Updater](https://github.com/afragen/github-updater) plugin
2. Add this repository using the GitHub Updater interface
3. Install and activate the plugin

## Updating Elements

When you need to update an element:

1. Make changes to the element in the GitHub repository
2. Create a new release with an incremented version number
3. All websites using this plugin will be notified of the update in the WordPress admin

## Migrating Elements from Theme

If you're currently using these elements in your Bricks child theme, this plugin includes a migration tool:

1. Go to Tools > kanka.dev Bricks Elements in the WordPress admin
2. Click the "Migrate Elements" button
3. The plugin will copy all elements from your theme to the plugin
4. You can then deactivate the elements in your theme to avoid conflicts

## Development

### Adding New Elements

To add a new element:

1. Create a new directory in the `elements` folder with the name of your element
2. Create a PHP file with the same name as the directory
3. Implement your element following the Bricks element structure
4. Add any CSS, JS, or other assets needed by your element

### GitHub Integration

This plugin uses GitHub for updates. To set up your own repository:

1. Fork or create a new repository on GitHub
2. Update the GitHub information in the main plugin file:
   - GitHub Plugin URI: yourusername/knk-bricks-elements
   - GitHub Branch: main (or your preferred branch)
3. Push your changes to GitHub
4. Create releases to trigger updates

## License

GPL-2.0+

## Credits

Developed by [kanka.dev](https://kanka.dev)


## Unreleased: optional bundled social SVGs

The Social Media element offers **Use bundled SVG icons**, disabled by default.
Existing `knk-social-media` options, field names, saved icon classes, URLs and font
output remain unchanged unless this is explicitly enabled per element.

Bundled icons cover WhatsApp, Skype, LinkedIn, GitHub, XING and Telegram, including
legacy aliases such as `fa fa-xing-square`. Unsupported icons and extra modifiers
(e.g. `fa-spin` or custom classes) retain the original font markup. This fallback
still needs the site's existing Font Awesome stylesheet. No stylesheet is dequeued
or loaded globally by this feature. Audit other font-icon uses before removing
Font Awesome from a theme. Size/color controls also apply to SVG output.

Only fixed, plugin-shipped SVG files are resolved; saved values cannot select
arbitrary paths or inject SVG markup. Font Awesome 6.7.2 attribution/licence is in
`assets/social-icons/LICENSE.txt`. New styling uses native Bricks control mappings;
no CSS build is required. No database migration or option rewrite takes place.

Test locally with Bricks active:
`wp eval-file wp-content/plugins/knk-bricks-elements/tests/social-icons.php`.
This uses temporary option filters and verifies persisted options are unchanged.
Before release, also verify opt-in selection, size/color controls, save/reload and
frontend output in the Bricks editor for supported target versions.

The built-in updater reads GitHub's latest release and compares its tag version;
a local commit is not an update release. Keep the current version until a reviewed
release with a version bump is prepared. Do not distribute this unreleased work
without the editor checks and a representative customer-site regression test.
