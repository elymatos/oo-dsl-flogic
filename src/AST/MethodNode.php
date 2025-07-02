<?php

namespace OODSLFLogic\AST;

class MethodNode extends Node
{
    public function __construct(
        public readonly QualifiedNameNode $name,
        public readonly array $parameters,
        public readonly ?TypeNode $returnType,
        public readonly BlockNode $body
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
