<?php

namespace OODSLToFLogic\Parser;

use OODSLToFLogic\AST\AssignmentNode;
use OODSLToFLogic\AST\BinaryExpressionNode;
use OODSLToFLogic\AST\BlockNode;
use OODSLToFLogic\AST\ClassNode;
use OODSLToFLogic\AST\ConstraintNode;
use OODSLToFLogic\AST\ExpressionNode;
use OODSLToFLogic\AST\IdentifierNode;
use OODSLToFLogic\AST\LiteralNode;
use OODSLToFLogic\AST\MethodCallNode;
use OODSLToFLogic\AST\MethodNode;
use OODSLToFLogic\AST\Node;
use OODSLToFLogic\AST\ObjectNode;
use OODSLToFLogic\AST\ParameterNode;
use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\AST\PropertyAccessNode;
use OODSLToFLogic\AST\PropertyNode;
use OODSLToFLogic\AST\RuleNode;
use OODSLToFLogic\AST\SetLiteralNode;
use OODSLToFLogic\AST\TypeNode;
use OODSLToFLogic\Utils\SourceLocation;
use OODSLToFLogic\Utils\ErrorHandler;

/**
 * Simple manual parser for OO-DSL (alternative to PEG)
 * This is a working implementation while you set up php-peg
 */
class SimpleParser
{
    private ErrorHandler $errorHandler;
    private array $tokens = [];
    private int $position = 0;
    private ?string $currentFilename = null;
    private int $currentLine = 1;
    private int $currentColumn = 1;

    public function __construct()
    {
        $this->errorHandler = new ErrorHandler();
    }

    /**
     * Parse source code and return AST
     */
    public function parse(string $source, ?string $filename = null): ?ProgramNode
    {
        $this->currentFilename = $filename;
        $this->errorHandler->clear();
        $this->position = 0;
        $this->currentLine = 1;
        $this->currentColumn = 1;

        try {
            $this->tokens = $this->tokenize($source);
            return $this->parseProgram();
        } catch (\Exception $e) {
            $this->errorHandler->addError(
                'Parse error: ' . $e->getMessage(),
                $this->getCurrentLocation()
            );
            return null;
        }
    }

    /**
     * Parse from file
     */
    public function parseFile(string $filename): ?ProgramNode
    {
        if (!file_exists($filename)) {
            $this->errorHandler->addError(
                "File not found: {$filename}",
                new SourceLocation(1, 1, $filename)
            );
            return null;
        }

        $source = file_get_contents($filename);
        return $this->parse($source, $filename);
    }

    private function tokenize(string $source): array
    {
        $tokens = [];
        $patterns = [
            'WHITESPACE' => '/^\s+/',
            'COMMENT' => '/^\/\/[^\n]*|\/\*.*?\*\//s',
            'CLASS' => '/^class\b/',
            'OBJECT' => '/^object\b/',
            'METHOD' => '/^method\b/',
            'RULE' => '/^rule\b/',
            'INHERITS' => '/^inherits\b/',
            'STRUCTURE' => '/^structure\b/',
            'FROM' => '/^from\b/',
            'RETURNS' => '/^returns\b/',
            'IF' => '/^if\b/',
            'STRING_TYPE' => '/^string\b/',
            'INTEGER_TYPE' => '/^integer\b/',
            'BOOLEAN_TYPE' => '/^boolean\b/',
            'FLOAT_TYPE' => '/^float\b/',
            'SET_TYPE' => '/^set\b/',
            'LIST_TYPE' => '/^list\b/',
            'TRUE' => '/^true\b/',
            'FALSE' => '/^false\b/',
            'IDENTIFIER' => '/^[a-zA-Z_][a-zA-Z0-9_]*/',
            'FLOAT' => '/^\d+\.\d+/',
            'INTEGER' => '/^\d+/',
            'STRING' => '/^"([^"\\\\]|\\\\.)*"/',
            'ASSIGN_ADD' => '/^\+=/',
            'ASSIGN_SUB' => '/^-=/',
            'EQ' => '/^==/',
            'NE' => '/^!=/',
            'LE' => '/^<=/',
            'GE' => '/^>=/',
            'ASSIGN' => '/^=/',
            'LT' => '/^</',
            'GT' => '/^>/',
            'AND' => '/^&&/',
            'OR' => '/^\|\|/',
            'DOT_DOT' => '/^\.\./',
            'DOT' => '/^\./',
            'SEMICOLON' => '/^;/',
            'COLON' => '/^:/',
            'COMMA' => '/^,/',
            'LPAREN' => '/^\(/',
            'RPAREN' => '/^\)/',
            'LBRACE' => '/^\{/',
            'RBRACE' => '/^\}/',
            'LBRACKET' => '/^\[/',
            'RBRACKET' => '/^\]/',
            'PLUS' => '/^\+/',
            'MINUS' => '/^-/',
            'MULTIPLY' => '/^\*/',
            'DIVIDE' => '/^\//',
        ];

        $offset = 0;
        $line = 1;
        $column = 1;

        while ($offset < strlen($source)) {
            $matched = false;

            foreach ($patterns as $type => $pattern) {
                if (preg_match($pattern, substr($source, $offset), $matches)) {
                    $value = $matches[0];

                    if ($type !== 'WHITESPACE' && $type !== 'COMMENT') {
                        $tokens[] = [
                            'type' => $type,
                            'value' => $value,
                            'line' => $line,
                            'column' => $column
                        ];
                    }

                    $offset += strlen($value);

                    // Update line and column
                    for ($i = 0; $i < strlen($value); $i++) {
                        if ($value[$i] === "\n") {
                            $line++;
                            $column = 1;
                        } else {
                            $column++;
                        }
                    }

                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                throw new \Exception("Unexpected character at line {$line}, column {$column}: " . substr($source, $offset, 10));
            }
        }

        return $tokens;
    }

    private function parseProgram(): ProgramNode
    {
        $statements = [];

        while (!$this->isAtEnd()) {
            $statement = $this->parseStatement();
            if ($statement) {
                $statements[] = $statement;
            }
        }

        return new ProgramNode($statements, $this->getCurrentLocation());
    }

    private function parseStatement(): ?Node
    {
        if ($this->match('CLASS')) {
            return $this->parseClass();
        } elseif ($this->match('OBJECT')) {
            return $this->parseObject();
        } elseif ($this->match('METHOD')) {
            return $this->parseMethod();
        } elseif ($this->match('RULE')) {
            return $this->parseRule();
        }

        throw new \Exception("Expected statement at " . $this->getCurrentToken()['value'] ?? 'EOF');
    }

    private function parseClass(): ClassNode
    {
        $name = $this->consume('IDENTIFIER', 'Expected class name')['value'];

        $parentClass = null;
        $structuralOnly = false;

        if ($this->match('INHERITS')) {
            if ($this->match('STRUCTURE')) {
                $structuralOnly = true;
            }
            $this->consume('FROM', 'Expected "from"');
            $parentClass = $this->consume('IDENTIFIER', 'Expected parent class name')['value'];
        }

        $this->consume('LBRACE', 'Expected "{"');

        $properties = [];
        $methods = [];

        while (!$this->check('RBRACE') && !$this->isAtEnd()) {
            if ($this->isType()) {
                $type = $this->parseType();
                $memberName = $this->consume('IDENTIFIER', 'Expected property or method name')['value'];

                if ($this->match('LPAREN')) {
                    // Method definition inside class
                    $parameters = $this->parseParameterList();
                    $this->consume('RPAREN', 'Expected ")"');

                    $returnType = null;
                    if ($this->match('RETURNS')) {
                        $returnType = $this->parseType();
                    } else {
                        // If no explicit return type, use the type before the method name
                        $returnType = $type;
                    }

                    if ($this->check('LBRACE')) {
                        // Method with body (implementation)
                        $body = $this->parseBlock();
                        $methods[] = new MethodNode(
                            $name . '.' . $memberName, // Qualified name
                            $parameters,
                            $returnType,
                            $body,
                            false, // Not signature only
                            $this->getCurrentLocation()
                        );
                    } else {
                        // Method signature only
                        $this->consume('SEMICOLON', 'Expected ";" or "{"');
                        $methods[] = new MethodNode(
                            $memberName,
                            $parameters,
                            $returnType,
                            null,
                            true, // Signature only
                            $this->getCurrentLocation()
                        );
                    }
                } else {
                    // Property definition

                    // Parse constraint AFTER property name
                    $constraint = null;
                    if ($this->match('LBRACE')) {
                        $constraint = $this->parseConstraint();
                        $this->consume('RBRACE', 'Expected "}"');
                    }

                    $this->consume('SEMICOLON', 'Expected ";"');
                    $properties[] = new PropertyNode(
                        $memberName,
                        $type,
                        $constraint,
                        $this->getCurrentLocation()
                    );
                }
            } else {
                throw new \Exception("Expected property or method declaration");
            }
        }

        $this->consume('RBRACE', 'Expected "}"');

        return new ClassNode(
            $name,
            $parentClass,
            $structuralOnly,
            $properties,
            $methods,
            $this->getCurrentLocation()
        );
    }

    private function parseObject(): ObjectNode
    {
        $name = $this->consume('IDENTIFIER', 'Expected object name')['value'];
        $this->consume('COLON', 'Expected ":"');
        $className = $this->consume('IDENTIFIER', 'Expected class name')['value'];

        $this->consume('LBRACE', 'Expected "{"');

        $assignments = [];

        while (!$this->check('RBRACE') && !$this->isAtEnd()) {
            $propertyName = $this->consume('IDENTIFIER', 'Expected property name')['value'];

            $operator = '=';
            if ($this->match('ASSIGN_ADD')) {
                $operator = '+=';
            } elseif ($this->match('ASSIGN_SUB')) {
                $operator = '-=';
            } else {
                $this->consume('ASSIGN', 'Expected assignment operator');
            }

            try {
                $value = $this->parseExpression();
            } catch (\Exception $e) {
                throw new \Exception("Error parsing value for property '{$propertyName}': " . $e->getMessage());
            }

            $this->consume('SEMICOLON', 'Expected ";"');

            $assignments[] = new AssignmentNode(
                $propertyName,
                $operator,
                $value,
                $this->getCurrentLocation()
            );
        }

        $this->consume('RBRACE', 'Expected "}"');

        return new ObjectNode($name, $className, $assignments, $this->getCurrentLocation());
    }

    private function parseMethod(): MethodNode
    {
        $className = $this->consume('IDENTIFIER', 'Expected class name')['value'];
        $this->consume('DOT', 'Expected "."');
        $methodName = $this->consume('IDENTIFIER', 'Expected method name')['value'];

        $this->consume('LPAREN', 'Expected "("');
        $parameters = $this->parseParameterList();
        $this->consume('RPAREN', 'Expected ")"');

        $returnType = null;
        if ($this->match('RETURNS')) {
            $returnType = $this->parseType();
        }

        $body = $this->parseBlock();

        return new MethodNode(
            $className . '.' . $methodName,
            $parameters,
            $returnType,
            $body,
            false,
            $this->getCurrentLocation()
        );
    }

    private function parseRule(): RuleNode
    {
        $name = $this->consume('IDENTIFIER', 'Expected rule name')['value'];
        $this->consume('LBRACE', 'Expected "{"');
        $this->consume('IF', 'Expected "if"');
        $this->consume('LPAREN', 'Expected "("');

        $condition = $this->parseExpression();

        $this->consume('RPAREN', 'Expected ")"');
        $this->consume('LBRACE', 'Expected "{"');

        // Parse the conclusion - should be like "Person.isAdult = true;"
        $target = $this->parseExpression(); // This will parse "Person.isAdult"
        $this->consume('ASSIGN', 'Expected "="');
        $value = $this->parseExpression(); // This will parse "true"
        $this->consume('SEMICOLON', 'Expected ";"');

        // Create the conclusion as an assignment
        $conclusion = new AssignmentNode(
            'rule_conclusion',
            '=',
            new BinaryExpressionNode($target, '=', $value, $this->getCurrentLocation()),
            $this->getCurrentLocation()
        );

        $this->consume('RBRACE', 'Expected "}"');
        $this->consume('RBRACE', 'Expected "}"');

        return new RuleNode($name, $condition, $conclusion, $this->getCurrentLocation());
    }

    private function parseType(): TypeNode
    {
        if ($this->match('SET_TYPE')) {
            $this->consume('LT', 'Expected "<"');
            $elementType = $this->parseType();
            $this->consume('GT', 'Expected ">"');

            return new TypeNode('set', $elementType, null, $this->getCurrentLocation());
        } elseif ($this->match('LIST_TYPE')) {
            $this->consume('LT', 'Expected "<"');
            $elementType = $this->parseType();
            $this->consume('GT', 'Expected ">"');

            return new TypeNode('list', $elementType, null, $this->getCurrentLocation());
        } elseif ($this->match('STRING_TYPE')) {
            return new TypeNode('string', null, null, $this->getCurrentLocation());
        } elseif ($this->match('INTEGER_TYPE')) {
            return new TypeNode('integer', null, null, $this->getCurrentLocation());
        } elseif ($this->match('BOOLEAN_TYPE')) {
            return new TypeNode('boolean', null, null, $this->getCurrentLocation());
        } elseif ($this->match('FLOAT_TYPE')) {
            return new TypeNode('float', null, null, $this->getCurrentLocation());
        } elseif ($this->check('IDENTIFIER')) {
            $typeName = $this->advance()['value'];
            return new TypeNode($typeName, null, null, $this->getCurrentLocation());
        }

        throw new \Exception("Expected type");
    }

    private function parseConstraint(): ConstraintNode
    {
        if ($this->check('INTEGER')) {
            $min = intval($this->advance()['value']);

            if ($this->match('DOT_DOT')) {
                if ($this->match('MULTIPLY')) {
                    $max = null; // Unbounded
                } else {
                    $max = intval($this->consume('INTEGER', 'Expected integer or "*"')['value']);
                }
            } else {
                $max = $min; // Single value constraint
            }

            return new ConstraintNode($min, $max, $this->getCurrentLocation());
        }

        throw new \Exception("Expected constraint");
    }

    private function parseParameterList(): array
    {
        $parameters = [];

        if (!$this->check('RPAREN')) {
            do {
                $type = $this->parseType();
                $name = $this->consume('IDENTIFIER', 'Expected parameter name')['value'];
                $parameters[] = new ParameterNode($name, $type, $this->getCurrentLocation());
            } while ($this->match('COMMA'));
        }

        return $parameters;
    }

    private function parseBlock(): BlockNode
    {
        $this->consume('LBRACE', 'Expected "{"');

        $statements = [];

        while (!$this->check('RBRACE') && !$this->isAtEnd()) {
            // For now, just parse simple return statements
            if ($this->match('IDENTIFIER')) {
                $token = $this->previous();
                if ($token['value'] === 'return') {
                    $expr = $this->parseExpression();
                    $this->consume('SEMICOLON', 'Expected ";"');

                    // Create a simple assignment representing the return
                    $statements[] = new AssignmentNode(
                        'return',
                        '=',
                        $expr,
                        $this->getCurrentLocation()
                    );
                } else {
                    // Put the token back and parse as assignment
                    $this->position--;
                    $propertyName = $this->consume('IDENTIFIER', 'Expected identifier')['value'];

                    $operator = '=';
                    if ($this->match('ASSIGN_ADD')) {
                        $operator = '+=';
                    } elseif ($this->match('ASSIGN_SUB')) {
                        $operator = '-=';
                    } else {
                        $this->consume('ASSIGN', 'Expected assignment operator');
                    }

                    $value = $this->parseExpression();
                    $this->consume('SEMICOLON', 'Expected ";"');

                    $statements[] = new AssignmentNode(
                        $propertyName,
                        $operator,
                        $value,
                        $this->getCurrentLocation()
                    );
                }
            } else {
                throw new \Exception("Expected statement in block");
            }
        }

        $this->consume('RBRACE', 'Expected "}"');

        return new BlockNode($statements, $this->getCurrentLocation());
    }

    private function parseExpression(): ExpressionNode
    {
        return $this->parseLogicalOr();
    }

    private function parseLogicalOr(): ExpressionNode
    {
        $expr = $this->parseLogicalAnd();

        while ($this->match('OR')) {
            $operator = $this->previous()['value'];
            $right = $this->parseLogicalAnd();
            $expr = new BinaryExpressionNode($expr, $operator, $right, $this->getCurrentLocation());
        }

        return $expr;
    }

    private function parseLogicalAnd(): ExpressionNode
    {
        $expr = $this->parseEquality();

        while ($this->match('AND')) {
            $operator = $this->previous()['value'];
            $right = $this->parseEquality();
            $expr = new BinaryExpressionNode($expr, $operator, $right, $this->getCurrentLocation());
        }

        return $expr;
    }

    private function parseEquality(): ExpressionNode
    {
        $expr = $this->parseComparison();

        while ($this->match('EQ', 'NE')) {
            $operator = $this->previous()['value'];
            $right = $this->parseComparison();
            $expr = new BinaryExpressionNode($expr, $operator, $right, $this->getCurrentLocation());
        }

        return $expr;
    }

    private function parseComparison(): ExpressionNode
    {
        $expr = $this->parseAddition();

        while ($this->match('GT', 'GE', 'LT', 'LE')) {
            $operator = $this->previous()['value'];
            $right = $this->parseAddition();
            $expr = new BinaryExpressionNode($expr, $operator, $right, $this->getCurrentLocation());
        }

        return $expr;
    }

    private function parseAddition(): ExpressionNode
    {
        $expr = $this->parseMultiplication();

        while ($this->match('PLUS', 'MINUS')) {
            $operator = $this->previous()['value'];
            $right = $this->parseMultiplication();
            $expr = new BinaryExpressionNode($expr, $operator, $right, $this->getCurrentLocation());
        }

        return $expr;
    }

    private function parseMultiplication(): ExpressionNode
    {
        $expr = $this->parsePrimary();

        while ($this->match('MULTIPLY', 'DIVIDE')) {
            $operator = $this->previous()['value'];
            $right = $this->parsePrimary();
            $expr = new BinaryExpressionNode($expr, $operator, $right, $this->getCurrentLocation());
        }

        return $expr;
    }

    private function parsePrimary(): ExpressionNode
    {
        if ($this->match('TRUE')) {
            return new LiteralNode(true, 'boolean', $this->getCurrentLocation());
        }

        if ($this->match('FALSE')) {
            return new LiteralNode(false, 'boolean', $this->getCurrentLocation());
        }

        if ($this->match('INTEGER')) {
            $value = intval($this->previous()['value']);
            return new LiteralNode($value, 'integer', $this->getCurrentLocation());
        }

        if ($this->match('FLOAT')) {
            $value = floatval($this->previous()['value']);
            return new LiteralNode($value, 'float', $this->getCurrentLocation());
        }

        if ($this->match('STRING')) {
            $value = $this->previous()['value'];
            // Remove quotes and handle escape sequences
            $value = substr($value, 1, -1);
            $value = str_replace('\\"', '"', $value);
            $value = str_replace('\\\\', '\\', $value);
            return new LiteralNode($value, 'string', $this->getCurrentLocation());
        }

        if ($this->match('LBRACE')) {
            // Set literal - simple case
            $elements = [];

            if (!$this->check('RBRACE')) {
                do {
                    $elements[] = $this->parseExpression();
                } while ($this->match('COMMA'));
            }

            $this->consume('RBRACE', 'Expected "}"');
            return new SetLiteralNode($elements, $this->getCurrentLocation());
        }

        if ($this->match('LPAREN')) {
            $expr = $this->parseExpression();
            $this->consume('RPAREN', 'Expected ")"');
            return $expr;
        }

        if ($this->check('IDENTIFIER')) {
            $name = $this->advance()['value'];

            // Check for method call or property access
            if ($this->match('DOT')) {
                $memberName = $this->consume('IDENTIFIER', 'Expected member name')['value'];

                if ($this->match('LPAREN')) {
                    // Method call
                    $args = [];

                    if (!$this->check('RPAREN')) {
                        do {
                            $args[] = $this->parseExpression();
                        } while ($this->match('COMMA'));
                    }

                    $this->consume('RPAREN', 'Expected ")"');

                    $objectNode = new IdentifierNode($name, $this->getCurrentLocation());
                    $methodCall = new MethodCallNode($objectNode, $memberName, $args, $this->getCurrentLocation());

                    // Handle chained calls after method call
                    while ($this->match('DOT')) {
                        $nextMember = $this->consume('IDENTIFIER', 'Expected member name')['value'];
                        if ($this->match('LPAREN')) {
                            // Chained method call
                            $nextArgs = [];
                            if (!$this->check('RPAREN')) {
                                do {
                                    $nextArgs[] = $this->parseExpression();
                                } while ($this->match('COMMA'));
                            }
                            $this->consume('RPAREN', 'Expected ")"');
                            $methodCall = new MethodCallNode($methodCall, $nextMember, $nextArgs, $this->getCurrentLocation());
                        } else {
                            // Chained property access
                            $methodCall = new PropertyAccessNode($methodCall, $nextMember, $this->getCurrentLocation());
                        }
                    }

                    return $methodCall;
                } else {
                    // Property access - check for chained access
                    $objectNode = new IdentifierNode($name, $this->getCurrentLocation());
                    $result = new PropertyAccessNode($objectNode, $memberName, $this->getCurrentLocation());

                    // Handle chained property access like Person.spouse.name
                    while ($this->match('DOT')) {
                        $nextMember = $this->consume('IDENTIFIER', 'Expected member name')['value'];
                        if ($this->match('LPAREN')) {
                            // Method call in chain
                            $args = [];
                            if (!$this->check('RPAREN')) {
                                do {
                                    $args[] = $this->parseExpression();
                                } while ($this->match('COMMA'));
                            }
                            $this->consume('RPAREN', 'Expected ")"');
                            $result = new MethodCallNode($result, $nextMember, $args, $this->getCurrentLocation());
                        } else {
                            // Property access in chain
                            $result = new PropertyAccessNode($result, $nextMember, $this->getCurrentLocation());
                        }
                    }

                    return $result;
                }
            } else {
                // Simple identifier
                return new IdentifierNode($name, $this->getCurrentLocation());
            }
        }

        throw new \Exception("Expected expression");
    }

    // Helper methods
    private function match(...$types): bool
    {
        foreach ($types as $type) {
            if ($this->check($type)) {
                $this->advance();
                return true;
            }
        }
        return false;
    }

    private function check(string $type): bool
    {
        if ($this->isAtEnd()) return false;
        return $this->getCurrentToken()['type'] === $type;
    }

    private function advance(): array
    {
        if (!$this->isAtEnd()) $this->position++;
        return $this->previous();
    }

    private function isAtEnd(): bool
    {
        return $this->position >= count($this->tokens);
    }

    private function previous(): array
    {
        return $this->tokens[$this->position - 1];
    }

    private function getCurrentToken(): ?array
    {
        if ($this->isAtEnd()) return null;
        return $this->tokens[$this->position];
    }

    private function consume(string $type, string $message): array
    {
        if ($this->check($type)) {
            return $this->advance();
        }

        $current = $this->getCurrentToken();
        if ($current) {
            $location = "at line {$current['line']}, column {$current['column']}";
            $found = "found '{$current['value']}' ({$current['type']})";
            throw new \Exception("{$message} {$location}, {$found}");
        } else {
            throw new \Exception("{$message} at end of file");
        }
    }

    private function getCurrentLocation(): SourceLocation
    {
        $token = $this->getCurrentToken();
        if ($token) {
            return new SourceLocation($token['line'], $token['column'], $this->currentFilename);
        }
        return new SourceLocation($this->currentLine, $this->currentColumn, $this->currentFilename);
    }

    private function isType(): bool
    {
        return $this->check('STRING_TYPE') ||
            $this->check('INTEGER_TYPE') ||
            $this->check('BOOLEAN_TYPE') ||
            $this->check('FLOAT_TYPE') ||
            $this->check('SET_TYPE') ||
            $this->check('LIST_TYPE') ||
            $this->check('IDENTIFIER');
    }

    public function getErrorHandler(): ErrorHandler
    {
        return $this->errorHandler;
    }

    public function hasErrors(): bool
    {
        return $this->errorHandler->hasErrors();
    }
}