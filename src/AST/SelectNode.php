<?php

namespace OODSLFLogic\AST;

class SelectNode extends Node
{
    public function __construct(
        public readonly IdentifierNode $target,
        public readonly ExpressionNode $condition
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
