<?php

namespace OODSLToFLogic\AST;

/**
 * Visitor pattern interface for AST traversal
 */
interface NodeVisitor
{
    public function visitProgram(ProgramNode $node): mixed;
    public function visitClass(ClassNode $node): mixed;
    public function visitObject(ObjectNode $node): mixed;
    public function visitMethod(MethodNode $node): mixed;
    public function visitProperty(PropertyNode $node): mixed;
    public function visitRule(RuleNode $node): mixed;
    public function visitType(TypeNode $node): mixed;
    public function visitExpression(ExpressionNode $node): mixed;
}