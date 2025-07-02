<?php

namespace OODSLFLogic\AST;

class IdentifierNode extends ExpressionNode
{
    public function __construct(
        public readonly string $name
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
