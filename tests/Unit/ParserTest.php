<?php

<?php

namespace OODSLToFLogic\Tests\Unit;

use PHPUnit\Framework\TestCase;
use OODSLToFLogic\Parser\Parser;
use OODSLToFLogic\CodeGen\FLogicGenerator;
use OODSLToFLogic\CodeGen\TypeMapper;
use OODSLToFLogic\AST\*;
use OODSLToFLogic\Utils\SourceLocation;

class ParserTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testParseSimpleClass(): void
    {
        $source = '
            class Person {
                string name;
                integer age;
            }
        ';

        $ast = $this->parser->parse($source);

        $this->assertInstanceOf(ProgramNode::class, $ast);
        $this->assertCount(1, $ast->statements);

        $classNode = $ast->statements[0];
        $this->assertInstanceOf(ClassNode::class, $classNode);
        $this->assertEquals('Person', $classNode->name);
        $this->assertNull($classNode->parentClass);
        $this->assertCount(2, $classNode->properties);
    }

    public function testParseClassWithInheritance(): void
    {
        $source = '
            class Employee inherits from Person {
                string employeeId;
            }
        ';

        $ast = $this->parser->parse($source);
        $classNode = $ast->statements[0];

        $this->assertEquals('Employee', $classNode->name);
        $this->assertEquals('Person', $classNode->parentClass);
        $this->assertFalse($classNode->structuralOnly);
    }

    public function testParseStructuralInheritance(): void
    {
        $source = '
            class Student inherits structure from Person {
                string studentId;
            }
        ';

        $ast = $this->parser->parse($source);
        $classNode = $ast->statements[0];

        $this->assertTrue($classNode->structuralOnly);
    }

    public function testParseObjectDefinition(): void
    {
        $source = '
            object John : Person {
                name = "John Doe";
                age = 30;
            }
        ';

        $ast = $this->parser->parse($source);
        $objectNode = $ast->statements[0];

        $this->assertInstanceOf(ObjectNode::class, $objectNode);
        $this->assertEquals('John', $objectNode->name);
        $this->assertEquals('Person', $objectNode->className);
        $this->assertCount(2, $objectNode->assignments);
    }

    public function testParseMethodDefinition(): void
    {
        $source = '
            method Person.isAdult() returns boolean {
                return this.age >= 18;
            }
        ';

        $ast = $this->parser->parse($source);
        $methodNode = $ast->statements[0];

        $this->assertInstanceOf(MethodNode::class, $methodNode);
        $this->assertEquals('Person.isAdult', $methodNode->name);
        $this->assertFalse($methodNode->isSignatureOnly);
        $this->assertNotNull($methodNode->body);
    }

    public function testParseRuleDefinition(): void
    {
        $source = '
            rule AdultRule {
                if (Person.age >= 18) {
                    Person.isAdult = true;
                }
            }
        ';

        $ast = $this->parser->parse($source);
        $ruleNode = $ast->statements[0];

        $this->assertInstanceOf(RuleNode::class, $ruleNode);
        $this->assertEquals('AdultRule', $ruleNode->name);
        $this->assertNotNull($ruleNode->condition);
        $this->assertNotNull($ruleNode->conclusion);
    }
}