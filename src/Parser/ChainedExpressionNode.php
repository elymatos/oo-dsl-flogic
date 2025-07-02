<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Chained expression node (e.g., Person.spouse.age)
 */
class ChainedExpressionNode extends ExpressionNode
{
    private string $root;
    private array $chain;

    public function __construct(string $root, array $chain)
    {
        parent::__construct();
        $this->root = $root;
        $this->chain = $chain;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    public function getChain(): array
    {
        return $this->chain;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitChainedExpression($this);
    }
}
