<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Method definition node
 */
class MethodNode extends Node
{
    /**
     * @param ParameterNode[] $parameters
     */
    public function __construct(
        public string $name,
        public array $parameters,
        public ?TypeNode $returnType,
        public ?BlockNode $body,
        public bool $isSignatureOnly,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitMethod($this);
    }
}
