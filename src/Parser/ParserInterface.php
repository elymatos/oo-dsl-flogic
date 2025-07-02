<?php

namespace OODSLFLogic\Parser;

use OODSLFLogic\AST\ProgramNode;
use OODSLFLogic\Utils\ErrorHandler;

interface ParserInterface
{
    public function parse(string $source, ?string $filename = null): ?ProgramNode;
    public function parseFile(string $filename): ?ProgramNode;
    public function hasErrors(): bool;
    public function getErrorHandler(): ErrorHandler;
    public function isAvailable(): bool;
}