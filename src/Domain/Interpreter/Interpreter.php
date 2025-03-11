<?php

namespace App\Domain\Interpreter;

use App\Domain\Functions\FunctionRegistry;

class Interpreter {
    private $functionRegistry;
    private $context = [];

    public function __construct(FunctionRegistry $functionRegistry) {
        $this->functionRegistry = $functionRegistry;
    }

    public function interpret(array $ast, array $args = []) {
        $this->context['args'] = $args;
        return $this->evaluate($ast);
    }

    private function evaluate(array $node) {
        switch ($node['type']) {
            case 'constant':
                return $this->evaluateConstant($node);
            case 'function_call':
                return $this->evaluateFunctionCall($node);
            default:
                throw new \Exception("Неизвестный тип узла: {$node['type']}");
        }
    }

    private function evaluateConstant(array $node) {
        $value = $node['value'];
        if ($value === 'true') {
            return true;
        } elseif ($value === 'false') {
            return false;
        } elseif ($value === 'null') {
            return null;
        } elseif (is_numeric($value)) {
            return strpos($value, '.') !== false ? (float)$value : (int)$value;
            // пофигу.
        } elseif (preg_match('/^".*"$/', $value)) {
            return substr($value, 1, -1);
        } else {
            throw new \Exception("Неизвестная константа: $value");
        }
    }

    private function evaluateFunctionCall(array $node) {
        $funcName = $node['func_name'];
        $params = array_map(fn($param) => $this->evaluate($param), $node['params']);

        if ($this->functionRegistry->has($funcName)) {
            return $this->functionRegistry->get($funcName)->execute($params, $this->context);
        } else {
            throw new \Exception("Неизвестная функция: $funcName");
        }
    }
}
