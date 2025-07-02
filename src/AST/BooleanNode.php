<?php

namespace OODSLFLogic\AST;

class BooleanNode extends LiteralNode
{
    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
