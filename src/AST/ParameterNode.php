<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Parameter node
 */
class ParameterNode extends Node
{
    public function __construct(
        public string $name,
        public TypeNode $type,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitExpression($this);
    }
}