<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
* Class declaration node
 */
class ClassDeclarationNode extends ASTNode
{
    private string $name;
    private ?string $parentClass;
    private array $properties = [];
    private array $methods = [];

    public function __construct(string $name, ?string $parentClass = null)
    {
        parent::__construct();
        $this->name = $name;
        $this->parentClass = $parentClass;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParentClass(): ?string
    {
        return $this->parentClass;
    }

    public function addProperty(PropertyDeclarationNode $property): void
    {
        $this->properties[] = $property;
    }

    public function addMethod(MethodNode $method): void
    {
        $this->methods[] = $method;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitClassDeclaration($this);
    }
}