<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Set expression node
 */
class SetExpressionNode extends ExpressionNode
{
    private array $elements;

    public function __construct(array $elements)
    {
        parent::__construct();
        $this->elements = $elements;
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitSetExpression($this);
    }
}
