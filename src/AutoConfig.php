<?php
namespace FilipVanReeth\AutoConfig;

class AutoConfig
{
    private static Configuration $configuration;
    private static ResourceRegistrar $resourceRegistrar;

    public static function init(Configuration $configuration): void
    {
        self::$configuration = $configuration;
        self::$resourceRegistrar = new ResourceRegistrar(self::$configuration);
    }
    
    public static function addDirectory(string $directory): void
    {
        self::getResourceRegistrar()->addDirectory($directory);
    }
    
    private static function getResourceRegistrar(): ResourceRegistrar
    {
        return self::$resourceRegistrar;
    }
    
    public static function addResource(string $name, string $type, array $constants): void
    {
        self::getResourceRegistrar()->register(new Resource($name, $type, $constants));
    }
    
    public static function getConstantsFromResources(): array
    {
        return self::getResourceRegistrar()->getAllConstantsFromResources();
    }
    
    public static function getResources()
    {
        return self::getResourceRegistrar()->getResources();
    }
    
    public static function getConstantsConfiguration(): array
    {
        return self::getResourceRegistrar()->getConstantsConfiguration();
    }
}