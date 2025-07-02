<?php

namespace OODSLFLogic\AST;

class UserTypeNode extends TypeNode
{
    public function __construct(
        public readonly IdentifierNode $name
    ) {
        parent::__construct();
    }

    public function getTypeName(): string
    {
        return $this->name->name;
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
