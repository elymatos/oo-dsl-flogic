<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Base class for all AST nodes
 */
abstract class Node
{
    public function __construct(
        public SourceLocation $location
    ) {}

    abstract public function accept(NodeVisitor $visitor): mixed;
}