<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Identifier/variable reference node
 */
class IdentifierNode extends ExpressionNode
{
    public function __construct(
        public string $name,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }
}