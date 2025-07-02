<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Base class for all AST nodes
 */
abstract class ASTNode
{
    protected array $children = [];
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function addChild(ASTNode $child): void
    {
        $this->children[] = $child;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    public function setAttribute(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    abstract public function accept(ASTVisitor $visitor);
}