<?php
namespace FilipVanReeth\AutoConfig;

class Resource {
    private string $name;
    private string $type;
    private array $constants = [];
    
    public function __construct(string $name, string $type, array $constants = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->constants = $constants;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function setType(string $type)
    {
        $this->type = $type;
    }
    
    public function getConstants(): array
    {
        return $this->constants;
    }
    
    public function setConstant(string $constant)
    {
        if (!in_array($constant, $this->constants)) {
            $this->constants[] = $constant;
        }
    }
}