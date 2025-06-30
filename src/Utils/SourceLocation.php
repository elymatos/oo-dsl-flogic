<?php

namespace OODSLToFLogic\Utils;

/**
 * Represents a location in source code
 */
class SourceLocation
{
    public function __construct(
        public int $line,
        public int $column,
        public ?string $filename = null
    ) {}

    public function toString(): string
    {
        $location = "line {$this->line}, column {$this->column}";
        if ($this->filename) {
            $location = "{$this->filename}:{$location}";
        }
        return $location;
    }
}