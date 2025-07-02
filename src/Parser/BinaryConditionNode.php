<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Binary condition node (AND/OR)
 */
class BinaryConditionNode extends ConditionNode
{
    private ConditionNode $left;
    private ConditionNode $right;
    private string $operator;

    public function __construct(ConditionNode $left, ConditionNode $right, string $operator)
    {
        parent::__construct();
        $this->left = $left;
        $this->right = $right;
        $this->operator = $operator;
    }

    public function getLeft(): ConditionNode
    {
        return $this->left;
    }

    public function getRight(): ConditionNode
    {
        return $this->right;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitBinaryCondition($this);
    }
}
