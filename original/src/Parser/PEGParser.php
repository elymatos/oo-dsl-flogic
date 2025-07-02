<?php

namespace OODSLToFLogic\Parser;

use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\Utils\ErrorHandler;
use OODSLToFLogic\Utils\SourceLocation;

class PEGParser implements ParserInterface
{
    private ErrorHandler $errorHandler;
    private ?object $pegParser = null;

    public function __construct()
    {
        $this->errorHandler = new ErrorHandler();
        $this->initializePEGParser();
    }

    private function initializePEGParser(): void
    {
        $generatedFile = __DIR__ . '/Generated/PEGParserGenerated.php';

        if (!file_exists($generatedFile)) {
            return;
        }

        require_once $generatedFile;

        // The generated class will be named based on your grammar
        $className = 'OODSLParser'; // This matches your grammar file
        if (class_exists($className)) {
            $this->pegParser = new $className();
        }
    }

    public function parse(string $source, ?string $filename = null): ?ProgramNode
    {
        $this->errorHandler->clear();

        if ($this->pegParser === null) {
            $this->errorHandler->addError(
                'PEG parser not available. Run: composer run build-parser',
                new SourceLocation(1, 1, $filename)
            );
            return null;
        }

        try {
            $this->pegParser->currentFilename = $filename;
            $result = $this->pegParser->match_Program($source);

            if ($result['success']) {
                return $result['result'];
            } else {
                $this->errorHandler->addError(
                    "Parse failed at position {$result['pos']}",
                    new SourceLocation(1, $result['pos'], $filename)
                );
                return null;
            }
        } catch (\Exception $e) {
            $this->errorHandler->addError(
                'PEG parse error: ' . $e->getMessage(),
                new SourceLocation(1, 1, $filename)
            );
            return null;
        }
    }

    public function parseFile(string $filename): ?ProgramNode
    {
        if (!file_exists($filename)) {
            $this->errorHandler->addError(
                "File not found: {$filename}",
                new SourceLocation(1, 1, $filename)
            );
            return null;
        }

        $source = file_get_contents($filename);
        return $this->parse($source, $filename);
    }

    public function hasErrors(): bool
    {
        return $this->errorHandler->hasErrors();
    }

    public function getErrorHandler(): ErrorHandler
    {
        return $this->errorHandler;
    }

    public function isAvailable(): bool
    {
        return $this->pegParser !== null;
    }
}