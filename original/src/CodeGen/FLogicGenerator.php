<?php

namespace OODSLToFLogic\CodeGen;

use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\AST\ClassNode;
use OODSLToFLogic\AST\ObjectNode;
use OODSLToFLogic\AST\MethodNode;
use OODSLToFLogic\AST\RuleNode;
use OODSLToFLogic\AST\PropertyNode;
use OODSLToFLogic\AST\AssignmentNode;
use OODSLToFLogic\AST\Node;

class FLogicGenerator
{
    private string $output = '';
    private int $indentLevel = 0;

    public function generate(ProgramNode $program): string
    {
        $this->output = '';
        $this->indentLevel = 0;

        // Generate F-Logic code header
        $this->output .= "// Generated F-Logic code from OO-DSL\n";
        $this->output .= "// Compiled at " . date('Y-m-d H:i:s') . "\n\n";

        $this->visitProgram($program);

        return $this->output;
    }

    public function visitProgram(ProgramNode $node): void
    {
        foreach ($node->getStatements() as $statement) {
            if ($statement instanceof ClassNode) {
                $this->visitClass($statement);
            } elseif ($statement instanceof ObjectNode) {
                $this->visitObject($statement);
            } elseif ($statement instanceof MethodNode) {
                $this->visitMethod($statement);
            } elseif ($statement instanceof RuleNode) {
                $this->visitRule($statement);
            }
            $this->output .= "\n";
        }
    }

    public function visitClass(ClassNode $node): void
    {
        $className = $node->getName();

        // Generate class signature
        $this->output .= "// Class: {$className}\n";

        // If class has inheritance, generate ISA relationship
        if ($node->getParentClass()) {
            $this->output .= "{$className}::{$node->getParentClass()}.\n";
        }

        // Generate property signatures
        foreach ($node->getProperties() as $property) {
            if ($property instanceof PropertyNode) {
                $this->visitProperty($property, $className);
            }
        }

        // Generate method signatures
        foreach ($node->getMethods() as $method) {
            if ($method instanceof MethodNode) {
                $this->visitMethodSignature($method, $className);
            }
        }
    }

    public function visitObject(ObjectNode $node): void
    {
        $objectName = $node->getName();
        $className = $node->getClassName();

        // Generate object instantiation
        $this->output .= "// Object: {$objectName}\n";
        $this->output .= "{$objectName}:{$className}.\n";

        // Generate property assignments
        foreach ($node->getAssignments() as $assignment) {
            if ($assignment instanceof AssignmentNode) {
                $this->visitAssignment($assignment, $objectName);
            }
        }
    }

    public function visitProperty(PropertyNode $property, string $className): void
    {
        $propertyName = $property->getName();
        $type = $property->getType();

        // Generate property signature
        $this->output .= "{$className}[{$propertyName} => {$this->mapDataType($type)}].\n";

        // Generate constraints if present
        if ($property->getConstraint()) {
            $constraint = $property->getConstraint();
            $this->output .= "// Constraint for {$className}.{$propertyName}: ";
            $this->output .= json_encode($constraint) . "\n";
        }
    }

    public function visitMethodSignature(MethodNode $method, string $className): void
    {
        $methodName = $method->getName();
        $returnType = $method->getReturnType();
        $parameters = $method->getParameters();

        // Build parameter list
        $paramList = [];
        foreach ($parameters as $param) {
            // Assuming parameters are arrays with type and name
            if (is_array($param) && isset($param['type'], $param['name'])) {
                $paramList[] = $this->mapDataType($param['type']);
            }
        }

        $paramString = empty($paramList) ? '' : '(' . implode(', ', $paramList) . ')';

        // Generate method signature
        $this->output .= "{$className}[{$methodName}{$paramString} => {$this->mapDataType($returnType)}].\n";
    }

    public function visitAssignment(AssignmentNode $assignment, string $objectName): void
    {
        $property = $assignment->getProperty();
        $operator = $assignment->getOperator();
        $value = $assignment->getValue();

        // Map assignment operator to F-Logic
        $flogicOp = match ($operator) {
            '=' => '->',
            '+=' => '+>',  // Assuming additive assignment
            '-=' => '->',  // Fallback to regular assignment
            default => '->'
        };

        $formattedValue = $this->formatValue($value);
        $this->output .= "{$objectName}[{$property} {$flogicOp} {$formattedValue}].\n";
    }

    public function visitMethod(MethodNode $node): void
    {
        // For standalone method declarations
        $methodName = $node->getName();
        $this->output .= "// Method: {$methodName}\n";

        // Method body would be generated here if supported
        if (!empty($node->getBody())) {
            $this->output .= "// Method body implementation would go here\n";
        }
    }

    public function visitRule(RuleNode $node): void
    {
        $ruleName = $node->getName();
        $this->output .= "// Rule: {$ruleName}\n";

        // Rule conditions and actions would be generated here
        if (!empty($node->getConditions())) {
            $this->output .= "// Rule conditions would be implemented here\n";
        }
    }

    private function mapDataType(string $type): string
    {
        return match ($type) {
            'string' => '\\string',
            'integer' => '\\integer',
            'boolean' => '\\boolean',
            'float' => '\\decimal',
            default => $type // Keep as-is for complex types
        };
    }

    private function formatValue($value): string
    {
        if (is_string($value)) {
            // Check if it's already quoted
            if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
                return $value;
            }
            // Quote string values
            return '"' . addslashes($value) . '"';
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        if (is_bool($value)) {
            return $value ? '\\true' : '\\false';
        }

        if (is_array($value)) {
            // Handle set/list values
            $elements = array_map([$this, 'formatValue'], $value);
            return '{' . implode(', ', $elements) . '}';
        }

        return (string) $value;
    }

    private function indent(): void
    {
        $this->indentLevel++;
    }

    private function dedent(): void
    {
        $this->indentLevel = max(0, $this->indentLevel - 1);
    }

    private function addIndent(): string
    {
        return str_repeat('    ', $this->indentLevel);
    }
}