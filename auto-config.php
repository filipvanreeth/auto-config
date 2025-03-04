<?php
/*
 * Plugin Name:       Auto Config
 * Plugin URI:        https://example.com/my-plugin/
 * Description:       Auto Config.
 * Version:           0.1.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Filip Van Reeth
 * Author URI:        https://filipvanreeth.com
 * License:           GPL v2 or later
 * License URI:       
 * Update URI:        
 * Text Domain:       auto-config
 * Domain Path:       /languages
 */

class AutoConfig
{
    public function __construct()
    {
        var_dump('WP Auto Config class');
    }

    public function getAllPlugins(): array
    {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        $allPlugins = get_plugins();

        $plugins = [];

        foreach ($allPlugins as $path => $plugin) {
            $plugins[] = explode('/', $path)[0];
        }

        return $plugins;
    }

    public function defineConstant($name)
    {
        return $name;
    }

    public function registerPluginConstants(string $name, array $constants)
    {
        $array = [];
        $array['name'] = $name;

        foreach ($constants as $constant) {
            $array['constants'][] = $constant;
        }

        return $array;
    }

    public function loadConstants()
    {
        $plugins = $this->getAllPlugins();

        $registerPluginsConstants = [];

        $registerPluginsConstants[] = $this->registerPluginConstants('advanced-custom-fields-pro', [
            $this->defineConstant('ACF_PRO_LICENSE')
        ]);

        $registerPluginsConstants[] = $this->registerPluginConstants('sitepress-multilingual-cms', [
            $this->defineConstant('OTGS_INSTALLER_SITE_KEY_WPML')
        ]);

        $registerPluginsConstants[] = $this->registerPluginConstants('gravityforms', [
            $this->defineConstant('GF_LICENSE_KEY'),
        ]);

        // Key value list

        $env = [
            'ACF_PRO_LICENSE' => 'b3JkZXJfaWQ9NDM3OTV8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE0LTExLTA3IDA4OjU0OjIy',
            'OTGS_INSTALLER_SITE_KEY_WPML' => '',
            'GF_LICENSE_KEY' => 'f11a417d1de598ab58db510168a83d8b',
        ];

        // var_dump($env);

        $pluginsConstants = [];

        foreach ($plugins as $plugin) {

            foreach ($registerPluginsConstants as $registerPluginConstants) {

                if ($plugin === $registerPluginConstants['name']) {

                    $constants = [];

                    foreach ($registerPluginConstants['constants'] as $constant) {
                        $constants[$constant] = $env[$constant];
                    }

                    $pluginsConstants[$plugin] = $constants;
                }
            }
        }

        // var_dump($pluginsConstants);

        foreach ($pluginsConstants as $plugin => $constants) {
            foreach ($constants as $constant => $value) {
                echo '<p>' . $constant . ': ' . $value . '</p>';
                define($constant, $value);
            }
        }
    }
}

add_action('admin_notices', function () {
    echo '<div class="notice notice-success is-dismissible">';
    $wpAutoConfig = new AutoConfig();
    $wpAutoConfig->getAllPlugins();
    $wpAutoConfig->loadConstants();
    $definedConstants = get_defined_constants(true);
    // var_dump($definedConstants['user']);
    $acf = (new ResourceBuilder())
        ->setName('advanced-custom-fields-pro')
        ->setType('plugin')
        ->setConstant('ACF_PRO_LICENSE')
        ->build();
    var_dump($acf);
    echo '</div>';
});



class ResourceBuilder
{
    private string $name;
    private string $type;
    private array $constants = [];
    
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }
    
    public function setConstant(string $constant): self
    {
        $this->constants[] = $constant;
        return $this;
    }
    
    public function build(): Resource
    {
        $resource = new Resource($this->name, $this->type);
        
        foreach ($this->constants as $constant) {
            $resource->setConstant($constant);
        }
        
        return $resource;
    }
}