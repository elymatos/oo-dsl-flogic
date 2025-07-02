<?php

namespace OODSLFLogic\AST;

class CollectionTypeNode extends TypeNode
{
    public function __construct(
        public readonly string $collectionType, // 'set', 'list', 'bag'
        public readonly TypeNode $elementType,
        public readonly ?ConstraintNode $constraint = null
    ) {
        parent::__construct();
    }

    public function getTypeName(): string
    {
        return $this->collectionType . '<' . $this->elementType->getTypeName() . '>';
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}
