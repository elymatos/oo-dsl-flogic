<?php

namespace OODSLFLogic\AST;

class QueryNode extends Node
{
    public function __construct(
        public readonly IdentifierNode $name,
        public readonly SelectNode $body
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}

