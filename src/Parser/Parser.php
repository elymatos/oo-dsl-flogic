<?php

namespace OODSLToFLogic\Parser;

use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\Utils\SourceLocation;
use OODSLToFLogic\Utils\ErrorHandler;

/**
 * Parser facade that delegates to SimpleParser for now
 * Can be switched to PEG parser later when properly configured
 */
class Parser
{
    private SimpleParser $simpleParser;
    private ErrorHandler $errorHandler;

    public function __construct()
    {
        $this->simpleParser = new SimpleParser();
        $this->errorHandler = new ErrorHandler();
    }

    /**
     * Parse source code and return AST
     */
    public function parse(string $source, ?string $filename = null): ?ProgramNode
    {
        return $this->simpleParser->parse($source, $filename);
    }

    /**
     * Parse from file
     */
    public function parseFile(string $filename): ?ProgramNode
    {
        return $this->simpleParser->parseFile($filename);
    }

    public function getErrorHandler(): ErrorHandler
    {
        return $this->simpleParser->getErrorHandler();
    }

    public function hasErrors(): bool
    {
        return $this->simpleParser->hasErrors();
    }
}