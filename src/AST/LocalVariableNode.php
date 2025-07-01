<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Represents a local variable assignment in a method body
 * Example: gross = this.salary + this.bonus;
 */
class LocalVariableNode extends Node
{
    public string $variableName;
    public ExpressionNode $value;

    public function __construct(string $variableName, ExpressionNode $value, ?SourceLocation $location = null)
    {
        parent::__construct($location);
        $this->variableName = $variableName;
        $this->value = $value;
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitLocalVariable($this);
    }

    public function __toString(): string
    {
        return "{$this->variableName} = {$this->value};";
    }
}