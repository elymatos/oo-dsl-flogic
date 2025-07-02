<?php

namespace OODSLFLogic\AST;

class StringNode extends LiteralNode
{
    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
