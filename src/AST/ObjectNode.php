<?php

namespace OODSLFLogic\AST;

class ObjectNode extends Node
{
    public function __construct(
        public readonly IdentifierNode $name,
        public readonly IdentifierNode $className,
        public readonly array $assignments
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
