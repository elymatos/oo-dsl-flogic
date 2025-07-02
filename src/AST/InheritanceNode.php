<?php

namespace OODSLFLogic\AST;

class InheritanceNode extends Node
{
    public function __construct(
        public readonly ?string $type, // 'structure' or null for full inheritance
        public readonly IdentifierNode $parent
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}

