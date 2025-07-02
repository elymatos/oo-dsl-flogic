<?php

namespace OODSLFLogic\Utils;

use OODSLFLogic\AST\SourceLocation;

class ErrorHandler
{
    private array $errors = [];
    private array $warnings = [];
    private bool $verbose = false;

    public function __construct(bool $verbose = false)
    {
        $this->verbose = $verbose;
    }

    public function addError(string $message, ?SourceLocation $location = null): void
    {
        $errorInfo = [
            'type' => 'error',
            'message' => $message,
            'location' => $location
        ];

        $this->errors[] = $errorInfo;

        if ($this->verbose) {
            $this->displayError($errorInfo);
        }
    }

    public function addWarning(string $message, ?SourceLocation $location = null): void
    {
        $warningInfo = [
            'type' => 'warning',
            'message' => $message,
            'location' => $location
        ];

        $this->warnings[] = $warningInfo;

        if ($this->verbose) {
            $this->displayError($warningInfo);
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function hasWarnings(): bool
    {
        return !empty($this->warnings);
    }

    public function clear(): void
    {
        $this->errors = [];
        $this->warnings = [];
    }

    public function setVerbose(bool $verbose): void
    {
        $this->verbose = $verbose;
    }

    private function displayError(array $errorInfo): void
    {
        $type = strtoupper($errorInfo['type']);
        $message = $errorInfo['message'];
        $location = $errorInfo['location'];

        $output = "\n{$type}: {$message}";

        if ($location) {
            $output .= " at {$location}";
        }

        $output .= "\n";

        echo $output;
    }

    public function formatErrorsForOutput(): string
    {
        if (empty($this->errors) && empty($this->warnings)) {
            return "No errors or warnings found.\n";
        }

        $output = "";
        $totalErrors = count($this->errors);
        $totalWarnings = count($this->warnings);

        if ($totalErrors > 0) {
            $output .= "Found {$totalErrors} error(s):\n\n";

            foreach ($this->errors as $index => $error) {
                $output .= ($index + 1) . ". ";

                if ($error['location']) {
                    $output .= "{$error['location']} - ";
                }

                $output .= "[ERROR] {$error['message']}\n\n";
            }
        }

        if ($totalWarnings > 0) {
            $output .= "Found {$totalWarnings} warning(s):\n\n";

            foreach ($this->warnings as $index => $warning) {
                $output .= ($index + 1) . ". ";

                if ($warning['location']) {
                    $output .= "{$warning['location']} - ";
                }

                $output .= "[WARNING] {$warning['message']}\n\n";
            }
        }

        return $output;
    }

    public function getErrorSummary(): array
    {
        return [
            'errors' => count($this->errors),
            'warnings' => count($this->warnings),
            'total' => count($this->errors) + count($this->warnings)
        ];
    }

    public function extractErrorContext(string $input, SourceLocation $location): array
    {
        $lines = explode("\n", $input);
        $context = [];

        // Get surrounding lines for context
        $startLine = max(1, $location->line - 2);
        $endLine = min(count($lines), $location->line + 2);

        for ($i = $startLine; $i <= $endLine; $i++) {
            $lineIndex = $i - 1; // Convert to 0-based index

            if (isset($lines[$lineIndex])) {
                $context[] = [
                    'line_number' => $i,
                    'content' => $lines[$lineIndex],
                    'is_error_line' => $i === $location->line
                ];
            }
        }

        return $context;
    }

    public function displayDetailedError(array $errorInfo, string $sourceCode = ''): void
    {
        $output = "\n" . str_repeat('=', 60) . "\n";
        $output .= strtoupper($errorInfo['type']) . "\n";
        $output .= str_repeat('=', 60) . "\n";

        if ($errorInfo['location']) {
            $location = $errorInfo['location'];
            if ($location->filename) {
                $output .= "File: {$location->filename}\n";
            }
            $output .= "Line {$location->line}, Column {$location->column}\n";
        }

        $output .= "Message: {$errorInfo['message']}\n";

        // Display context if source code is available
        if (!empty($sourceCode) && $errorInfo['location']) {
            $context = $this->extractErrorContext($sourceCode, $errorInfo['location']);

            if (!empty($context)) {
                $output .= "\nContext:\n";
                $output .= str_repeat('-', 40) . "\n";

                foreach ($context as $contextLine) {
                    $lineNum = str_pad($contextLine['line_number'], 4, ' ', STR_PAD_LEFT);
                    $marker = $contextLine['is_error_line'] ? '>>> ' : '    ';

                    $output .= "{$lineNum}: {$marker}{$contextLine['content']}\n";

                    // Add error pointer for error line
                    if ($contextLine['is_error_line'] && $errorInfo['location']->column > 0) {
                        $pointer = str_repeat(' ', 9 + $errorInfo['location']->column - 1) . '^';
                        $output .= "{$pointer}\n";
                    }
                }
            }
        }

        $output .= str_repeat('=', 60) . "\n";

        echo $output;
    }

    public function handleParseError(\Exception $error, string $filename, string $input): void
    {
        // Try to extract line/column from error message if available
        $line = 1;
        $column = 1;

        // Some parsers provide position information
        if (preg_match('/line (\d+)/i', $error->getMessage(), $matches)) {
            $line = (int)$matches[1];
        }

        if (preg_match('/column (\d+)/i', $error->getMessage(), $matches)) {
            $column = (int)$matches[1];
        }

        $location = new SourceLocation($line, $column, $filename);

        $this->addError('Parse error: ' . $error->getMessage(), $location);

        if ($this->verbose) {
            $this->displayDetailedError([
                'type' => 'parse_error',
                'message' => $error->getMessage(),
                'location' => $location
            ], $input);
        }
    }

    public function handleSemanticError(string $message, string $filename, int $line = 0, int $column = 0): void
    {
        $location = new SourceLocation($line, $column, $filename);
        $this->addError($message, $location);
    }

    public function handleGenericError(\Exception $error, string $filename): void
    {
        $location = new SourceLocation(1, 1, $filename);
        $this->addError('Error: ' . $error->getMessage(), $location);

        if ($this->verbose) {
            echo "\nStack Trace:\n";
            echo $error->getTraceAsString() . "\n";
        }
    }
}