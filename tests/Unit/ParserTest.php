<?php

namespace OODSLFLogic\Tests\Unit;

use PHPUnit\Framework\TestCase;
use OODSLFLogic\Parser\Parser;
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

class ParserTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testSimpleClassParsing(): void
    {
        $input = '
        class Person {
            string name;
            integer age;
        }
        ';

        $ast = $this->parser->parse($input);

        $this->assertInstanceOf(ProgramNode::class, $ast);
        $this->assertCount(1, $ast->statements);

        $classNode = $ast->statements[0];
        $this->assertInstanceOf(ClassNode::class, $classNode);
        $this->assertEquals('Person', $classNode->name->name);
        $this->assertCount(2, $classNode->body);
    }

    public function testClassWithInheritance(): void
    {
        $input = '
        class Student inherits from Person {
            string studentId;
        }
        ';

        $ast = $this->parser->parse($input);
        $classNode = $ast->statements[0];

        $this->assertInstanceOf(ClassNode::class, $classNode);
        $this->assertEquals('Student', $classNode->name->name);
        $this->assertNotNull($classNode->inheritance);
        $this->assertEquals('Person', $classNode->inheritance->parent->name);
    }

    public function testObjectCreation(): void
    {
        $input = '
        object John : Person {
            name = "John Doe";
            age = 30;
        }
        ';

        $ast = $this->parser->parse($input);
        $objectNode = $ast->statements[0];

        $this->assertInstanceOf(ObjectNode::class, $objectNode);
        $this->assertEquals('John', $objectNode->name->name);
        $this->assertEquals('Person', $objectNode->className->name);
        $this->assertCount(2, $objectNode->assignments);
    }

    public function testMethodDefinition(): void
    {
        $input = '
        method Person.isAdult() returns boolean {
            return this.age >= 18;
        }
        ';

        $ast = $this->parser->parse($input);
        $methodNode = $ast->statements[0];

        $this->assertInstanceOf(MethodNode::class, $methodNode);
        $this->assertEquals('Person.isAdult', $methodNode->name->toString());
        $this->assertEmpty($methodNode->parameters);
        $this->assertNotNull($methodNode->returnType);
    }

    public function testRuleDefinition(): void
    {
        $input = '
        rule AdultPerson {
            if (Person.age >= 18) {
                Person.isAdult = true;
            }
        }
        ';

        $ast = $this->parser->parse($input);
        $ruleNode = $ast->statements[0];

        $this->assertInstanceOf(RuleNode::class, $ruleNode);
        $this->assertEquals('AdultPerson', $ruleNode->name->name);
        $this->assertInstanceOf(IfNode::class, $ruleNode->body);
    }

    public function testQueryDefinition(): void
    {
        $input = '
        query FindAdults {
            select Person where Person.isAdult == true;
        }
        ';

        $ast = $this->parser->parse($input);
        $queryNode = $ast->statements[0];

        $this->assertInstanceOf(QueryNode::class, $queryNode);
        $this->assertEquals('FindAdults', $queryNode->name->name);
        $this->assertInstanceOf(SelectNode::class, $queryNode->body);
    }

    public function testCollectionTypes(): void
    {
        $input = '
        class Family {
            set<Person>{2..10} members;
            list<string> addresses;
        }
        ';

        $ast = $this->parser->parse($input);
        $classNode = $ast->statements[0];

        $this->assertInstanceOf(ClassNode::class, $classNode);
        $this->assertCount(2, $classNode->body);

        $setField = $classNode->body[0];
        $this->assertInstanceOf(FieldNode::class, $setField);
        $this->assertInstanceOf(CollectionTypeNode::class, $setField->type);
        $this->assertEquals('set', $setField->type->collectionType);
    }

    public function testModuleDefinition(): void
    {
        $input = '
        module TestModule {
            class Person {
                string name;
            }
            
            export Person;
        }
        ';

        $ast = $this->parser->parse($input);
        $moduleNode = $ast->statements[0];

        $this->assertInstanceOf(ModuleNode::class, $moduleNode);
        $this->assertEquals('TestModule', $moduleNode->name->name);
        $this->assertCount(2, $moduleNode->body);
    }

    public function testInvalidSyntax(): void
    {
        $input = 'invalid syntax here';

        $errors = $this->parser->validateSyntax($input);

        $this->assertNotEmpty($errors);
        $this->assertEquals('syntax_error', $errors[0]['type']);
    }

    public function testComplexExpression(): void
    {
        $input = '
        rule ComplexRule {
            if (Person.age >= 18 && Person.isVegetarian && Person.spouse.isVegetarian) {
                Person.isHappy = true;
            }
        }
        ';

        $ast = $this->parser->parse($input);
        $ruleNode = $ast->statements[0];

        $this->assertInstanceOf(RuleNode::class, $ruleNode);
        $ifNode = $ruleNode->body;
        $this->assertInstanceOf(IfNode::class, $ifNode);
        $this->assertInstanceOf(ExpressionNode::class, $ifNode->condition);
    }

    public function testMethodWithParameters(): void
    {
        $input = '
        method Person.calculateAge(integer birthYear) returns integer {
            return 2025 - birthYear;
        }
        ';

        $ast = $this->parser->parse($input);
        $methodNode = $ast->statements[0];

        $this->assertInstanceOf(MethodNode::class, $methodNode);
        $this->assertCount(1, $methodNode->parameters);

        $param = $methodNode->parameters[0];
        $this->assertInstanceOf(ParameterNode::class, $param);
        $this->assertEquals('birthYear', $param->name->name);
    }
}