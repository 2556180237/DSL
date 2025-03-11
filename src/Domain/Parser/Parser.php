<?php

namespace App\Domain\Parser;

class Parser {
    private $tokens;
    private $pos = 0;

    public function __construct(array $tokens) {
        $this->tokens = $tokens;
    }

    public function parse(): array {
        if (empty($this->tokens)) {
            throw new \Exception("Нет токенов для разбора.");
        }
        return $this->parseExpression();
    }

    private function parseExpression(): array {
        $token = $this->currentToken();

        if ($token['type'] === 'LPAREN') {
            return $this->parseFunctionCall();
        } elseif (in_array($token['type'], ['STRING', 'NUMBER', 'IDENTIFIER'])) {
            return $this->parseConstant();
        } else {
            throw new \Exception("Неожиданный токен: {$token['type']}");
        }
    }

    private function parseFunctionCall(): array {
        $this->consume('LPAREN');
        $funcName = $this->consume('IDENTIFIER')['value'];

        $params = [];
        while ($this->currentToken()['type'] !== 'RPAREN') {
            if ($this->currentToken()['type'] === 'COMMA') {
                $this->consume('COMMA');
                
                if ($this->currentToken()['type'] === 'NUMBER') {
            		$params[] = $this->parseExpression();
            		continue;
        	}

                $nextToken = $this->currentToken();
                if ($nextToken['type'] === 'RPAREN') {
                    break;
                }
            }

            $params[] = $this->parseExpression();
        }

        $this->consume('RPAREN');
        return ['type' => 'function_call', 'func_name' => $funcName, 'params' => $params];
    }

    private function parseConstant(): array {
        $token = $this->currentToken();

        if (in_array($token['type'], ['STRING', 'NUMBER', 'IDENTIFIER'])) {
            $this->pos++;
            return ['type' => 'constant', 'value' => $token['value']];
        } else {
            throw new \Exception("Неожиданный токен: {$token['type']}");
        }
    }

    private function currentToken(): array {
        if ($this->pos >= count($this->tokens)) {
            throw new \Exception("Неожиданный конец входных данных.");
        }
        return $this->tokens[$this->pos];
    }

    private function peekToken(): array {
        if ($this->pos + 1 >= count($this->tokens)) {
            throw new \Exception("Неожиданный конец входных данных при попытке заглянуть вперед.");
        }
        return $this->tokens[$this->pos + 1];
    }

    private function consume(string $expectedType): array {
        $token = $this->currentToken();

        if ($token['type'] === $expectedType) {
            $this->pos++;
            return $token;
        } else {
            throw new \Exception("Ожидался токен типа $expectedType, получен {$token['type']}");
        }
    }
}
