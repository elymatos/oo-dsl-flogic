<?php

namespace OODSLToFLogic\Utils;

/**
 * Enhanced symbol table for tracking variable declarations and scoping
 */
class SymbolTable
{
    private array $variables = [];
    private array $variableTypes = [];
    private array $variableKeywords = [];  // Track 'let', 'var', 'const'
    private ?SymbolTable $parent = null;
    private int $scopeLevel = 0;

    public function __construct(?SymbolTable $parent = null)
    {
        $this->parent = $parent;
        $this->scopeLevel = $parent ? $parent->scopeLevel + 1 : 0;
    }

    /**
     * Declare a variable with explicit keyword
     */
    public function declareVariable(
        string $name,
        string $keyword,
        ?string $type = null
    ): void {
        // Check for redeclaration in same scope
        if (isset($this->variables[$name])) {
            throw new \Exception("Variable '{$name}' already declared in this scope");
        }

        // Check for const reassignment
        if ($this->isConstant($name)) {
            throw new \Exception("Cannot redeclare constant variable '{$name}'");
        }

        $this->variables[$name] = true;
        $this->variableKeywords[$name] = $keyword;

        if ($type) {
            $this->variableTypes[$name] = $type;
        }
    }

    /**
     * Assign to an existing variable
     */
    public function assignVariable(string $name): void
    {
        if (!$this->hasVariable($name)) {
            throw new \Exception("Variable '{$name}' not declared");
        }

        if ($this->isConstant($name)) {
            throw new \Exception("Cannot assign to constant variable '{$name}'");
        }
    }

    /**
     * Check if variable exists in this scope or parent scopes
     */
    public function hasVariable(string $name): bool
    {
        if (isset($this->variables[$name])) {
            return true;
        }

        return $this->parent && $this->parent->hasVariable($name);
    }

    /**
     * Check if variable is declared as const
     */
    public function isConstant(string $name): bool
    {
        if (isset($this->variableKeywords[$name])) {
            return $this->variableKeywords[$name] === 'const';
        }

        return $this->parent && $this->parent->isConstant($name);
    }

    /**
     * Get variable declaration keyword
     */
    public function getVariableKeyword(string $name): ?string
    {
        if (isset($this->variableKeywords[$name])) {
            return $this->variableKeywords[$name];
        }

        return $this->parent?->getVariableKeyword($name);
    }

    /**
     * Get variable type
     */
    public function getVariableType(string $name): ?string
    {
        if (isset($this->variableTypes[$name])) {
            return $this->variableTypes[$name];
        }

        return $this->parent?->getVariableType($name);
    }

    /**
     * Create child scope
     */
    public function createChildScope(): SymbolTable
    {
        return new SymbolTable($this);
    }

    /**
     * Get all variables in current scope
     */
    public function getCurrentScopeVariables(): array
    {
        return array_keys($this->variables);
    }

    /**
     * Get all variables including parent scopes
     */
    public function getAllVariables(): array
    {
        $allVars = array_keys($this->variables);

        if ($this->parent) {
            $allVars = array_merge($allVars, $this->parent->getAllVariables());
        }

        return array_unique($allVars);
    }

    /**
     * Get scope level
     */
    public function getScopeLevel(): int
    {
        return $this->scopeLevel;
    }

    /**
     * Debug: Print scope information
     */
    public function debug(): string
    {
        $vars = [];
        foreach ($this->variables as $name => $declared) {
            $keyword = $this->variableKeywords[$name] ?? 'unknown';
            $type = $this->variableTypes[$name] ?? 'any';
            $vars[] = "{$keyword} {$name}: {$type}";
        }

        return "Scope Level {$this->scopeLevel}: [" . implode(', ', $vars) . "]";
    }
}