<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Root program node
 */
class ProgramNode extends Node
{
    /**
     * @param array<Node> $statements
     */
    public function __construct(
        public array $statements,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitProgram($this);
    }
}