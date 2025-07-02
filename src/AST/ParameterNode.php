<?php

namespace OODSLFLogic\AST;

class ParameterNode extends Node
{
    public function __construct(
        public readonly TypeNode $type,
        public readonly IdentifierNode $name
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
