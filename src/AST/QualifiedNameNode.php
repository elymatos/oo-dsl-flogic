<?php

namespace OODSLFLogic\AST;

class QualifiedNameNode extends Node
{
    public function __construct(
        public readonly array $parts // array of IdentifierNode
    ) {
        parent::__construct();
    }

    public function toString(): string
    {
        return implode('.', array_map(fn($part) => $part->name, $this->parts));
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
