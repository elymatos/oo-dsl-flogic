<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;
/**
 * Assignment action node
 */
class AssignmentActionNode extends ActionNode
{
    private ChainedExpressionNode $target;
    private ExpressionNode $value;

    public function __construct(ChainedExpressionNode $target, ExpressionNode $value)
    {
        parent::__construct();
        $this->target = $target;
        $this->value = $value;
    }

    public function getTarget(): ChainedExpressionNode
    {
        return $this->target;
    }

    public function getValue(): ExpressionNode
    {
        return $this->value;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitAssignmentAction($this);
    }
}
