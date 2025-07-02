<?php

namespace OODSLFLogic\CodeGen;

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

class FLogicGenerator implements NodeVisitor
{
    private array $output = [];
    private int $indentLevel = 0;
    private string $currentModule = 'main';
    private array $typeSignatures = [];
    private array $objectInstances = [];

    public function generate(ProgramNode $program): string
    {
        $this->output = [];
        $this->indentLevel = 0;

        // Visit the program node
        $program->accept($this);

        return implode("\n", $this->output);
    }

    public function visit(Node $node): mixed
    {
        $method = 'visit' . $this->getNodeTypeName($node);

        if (method_exists($this, $method)) {
            return $this->$method($node);
        }

        throw new \RuntimeException("No visitor method for node type: " . get_class($node));
    }

    private function getNodeTypeName(Node $node): string
    {
        $className = get_class($node);
        $parts = explode('\\', $className);
        return str_replace('Node', '', end($parts));
    }

    // Program structure visitors
    public function visitProgram(ProgramNode $node): void
    {
        $this->emit("% Generated F-Logic code from OO-DSL");
        $this->emit("% Generated at: " . date('Y-m-d H:i:s'));
        $this->emit("");

        foreach ($node->statements as $statement) {
            $statement->accept($this);
            $this->emit("");
        }

        // Emit collected type signatures at the end
        if (!empty($this->typeSignatures)) {
            $this->emit("% Type signatures");
            foreach ($this->typeSignatures as $signature) {
                $this->emit($signature);
            }
        }
    }

    public function visitModule(ModuleNode $node): void
    {
        $moduleName = $node->name->name;
        $this->currentModule = $moduleName;

        $this->emit("% Module: {$moduleName}");
        $this->emit("@{{$moduleName}}");

        foreach ($node->body as $statement) {
            $statement->accept($this);
        }
    }

    // Class visitors
    public function visitClass(ClassNode $node): void
    {
        $className = $node->name->name;

        $this->emit("% Class definition: {$className}");

        // Handle inheritance
        if ($node->inheritance) {
            $parentClass = $node->inheritance->parent->name;
            $this->emit("{$className}::{$parentClass}.");
        } else {
            $this->emit("{$className}::Object.");
        }

        // Collect field signatures
        $signatures = [];
        $methods = [];

        foreach ($node->body as $member) {
            if ($member instanceof FieldNode) {
                $signatures[] = $this->generateFieldSignature($member);
            } elseif ($member instanceof MethodSignatureNode) {
                $signatures[] = $this->generateMethodSignature($member);
            } elseif ($member instanceof MethodNode) {
                $methods[] = $member;
            }
        }

        // Emit class signature
        if (!empty($signatures)) {
            $signatureStr = implode(",\n       ", $signatures);
            $this->emit("{$className}[|{$signatureStr}|].");
        }

        // Process method definitions
        foreach ($methods as $method) {
            $method->accept($this);
        }
    }

    private function generateFieldSignature(FieldNode $field): string
    {
        $fieldName = $field->name->name;
        $typeStr = $this->generateTypeSignature($field->type, $field->constraint);

        return "{$fieldName} => {$typeStr}";
    }

    private function generateMethodSignature(MethodSignatureNode $method): string
    {
        $methodName = $method->name->name;
        $returnType = $this->generateTypeSignature($method->returnType);

        if (empty($method->parameters)) {
            return "{$methodName}() => {$returnType}";
        }

        $paramTypes = array_map(
            fn($param) => $this->generateTypeSignature($param->type),
            $method->parameters
        );

        $paramStr = implode(', ', $paramTypes);
        return "{$methodName}({$paramStr}) => {$returnType}";
    }

    private function generateTypeSignature(TypeNode $type, ?ConstraintNode $constraint = null): string
    {
        if ($type instanceof PrimitiveTypeNode) {
            return '\\' . $type->typeName;
        } elseif ($type instanceof UserTypeNode) {
            return $type->name->name;
        } elseif ($type instanceof CollectionTypeNode) {
            $elementType = $this->generateTypeSignature($type->elementType);
            $constraintStr = $constraint ? $this->generateConstraintString($constraint) : '';

            if ($type->collectionType === 'set') {
                return "{$elementType}{$constraintStr}";
            } elseif ($type->collectionType === 'list') {
                return "\\list";
            }
        }

        return "\\object";
    }

    private function generateConstraintString(ConstraintNode $constraint): string
    {
        if ($constraint->constraint instanceof RangeNode) {
            $range = $constraint->constraint;
            return "{{$range->min}..{$range->max}}";
        } elseif ($constraint->constraint instanceof IntegerNode) {
            $count = $constraint->constraint->value;
            return "{{$count}}";
        }

        return "";
    }

    // Object visitors
    public function visitObject(ObjectNode $node): void
    {
        $objectName = $node->name->name;
        $className = $node->className->name;

        $this->emit("% Object: {$objectName}");
        $this->emit("{$objectName}:{$className}.");

        foreach ($node->assignments as $assignment) {
            $this->visitObjectAssignment($assignment, $objectName);
        }
    }

    private function visitObjectAssignment(AssignmentNode $assignment, string $objectName): void
    {
        $fieldName = $assignment->target->name;
        $operator = $assignment->operator;

        if ($assignment->value instanceof SetLiteralNode) {
            // Handle set assignments
            foreach ($assignment->value->elements as $element) {
                $value = $this->generateExpressionValue($element);
                $this->emit("{$objectName}[{$fieldName} -> {$value}].");
            }
        } elseif ($assignment->value instanceof BooleanNode && $assignment->value->value === true) {
            // Handle boolean true as frame attribute without value
            $this->emit("{$objectName}[{$fieldName}].");
        } else {
            $value = $this->generateExpressionValue($assignment->value);
            $this->emit("{$objectName}[{$fieldName} -> {$value}].");
        }
    }

    // Method visitors
    public function visitMethod(MethodNode $node): void
    {
        $qualifiedName = $node->name->toString();
        $parts = explode('.', $qualifiedName);
        $className = $parts[0];
        $methodName = $parts[1];

        $this->emit("% Method implementation: {$qualifiedName}");

        if (empty($node->parameters)) {
            $this->emit("?P:{$className}[{$methodName}() -> ?Result] :-");
        } else {
            $paramVars = array_map(fn($i) => "?P{$i}", range(1, count($node->parameters)));
            $paramStr = implode(', ', $paramVars);
            $this->emit("?P:{$className}[{$methodName}({$paramStr}) -> ?Result] :-");
        }

        $this->indentLevel++;
        $this->visitMethodBody($node->body);
        $this->indentLevel--;
    }

    private function visitMethodBody(BlockNode $body): void
    {
        foreach ($body->statements as $statement) {
            if ($statement instanceof ReturnNode) {
                $value = $this->generateExpressionValue($statement->expression);
                $this->emit("?Result \\is {$value}.");
            } else {
                $statement->accept($this);
            }
        }
    }

    // Rule visitors
    public function visitRule(RuleNode $node): void
    {
        $ruleName = $node->name->name;

        $this->emit("% Rule: {$ruleName}");
        $this->emit("@!{{$ruleName}}");

        if ($node->body instanceof IfNode) {
            $this->visitRuleIf($node->body);
        } else {
            $node->body->accept($this);
        }
    }

    private function visitRuleIf(IfNode $ifNode): void
    {
        // Generate rule head and body
        $head = $this->generateRuleHead($ifNode->thenBlock);
        $conditions = $this->generateRuleConditions($ifNode->condition);

        $this->emit("{$head} :-");
        $this->indentLevel++;
        foreach ($conditions as $condition) {
            $this->emit($condition . ",");
        }
        // Remove trailing comma from last condition
        if (!empty($conditions)) {
            $lastLine = array_pop($this->output);
            $this->output[] = rtrim($lastLine, ',') . '.';
        }
        $this->indentLevel--;
    }

    private function generateRuleHead(BlockNode $thenBlock): string
    {
        // Extract the assignment from the then block
        foreach ($thenBlock->statements as $statement) {
            if ($statement instanceof ExpressionStatementNode &&
                $statement->expression instanceof AssignmentNode) {
                $assignment = $statement->expression;
                return $this->generateAssignmentHead($assignment);
            }
        }

        return "?P[unknown]";
    }

    private function generateAssignmentHead(AssignmentNode $assignment): string
    {
        if ($assignment->value instanceof BooleanNode && $assignment->value->value === true) {
            return "?P[{$assignment->target->name}]";
        }

        $value = $this->generateExpressionValue($assignment->value);
        return "?P[{$assignment->target->name} -> {$value}]";
    }

    private function generateRuleConditions(ExpressionNode $condition): array
    {
        $conditions = [];

        if ($condition instanceof BinaryOpNode) {
            if ($condition->operator === '&&' || $condition->operator === 'and') {
                $conditions = array_merge(
                    $this->generateRuleConditions($condition->left),
                    $this->generateRuleConditions($condition->right)
                );
            } else {
                $conditions[] = $this->generateConditionExpression($condition);
            }
        } else {
            $conditions[] = $this->generateConditionExpression($condition);
        }

        return $conditions;
    }

    private function generateConditionExpression(ExpressionNode $expr): string
    {
        if ($expr instanceof PropertyAccessNode) {
            $parts = $expr->name->parts;
            if (count($parts) === 2) {
                $obj = $parts[0]->name;
                $prop = $parts[1]->name;

                if ($obj === 'Person') {
                    return "?P:{$obj}[{$prop}]";
                } else {
                    return "?P[{$obj} -> ?{$obj}], ?{$obj}[{$prop}]";
                }
            }
        } elseif ($expr instanceof MethodCallNode) {
            $parts = $expr->name->parts;
            if (count($parts) === 2) {
                $obj = $parts[0]->name;
                $method = $parts[1]->name;
                return "?P:{$obj}[{$method}() -> \\true]";
            }
        } elseif ($expr instanceof BinaryOpNode && $expr->operator === '==') {
            $left = $this->generateExpressionValue($expr->left);
            $right = $this->generateExpressionValue($expr->right);
            return "{$left} = {$right}";
        }

        return $this->generateExpressionValue($expr);
    }

    // Query visitors
    public function visitQuery(QueryNode $node): void
    {
        $queryName = $node->name->name;
        $this->emit("% Query: {$queryName}");

        $target = $node->body->target->name;
        $condition = $this->generateConditionExpression($node->body->condition);

        $this->emit("?- {$condition}.");
    }

    // Expression value generation
    private function generateExpressionValue(ExpressionNode $expr): string
    {
        if ($expr instanceof StringNode) {
            return '"' . $expr->value . '"';
        } elseif ($expr instanceof IntegerNode) {
            return (string)$expr->value;
        } elseif ($expr instanceof FloatNode) {
            return (string)$expr->value;
        } elseif ($expr instanceof BooleanNode) {
            return $expr->value ? '\\true' : '\\false';
        } elseif ($expr instanceof IdentifierNode) {
            return $expr->name;
        } elseif ($expr instanceof PropertyAccessNode) {
            return $expr->name->toString();
        } elseif ($expr instanceof ThisNode) {
            return '?P';
        } elseif ($expr instanceof BinaryOpNode) {
            $left = $this->generateExpressionValue($expr->left);
            $right = $this->generateExpressionValue($expr->right);

            switch ($expr->operator) {
                case '+': return "{$left} + {$right}";
                case '-': return "{$left} - {$right}";
                case '*': return "{$left} * {$right}";
                case '/': return "{$left} / {$right}";
                case '==': return "{$left} = {$right}";
                case '!=': return "{$left} \\= {$right}";
                case '<': return "{$left} < {$right}";
                case '>': return "{$left} > {$right}";
                case '<=': return "{$left} =< {$right}";
                case '>=': return "{$left} >= {$right}";
                default: return "{$left} {$expr->operator} {$right}";
            }
        }

        return "unknown";
    }

    // Import/Export visitors
    public function visitImport(ImportNode $node): void
    {
        $moduleName = $node->module->toString();

        if ($node->imports) {
            $imports = array_map(fn($id) => $id->name, $node->imports);
            $importStr = implode(', ', $imports);
            $this->emit("\\import {$moduleName}.{{$importStr}}.");
        } else {
            $this->emit("\\import {$moduleName}.");
        }
    }

    public function visitExport(ExportNode $node): void
    {
        $exports = array_map(fn($id) => $id->name, $node->exports);
        $exportStr = implode(', ', $exports);
        $this->emit("\\export {$exportStr}.");
    }

    // Utility methods
    private function emit(string $line): void
    {
        $indent = str_repeat('    ', $this->indentLevel);
        $this->output[] = $indent . $line;
    }

    // Handle other node types
    public function visitParameter(ParameterNode $node): void {}
    public function visitConstraint(ConstraintNode $node): void {}
    public function visitRange(RangeNode $node): void {}
    public function visitInheritance(InheritanceNode $node): void {}
    public function visitField(FieldNode $node): void {}
    public function visitMethodSignature(MethodSignatureNode $node): void {}
    public function visitAssignment(AssignmentNode $node): void {}
    public function visitSelect(SelectNode $node): void {}
    public function visitIf(IfNode $node): void {}
    public function visitBlock(BlockNode $node): void {}
    public function visitReturn(ReturnNode $node): void {}
    public function visitExpressionStatement(ExpressionStatementNode $node): void {}
    public function visitBinaryOp(BinaryOpNode $node): void {}
    public function visitUnaryOp(UnaryOpNode $node): void {}
    public function visitMethodCall(MethodCallNode $node): void {}
    public function visitPropertyAccess(PropertyAccessNode $node): void {}
    public function visitQualifiedName(QualifiedNameNode $node): void {}
    public function visitString(StringNode $node): void {}
    public function visitInteger(IntegerNode $node): void {}
    public function visitFloat(FloatNode $node): void {}
    public function visitBoolean(BooleanNode $node): void {}
    public function visitSetLiteral(SetLiteralNode $node): void {}
    public function visitThis(ThisNode $node): void {}
    public function visitIdentifier(IdentifierNode $node): void {}
    public function visitPrimitiveType(PrimitiveTypeNode $node): void {}
    public function visitUserType(UserTypeNode $node): void {}
    public function visitCollectionType(CollectionTypeNode $node): void {}
}