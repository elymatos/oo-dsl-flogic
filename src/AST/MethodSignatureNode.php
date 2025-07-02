<?php

namespace OODSLFLogic\AST;

class MethodSignatureNode extends Node
{
    public function __construct(
        public readonly TypeNode $returnType,
        public readonly IdentifierNode $name,
        public readonly array $parameters = []
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
