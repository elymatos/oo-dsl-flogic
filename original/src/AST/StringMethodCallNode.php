<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Represents string method calls like .length(), .toUpperCase(), etc.
 * Example: firstName.toUpperCase()
 */
class StringMethodCallNode extends ExpressionNode
{
    public ExpressionNode $stringExpression;
    public string $methodName;
    public array $arguments;

    public function __construct(ExpressionNode $stringExpression, string $methodName, array $arguments = [], ?SourceLocation $location = null)
    {
        parent::__construct($location);
        $this->stringExpression = $stringExpression;
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitStringMethodCall($this);
    }

    public function generateFLogic(): string
    {
        // Generate the base string expression
        $stringExpr = $this->stringExpression;

        switch ($this->methodName) {
            case 'length':
                return "str_length({$stringExpr})";
            case 'toUpperCase':
                return "str_to_upper({$stringExpr})";
            case 'toLowerCase':
                return "str_to_lower({$stringExpr})";
            case 'trim':
                return "str_trim({$stringExpr})";
            case 'substring':
                if (count($this->arguments) >= 2) {
                    $start = $this->arguments[0];
                    $length = $this->arguments[1];
                    return "str_substring({$stringExpr}, {$start}, {$length})";
                } elseif (count($this->arguments) >= 1) {
                    $start = $this->arguments[0];
                    return "str_substring({$stringExpr}, {$start})";
                }
                return "str_substring({$stringExpr})";
            case 'indexOf':
                if (count($this->arguments) >= 1) {
                    $searchStr = $this->arguments[0];
                    return "str_index_of({$stringExpr}, {$searchStr})";
                }
                return "str_index_of({$stringExpr})";
            case 'replace':
                if (count($this->arguments) >= 2) {
                    $search = $this->arguments[0];
                    $replace = $this->arguments[1];
                    return "str_replace({$stringExpr}, {$search}, {$replace})";
                }
                return "str_replace({$stringExpr})";
            default:
                throw new \Exception("Unsupported string method: {$this->methodName}");
        }
    }

    public function __toString(): string
    {
        $args = implode(', ', array_map('strval', $this->arguments));
        return "{$this->stringExpression}.{$this->methodName}({$args})";
    }
}