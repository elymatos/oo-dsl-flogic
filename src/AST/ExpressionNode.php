<?php

namespace OODSLToFLogic\AST;

/**
 * Expression base node
 */
abstract class ExpressionNode extends Node
{
    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitExpression($this);
    }
}