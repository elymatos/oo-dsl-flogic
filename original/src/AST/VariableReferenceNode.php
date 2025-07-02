<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Represents a reference to a local variable
 * Example: using 'gross' or 'tax' in expressions
 */
class VariableReferenceNode extends ExpressionNode
{
    public string $variableName;

    public function __construct(string $variableName, ?SourceLocation $location = null)
    {
        parent::__construct($location);
        $this->variableName = $variableName;
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitVariableReference($this);
    }

    public function __toString(): string
    {
        return $this->variableName;
    }
}