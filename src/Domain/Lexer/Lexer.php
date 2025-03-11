<?php

namespace App\Domain\Lexer;

class Lexer {
    private $code;
    private $tokens = [];

    public function __construct(string $code) {
        $this->code = $code;
    }

    public function tokenize(): array {
        $tokenSpec = [
            'STRING' => '"[^"]*"',
            'NUMBER' => '\b(0|[1-9]\d*)\b',
            'IDENTIFIER' => '[a-zA-Z_][a-zA-Z0-9_.]*',
            'SKIP' => '[ \t\r\n]+',
            'COMMA' => ',',
            'LPAREN' => '\(',
            'RPAREN' => '\)',
        ];

        $regex = '';
        foreach ($tokenSpec as $type => $pattern) {
            $regex .= "(?P<$type>$pattern)|";
        }
        $regex = rtrim($regex, '|');

        if (preg_match_all("/$regex/", $this->code, $matches, PREG_SET_ORDER) === false) {
            throw new \Exception("Ошибка при разборе кода.");
        }

        foreach ($matches as $match) {
            foreach ($tokenSpec as $type => $pattern) {
                if (isset($match[$type]) && $match[$type] !== '') {
                    if ($type !== 'SKIP') {
                        $this->tokens[] = ['type' => $type, 'value' => $match[$type]];
                    }
                    break;
                }
            }
        }

        return $this->tokens;
    }
}
