<?php

namespace OODSLFLogic\AST;

// Class-related nodes
class ClassNode extends Node
{
    public function __construct(
        public readonly IdentifierNode $name,
        public readonly ?InheritanceNode $inheritance,
        public readonly array $body
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
