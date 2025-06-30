<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Rule definition node
 */
class RuleNode extends Node
{
    public function __construct(
        public string $name,
        public Node $condition,
        public Node $conclusion,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitRule($this);
    }
}