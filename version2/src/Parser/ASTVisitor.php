<?php
// src/Parser/ASTNode.php
namespace FLogicDSL\Parser;

/**
 * Visitor interface for AST traversal
 */
interface ASTVisitor
{
    public function visitProgram(ProgramNode $node);
    public function visitClassDeclaration(ClassDeclarationNode $node);
    public function visitPropertyDeclaration(PropertyDeclarationNode $node);
    public function visitMethod(MethodNode $node);
    public function visitObjectDeclaration(ObjectDeclarationNode $node);
    public function visitPropertyAssignment(PropertyAssignmentNode $node);
    public function visitRuleDeclaration(RuleDeclarationNode $node);
    public function visitChainedExpression(ChainedExpressionNode $node);
    public function visitMethodCall(MethodCallNode $node);
    public function visitLiteral(LiteralNode $node);
    public function visitSetExpression(SetExpressionNode $node);
    public function visitBinaryCondition(BinaryConditionNode $node);
    public function visitComparisonCondition(ComparisonConditionNode $node);
    public function visitAssignmentAction(AssignmentActionNode $node);
}