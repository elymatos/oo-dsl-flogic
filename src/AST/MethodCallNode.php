<?php

namespace OODSLFLogic\AST;

class MethodCallNode extends ExpressionNode
{
    public function __construct(
        public readonly QualifiedNameNode $name,
        public readonly array $arguments = []
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
