<?php

namespace App\Domain\Functions;

class GetArgFunction implements FunctionInterface {
    public function execute(array $params, array $context): mixed {
        if (count($params) !== 1) {
            throw new \Exception("Функция GetArgFunction требует ровно 1 параметр: индекс аргумента.");
        }

        $index = $params[0];

        if (!is_int($index)) {
            throw new \Exception("Функция GetArgFunction ожидает, что параметр будет целым числом.");
        }

        if (!isset($context['args'][$index])) {
            throw new \Exception("Аргумент с индексом $index не найден.");
        }

        return $context['args'][$index];
    }
}
