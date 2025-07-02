<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Unary expression node
 */
class UnaryExpressionNode extends ExpressionNode
{
    public function __construct(
        public string $operator,
        public ExpressionNode $operand,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }
}