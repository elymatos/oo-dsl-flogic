<?php
// src/Translator/FLogicTranslator.php
namespace FLogicDSL\Translator;

use FLogicDSL\Parser\ASTVisitor;
use FLogicDSL\Parser\ActionNode;
use FLogicDSL\Parser\AssignmentActionNode;
use FLogicDSL\Parser\ASTNode;
use FLogicDSL\Parser\BinaryConditionNode;
use FLogicDSL\Parser\ChainedExpressionNode;
use FLogicDSL\Parser\ClassDeclarationNode;
use FLogicDSL\Parser\ComparisonConditionNode;
use FLogicDSL\Parser\ConditionNode;
use FLogicDSL\Parser\ExpressionNode;
use FLogicDSL\Parser\LiteralNode;
use FLogicDSL\Parser\MethodCallNode;
use FLogicDSL\Parser\MethodNode;
use FLogicDSL\Parser\ObjectDeclarationNode;
use FLogicDSL\Parser\ProgramNode;
use FLogicDSL\Parser\PropertyAssignmentNode;
use FLogicDSL\Parser\PropertyDeclarationNode;
use FLogicDSL\Parser\RuleDeclarationNode;
use FLogicDSL\Parser\SetExpressionNode;


/**
 * Translates OODSL AST to F-Logic ErgoAI syntax
 */
class FLogicTranslator implements ASTVisitor
{
    private TranslationContext $context;
    private string $output = '';
    private int $indentLevel = 0;

    public function __construct(TranslationContext $context = null)
    {
        $this->context = $context ?? new TranslationContext();
    }

    public function translate(ProgramNode $program): string
    {
        $this->output = '';
        $this->indentLevel = 0;
        $program->accept($this);
        return $this->output;
    }

    private function emit(string $text, bool $newline = true): void
    {
        $indent = str_repeat('    ', $this->indentLevel);
        $this->output .= $indent . $text . ($newline ? "\n" : '');
    }

    private function emitComment(string $comment): void
    {
        $this->emit("// $comment");
    }

    public function visitProgram(ProgramNode $node): void
    {
        $this->emitComment("Generated F-Logic ErgoAI code");
        $this->emit("");

        // First pass: collect all class signatures
        foreach ($node->getChildren() as $child) {
            if ($child instanceof ClassDeclarationNode) {
                $this->context->addClass($child);
            }
        }

        // Second pass: generate signatures
        $this->emitComment("Class signatures");
        foreach ($node->getChildren() as $child) {
            if ($child instanceof ClassDeclarationNode) {
                $this->generateClassSignature($child);
            }
        }
        $this->emit("");

        // Third pass: generate inheritance relationships
        $hasInheritance = false;
        foreach ($node->getChildren() as $child) {
            if ($child instanceof ClassDeclarationNode && $child->getParentClass()) {
                if (!$hasInheritance) {
                    $this->emitComment("Class hierarchy");
                    $hasInheritance = true;
                }
                $this->emit("{$child->getName()}::{$child->getParentClass()}.");
            }
        }
        if ($hasInheritance) {
            $this->emit("");
        }

        // Fourth pass: generate object instances and other constructs
        foreach ($node->getChildren() as $child) {
            $child->accept($this);
        }
    }

    private function generateClassSignature(ClassDeclarationNode $class): void
    {
        $className = $class->getName();
        $signatures = [];

        // Property signatures
        foreach ($class->getProperties() as $property) {
            $propertyName = $property->getName();
            $type = $this->translateType($property->getType());

            if ($this->isCollectionType($property->getType())) {
                $signatures[] = "$propertyName *=> $type";
            } else {
                $cardinality = $property->getCardinality();
                if ($cardinality) {
                    $signatures[] = "$propertyName{{$cardinality[0]}..{$cardinality[1]}} => $type";
                } else {
                    $signatures[] = "$propertyName => $type";
                }
            }
        }

        // Method signatures
        foreach ($class->getMethods() as $method) {
            $methodName = $method->getName();
            $returnType = $this->translateType($method->getReturnType());
            $params = $this->translateParameters($method->getParameters());

            if (!empty($params)) {
                $signatures[] = "$methodName($params) => $returnType";
            } else {
                $signatures[] = "$methodName() => $returnType";
            }
        }

        if (!empty($signatures)) {
            $this->emit("{$className}[" . implode(', ', $signatures) . "].");
        }
    }

    public function visitClassDeclaration(ClassDeclarationNode $node): void
    {
        // Class signatures and inheritance are handled in visitProgram
        // Generate method implementations here
        $hasImplementations = false;
        foreach ($node->getMethods() as $method) {
            if ($method->isImplementation()) {
                if (!$hasImplementations) {
                    $this->emitComment("Method implementations for {$node->getName()}");
                    $hasImplementations = true;
                }
                $this->generateMethodImplementation($node->getName(), $method);
            }
        }
        if ($hasImplementations) {
            $this->emit("");
        }
    }

    private function generateMethodImplementation(string $className, MethodNode $method): void
    {
        $methodName = $method->getName();
        $params = $this->translateParameters($method->getParameters());
        $returnVar = "?Result";

        if (!empty($params)) {
            $this->emit("?X[{$methodName}($params) -> $returnVar] :-");
        } else {
            $this->emit("?X[{$methodName}() -> $returnVar] :-");
        }

        $this->indentLevel++;
        $this->emit("?X:$className,");

        // Simple implementation - would need to parse method body for full implementation
        $this->emit("// TODO: Implement method body");
        $this->emit("$returnVar = 'not_implemented'.");

        $this->indentLevel--;
        $this->emit("");
    }

    public function visitObjectDeclaration(ObjectDeclarationNode $node): void
    {
        $objectName = $node->getName();
        $className = $node->getClassName();

        $this->emitComment("Object instance: $objectName");

        // Generate class membership
        $this->emit("$objectName:$className.");

        // Generate property assignments
        $simpleProps = [];
        $complexProps = [];

        foreach ($node->getProperties() as $prop) {
            $propName = $prop->getName();
            $value = $this->translateExpression($prop->getValue());

            if ($prop->getOperator() === '+=') {
                $complexProps[] = "$propName -> $value";
            } else {
                $simpleProps[] = "$propName -> $value";
            }
        }

        // Emit simple properties in one frame
        if (!empty($simpleProps)) {
            $this->emit("{$objectName}[" . implode(', ', $simpleProps) . "].");
        }

        // Emit complex properties separately
        foreach ($complexProps as $prop) {
            $this->emit("$objectName[$prop].");
        }

        $this->emit("");
    }

    public function visitRuleDeclaration(RuleDeclarationNode $node): void
    {
        $ruleName = $node->getName();

        $this->emitComment("Rule: $ruleName");

        $action = $this->translateAction($node->getAction());
        $condition = $this->translateCondition($node->getCondition());

        $this->emit("@!{{$ruleName}} $action :-");
        $this->indentLevel++;
        $this->emit($condition . ".");
        $this->indentLevel--;
        $this->emit("");
    }

    private function translateAction(ActionNode $action): string
    {
        if ($action instanceof AssignmentActionNode) {
            $target = $this->translateChainedExpression($action->getTarget());
            $value = $this->translateExpression($action->getValue());

            // Convert chained expression to F-Logic frame syntax
            $parts = explode('.', $target);
            if (count($parts) > 1) {
                $object = $parts[0];
                $property = $parts[1];
                return "{$object}[$property -> $value]";
            }

            return "$target -> $value";
        }

        return "unknown_action";
    }

    private function translateCondition(ConditionNode $condition): string
    {
        if ($condition instanceof BinaryConditionNode) {
            $left = $this->translateCondition($condition->getLeft());
            $right = $this->translateCondition($condition->getRight());
            $op = $condition->getOperator() === '&&' ? ',' : ';';

            if ($op === ';') {
                return "($left $op $right)";
            }
            return "$left $op\n" . str_repeat('    ', $this->indentLevel + 1) . $right;
        }

        if ($condition instanceof ComparisonConditionNode) {
            $left = $this->translateExpression($condition->getLeft());
            $right = $this->translateExpression($condition->getRight());
            $op = $this->translateComparisonOperator($condition->getOperator());

            return "$left $op $right";
        }

        return "unknown_condition";
    }

    private function translateComparisonOperator(string $op): string
    {
        return match($op) {
            '==' => '==',
            '!=' => '\\==',
            '<=' => '=<',
            '>=' => '>=',
            '<' => '<',
            '>' => '>',
            default => $op
        };
    }

    private function translateExpression(ExpressionNode $expr): string
    {
        return $expr->accept($this);
    }

    public function visitChainedExpression(ChainedExpressionNode $node): string
    {
        return $this->translateChainedExpression($node);
    }

    private function translateChainedExpression(ChainedExpressionNode $node): string
    {
        $root = $node->getRoot();
        $chain = $node->getChain();

        if ($root === 'this') {
            $root = '?X';
        }

        // For F-Logic, we need to decompose chained access
        // Person.spouse.age becomes multiple frame accesses
        if (count($chain) === 1) {
            // Simple property access: Person.property
            if ($this->isMethodCall($chain[0])) {
                return "{$root}[{$chain[0]}() -> ?Result], ?Result";
            } else {
                return "{$root}[{$chain[0]} -> ?Value], ?Value";
            }
        }

        // Complex chained access needs intermediate variables
        $conditions = [];
        $currentVar = $root;

        for ($i = 0; $i < count($chain); $i++) {
            $property = $chain[$i];
            $nextVar = "?Var" . ($i + 1);

            if ($this->isMethodCall($property)) {
                $conditions[] = "{$currentVar}[{$property}() -> $nextVar]";
            } else {
                $conditions[] = "{$currentVar}[$property -> $nextVar]";
            }

            $currentVar = $nextVar;
        }

        return implode(', ', $conditions) . ", $currentVar";
    }

    public function visitMethodCall(MethodCallNode $node): string
    {
        $methodName = $node->getName();
        $args = array_map([$this, 'translateExpression'], $node->getArguments());

        if (!empty($args)) {
            return "$methodName(" . implode(', ', $args) . ")";
        }

        return "$methodName()";
    }

    public function visitLiteral(LiteralNode $node): string
    {
        $value = $node->getValue();
        $type = $node->getType();

        return match($type) {
            'string' => '"' . $value . '"',
            'integer', 'float' => (string)$value,
            'boolean' => $value ? 'true' : 'false',
            default => (string)$value
        };
    }

    public function visitSetExpression(SetExpressionNode $node): string
    {
        $elements = array_map(function($elem) {
            return is_string($elem) ? $elem : $this->translateExpression($elem);
        }, $node->getElements());

        return '{' . implode(', ', $elements) . '}';
    }

    public function visitPropertyDeclaration(PropertyDeclarationNode $node): void
    {
        // Handled in class signature generation
    }

    public function visitMethod(MethodNode $node): void
    {
        // Handled in class signature and implementation generation
    }

    public function visitPropertyAssignment(PropertyAssignmentNode $node): void
    {
        // Handled in object declaration
    }

    public function visitBinaryCondition(BinaryConditionNode $node): string
    {
        return $this->translateCondition($node);
    }

    public function visitComparisonCondition(ComparisonConditionNode $node): string
    {
        return $this->translateCondition($node);
    }

    public function visitAssignmentAction(AssignmentActionNode $node): string
    {
        return $this->translateAction($node);
    }

    private function translateType(string $type): string
    {
        if (str_starts_with($type, 'set<') || str_starts_with($type, 'list<')) {
            // Extract inner type from collection
            preg_match('/^(?:set|list)<(.+)>$/', $type, $matches);
            return $matches[1] ?? 'object';
        }

        return match($type) {
            'string' => 'string',
            'integer' => 'integer',
            'float' => 'float',
            'boolean' => 'boolean',
            default => $type // Assume it's a class name
        };
    }

    private function isCollectionType(string $type): bool
    {
        return str_starts_with($type, 'set<') || str_starts_with($type, 'list<');
    }

    private function translateParameters(array $parameters): string
    {
        $paramStrings = [];
        foreach ($parameters as $param) {
            $paramStrings[] = '?' . ucfirst($param['name']);
        }
        return implode(', ', $paramStrings);
    }

    private function isMethodCall(string $identifier): bool
    {
        return str_contains($identifier, '(') && str_contains($identifier, ')');
    }
}
