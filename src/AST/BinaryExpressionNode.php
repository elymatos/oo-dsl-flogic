<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Binary expression node
 */
class BinaryExpressionNode extends ExpressionNode
{
    public function __construct(
        public ExpressionNode $left,
        public string $operator,
        public ExpressionNode $right,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }
}