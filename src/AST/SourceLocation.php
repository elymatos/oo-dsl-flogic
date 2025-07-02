<?php

namespace OODSLFLogic\AST;


class SourceLocation
{
    public function __construct(
        public readonly int $line,
        public readonly int $column,
        public readonly ?string $filename = null
    ) {}

    public function toArray(): array
    {
        return [
            'line' => $this->line,
            'column' => $this->column,
            'filename' => $this->filename
        ];
    }

    public function __toString(): string
    {
        $location = "{$this->line}:{$this->column}";
        if ($this->filename) {
            $location = "{$this->filename}:{$location}";
        }
        return $location;
    }
}