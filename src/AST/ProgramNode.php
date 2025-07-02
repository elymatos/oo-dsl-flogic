<?php

namespace OODSLFLogic\AST;

// Program structure nodes
class ProgramNode extends Node
{
    public function __construct(
        public readonly array $statements
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
