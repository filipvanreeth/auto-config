<?php
namespace FilipVanReeth\AutoConfig;

use Google\Service\AndroidProvisioningPartner\Configuration;

class ResourceLoader
{
    private Resource $resource;
    private array $configuration;
    
    public function __construct(Resource $resource, array $configuration)
    {
        $this->resource = $resource;
        $this->configuration = $configuration;
    }
    
    public function load()
    {
        foreach ($this->resource->getConstants() as $constant) {
            if (isset($this->configuration[$constant])) {
                define($constant, $this->configuration[$constant]);
            }
        }
    }
    
    public function getConstantsConfiguration(): array
    {
        $resourceConstants = $this->resource->getConstants();
        
        $constantsConfiguration = [];
        
        foreach($resourceConstants as $constant) {
            $constantsConfiguration[$constant] = $this->configuration[$constant] ?? '';
        }
        
        return $constantsConfiguration;
    }
}