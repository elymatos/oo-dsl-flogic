<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Base expression node
 */
abstract class ExpressionNode extends ASTNode
{
    abstract public function accept(ASTVisitor $visitor);
}