<?php

namespace OODSLToFLogic\Utils;

/**
 * Represents a compiler error or warning
 */
class CompilerError
{
    public function __construct(
        public string $message,
        public SourceLocation $location,
        public string $type = 'error'
    ) {}

    public function format(): string
    {
        $type = strtoupper($this->type);
        return "[{$type}] {$this->location->toString()}: {$this->message}";
    }
}