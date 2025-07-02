<?php

namespace OODSLFLogic\AST;

class ThisNode extends ExpressionNode
{
    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
