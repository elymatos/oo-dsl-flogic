<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Property definition node
 */
class PropertyNode extends Node
{
    public function __construct(
        public string $name,
        public TypeNode $type,
        public ?ConstraintNode $constraint,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitProperty($this);
    }
}