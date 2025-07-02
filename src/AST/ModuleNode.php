<?php

namespace OODSLFLogic\AST;

class ModuleNode extends Node
{
    public function __construct(
        public readonly IdentifierNode $name,
        public readonly array $body
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
