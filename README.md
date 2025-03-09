# Auto Config

Type: composer package

## Usage (example)

```
$configuration = new \FilipVanReeth\AutoConfig\Configuration();

foreach ($env_files as $env_file) {
    $configuration->applyEnvFileSettings($root_dir . '/' . $env_file);
}

$wpContentDirectory = $webroot_dir . Config::get('CONTENT_DIR');

\FilipVanReeth\AutoConfig\AutoConfig::init($configuration);

$bedrockRecipe = new \FilipVanReeth\AutoConfig\Recipe\Bedrock($wpContentDirectory);
\FilipVanReeth\AutoConfig\AutoConfig::recipe($bedrockRecipe);

\FilipVanReeth\AutoConfig\AutoConfig::addResource(
    'sitepress-multilingual-cms',
    'plugin',
    ['OTGS_INSTALLER_SITE_KEY_WPML']
);
\FilipVanReeth\AutoConfig\AutoConfig::addResource(
    'akismet',
    'plugin',
    ['AKISMET_KEY']
);

if ($autoConfigConstants = \FilipVanReeth\AutoConfig\AutoConfig::getConstantsConfiguration()) {
    foreach ($autoConfigConstants as $constant => $value) {
        Config::define($constant, $value);
    }
}
```
