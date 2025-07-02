<?php

namespace OODSLFLogic\AST;

class ImportNode extends Node
{
    public function __construct(
        public readonly QualifiedNameNode $module,
        public readonly ?array $imports = null // array of IdentifierNode
    ) {
        parent::__construct();
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
