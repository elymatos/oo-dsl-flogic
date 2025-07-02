<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Object declaration node
 */
class ObjectDeclarationNode extends ASTNode
{
    private string $name;
    private string $className;
    private array $properties = [];

    public function __construct(string $name, string $className)
    {
        parent::__construct();
        $this->name = $name;
        $this->className = $className;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function addProperty(PropertyAssignmentNode $property): void
    {
        $this->properties[] = $property;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitObjectDeclaration($this);
    }
}