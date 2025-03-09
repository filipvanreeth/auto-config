<?php
namespace FilipVanReeth\AutoConfig\Recipe;

use FilipVanReeth\AutoConfig\RecipeInterface;

class Bedrock implements RecipeInterface
{
    private ?string $rootPath;
    private array $directories = [];
    private string $envFile = '.env';
    
    public function __construct(?string $rootPath)
    {
        $this->rootPath = $rootPath;
        $this->setDirectories();
    }
    
    public function setRootPath(string $rootPath)
    {
        $this->rootPath = $rootPath;
    }
    
    public function getRootPath(): string
    {
        return $this->rootPath;
    }
    
    public function getName(): string
    {
        return 'bedrock';
    }
    
    public function setDirectory(string $directory)
    {
        $this->directories[] = $directory;
    }
    
    private function setDirectories() {
        $directories = [
            'mu-plugins',
            'plugins',
            'themes',
        ];
        
        foreach ($directories as $directory) {
            $this->setDirectory($this->getRootPath() . '/' . $directory);
        }
    }

    public function getDirectories(): array
    {
        return $this->directories;
    }

    public function getEnvFile(): string
    {
        return '.env';
    }
}