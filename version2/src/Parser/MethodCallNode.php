<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Method call node
 */
class MethodCallNode extends ExpressionNode
{
    private string $name;
    private array $arguments;

    public function __construct(string $name, array $arguments = [])
    {
        parent::__construct();
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitMethodCall($this);
    }
}
