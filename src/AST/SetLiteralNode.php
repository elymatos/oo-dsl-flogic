<?php

namespace OODSLToFLogic\AST;


use OODSLToFLogic\Utils\SourceLocation;

/**
 * Set literal node
 */
class SetLiteralNode extends ExpressionNode
{
    /**
     * @param ExpressionNode[] $elements
     */
    public function __construct(
        public array $elements,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }
}