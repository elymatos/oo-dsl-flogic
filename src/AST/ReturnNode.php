<?php

namespace OODSLFLogic\AST;

class ReturnNode extends Node
{
    public function __construct(
        public readonly ExpressionNode $expression
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
