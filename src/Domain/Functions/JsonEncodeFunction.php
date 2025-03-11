<?php

namespace App\Domain\Functions;

use App\Domain\Functions\FunctionInterface;

class JsonEncodeFunction implements FunctionInterface {
    public function execute(array $params, array $context): string {
        if (count($params) !== 1) {
            throw new \Exception("Функция JsonEncodeFunction требует ровно 1 параметр: данные для сериализации.");
        }

        $data = $params[0];

        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        if ($json === false) {
            throw new \Exception("Ошибка при сериализации данных в JSON: " . json_last_error_msg());
        }

        return $json;
    }
}
