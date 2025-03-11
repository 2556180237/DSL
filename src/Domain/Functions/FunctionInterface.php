<?php
namespace App\Domain\Functions;

interface FunctionInterface {
    public function execute(array $params, array $context);
}
