<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Property access node
 */
class PropertyAccessNode extends ExpressionNode
{
    public function __construct(
        public ExpressionNode $object,
        public string $propertyName,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }
}