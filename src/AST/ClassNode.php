<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Class definition node
 */
class ClassNode extends Node
{
    /**
     * @param PropertyNode[] $properties
     * @param MethodNode[] $methods
     */
    public function __construct(
        public string $name,
        public ?string $parentClass,
        public bool $structuralOnly,
        public array $properties,
        public array $methods,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitClass($this);
    }
}