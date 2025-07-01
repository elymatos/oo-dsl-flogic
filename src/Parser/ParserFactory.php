<?php

namespace OODSLToFLogic\Parser;

class ParserFactory
{
    public static function create(string $type = 'simple'): ParserInterface
    {
        return match($type) {
            'simple' => new SimpleParser(),
            'peg' => new PEGParser(),
            default => new SimpleParser() // Default to simple for now
        };
    }

    public static function getAvailableParsers(): array
    {
        return ['simple', 'peg'];
    }
}