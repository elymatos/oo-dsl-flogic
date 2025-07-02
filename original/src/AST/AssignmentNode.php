<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Assignment node
 */
class AssignmentNode extends ExpressionNode
{
    public function __construct(
        public string $propertyName,
        public string $operator, // '=', '+=', '-='
        public ExpressionNode $value,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitExpression($this);
    }
}