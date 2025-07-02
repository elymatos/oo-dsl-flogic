<?php

namespace OODSLFLogic\AST;

class IntegerNode extends LiteralNode
{
    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
