<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Literal value node
 */
class LiteralNode extends ExpressionNode
{
    public function __construct(
        public mixed $value,
        public string $type, // 'string', 'integer', 'boolean', 'float'
        SourceLocation $location
    ) {
        parent::__construct($location);
    }
}