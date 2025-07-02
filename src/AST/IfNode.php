<?php

namespace OODSLFLogic\AST;

class IfNode extends Node
{
    public function __construct(
        public readonly ExpressionNode $condition,
        public readonly BlockNode $thenBlock,
        public readonly ?BlockNode $elseBlock = null
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
