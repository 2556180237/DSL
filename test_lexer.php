<?php

require 'vendor/autoload.php';

use App\Domain\Lexer\Lexer;
use App\Domain\Parser\Parser;

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

echo "Токены:\n";
print_r($tokens);

$parser = new Parser($tokens);
$ast = $parser->parse();

echo "(AST):\n";
print_r($ast);
