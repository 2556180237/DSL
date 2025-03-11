<?php

namespace App\Domain\Functions;

use App\Domain\Functions\FunctionInterface;

class ArrayMakeFunction implements FunctionInterface {
    public function execute(array $params, array $context): array {
        return $params;
    }
}
