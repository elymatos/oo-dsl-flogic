<?php

namespace OODSLFLogic\AST;

class SetLiteralNode extends ExpressionNode
{
    public function __construct(
        public readonly array $elements
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
