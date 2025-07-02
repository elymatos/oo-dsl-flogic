<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Action node
 */
abstract class ActionNode extends ASTNode
{
    abstract public function accept(ASTVisitor $visitor);
}
