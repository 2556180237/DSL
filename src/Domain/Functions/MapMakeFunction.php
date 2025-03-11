<?php

namespace App\Domain\Functions;

use App\Domain\Functions\FunctionInterface;

class MapMakeFunction implements FunctionInterface {
    public function execute(array $params, array $context): array {
        if (count($params) !== 2) {
            throw new \Exception("Функция MapMakeFunction требует ровно 2 параметра: ключи и значения.");
        }

        $keys = $params[0];
        $values = $params[1];

        if (!is_array($keys) || !is_array($values)) {
            throw new \Exception("Функция MapMakeFunction ожидает, что оба параметра будут массивами.");
        }

        if (count($keys) !== count($values)) {
            throw new \Exception("Функция MapMakeFunction ожидает, что массивы ключей и значений будут одинаковой длины.");
        }

        return array_combine($keys, $values);
    }
}
