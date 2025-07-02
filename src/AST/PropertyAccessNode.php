<?php

namespace OODSLFLogic\AST;

class PropertyAccessNode extends ExpressionNode
{
    public function __construct(
        public readonly QualifiedNameNode $name
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
