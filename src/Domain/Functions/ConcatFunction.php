<?php

namespace App\Domain\Functions;

class ConcatFunction implements FunctionInterface {
    public function execute(array $params, array $context): string {
        if (count($params) !== 2) {
            throw new \Exception("Функция ConcatFunction требует ровно 2 параметра: две строки для конкатенации.");
        }

        $string1 = $params[0];
        $string2 = $params[1];
        
        if (!is_string($string1)) {
            $string1 = (string) $string1;
        }
        if (!is_string($string2)) {
            $string2 = (string) $string2;
        }

        return $string1 . $string2;
    }
}
