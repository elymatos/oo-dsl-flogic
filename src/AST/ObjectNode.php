<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Object instantiation node
 */
class ObjectNode extends Node
{
    /**
     * @param AssignmentNode[] $assignments
     */
    public function __construct(
        public string $name,
        public string $className,
        public array $assignments,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitObject($this);
    }
}