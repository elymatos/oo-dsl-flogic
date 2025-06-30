<?php

namespace OODSLToFLogic\CodeGen;

use OODSLToFLogic\AST\TypeNode;
use OODSLToFLogic\AST\ConstraintNode;

/**
 * Maps DSL types to F-Logic types and handles type constraints
 */
class TypeMapper
{
    /**
     * Map from DSL primitive types to F-Logic types
     */
    private const PRIMITIVE_TYPE_MAP = [
        'string' => '\\string',
        'integer' => '\\integer',
        'boolean' => '\\boolean',
        'float' => '\\double',
    ];

    /**
     * Convert DSL type to F-Logic type specification
     */
    public function mapType(TypeNode $type): string
    {
        if ($type->isPrimitive()) {
            return self::PRIMITIVE_TYPE_MAP[$type->name] ?? $type->name;
        }

        if ($type->isCollection()) {
            $elementType = $this->mapType($type->elementType);

            // Collections in F-Logic are represented as set-valued methods
            // The constraint determines cardinality
            if ($type->name === 'set') {
                return $elementType;
            } elseif ($type->name === 'list') {
                return '\\list'; // F-Logic has built-in list type
            }
        }

        // Custom/class types remain as-is
        return $type->name;
    }

    /**
     * Generate F-Logic signature for a property/method
     */
    public function generateSignature(string $name, TypeNode $type, ?ConstraintNode $constraint = null): string
    {
        $flogicType = $this->mapType($type);
        $constraintStr = $constraint ? $constraint->toString() : '';

        if ($type->isCollection() && $type->name === 'set') {
            // For set-valued properties, use cardinality constraint
            if ($constraint) {
                return "{$name}{$constraintStr} => {$flogicType}";
            } else {
                return "{$name} => {$flogicType}";
            }
        } elseif ($type->isCollection() && $type->name === 'list') {
            // Lists are typically single-valued in the signature
            return "{$name} => {$flogicType}";
        } else {
            // Scalar properties
            if ($constraint) {
                return "{$name}{$constraintStr} => {$flogicType}";
            } else {
                return "{$name} => {$flogicType}";
            }
        }
    }

    /**
     * Check if a type should be treated as functional (0..1 cardinality)
     */
    public function isFunctional(TypeNode $type, ?ConstraintNode $constraint = null): bool
    {
        if ($type->isCollection() && $type->name === 'set') {
            return false; // Sets are inherently multi-valued
        }

        if ($constraint && $constraint->max !== null && $constraint->max <= 1) {
            return true;
        }

        // Primitive types and custom types are functional by default
        return !$type->isCollection();
    }

    /**
     * Generate F-Logic literal value
     */
    public function generateLiteral(mixed $value, string $type): string
    {
        switch ($type) {
            case 'string':
                return '"' . addslashes($value) . '"';

            case 'integer':
            case 'float':
                return (string) $value;

            case 'boolean':
                return $value ? '\\true' : '\\false';

            default:
                // For object references, use as-is
                return (string) $value;
        }
    }

    /**
     * Convert DSL operator to F-Logic operator
     */
    public function mapOperator(string $operator): string
    {
        return match ($operator) {
            '&&', 'and' => ',',
            '||', 'or' => ';',
            '==' => '=',
            '!=' => '\\=',
            '<=' => '=<',
            '>=' => '>=',
            '<' => '<',
            '>' => '>',
            '+' => '+',
            '-' => '-',
            '*' => '*',
            '/' => '/',
            '%' => 'mod',
            '!' => '\\+',
            'not' => '\\+',
            default => $operator,
        };
    }

    /**
     * Generate variable name for F-Logic (with ? prefix)
     */
    public function generateVariable(string $name): string
    {
        // Capitalize first letter and add ? prefix
        return '?' . ucfirst($name);
    }

    /**
     * Check if type requires special handling in F-Logic
     */
    public function requiresSpecialHandling(TypeNode $type): bool
    {
        return $type->isCollection() || $type->constraint !== null;
    }
}