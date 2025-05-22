<?php
/**
 * GitHub Updater Class
 * 
 * Enables automatic updates from a GitHub repository
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class KNK_Bricks_Elements_GitHub_Updater {
    private $slug;
    private $plugin_data;
    private $username;
    private $repo;
    private $plugin_file;
    private $github_api_result;
    private $access_token;

    /**
     * Constructor
     * 
     * @param string $plugin_file
     * @param string $github_username
     * @param string $github_repo
     * @param string $access_token (optional)
     */
    public function __construct($plugin_file, $github_username, $github_repo, $access_token = '') {
        $this->plugin_file = $plugin_file;
        $this->username = $github_username;
        $this->repo = $github_repo;
        $this->access_token = $access_token;

        add_filter('pre_set_site_transient_update_plugins', array($this, 'check_update'));
        add_filter('plugins_api', array($this, 'plugin_popup'), 10, 3);
        add_filter('upgrader_post_install', array($this, 'after_install'), 10, 3);
        
        $this->plugin_data = get_plugin_data($this->plugin_file);
        $this->slug = plugin_basename($this->plugin_file);
    }

    /**
     * Get repository info from GitHub
     * 
     * @return array|false
     */
    private function get_repository_info() {
        if (!empty($this->github_api_result)) {
            return $this->github_api_result;
        }

        $url = "https://api.github.com/repos/{$this->username}/{$this->repo}/releases/latest";
        
        if (!empty($this->access_token)) {
            $url = add_query_arg(array('access_token' => $this->access_token), $url);
        }
        
        $response = wp_remote_get($url, array(
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'WordPress/' . get_bloginfo('version')
            )
        ));

        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
            return false;
        }

        $result = json_decode(wp_remote_retrieve_body($response));
        
        if (empty($result)) {
            return false;
        }
        
        $this->github_api_result = $result;
        return $result;
    }

    /**
     * Check for plugin updates
     * 
     * @param object $transient
     * @return object
     */
    public function check_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        $repository_info = $this->get_repository_info();
        if (false === $repository_info || !is_object($repository_info)) {
            return $transient;
        }

        $current_version = $this->plugin_data['Version'];
        $remote_version = isset($repository_info->tag_name) ? ltrim($repository_info->tag_name, 'v') : '';
        
        if (empty($remote_version)) {
            return $transient;
        }

        if (version_compare($current_version, $remote_version, '<')) {
            $download_url = isset($repository_info->zipball_url) ? $repository_info->zipball_url : '';
            
            if (empty($download_url)) {
                return $transient;
            }
            
            if (!empty($this->access_token)) {
                $download_url = add_query_arg(array('access_token' => $this->access_token), $download_url);
            }

            $transient->response[$this->slug] = (object) array(
                'slug' => $this->slug,
                'new_version' => $remote_version,
                'url' => $this->plugin_data['PluginURI'],
                'package' => $download_url,
            );
        }

        return $transient;
    }

    /**
     * Show plugin information in the plugins page
     * 
     * @param false|object|array $result
     * @param string $action
     * @param object $args
     * @return object
     */
    public function plugin_popup($result, $action, $args) {
        if ('plugin_information' !== $action || $args->slug !== $this->slug) {
            return $result;
        }

        $repository_info = $this->get_repository_info();
        if (false === $repository_info || !is_object($repository_info)) {
            return $result;
        }

        $plugin_data = $this->plugin_data;
        $remote_version = isset($repository_info->tag_name) ? ltrim($repository_info->tag_name, 'v') : '';
        
        if (empty($remote_version)) {
            return $result;
        }

        $plugin_info = (object) array(
            'name' => $plugin_data['Name'],
            'slug' => $this->slug,
            'version' => $remote_version,
            'author' => $plugin_data['Author'],
            'author_profile' => $plugin_data['AuthorURI'],
            'homepage' => $plugin_data['PluginURI'],
            'requires' => $plugin_data['RequiresWP'] ?? '',
            'requires_php' => $plugin_data['RequiresPHP'] ?? '',
            'downloaded' => 0,
            'last_updated' => isset($repository_info->published_at) ? $repository_info->published_at : '',
            'sections' => array(
                'description' => $plugin_data['Description'],
                'changelog' => isset($repository_info->body) ? nl2br($repository_info->body) : '',
            ),
            'download_link' => isset($repository_info->zipball_url) ? $repository_info->zipball_url : '',
        );

        return $plugin_info;
    }

    /**
     * After plugin update
     * 
     * @param bool $response
     * @param array $hook_extra
     * @param array $result
     * @return array
     */
    public function after_install($response, $hook_extra, $result) {
        global $wp_filesystem;

        if (!isset($hook_extra['plugin']) || $hook_extra['plugin'] !== $this->slug) {
            return $result;
        }

        // Ensure plugin directory name is correct after update
        $plugin_folder = WP_PLUGIN_DIR . '/' . dirname($this->slug);
        $wp_filesystem->move($result['destination'], $plugin_folder);
        $result['destination'] = $plugin_folder;

        // Re-activate plugin
        if (is_plugin_active($this->slug)) {
            activate_plugin($this->slug);
        }

        return $result;
    }
}
