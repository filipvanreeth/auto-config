<?php
namespace FilipVanReeth\AutoConfig;

class Configuration
{
    private array $configuration = [];

    public function get(string $key, $default = null)
    {
        return $this->configuration[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($this->configuration[$key]);
    }

    public function add(string $key, $value): void
    {
        $this->configuration[$key] = $value;
    }

    public function applyEnvFileSettings(string $envFile): void
    {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $this->processEnvLine($line);
        }
    }

    private function processEnvLine(string $line): void
    {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            return;
        }

        [$key, $value] = array_map('trim', explode('=', $line, 2));
        
        $value = trim($value, " \t\n\r\0\x0B\"'");
        
        if (empty($value)) {
            return;
        }
        
        $this->configuration[$key] = $value;
    }
    
    public function getConfig(): array
    {
        return $this->configuration;
    }
}