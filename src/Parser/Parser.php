<?php

namespace OODSLFLogic\Parser;

use Exception;
use OODSLFLogic\AST\ProgramNode;
use OODSLFLogic\Utils\ErrorHandler;
use OODSLFLogic\AST\SourceLocation;

class Parser implements ParserInterface
{
    private ErrorHandler $errorHandler;
    private ?object $pegParser = null;

    public function __construct()
    {
        $this->errorHandler = new ErrorHandler();
        //$this->initializePEGParser();
    }

    private function initializePEGParser(): void
    {
        $generatedFile = __DIR__ . '/Generated/OODSLParser.php';

        if (!file_exists($generatedFile)) {
            $this->errorHandler->addError(
                'Generated parser not found. Run: composer run build-parser',
                new SourceLocation(1, 1, null)
            );
            return;
        }

        require_once $generatedFile;

        $className = 'OODSLFLogic\\Parser\\Generated\\OODSLParser';
        if (class_exists($className)) {
            $this->pegParser = new $className();
        }
    }

    public function parse(string $source, ?string $filename = null): ?ProgramNode
    {
        $this->errorHandler->clear();

        // Parse OODSL
//        $this->pegParser = new \OODSLFLogic\Parser\Generated\OODSLParser($source);
        $ast = null;

//        // Try different parsing methods
//        if (method_exists($this->pegParser, 'parse')) {
//            echo "calling method parse...\n";
//            $result = $this->pegParser->parse($source);
//        } elseif (method_exists($this->pegParser, 'match_Program')) {
        $this->pegParser = new \OODSLFLogic\Parser\Generated\OODSLParser($source);
            echo "calling method match_program...\n";
            $result = $this->pegParser->match_Program();
            print_r($result);

            return $result;
//        } else {
//            throw new Exception("Parser has no suitable parse method");
//        }


//        if ($this->pegParser === null) {
//            $this->errorHandler->addError(
//                'PEG parser not available. Run: composer run build-parser',
//                new SourceLocation(1, 1, $filename)
//            );
//            return null;
//        }

//        try {
//            $this->pegParser->currentFilename = $filename;
//            $result = $this->pegParser->match_Program($source);

//            if ($result['success']) {
//                return $result['result'];
//            } else {
//                $this->handleParseError($result, $source, $filename);
//                return null;
//            }
//        } catch (\Exception $e) {
//            $this->errorHandler->addError(
//                'PEG parse error: ' . $e->getMessage(),
//                new SourceLocation(1, 1, $filename)
//            );
//            return null;
//        }
    }

    private function handleParseError(array $result, string $source, ?string $filename): void
    {
        $pos = $result['pos'] ?? 0;
        $line = $this->getLineNumber($source, $pos);
        $column = $this->getColumnNumber($source, $pos);

        $location = new SourceLocation($line, $column, $filename);

        $errorMessage = "Parse failed at position {$pos}";
        if (isset($result['furthest_match'])) {
            $errorMessage .= " (expected: {$result['furthest_match']})";
        }

        $this->errorHandler->addError($errorMessage, $location);
    }

    private function getLineNumber(string $source, int $pos): int
    {
        return substr_count(substr($source, 0, $pos), "\n") + 1;
    }

    private function getColumnNumber(string $source, int $pos): int
    {
        $lastNewline = strrpos(substr($source, 0, $pos), "\n");
        if ($lastNewline === false) {
            return $pos + 1;
        }
        return $pos - $lastNewline;
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

        if (!is_readable($filename)) {
            $this->errorHandler->addError(
                "File not readable: {$filename}",
                new SourceLocation(1, 1, $filename)
            );
            return null;
        }

        $source = file_get_contents($filename);
        if ($source === false) {
            $this->errorHandler->addError(
                "Failed to read file: {$filename}",
                new SourceLocation(1, 1, $filename)
            );
            return null;
        }

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

    public function validateSyntax(string $input): array
    {
        $errors = [];

        try {
            $result = $this->parse($input);
            if ($result === null && $this->hasErrors()) {
                foreach ($this->errorHandler->getErrors() as $error) {
                    $errors[] = [
                        'type' => 'syntax_error',
                        'message' => $error['message'],
                        'line' => $error['location']->line ?? 0,
                        'column' => $error['location']->column ?? 0
                    ];
                }
            }
        } catch (\Exception $e) {
            $errors[] = [
                'type' => 'general_error',
                'message' => $e->getMessage(),
                'line' => 0,
                'column' => 0
            ];
        }

        return $errors;
    }
}