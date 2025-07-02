<?php

namespace OODSLFLogic\AST;

class UnaryOpNode extends ExpressionNode
{
    public function __construct(
        public readonly string $operator,
        public readonly ExpressionNode $operand
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
