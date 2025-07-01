<?php

namespace OODSLToFLogic\Parser;

use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\Utils\ErrorHandler;

interface ParserInterface
{
    public function parse(string $source, ?string $filename = null): ?ProgramNode;
    public function parseFile(string $filename): ?ProgramNode;
    public function hasErrors(): bool;
    public function getErrorHandler(): ErrorHandler;
}