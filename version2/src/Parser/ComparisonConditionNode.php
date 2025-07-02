<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Comparison condition node
 */
class ComparisonConditionNode extends ConditionNode
{
    private ExpressionNode $left;
    private ExpressionNode $right;
    private string $operator;

    public function __construct(ExpressionNode $left, ExpressionNode $right, string $operator)
    {
        parent::__construct();
        $this->left = $left;
        $this->right = $right;
        $this->operator = $operator;
    }

    public function getLeft(): ExpressionNode
    {
        return $this->left;
    }

    public function getRight(): ExpressionNode
    {
        return $this->right;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitComparisonCondition($this);
    }
}
