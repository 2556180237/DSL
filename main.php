<?php

require 'vendor/autoload.php';

use App\Application\InterpreterService;

use App\Domain\Lexer\Lexer;
use App\Domain\Parser\Parser;

// Исходный код программы
$code = '
(bk.action.string.JsonEncode, 
    (bk.action.map.Make, 
        (bk.action.array.Make, "message"), 
        (bk.action.array.Make, 
            (bk.action.string.Concat, "Hello, ", (bk.action.core.GetArg, 0))
        )
    )
)
';

// Лексический анализ
$lexer = new Lexer($code);
$tokens = $lexer->tokenize();

// Вывод токенов
// echo "Токены:\n";
// print_r($tokens);

// Синтаксический анализ
$parser = new Parser($tokens);
$ast = $parser->parse();


// Аргументы программы
$args = ["world"];

// Создаем сервис интерпретатора
$interpreterService = new InterpreterService();

// Выполняем программу
try {
    $result = $interpreterService->execute($code, $args);
    // {"message":"Hello, world"}
    echo "Тип: " . gettype($result) . "\r\n";
    echo $result . "\r\n";
    $result = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo $result;
} catch (\Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
