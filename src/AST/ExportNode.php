<?php

namespace OODSLFLogic\AST;

class ExportNode extends Node
{
    public function __construct(
        public readonly array $exports // array of IdentifierNode
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}