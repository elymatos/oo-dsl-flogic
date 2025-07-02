<?php

namespace OODSLFLogic\AST;

class RuleNode extends Node
{
    public function __construct(
        public readonly IdentifierNode $name,
        public readonly Node $body // IfNode or AssignmentNode
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
