<?php

namespace App\Domain\Functions;

class FunctionRegistry {
    private $functions = [];

    public function register(string $name, FunctionInterface $function): void {
        $this->functions[$name] = $function;
    }

    public function has(string $name): bool {
        return isset($this->functions[$name]);
    }

    public function get(string $name): FunctionInterface {
        return $this->functions[$name];
    }
}
