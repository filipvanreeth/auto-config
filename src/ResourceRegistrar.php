<?php
namespace FilipVanReeth\AutoConfig;

class ResourceRegistrar
{
    private Configuration $configuration;
    private array $resources = [];
    private array $directories = [];
    private array $constantsConfiguration = [];

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    private function getDefaultResources(): array
    {
        $defaultResources = [];
        $defaultResources[] = new Resource('advanced-custom-fields-pro', 'plugin', ['ACF_PRO_LICENSE']);
        $defaultResources[] = new Resource('gravityforms', 'plugin', ['GF_LICENSE_KEY']);

        return $defaultResources;
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    public function register(Resource $resource)
    {
        $this->resources[] = $resource;
    }

    public function autoRegisterResources()
    {
        $directories = $this->getDirectories();

        if (empty($directories)) {
            return;
        }

        foreach ($directories as $directory) {
            $files = $this->readDirectory($directory);
            $defaultResources = $this->getDefaultResources();

            foreach ($files as $file) {

                if (array_filter($this->resources, fn($resource) => $resource->getName() === $file)) {
                    continue;
                }

                foreach ($defaultResources as $defaultResource) {
                    if ($file === $defaultResource->getName()) {
                        $this->register($defaultResource);
                    }
                }
            }
        }
    }

    public function addDirectory($directory)
    {
        $this->directories[] = $directory;
        $this->autoRegisterResources();
    }

    public function getDirectories(): array
    {
        return $this->directories;
    }

    public function readDirectory($directory)
    {
        $files = scandir($directory);

        $files = array_filter($files, function ($file) use ($directory) {
            return is_dir($directory . DIRECTORY_SEPARATOR . $file) && !in_array($file, ['.', '..']);
        });

        return $files;
    }

    public function getAllConstants(): array
    {
        $constants = [];

        foreach ($this->resources as $resource) {
            $constants = array_merge($constants, $resource->getConstants());
        }

        return $constants;
    }

    public function getUndefinedConstants(): array
    {
        $constants = $this->getAllConstants();

        $undefinedConstants = [];

        foreach ($constants as $constant) {
            if (!defined($constant)) {
                $undefinedConstants[] = $constant;
            }
        }

        return $undefinedConstants;
    }

    private function setupConstantsConfiguration()
    {
        $configuration = $this->configuration;
        $resources = $this->getResources();

        $constantsConfiguration = [];

        foreach ($resources as $resource) {
            $constants = $resource->getConstants();

            foreach ($constants as $constant) {
                if (!array_key_exists($constant, $configuration->getConfig())) {
                    continue;
                }

                $constantsConfiguration[$constant] = $configuration->get($constant);
            }
        }

        $this->constantsConfiguration = $constantsConfiguration;
    }
    
    public function getConstantsConfiguration(): array
    {
        $this->setupConstantsConfiguration();
        
        return $this->constantsConfiguration;
    }
}