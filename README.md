# Auto Config

Type: composer package

## Usage (example)

```
$configuration = [
    '{KEY}' => '{value}',
    ...
];

// Initialize Resource Registrar
$resourceRegistrar = new ResourceRegistrar($configuration);

// Add directories to scan the files
$resourceRegistrar->addDirectory(WP_CONTENT_DIR . '/mu-plugins');
$resourceRegistrar->addDirectory(WP_CONTENT_DIR . '/plugins');
$resourceRegistrar->addDirectory(WP_CONTENT_DIR . '/themes');

// Register a new resource
$resourceRegistrar->register( new Resource('sitepress-multilingual-cms', 'plugin', ['OTGS_INSTALLER_SITE_KEY_WPML']) );

// Load and define the constants
$resourceRegistrar->load();
```
