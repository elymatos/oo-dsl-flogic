<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Program root node
 */
class ProgramNode extends ASTNode
{
    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitProgram($this);
    }
}