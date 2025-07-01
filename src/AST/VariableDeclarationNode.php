<?php

namespace OODSLToFLogic\AST;

use OODSLToFLogic\Utils\SourceLocation;

/**
 * Represents variable declarations with explicit keywords
 * Examples: let x = 5; var name = "John"; const PI = 3.14;
 */
class VariableDeclarationNode extends Node
{
    public string $keyword;        // 'let', 'var', 'const'
    public string $variableName;
    public ?TypeNode $type;        // Optional type annotation
    public ExpressionNode $initialValue;
    public bool $isConstant;

    public function __construct(
        string $keyword,
        string $variableName,
        ExpressionNode $initialValue,
        ?TypeNode $type = null,
        ?SourceLocation $location = null
    ) {
        parent::__construct($location);
        $this->keyword = $keyword;
        $this->variableName = $variableName;
        $this->initialValue = $initialValue;
        $this->type = $type;
        $this->isConstant = $keyword === 'const';
    }

    public function accept(NodeVisitor $visitor): mixed
    {
        return $visitor->visitVariableDeclaration($this);
    }

    public function __toString(): string
    {
        $typeStr = $this->type ? " : {$this->type}" : '';
        return "{$this->keyword} {$this->variableName}{$typeStr} = {$this->initialValue};";
    }
}