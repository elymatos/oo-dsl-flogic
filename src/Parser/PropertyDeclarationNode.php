<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Property declaration node
 */
class PropertyDeclarationNode extends ASTNode
{
    private string $type;
    private string $name;
    private ?array $cardinality;

    public function __construct(string $type, string $name, ?array $cardinality = null)
    {
        parent::__construct();
        $this->type = $type;
        $this->name = $name;
        $this->cardinality = $cardinality;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCardinality(): ?array
    {
        return $this->cardinality;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitPropertyDeclaration($this);
    }
}
