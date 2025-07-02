<?php

namespace OODSLFLogic\AST;

class PrimitiveTypeNode extends TypeNode
{
    public function __construct(
        public readonly string $typeName
    ) {
        parent::__construct();
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
