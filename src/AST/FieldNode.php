<?php

namespace OODSLFLogic\AST;

class FieldNode extends Node
{
    public function __construct(
        public readonly TypeNode $type,
        public readonly IdentifierNode $name,
        public readonly ?ConstraintNode $constraint = null
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
