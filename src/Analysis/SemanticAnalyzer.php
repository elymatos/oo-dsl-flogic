<?php

namespace OODSLFLogic\Analysis;

use OODSLFLogic\AST\AssignmentNode;
use OODSLFLogic\AST\BinaryOpNode;
use OODSLFLogic\AST\BlockNode;
use OODSLFLogic\AST\BooleanNode;
use OODSLFLogic\AST\ClassNode;
use OODSLFLogic\AST\CollectionTypeNode;
use OODSLFLogic\AST\ConstraintNode;
use OODSLFLogic\AST\ExportNode;
use OODSLFLogic\AST\ExpressionNode;
use OODSLFLogic\AST\ExpressionStatementNode;
use OODSLFLogic\AST\FieldNode;
use OODSLFLogic\AST\FloatNode;
use OODSLFLogic\AST\IdentifierNode;
use OODSLFLogic\AST\IfNode;
use OODSLFLogic\AST\ImportNode;
use OODSLFLogic\AST\InheritanceNode;
use OODSLFLogic\AST\IntegerNode;
use OODSLFLogic\AST\LiteralNode;
use OODSLFLogic\AST\MethodCallNode;
use OODSLFLogic\AST\MethodNode;
use OODSLFLogic\AST\MethodSignatureNode;
use OODSLFLogic\AST\ModuleNode;
use OODSLFLogic\AST\Node;
use OODSLFLogic\AST\NodeVisitor;
use OODSLFLogic\AST\ObjectNode;
use OODSLFLogic\AST\ParameterNode;
use OODSLFLogic\AST\PrimitiveTypeNode;
use OODSLFLogic\AST\ProgramNode;
use OODSLFLogic\AST\PropertyAccessNode;
use OODSLFLogic\AST\QualifiedNameNode;
use OODSLFLogic\AST\QueryNode;
use OODSLFLogic\AST\RangeNode;
use OODSLFLogic\AST\ReturnNode;
use OODSLFLogic\AST\RuleNode;
use OODSLFLogic\AST\SelectNode;
use OODSLFLogic\AST\SetLiteralNode;
use OODSLFLogic\AST\SourceLocation;
use OODSLFLogic\AST\StringNode;
use OODSLFLogic\AST\ThisNode;
use OODSLFLogic\AST\TypeNode;
use OODSLFLogic\AST\UnaryOpNode;
use OODSLFLogic\AST\UserTypeNode;

class SemanticAnalyzer implements NodeVisitor
{
    private SymbolTable $symbolTable;
    private array $errors = [];
    private array $warnings = [];
    private string $currentClass = '';
    private string $currentModule = 'main';

    public function __construct()
    {
        $this->symbolTable = new SymbolTable();
    }

    public function analyze(ProgramNode $program): AnalysisResult
    {
        $this->errors = [];
        $this->warnings = [];
        $this->symbolTable = new SymbolTable();

        // First pass: collect all class and module declarations
        $this->collectDeclarations($program);

        // Second pass: validate semantics
        $program->accept($this);

        return new AnalysisResult($this->errors, $this->warnings, $this->symbolTable);
    }

    private function collectDeclarations(ProgramNode $program): void
    {
        foreach ($program->statements as $statement) {
            if ($statement instanceof ModuleNode) {
                $this->symbolTable->addModule($statement->name->name);

                foreach ($statement->body as $item) {
                    if ($item instanceof ClassNode) {
                        $this->symbolTable->addClass(
                            $item->name->name,
                            $statement->name->name,
                            $item->inheritance?->parent->name
                        );
                    }
                }
            } elseif ($statement instanceof ClassNode) {
                $this->symbolTable->addClass(
                    $statement->name->name,
                    $this->currentModule,
                    $statement->inheritance?->parent->name
                );
            }
        }
    }

    public function visit(Node $node): mixed
    {
        $method = 'visit' . $this->getNodeTypeName($node);

        if (method_exists($this, $method)) {
            return $this->$method($node);
        }

        // Default behavior: visit all child nodes
        $this->visitChildren($node);
        return null;
    }

    private function getNodeTypeName(Node $node): string
    {
        $className = get_class($node);
        $parts = explode('\\', $className);
        return str_replace('Node', '', end($parts));
    }

    private function visitChildren(Node $node): void
    {
        $reflection = new \ReflectionClass($node);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($node);

            if (is_array($value)) {
                foreach ($value as $item) {
                    if ($item instanceof Node) {
                        $item->accept($this);
                    }
                }
            } elseif ($value instanceof Node) {
                $value->accept($this);
            }
        }
    }

    // Visitor methods
    public function visitProgram(ProgramNode $node): void
    {
        foreach ($node->statements as $statement) {
            $statement->accept($this);
        }
    }

    public function visitModule(ModuleNode $node): void
    {
        $oldModule = $this->currentModule;
        $this->currentModule = $node->name->name;

        foreach ($node->body as $statement) {
            $statement->accept($this);
        }

        $this->currentModule = $oldModule;
    }

    public function visitClass(ClassNode $node): void
    {
        $className = $node->name->name;
        $oldClass = $this->currentClass;
        $this->currentClass = $className;

        // Validate inheritance
        if ($node->inheritance) {
            $parentClass = $node->inheritance->parent->name;

            if (!$this->symbolTable->hasClass($parentClass)) {
                $this->addError("Class '{$className}' extends undefined class '{$parentClass}'", $node);
            } else {
                // Check for circular inheritance
                if ($this->hasCircularInheritance($className, $parentClass)) {
                    $this->addError("Circular inheritance detected for class '{$className}'", $node);
                }
            }
        }

        // Validate class members
        $fieldNames = [];
        $methodNames = [];

        foreach ($node->body as $member) {
            if ($member instanceof FieldNode) {
                $fieldName = $member->name->name;

                if (in_array($fieldName, $fieldNames)) {
                    $this->addError("Duplicate field '{$fieldName}' in class '{$className}'", $member);
                }

                $fieldNames[] = $fieldName;
                $member->accept($this);

            } elseif ($member instanceof MethodSignatureNode || $member instanceof MethodNode) {
                $methodName = $member->name->name ?? $member->name->toString();

                if (in_array($methodName, $methodNames)) {
                    $this->addError("Duplicate method '{$methodName}' in class '{$className}'", $member);
                }

                $methodNames[] = $methodName;
                $member->accept($this);
            }
        }

        // Add class fields and methods to symbol table
        $this->symbolTable->addClassMembers($className, $fieldNames, $methodNames);

        $this->currentClass = $oldClass;
    }

    public function visitField(FieldNode $node): void
    {
        // Validate field type
        $this->validateType($node->type, $node);

        // Validate constraints
        if ($node->constraint) {
            $node->constraint->accept($this);
        }
    }

    public function visitMethodSignature(MethodSignatureNode $node): void
    {
        // Validate return type
        $this->validateType($node->returnType, $node);

        // Validate parameters
        $paramNames = [];
        foreach ($node->parameters as $param) {
            $paramName = $param->name->name;

            if (in_array($paramName, $paramNames)) {
                $this->addError("Duplicate parameter '{$paramName}' in method '{$node->name->name}'", $param);
            }

            $paramNames[] = $paramName;
            $this->validateType($param->type, $param);
        }
    }

    public function visitMethod(MethodNode $node): void
    {
        $methodName = $node->name->toString();
        $parts = explode('.', $methodName);

        if (count($parts) !== 2) {
            $this->addError("Invalid method name format: '{$methodName}'. Expected 'ClassName.methodName'", $node);
            return;
        }

        $className = $parts[0];
        $method = $parts[1];

        // Validate that the class exists
        if (!$this->symbolTable->hasClass($className)) {
            $this->addError("Method defined for undefined class '{$className}'", $node);
        }

        // Validate parameters
        $paramNames = [];
        foreach ($node->parameters as $param) {
            $paramName = $param->name->name;

            if (in_array($paramName, $paramNames)) {
                $this->addError("Duplicate parameter '{$paramName}' in method '{$methodName}'", $param);
            }

            $paramNames[] = $paramName;
            $this->validateType($param->type, $param);
        }

        // Validate return type
        if ($node->returnType) {
            $this->validateType($node->returnType, $node);
        }

        // Validate method body
        $node->body->accept($this);
    }

    public function visitObject(ObjectNode $node): void
    {
        $objectName = $node->name->name;
        $className = $node->className->name;

        // Validate that the class exists
        if (!$this->symbolTable->hasClass($className)) {
            $this->addError("Object '{$objectName}' instantiated from undefined class '{$className}'", $node);
            return;
        }

        // Validate assignments
        foreach ($node->assignments as $assignment) {
            $this->validateObjectAssignment($assignment, $className, $node);
        }

        $this->symbolTable->addObject($objectName, $className);
    }

    private function validateObjectAssignment(AssignmentNode $assignment, string $className, Node $context): void
    {
        $fieldName = $assignment->target->name;

        // Check if field exists in class (simplified - would need full inheritance checking)
        $classInfo = $this->symbolTable->getClass($className);
        if ($classInfo && !empty($classInfo['fields']) && !in_array($fieldName, $classInfo['fields'])) {
            $this->addWarning("Field '{$fieldName}' not declared in class '{$className}'", $assignment);
        }

        // Validate assignment value
        $assignment->value->accept($this);
    }

    public function visitRule(RuleNode $node): void
    {
        $ruleName = $node->name->name;

        if ($this->symbolTable->hasRule($ruleName)) {
            $this->addError("Duplicate rule '{$ruleName}'", $node);
        }

        $this->symbolTable->addRule($ruleName);
        $node->body->accept($this);
    }

    public function visitPropertyAccess(PropertyAccessNode $node): void
    {
        $parts = $node->name->parts;

        if (count($parts) >= 2) {
            $className = $parts[0]->name;

            // If it's a class reference, validate the class exists
            if (!$this->symbolTable->hasClass($className) && !$this->symbolTable->hasObject($className)) {
                $this->addWarning("Reference to undefined class or object '{$className}'", $node);
            }
        }
    }

    public function visitMethodCall(MethodCallNode $node): void
    {
        $parts = $node->name->parts;

        if (count($parts) >= 2) {
            $className = $parts[0]->name;
            $methodName = $parts[1]->name;

            // Validate class exists
            if (!$this->symbolTable->hasClass($className) && !$this->symbolTable->hasObject($className)) {
                $this->addWarning("Method call on undefined class or object '{$className}'", $node);
            }
        }

        // Validate arguments
        foreach ($node->arguments as $arg) {
            $arg->accept($this);
        }
    }

    private function validateType(TypeNode $type, Node $context): void
    {
        if ($type instanceof UserTypeNode) {
            $typeName = $type->name->name;

            if (!$this->symbolTable->hasClass($typeName) && !$this->isPrimitiveType($typeName)) {
                $this->addError("Unknown type '{$typeName}'", $context);
            }
        } elseif ($type instanceof CollectionTypeNode) {
            $this->validateType($type->elementType, $context);
        }
    }

    private function isPrimitiveType(string $typeName): bool
    {
        return in_array($typeName, ['string', 'integer', 'boolean', 'float']);
    }

    private function hasCircularInheritance(string $className, string $parentClass): bool
    {
        $visited = [];
        $current = $parentClass;

        while ($current && !in_array($current, $visited)) {
            if ($current === $className) {
                return true;
            }

            $visited[] = $current;
            $classInfo = $this->symbolTable->getClass($current);
            $current = $classInfo['parent'] ?? null;
        }

        return false;
    }

    private function addError(string $message, Node $node): void
    {
        $this->errors[] = [
            'message' => $message,
            'node' => $node,
            'location' => $node->getLocation()
        ];
    }

    private function addWarning(string $message, Node $node): void
    {
        $this->warnings[] = [
            'message' => $message,
            'node' => $node,
            'location' => $node->getLocation()
        ];
    }
}

class SymbolTable
{
    private array $modules = [];
    private array $classes = [];
    private array $objects = [];
    private array $rules = [];

    public function addModule(string $name): void
    {
        $this->modules[$name] = ['name' => $name];
    }

    public function addClass(string $name, string $module = 'main', ?string $parent = null): void
    {
        $this->classes[$name] = [
            'name' => $name,
            'module' => $module,
            'parent' => $parent,
            'fields' => [],
            'methods' => []
        ];
    }

    public function addClassMembers(string $className, array $fields, array $methods): void
    {
        if (isset($this->classes[$className])) {
            $this->classes[$className]['fields'] = $fields;
            $this->classes[$className]['methods'] = $methods;
        }
    }

    public function addObject(string $name, string $className): void
    {
        $this->objects[$name] = [
            'name' => $name,
            'class' => $className
        ];
    }

    public function addRule(string $name): void
    {
        $this->rules[$name] = ['name' => $name];
    }

    public function hasModule(string $name): bool
    {
        return isset($this->modules[$name]);
    }

    public function hasClass(string $name): bool
    {
        return isset($this->classes[$name]);
    }

    public function hasObject(string $name): bool
    {
        return isset($this->objects[$name]);
    }

    public function hasRule(string $name): bool
    {
        return isset($this->rules[$name]);
    }

    public function getClass(string $name): ?array
    {
        return $this->classes[$name] ?? null;
    }

    public function getObject(string $name): ?array
    {
        return $this->objects[$name] ?? null;
    }

    public function getAllClasses(): array
    {
        return $this->classes;
    }

    public function getAllObjects(): array
    {
        return $this->objects;
    }
}

class AnalysisResult
{
    public function __construct(
        private array $errors,
        private array $warnings,
        private SymbolTable $symbolTable
    ) {}

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function hasWarnings(): bool
    {
        return !empty($this->warnings);
    }

    public function getErrors(): array
    {
        return array_map(fn($error) => $error['message'], $this->errors);
    }

    public function getWarnings(): array
    {
        return array_map(fn($warning) => $warning['message'], $this->warnings);
    }

    public function getSymbolTable(): SymbolTable
    {
        return $this->symbolTable;
    }

    public function getDetailedErrors(): array
    {
        return $this->errors;
    }

    public function getDetailedWarnings(): array
    {
        return $this->warnings;
    }
}