<?php

namespace OODSLFLogic\AST;

abstract class Node
{
    protected array $attributes = [];
    protected ?SourceLocation $location = null;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function setAttribute(string $key, mixed $value): self
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function getAttribute(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    public function setLocation(?SourceLocation $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getLocation(): ?SourceLocation
    {
        return $this->location;
    }

    abstract public function accept(NodeVisitor $visitor): mixed;

    public function getType(): string
    {
        return static::class;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'attributes' => $this->attributes,
            'location' => $this->location?->toArray()
        ];
    }
}
