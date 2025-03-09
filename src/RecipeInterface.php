<?php
namespace FilipVanReeth\AutoConfig;

interface RecipeInterface
{
    public function getName(): string;
    public function getDirectories(): array;
    public function getEnvFile(): string;
}
