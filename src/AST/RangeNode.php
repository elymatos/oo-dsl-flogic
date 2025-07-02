<?php

namespace OODSLFLogic\AST;

class RangeNode extends Node
{
    public function __construct(
        public readonly int $min,
        public readonly int $max
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
