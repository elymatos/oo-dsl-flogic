<?php

namespace OODSLToFLogic\Utils;

/**
 * Error handling and reporting
 */
class ErrorHandler
{
    private array $errors = [];
    private array $warnings = [];

    public function addError(string $message, SourceLocation $location): void
    {
        $this->errors[] = new CompilerError($message, $location, 'error');
    }

    public function addWarning(string $message, SourceLocation $location): void
    {
        $this->warnings[] = new CompilerError($message, $location, 'warning');
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function hasWarnings(): bool
    {
        return !empty($this->warnings);
    }

    /**
     * @return CompilerError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return CompilerError[]
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function formatErrors(): string
    {
        $output = [];

        foreach ($this->errors as $error) {
            $output[] = $error->format();
        }

        foreach ($this->warnings as $warning) {
            $output[] = $warning->format();
        }

        return implode("\n", $output);
    }

    public function clear(): void
    {
        $this->errors = [];
        $this->warnings = [];
    }
}
