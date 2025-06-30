<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Method call node
 */
class MethodCallNode extends ExpressionNode
{
    /**
     * @param ExpressionNode[] $arguments
     */
    public function __construct(
        public ExpressionNode $object,
        public string $methodName,
        public array $arguments,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }
}