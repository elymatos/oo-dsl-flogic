<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Constraint node (for cardinality constraints)
 */
class ConstraintNode extends Node
{
    public function __construct(
        public ?int $min,
        public ?int $max,
        SourceLocation $location
    ) {
        parent::__construct($location);
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitExpression($this);
    }

    public function toString(): string
    {
        if ($this->min === null && $this->max === null) {
            return '';
        }

        if ($this->min === $this->max) {
            return "{{$this->min}}";
        }

        $min = $this->min ?? '0';
        $max = $this->max ?? '*';

        return "{{$min}..{$max}}";
    }
}