<?php

namespace OODSLFLogic\AST;

class ConstraintNode extends Node
{
    public function __construct(
        public readonly RangeNode|IntegerNode $constraint
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}

