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
