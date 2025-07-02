<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Type specification node
 */
class TypeNode extends Node
{
    public function __construct(
        public string $name,
        public ?TypeNode $elementType = null, // for collections
        public ?ConstraintNode $constraint = null,
        SourceLocation $location = null
    ) {
        parent::__construct($location ?? new SourceLocation(0, 0));
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitType($this);
    }

    public function isCollection(): bool
    {
        return in_array($this->name, ['set', 'list']);
    }

    public function isPrimitive(): bool
    {
        return in_array($this->name, ['string', 'integer', 'boolean', 'float']);
    }
}