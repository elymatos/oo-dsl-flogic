<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Block statement node
 */
class BlockNode extends ExpressionNode
{
    /**
     * @param Node[] $statements
     */
    public function __construct(
        public array $statements,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitExpression($this);
    }
}