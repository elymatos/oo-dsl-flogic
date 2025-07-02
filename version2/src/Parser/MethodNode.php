<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Method node (can be signature or implementation)
 */
class MethodNode extends ASTNode
{
    private string $returnType;
    private string $name;
    private array $parameters;
    private ?array $body;

    public function __construct(string $returnType, string $name, array $parameters = [], ?array $body = null)
    {
        parent::__construct();
        $this->returnType = $returnType;
        $this->name = $name;
        $this->parameters = $parameters;
        $this->body = $body;
    }

    public function getReturnType(): string
    {
        return $this->returnType;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getBody(): ?array
    {
        return $this->body;
    }

    public function isImplementation(): bool
    {
        return $this->body !== null;
    }

    public function accept(ASTVisitor $visitor)
    {
        return $visitor->visitMethod($this);
    }
}