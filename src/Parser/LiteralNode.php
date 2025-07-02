<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Literal value node
 */
class LiteralNode extends ExpressionNode
{
    private $value;
    private string $type;

    public function __construct($value, string $type)
    {
        parent::__construct();
        $this->value = $value;
        $this->type = $type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitLiteral($this);
    }
}
