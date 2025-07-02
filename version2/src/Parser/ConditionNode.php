<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Condition node
 */
abstract class ConditionNode extends ASTNode
{
    abstract public function accept(ASTVisitor $visitor);
}