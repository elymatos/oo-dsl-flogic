<?php

namespace OODSLFLogic\AST;

class FloatNode extends LiteralNode
{
    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
