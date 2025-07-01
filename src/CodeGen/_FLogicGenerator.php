<?php

namespace OODSLToFLogic\CodeGen;

use OODSLToFLogic\AST\AssignmentNode;
use OODSLToFLogic\AST\BinaryExpressionNode;
use OODSLToFLogic\AST\BlockNode;
use OODSLToFLogic\AST\ClassNode;
use OODSLToFLogic\AST\ExpressionNode;
use OODSLToFLogic\AST\IdentifierNode;
use OODSLToFLogic\AST\LiteralNode;
use OODSLToFLogic\AST\MethodCallNode;
use OODSLToFLogic\AST\MethodNode;
use OODSLToFLogic\AST\Node;
use OODSLToFLogic\AST\NodeVisitor;
use OODSLToFLogic\AST\ObjectNode;
use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\AST\PropertyAccessNode;
use OODSLToFLogic\AST\PropertyNode;
use OODSLToFLogic\AST\RuleNode;
use OODSLToFLogic\AST\SetLiteralNode;
use OODSLToFLogic\AST\TypeNode;
use OODSLToFLogic\AST\UnaryExpressionNode;
use OODSLToFLogic\AST\CollectionMethodCallNode;
use OODSLToFLogic\AST\LocalVariableNode;
use OODSLToFLogic\AST\VariableReferenceNode;
use OODSLToFLogic\AST\StringMethodCallNode;
use OODSLToFLogic\AST\VariableDeclarationNode;
use OODSLToFLogic\AST\VariableAssignmentNode;
use OODSLToFLogic\Utils\SymbolTable;
use OODSLToFLogic\Utils\ErrorHandler;

/**
 * Generates F-Logic code from AST
 */
class _FLogicGenerator implements NodeVisitor
{
    private TypeMapper $typeMapper;
    private ErrorHandler $errorHandler;
    private string $currentModule = 'main';
    private array $output = [];
    private int $indentLevel = 0;

    public function __construct()
    {
        $this->typeMapper = new TypeMapper();
        $this->errorHandler = new ErrorHandler();
    }

    public function generate(ProgramNode $program): string
    {
        $this->output = [];
        $this->addComment("Generated F-Logic code from OO-DSL");
        $this->addComment("Module: {$this->currentModule}");
        $this->addEmptyLine();

        $program->accept($this);

        return implode("\n", $this->output);
    }

    public function visitProgram(ProgramNode $node): mixed
    {
        foreach ($node->statements as $statement) {
            $statement->accept($this);
            $this->addEmptyLine();
        }
        return null;
    }

    public function visitClass(ClassNode $node): mixed
    {
        $this->addComment("Class: {$node->name}");

        // Generate inheritance relationship
        if ($node->parentClass) {
            $this->addLine("{$node->name}::{$node->parentClass}.");
        }

        // Generate class-level signatures
        if (!empty($node->properties) || !empty($node->methods)) {
            $signatures = [];

            // Process properties
            foreach ($node->properties as $property) {
                $signature = $this->typeMapper->generateSignature(
                    $property->name,
                    $property->type,
                    $property->constraint
                );
                $signatures[] = $signature;
            }

            // Process method signatures
            foreach ($node->methods as $method) {
                if ($method->isSignatureOnly) {
                    $signature = $this->generateMethodSignature($method);
                    $signatures[] = $signature;
                }
            }

            if (!empty($signatures)) {
                if ($node->structuralOnly) {
                    $this->addComment("Structural inheritance only - object-level signatures");
                    $this->addLine("{$node->name}[" . implode(", ", $signatures) . "].");
                } else {
                    $this->addComment("Class-level signatures (inheritable)");
                    $this->addLine("{$node->name}[|" . implode(", ", $signatures) . "|].");
                }
            }
        }

        return null;
    }

    public function visitObject(ObjectNode $node): mixed
    {
        $this->addComment("Object: {$node->name}");

        // Object instantiation
        $this->addLine("{$node->name}:{$node->className}.");

        // Object properties
        foreach ($node->assignments as $assignment) {
            $this->generateObjectAssignment($node->name, $assignment);
        }

        return null;
    }

    public function visitMethod(MethodNode $node): mixed
    {
        if ($node->isSignatureOnly) {
            return null; // Already handled in class definition
        }

        $this->addComment("Method implementation: {$node->name}");

        // Extract class name and method name
        $parts = explode('.', $node->name);
        if (count($parts) !== 2) {
            $this->errorHandler->addError(
                "Invalid method name format: {$node->name}",
                $node->location
            );
            return null;
        }

        [$className, $methodName] = $parts;

        // Generate method rule
        $this->generateMethodRule($className, $methodName, $node);

        return null;
    }

    public function visitRule(RuleNode $node): mixed
    {
        $this->addComment("Rule: {$node->name}");

        // Generate named rule with @!{} syntax
        $ruleName = "@!{{$node->name}}";

        // Generate rule head (conclusion)
        $head = $this->generateRuleConclusion($node->conclusion);

        // Generate rule body (condition)
        $body = $this->generateRuleCondition($node->condition);

        $this->addLine("{$ruleName} {$head} :- {$body}.");

        return null;
    }

    public function visitProperty(PropertyNode $node): mixed
    {
        // Properties are handled within class definitions
        return null;
    }

    public function visitType(TypeNode $node): mixed
    {
        return $this->typeMapper->mapType($node);
    }

    public function visitExpression(ExpressionNode $node): mixed
    {
        return $this->generateExpression($node);
    }

    private function generateMethodSignature(MethodNode $method): string
    {
        $params = [];
        foreach ($method->parameters as $param) {
            $paramType = $this->typeMapper->mapType($param->type);
            $params[] = $paramType;
        }

        $paramStr = !empty($params) ? '(' . implode(', ', $params) . ')' : '()';

        if ($method->returnType) {
            $returnType = $this->typeMapper->mapType($method->returnType);
            return "{$method->name}{$paramStr} => {$returnType}";
        } else {
            return "{$method->name}{$paramStr}";
        }
    }

    private function generateObjectAssignment(string $objectName, AssignmentNode $assignment): void
    {
        $value = $this->generateExpression($assignment->value);

        switch ($assignment->operator) {
            case '=':
                $this->addLine("{$objectName}[{$assignment->propertyName} -> {$value}].");
                break;

            case '+=':
                // For set addition, generate multiple facts
                if ($assignment->value instanceof SetLiteralNode) {
                    foreach ($assignment->value->elements as $element) {
                        $elementValue = $this->generateExpression($element);
                        $this->addLine("{$objectName}[{$assignment->propertyName} -> {$elementValue}].");
                    }
                } else {
                    $this->addLine("{$objectName}[{$assignment->propertyName} -> {$value}].");
                }
                break;

            case '-=':
                // For set removal, this would require retraction (not shown here)
                $this->addComment("Set removal not implemented in this version");
                break;
        }
    }

    private function generateMethodRule(string $className, string $methodName, MethodNode $method): void
    {
        // Generate method head
        $objVar = $this->typeMapper->generateVariable('obj');
        $params = [];
        $paramVars = [];

        foreach ($method->parameters as $param) {
            $paramVar = $this->typeMapper->generateVariable($param->name);
            $paramVars[] = $paramVar;
            $params[] = $paramVar;
        }

        $paramStr = !empty($params) ? '(' . implode(', ', $params) . ')' : '()';

        if ($method->returnType) {
            $resultVar = $this->typeMapper->generateVariable('result');
            $head = "{$objVar}:{$className}[{$methodName}{$paramStr} -> {$resultVar}]";
        } else {
            $head = "{$objVar}:{$className}[{$methodName}{$paramStr}]";
        }

        // Generate method body
        if ($method->body) {
            $body = $this->generateBlock($method->body, $objVar, $paramVars);
            $this->addLine("{$head} :- {$body}.");
        } else {
            $this->addLine("{$head}.");
        }
    }

    private function generateBlock(BlockNode $block, string $objectVar, array $paramVars = []): string
    {
        $conditions = [];
        $localVarMap = []; // Track local variable F-Logic names
        $propertyAccesses = []; // Track property accesses we need to add

        foreach ($block->statements as $statement) {
            if ($statement instanceof VariableDeclarationNode) {
                // Handle let/var/const declarations
                $varName = $this->typeMapper->generateVariable($statement->variableName);
                $localVarMap[$statement->variableName] = $varName;

                // Collect property accesses from the value expression
                $this->collectPropertyAccesses($statement->initialValue, $objectVar, $propertyAccesses);
                $value = $this->generateExpressionWithVars($statement->initialValue, $localVarMap, $objectVar);
                $conditions[] = "{$varName} = {$value}";

            } elseif ($statement instanceof VariableAssignmentNode) {
                // Handle variable reassignments
                if (isset($localVarMap[$statement->variableName])) {
                    $varName = $localVarMap[$statement->variableName];
                } else {
                    $varName = $this->typeMapper->generateVariable($statement->variableName);
                    $localVarMap[$statement->variableName] = $varName;
                }

                $this->collectPropertyAccesses($statement->value, $objectVar, $propertyAccesses);
                $value = $this->generateExpressionWithVars($statement->value, $localVarMap, $objectVar);

                switch ($statement->operator) {
                    case '=':
                        $conditions[] = "{$varName} = {$value}";
                        break;
                    case '+=':
                        $conditions[] = "{$varName} = ({$varName} + {$value})";
                        break;
                    case '-=':
                        $conditions[] = "{$varName} = ({$varName} - {$value})";
                        break;
                    default:
                        $conditions[] = "{$varName} = {$value}";
                }

            } elseif ($statement instanceof LocalVariableNode) {
                // Handle old-style implicit declarations (keep for compatibility)
                $varName = $this->typeMapper->generateVariable($statement->variableName);
                $localVarMap[$statement->variableName] = $varName;

                $this->collectPropertyAccesses($statement->value, $objectVar, $propertyAccesses);
                $value = $this->generateExpressionWithVars($statement->value, $localVarMap, $objectVar);
                $conditions[] = "{$varName} = {$value}";

            } elseif ($statement instanceof AssignmentNode) {
                if ($statement->propertyName === 'return') {
                    // Handle return statements
                    $this->collectPropertyAccesses($statement->value, $objectVar, $propertyAccesses);
                    $value = $this->generateExpressionWithVars($statement->value, $localVarMap, $objectVar);
                    $conditions[] = "?Result = {$value}";
                } else {
                    // Handle property assignments
                    $this->collectPropertyAccesses($statement->value, $objectVar, $propertyAccesses);
                    $value = $this->generateExpressionWithVars($statement->value, $localVarMap, $objectVar);
                    $conditions[] = "{$statement->propertyName} = {$value}";
                }
            } elseif ($statement instanceof ExpressionNode) {
                $this->collectPropertyAccesses($statement, $objectVar, $propertyAccesses);
                $conditions[] = $this->generateExpressionWithVars($statement, $localVarMap, $objectVar);
            }
        }

        // Add all property access conditions at the beginning
        $allConditions = array_merge($propertyAccesses, $conditions);
        return implode(', ', $allConditions);
    }

// Add this new helper method
    private function collectPropertyAccesses(ExpressionNode $expr, string $objectVar, array &$propertyAccesses): void
    {
        if ($expr instanceof PropertyAccessNode) {
            if ($expr->object instanceof IdentifierNode && $expr->object->name === 'this') {
                $valueVar = $this->typeMapper->generateVariable($expr->propertyName . 'Value');
                $condition = "{$objectVar}[{$expr->propertyName} -> {$valueVar}]";

                // Avoid duplicates
                if (!in_array($condition, $propertyAccesses)) {
                    $propertyAccesses[] = $condition;
                }
            }
        } elseif ($expr instanceof BinaryExpressionNode) {
            $this->collectPropertyAccesses($expr->left, $objectVar, $propertyAccesses);
            $this->collectPropertyAccesses($expr->right, $objectVar, $propertyAccesses);
        } elseif ($expr instanceof MethodCallNode) {
            foreach ($expr->arguments as $arg) {
                $this->collectPropertyAccesses($arg, $objectVar, $propertyAccesses);
            }
        } elseif ($expr instanceof StringMethodCallNode) {
            // For string methods like this.firstName.toUpperCase()
            if ($expr->stringExpression instanceof PropertyAccessNode) {
                $propAccess = $expr->stringExpression;
                if ($propAccess->object instanceof IdentifierNode && $propAccess->object->name === 'this') {
                    $valueVar = $this->typeMapper->generateVariable($propAccess->propertyName . 'Value');
                    $condition = "{$objectVar}[{$propAccess->propertyName} -> {$valueVar}]";

                    if (!in_array($condition, $propertyAccesses)) {
                        $propertyAccesses[] = $condition;
                    }
                }
            }

            // Also collect from arguments
            foreach ($expr->arguments as $arg) {
                $this->collectPropertyAccesses($arg, $objectVar, $propertyAccesses);
            }
        }
        // Add other expression types as needed
    }

    private function generateRuleConclusion(Node $conclusion): string
    {
        if ($conclusion instanceof AssignmentNode && $conclusion->propertyName === 'rule_conclusion') {
            $expr = $conclusion->value;
            if ($expr instanceof BinaryExpressionNode && $expr->operator === '=') {
                $target = $expr->left;

                // Convert property access to F-Logic pattern
                if ($target instanceof PropertyAccessNode) {
                    $obj = $target->object;
                    $prop = $target->propertyName;

                    if ($obj instanceof IdentifierNode && ctype_upper($obj->name[0])) {
                        // Class.property pattern becomes ?X:Class[property]
                        $varName = $this->typeMapper->generateVariable('x');
                        return "{$varName}:{$obj->name}[{$prop}]";
                    }
                }

                return $this->generateExpression($target);
            }
        }

        if ($conclusion instanceof ExpressionNode) {
            return $this->generateExpression($conclusion);
        }

        return "/* Unsupported conclusion type: " . get_class($conclusion) . " */";
    }

    private function generateRuleCondition(ExpressionNode $condition): string
    {
        return $this->generateComplexCondition($condition);
    }

    private function generateComplexCondition(ExpressionNode $expr): string
    {
        if ($expr instanceof BinaryExpressionNode) {
            if ($expr->operator === '&&' || $expr->operator === 'and') {
                // AND: both conditions must be true, join with comma
                $left = $this->generateComplexCondition($expr->left);
                $right = $this->generateComplexCondition($expr->right);
                return "{$left}, {$right}";
            } elseif ($expr->operator === '||' || $expr->operator === 'or') {
                // OR: either condition can be true, use disjunction
                $left = $this->generateComplexCondition($expr->left);
                $right = $this->generateComplexCondition($expr->right);
                return "({$left}; {$right})";
            } else {
                // Regular comparison operators
                return $this->generateConditionComparison($expr);
            }
        } elseif ($expr instanceof PropertyAccessNode) {
            return $this->generateConditionExpression($expr);
        } elseif ($expr instanceof MethodCallNode) {
            return $this->generateConditionMethodCall($expr);
        } else {
            return $this->generateExpression($expr);
        }
    }

    private function generateConditionComparison(BinaryExpressionNode $expr): string
    {
        $left = $this->generateConditionExpression($expr->left);
        $right = $this->generateExpression($expr->right);
        $op = $this->typeMapper->mapOperator($expr->operator);

        return "{$left} {$op} {$right}";
    }

    private function generateConditionMethodCall(MethodCallNode $expr): string
    {
        $obj = $expr->object;
        $method = $expr->methodName;

        if ($obj instanceof IdentifierNode && ctype_upper($obj->name[0])) {
            // Class method call like Employee.isAdult()
            $objVar = $this->typeMapper->generateVariable('x');
            $resultVar = $this->typeMapper->generateVariable('result');
            return "{$objVar}:{$obj->name}[{$method}() -> {$resultVar}], {$resultVar} = \\true";
        }

        return $this->generateExpression($expr);
    }

    private function generateConditionExpression(ExpressionNode $expr): string
    {
        if ($expr instanceof PropertyAccessNode) {
            return $this->generateChainedPropertyAccess($expr);
        } elseif ($expr instanceof MethodCallNode) {
            return $this->generateConditionMethodCall($expr);
        } elseif ($expr instanceof StringMethodCallNode) {
            // Handle string methods in conditions
            if ($expr->stringExpression instanceof PropertyAccessNode) {
                $propAccess = $expr->stringExpression;
                if ($propAccess->object instanceof IdentifierNode && ctype_upper($propAccess->object->name[0])) {
                    $objVar = $this->typeMapper->generateVariable('x');
                    $valueVar = $this->typeMapper->generateVariable('value');
                    $condition = "{$objVar}:{$propAccess->object->name}[{$propAccess->propertyName} -> {$valueVar}]";

                    switch ($expr->methodName) {
                        case 'length':
                            return "{$condition}, str_length({$valueVar})";
                        case 'toUpperCase':
                            return "{$condition}, str_to_upper({$valueVar})";
                        case 'toLowerCase':
                            return "{$condition}, str_to_lower({$valueVar})";
                        case 'indexOf':
                            if (count($expr->arguments) >= 1) {
                                $searchArg = $this->generateExpression($expr->arguments[0]);
                                return "{$condition}, str_indexOf({$valueVar}, {$searchArg})";
                            }
                            return "{$condition}, str_indexOf({$valueVar})";
                        default:
                            return "{$condition}, str_{$expr->methodName}({$valueVar})";
                    }
                }
            }
        }

        return $this->generateExpression($expr);
    }

    private function generateChainedPropertyAccess(PropertyAccessNode $expr): string
    {
        $obj = $expr->object;
        $prop = $expr->propertyName;

        if ($obj instanceof IdentifierNode && ctype_upper($obj->name[0])) {
            // Simple class property access: Person.age
            $objVar = $this->typeMapper->generateVariable('x');
            $valueVar = $this->typeMapper->generateVariable('v');
            return "{$objVar}:{$obj->name}[{$prop} -> {$valueVar}], {$valueVar}";
        } elseif ($obj instanceof PropertyAccessNode) {
            // Chained property access: Person.spouse.name
            return $this->generateNestedPropertyAccess($expr);
        } elseif ($obj instanceof MethodCallNode) {
            // Property access on method result: Person.getSpouse().name
            return $this->generateMethodPropertyChain($expr);
        } elseif ($obj instanceof IdentifierNode && ctype_lower($obj->name[0])) {
            // Instance property access: john.spouse.name
            return $this->generateInstancePropertyChain($expr);
        }

        return $this->generateExpression($expr);
    }

    private function generateNestedPropertyAccess(PropertyAccessNode $expr): string
    {
        // Break down the chain: Person.spouse.name
        $chain = $this->collectPropertyChain($expr);

        if (count($chain) < 2) {
            return $this->generateExpression($expr);
        }

        $conditions = [];
        $currentVar = null;

        // Start with the root class
        $rootClass = $chain[0]['object'];
        if ($rootClass instanceof IdentifierNode && ctype_upper($rootClass->name[0])) {
            $currentVar = $this->typeMapper->generateVariable('x0');
            $nextVar = $this->typeMapper->generateVariable('x1');

            $conditions[] = "{$currentVar}:{$rootClass->name}[{$chain[0]['property']} -> {$nextVar}]";
            $currentVar = $nextVar;

            // Chain through intermediate properties
            for ($i = 1; $i < count($chain) - 1; $i++) {
                $nextVar = $this->typeMapper->generateVariable('x' . ($i + 1));
                $conditions[] = "{$currentVar}[{$chain[$i]['property']} -> {$nextVar}]";
                $currentVar = $nextVar;
            }

            // Final property access
            $finalVar = $this->typeMapper->generateVariable('v');
            $finalProp = $chain[count($chain) - 1]['property'];
            $conditions[] = "{$currentVar}[{$finalProp} -> {$finalVar}]";

            return implode(', ', $conditions) . ', ' . $finalVar;
        }

        return $this->generateExpression($expr);
    }

    private function generateMethodPropertyChain(PropertyAccessNode $expr): string
    {
        // Handle cases like Person.getSpouse().name
        $methodCall = $expr->object;
        $property = $expr->propertyName;

        if ($methodCall instanceof MethodCallNode) {
            $methodCondition = $this->generateConditionMethodCall($methodCall);

            // Extract the result variable from method call
            if (preg_match('/-> (\?\w+)\]/', $methodCondition, $matches)) {
                $resultVar = $matches[1];
                $finalVar = $this->typeMapper->generateVariable('v');
                return $methodCondition . ", {$resultVar}[{$property} -> {$finalVar}], {$finalVar}";
            }
        }

        return $this->generateExpression($expr);
    }

    private function generateInstancePropertyChain(PropertyAccessNode $expr): string
    {
        // Handle cases like john.spouse.name
        $chain = $this->collectPropertyChain($expr);

        if (count($chain) < 2) {
            return $this->generateExpression($expr);
        }

        $conditions = [];
        $rootObj = $chain[0]['object'];

        if ($rootObj instanceof IdentifierNode && ctype_lower($rootObj->name[0])) {
            $currentVar = $rootObj->name;

            // Chain through properties
            for ($i = 0; $i < count($chain); $i++) {
                if ($i < count($chain) - 1) {
                    $nextVar = $this->typeMapper->generateVariable('x' . $i);
                    $conditions[] = "{$currentVar}[{$chain[$i]['property']} -> {$nextVar}]";
                    $currentVar = $nextVar;
                } else {
                    // Final property
                    $finalVar = $this->typeMapper->generateVariable('v');
                    $conditions[] = "{$currentVar}[{$chain[$i]['property']} -> {$finalVar}]";
                    return implode(', ', $conditions) . ', ' . $finalVar;
                }
            }
        }

        return $this->generateExpression($expr);
    }

    private function collectPropertyChain(PropertyAccessNode $expr): array
    {
        $chain = [];
        $current = $expr;

        // Collect the chain from right to left
        while ($current instanceof PropertyAccessNode) {
            array_unshift($chain, [
                'object' => $current->object instanceof PropertyAccessNode ? null : $current->object,
                'property' => $current->propertyName
            ]);

            if ($current->object instanceof PropertyAccessNode) {
                $current = $current->object;
            } else {
                $chain[0]['object'] = $current->object;
                break;
            }
        }

        return $chain;
    }

    private function generateExpression(ExpressionNode $expr): string
    {
        return match (get_class($expr)) {
            BinaryExpressionNode::class => $this->generateBinaryExpression($expr),
            UnaryExpressionNode::class => $this->generateUnaryExpression($expr),
            IdentifierNode::class => $this->generateIdentifier($expr),
            LiteralNode::class => $this->generateLiteral($expr),
            MethodCallNode::class => $this->generateMethodCall($expr),
            PropertyAccessNode::class => $this->generatePropertyAccess($expr),
            SetLiteralNode::class => $this->generateSetLiteral($expr),
            AssignmentNode::class => $this->generateAssignmentExpression($expr),
            BlockNode::class => $this->generateBlockExpression($expr),
            CollectionMethodCallNode::class => $this->generateCollectionMethod($expr),
            LocalVariableNode::class => $this->generateLocalVariable($expr),
            VariableReferenceNode::class => $this->generateVariableReference($expr),
            StringMethodCallNode::class => $this->generateStringMethod($expr),
            VariableDeclarationNode::class => $this->generateVariableDeclaration($expr),    // ADD THIS
            VariableAssignmentNode::class => $this->generateVariableAssignment($expr),      // ADD THIS
            default => "/* Unsupported expression: " . get_class($expr) . " */",
        };
    }

    private function generateAssignmentExpression(AssignmentNode $assignment): string
    {
        $value = $this->generateExpression($assignment->value);

        switch ($assignment->operator) {
            case '=':
                return "{$assignment->propertyName} -> {$value}";
            case '+=':
                return "{$assignment->propertyName} -> {$value}";
            case '-=':
                return "/* Set removal not implemented */";
            default:
                return "{$assignment->propertyName} {$assignment->operator} {$value}";
        }
    }

    private function generateBlockExpression(BlockNode $block): string
    {
        $statements = [];

        foreach ($block->statements as $statement) {
            if ($statement instanceof AssignmentNode) {
                if ($statement->propertyName === 'return') {
                    // Handle return statements
                    $statements[] = $this->generateExpression($statement->value);
                } else {
                    $statements[] = $this->generateExpression($statement);
                }
            } elseif ($statement instanceof ExpressionNode) {
                $statements[] = $this->generateExpression($statement);
            }
        }

        return implode(', ', $statements);
    }

    private function generateBinaryExpression(BinaryExpressionNode $expr): string
    {
        $left = $this->generateExpression($expr->left);
        $right = $this->generateExpression($expr->right);

        // Handle special cases
        if ($expr->operator === '&&' || $expr->operator === 'and') {
            return "{$left}, {$right}";
        } elseif ($expr->operator === '||' || $expr->operator === 'or') {
            return "({$left}; {$right})";
        } elseif ($expr->operator === '+') {
            // Check if this might be string concatenation
            // For now, we'll assume + on strings means concatenation
            return "str_concat({$left}, {$right})";
        } else {
            $op = $this->typeMapper->mapOperator($expr->operator);
            return "{$left} {$op} {$right}";
        }
    }

    private function generateUnaryExpression(UnaryExpressionNode $expr): string
    {
        $operand = $this->generateExpression($expr->operand);
        $op = $this->typeMapper->mapOperator($expr->operator);

        return "{$op} {$operand}";
    }

    private function generateIdentifier(IdentifierNode $expr): string
    {
        if ($expr->name === 'this') {
            return '?Self'; // Special variable for current object
        }

        // Check if it's a variable or object reference
        if (ctype_lower($expr->name[0])) {
            return $this->typeMapper->generateVariable($expr->name);
        } else {
            return $expr->name; // Object/class name
        }
    }

    private function generateLiteral(LiteralNode $expr): string
    {
        return $this->typeMapper->generateLiteral($expr->value, $expr->type);
    }

    private function generateMethodCall(MethodCallNode $expr): string
    {
        $object = $this->generateExpression($expr->object);
        $args = array_map([$this, 'generateExpression'], $expr->arguments);
        $argStr = !empty($args) ? '(' . implode(', ', $args) . ')' : '()';

        return "{$object}[{$expr->methodName}{$argStr}]";
    }

    private function generatePropertyAccess(PropertyAccessNode $expr): string
    {
        // Check if this is a chained property access
        if ($this->isChainedPropertyAccess($expr)) {
            return $this->generateChainedPropertyForExpression($expr);
        }

        $object = $this->generateExpression($expr->object);

        // Handle simple property access
        if ($expr->object instanceof IdentifierNode) {
            $objName = $expr->object->name;
            if (ctype_upper($objName[0])) {
                // Class reference like Person.age becomes ?P:Person[age -> ?V]
                $varName = $this->typeMapper->generateVariable('obj');
                $valueVar = $this->typeMapper->generateVariable('value');
                return "{$varName}:{$objName}[{$expr->propertyName} -> {$valueVar}]";
            } else {
                // Instance reference like john.age
                return "{$object}[{$expr->propertyName}]";
            }
        }

        return "{$object}[{$expr->propertyName}]";
    }

    private function isChainedPropertyAccess(PropertyAccessNode $expr): bool
    {
        return $expr->object instanceof PropertyAccessNode ||
            $expr->object instanceof MethodCallNode;
    }

    private function generateChainedPropertyForExpression(PropertyAccessNode $expr): string
    {
        if ($expr->object instanceof PropertyAccessNode) {
            // Property chain like Person.spouse.name
            $chain = $this->collectPropertyChain($expr);

            if (count($chain) >= 2) {
                $rootClass = $chain[0]['object'];
                if ($rootClass instanceof IdentifierNode && ctype_upper($rootClass->name[0])) {
                    // Generate intermediate variables for the chain
                    $vars = [];
                    for ($i = 0; $i <= count($chain); $i++) {
                        $vars[] = $this->typeMapper->generateVariable('x' . $i);
                    }

                    $conditions = [];
                    $conditions[] = "{$vars[0]}:{$rootClass->name}[{$chain[0]['property']} -> {$vars[1]}]";

                    for ($i = 1; $i < count($chain); $i++) {
                        $conditions[] = "{$vars[$i]}[{$chain[$i]['property']} -> {$vars[$i + 1]}]";
                    }

                    return '(' . implode(', ', $conditions) . ', ' . end($vars) . ')';
                }
            }
        } elseif ($expr->object instanceof MethodCallNode) {
            // Method call followed by property access
            $methodResult = $this->generateMethodCall($expr->object);
            return "({$methodResult}[{$expr->propertyName}])";
        }

        // Fallback to regular generation
        $object = $this->generateExpression($expr->object);
        return "{$object}[{$expr->propertyName}]";
    }

    private function generateSetLiteral(SetLiteralNode $expr): string
    {
        $elements = array_map([$this, 'generateExpression'], $expr->elements);
        return '{' . implode(', ', $elements) . '}';
    }

    private function generateCollectionMethod(CollectionMethodCallNode $expr): string
    {
        return $expr->generateFLogic(); // Use the method from your AST node!
    }

    // Add these methods to your FLogicGenerator class

    private function generateLocalVariable(LocalVariableNode $expr): string
    {
        // Local variables are handled in the method generation context
        // This shouldn't be called directly in expressions
        return "/* Local variable: {$expr->variableName} */";
    }

    private function generateVariableReference(VariableReferenceNode $expr): string
    {
        // Generate F-Logic variable name
        return $this->typeMapper->generateVariable($expr->variableName);
    }

    public function visitLocalVariable(LocalVariableNode $node): mixed
    {
        // Local variables are handled in the block context, not individually
        return null;
    }

    public function visitVariableReference(VariableReferenceNode $node): mixed
    {
        return $this->generateVariableReference($node);
    }

    // Helper method to generate expressions with local variable context
    private function generateExpressionWithVars(ExpressionNode $expr, array $localVarMap, string $objectVar): string
    {
        if ($expr instanceof VariableReferenceNode) {
            // Check if it's a local variable
            if (isset($localVarMap[$expr->variableName])) {
                return $localVarMap[$expr->variableName];
            }
            // Otherwise, treat as regular identifier
            return $this->generateExpression($expr);
        } elseif ($expr instanceof PropertyAccessNode) {
            // Handle 'this' references in local variable context
            if ($expr->object instanceof IdentifierNode && $expr->object->name === 'this') {
                // For property access in expressions, just return the variable name
                // The property access condition will be added separately
                return $this->typeMapper->generateVariable($expr->propertyName . 'Value');
            }
            return $this->generateExpression($expr);
        } elseif ($expr instanceof BinaryExpressionNode) {
            // Handle special operators first
            if ($expr->operator === '&&' || $expr->operator === 'and') {
                $left = $this->generateExpressionWithVars($expr->left, $localVarMap, $objectVar);
                $right = $this->generateExpressionWithVars($expr->right, $localVarMap, $objectVar);
                return "{$left}, {$right}";
            } elseif ($expr->operator === '||' || $expr->operator === 'or') {
                $left = $this->generateExpressionWithVars($expr->left, $localVarMap, $objectVar);
                $right = $this->generateExpressionWithVars($expr->right, $localVarMap, $objectVar);
                return "({$left}; {$right})";
            } elseif ($expr->operator === '+') {
                // Smart detection: use str_concat only for string operations
                $left = $this->generateExpressionWithVars($expr->left, $localVarMap, $objectVar);
                $right = $this->generateExpressionWithVars($expr->right, $localVarMap, $objectVar);

                // Check if either operand is a string literal or string operation
                if ($this->isStringExpression($expr->left) || $this->isStringExpression($expr->right)) {
                    return "str_concat({$left}, {$right})";
                } else {
                    // Arithmetic addition
                    return "({$left} + {$right})";
                }
            } else {
                // Other binary expressions
                $left = $this->generateExpressionWithVars($expr->left, $localVarMap, $objectVar);
                $right = $this->generateExpressionWithVars($expr->right, $localVarMap, $objectVar);
                $op = $this->typeMapper->mapOperator($expr->operator);
                return "({$left} {$op} {$right})";
            }
        } elseif ($expr instanceof StringMethodCallNode) {
            // Handle string methods with proper variable context
            $stringExpr = $this->generateExpressionWithVars($expr->stringExpression, $localVarMap, $objectVar);

            switch ($expr->methodName) {
                case 'length':
                    return "str_length({$stringExpr})";
                case 'toUpperCase':
                    return "str_to_upper({$stringExpr})";
                case 'toLowerCase':
                    return "str_to_lower({$stringExpr})";
                // ... other cases
                default:
                    return "str_{$expr->methodName}({$stringExpr})";
            }
        }

        // Default to regular expression generation
        return $this->generateExpression($expr);
    }
    private function isStringExpression(ExpressionNode $expr): bool
    {
        if ($expr instanceof LiteralNode && $expr->type === 'string') {
            return true;
        }

        if ($expr instanceof StringMethodCallNode) {
            return true;
        }

        if ($expr instanceof BinaryExpressionNode && $expr->operator === '+') {
            // If either side is a string, the whole expression is string concatenation
            return $this->isStringExpression($expr->left) || $this->isStringExpression($expr->right);
        }

        // You could add more sophisticated type checking here
        return false;
    }

    private function generateStringMethod(StringMethodCallNode $expr): string
    {
        // Generate the string expression first
        $stringExpr = $this->generateExpression($expr->stringExpression);

        switch ($expr->methodName) {
            case 'length':
                return "str_length({$stringExpr})";
            case 'toUpperCase':
                return "str_to_upper({$stringExpr})";
            case 'toLowerCase':
                return "str_to_lower({$stringExpr})";
            case 'trim':
                return "str_trim({$stringExpr})";
            case 'substring':
                if (count($expr->arguments) >= 2) {
                    $start = $this->generateExpression($expr->arguments[0]);
                    $length = $this->generateExpression($expr->arguments[1]);
                    return "str_substring({$stringExpr}, {$start}, {$length})";
                } elseif (count($expr->arguments) >= 1) {
                    $start = $this->generateExpression($expr->arguments[0]);
                    return "str_substring({$stringExpr}, {$start})";
                }
                return "str_substring({$stringExpr})";
            case 'indexOf':
                if (count($expr->arguments) >= 1) {
                    $searchStr = $this->generateExpression($expr->arguments[0]);
                    return "str_index_of({$stringExpr}, {$searchStr})";
                }
                return "str_index_of({$stringExpr})";
            case 'replace':
                if (count($expr->arguments) >= 2) {
                    $search = $this->generateExpression($expr->arguments[0]);
                    $replace = $this->generateExpression($expr->arguments[1]);
                    return "str_replace({$stringExpr}, {$search}, {$replace})";
                }
                return "str_replace({$stringExpr})";
            default:
                throw new \Exception("Unsupported string method: {$expr->methodName}");
        }
    }

    // Add visitor method
    public function visitStringMethodCall(StringMethodCallNode $node): mixed
    {
        return $this->generateStringMethod($node);
    }

    private function generateVariableDeclaration(VariableDeclarationNode $expr): string
    {
        // Variable declarations are handled in the method generation context
        return "/* Variable declaration: {$expr->variableName} */";
    }

    private function generateVariableAssignment(VariableAssignmentNode $expr): string
    {
        // Variable assignments are handled in the method generation context
        return "/* Variable assignment: {$expr->variableName} */";
    }

// Add visitor methods
    public function visitVariableDeclaration(VariableDeclarationNode $node): mixed
    {
        return $this->generateVariableDeclaration($node);
    }

    public function visitVariableAssignment(VariableAssignmentNode $node): mixed
    {
        return $this->generateVariableAssignment($node);
    }

    // Utility methods for output formatting
    private function addLine(string $line): void
    {
        $indent = str_repeat('    ', $this->indentLevel);
        $this->output[] = $indent . $line;
    }

    private function addComment(string $comment): void
    {
        $this->addLine("// {$comment}");
    }

    private function addEmptyLine(): void
    {
        $this->output[] = '';
    }

    private function increaseIndent(): void
    {
        $this->indentLevel++;
    }

    private function decreaseIndent(): void
    {
        $this->indentLevel = max(0, $this->indentLevel - 1);
    }

    public function getErrorHandler(): ErrorHandler
    {
        return $this->errorHandler;
    }
}