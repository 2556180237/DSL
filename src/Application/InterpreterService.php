<?php

namespace App\Application;

use App\Domain\Lexer\Lexer;
use App\Domain\Parser\Parser;
use App\Domain\Interpreter\Interpreter;
use App\Domain\Functions\FunctionRegistry;
use App\Domain\Functions\GetArgFunction;
use App\Domain\Functions\ArrayMakeFunction;
use App\Domain\Functions\MapMakeFunction;
use App\Domain\Functions\JsonEncodeFunction;
use App\Domain\Functions\ConcatFunction;

class InterpreterService {
    private $interpreter;

    public function __construct() {
        $functionRegistry = new FunctionRegistry();
        $functionRegistry->register('bk.action.core.GetArg', new GetArgFunction());
        $functionRegistry->register('bk.action.array.Make', new ArrayMakeFunction());
        $functionRegistry->register('bk.action.map.Make', new MapMakeFunction());
        $functionRegistry->register('bk.action.string.JsonEncode', new JsonEncodeFunction());
        $functionRegistry->register('bk.action.string.Concat', new ConcatFunction());

        $this->interpreter = new Interpreter($functionRegistry);
    }

    public function execute(string $code, array $args = []) {
    	    // Лексический анализ
	    $lexer = new Lexer($code);
	    $tokens = $lexer->tokenize();
	    // Синтаксический анализ
	    $parser = new Parser($tokens);
	    $ast = $parser->parse();
	    // Интерпретация
	    return $this->interpreter->interpret($ast, $args);
	}
}
