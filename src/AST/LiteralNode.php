<?php

namespace OODSLFLogic\AST;

abstract class LiteralNode extends ExpressionNode
{
    public function __construct(
        public readonly mixed $value
    ) {
        parent::__construct();
    }
}

