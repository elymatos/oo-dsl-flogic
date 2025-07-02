<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Property assignment node
 */
class PropertyAssignmentNode extends ASTNode
{
    private string $name;
    private ExpressionNode $value;
    private string $operator; // "=" or "+="

    public function __construct(string $name, ExpressionNode $value, string $operator = "=")
    {
        parent::__construct();
        $this->name = $name;
        $this->value = $value;
        $this->operator = $operator;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): ExpressionNode
    {
        return $this->value;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitPropertyAssignment($this);
    }
}