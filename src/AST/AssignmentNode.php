<?php

namespace OODSLFLogic\AST;

class AssignmentNode extends Node
{
    public function __construct(
        public readonly IdentifierNode $target,
        public readonly string $operator, // '=', '+=', '-='
        public readonly ExpressionNode $value
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
