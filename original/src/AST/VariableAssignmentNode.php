<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Represents variable reassignments (not declarations)
 * Examples: x = 10; name = "Jane"; counter += 1;
 */
class VariableAssignmentNode extends Node
{
    public string $variableName;
    public string $operator;       // '=', '+=', '-=', '*=', '/='
    public ExpressionNode $value;

    public function __construct(
        string $variableName,
        string $operator,
        ExpressionNode $value,
        ?SourceLocation $location = null
    ) {
        parent::__construct($location);
        $this->variableName = $variableName;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitVariableAssignment($this);
    }

    public function __toString(): string
    {
        return "{$this->variableName} {$this->operator} {$this->value};";
    }
}