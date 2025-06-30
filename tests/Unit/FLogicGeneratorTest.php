<?php

namespace OODSLToFLogic\Tests\Unit;

use PHPUnit\Framework\TestCase;
use OODSLToFLogic\Parser\Parser;
use OODSLToFLogic\CodeGen\FLogicGenerator;
use OODSLToFLogic\CodeGen\TypeMapper;
use OODSLToFLogic\AST\*;
use OODSLToFLogic\Utils\SourceLocation;

class FLogicGeneratorTest extends TestCase
{
    private FLogicGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new FLogicGenerator();
    }

    public function testGenerateSimpleClass(): void
    {
        $location = new SourceLocation(1, 1);
        $nameProperty = new PropertyNode(
            'name',
            new TypeNode('string'),
            null,
            $location
        );

        $classNode = new ClassNode(
            'Person',
            null,
            false,
            [$nameProperty],
            [],
            $location
        );

        $program = new ProgramNode([$classNode], $location);
        $flogicCode = $this->generator->generate($program);

        $this->assertStringContainsString('Person[|name => \\string|].', $flogicCode);
    }

    public function testGenerateClassWithInheritance(): void
    {
        $location = new SourceLocation(1, 1);
        $classNode = new ClassNode(
            'Employee',
            'Person',
            false,
            [],
            [],
            $location
        );

        $program = new ProgramNode([$classNode], $location);
        $flogicCode = $this->generator->generate($program);

        $this->assertStringContainsString('Employee::Person.', $flogicCode);
    }

    public function testGenerateObject(): void
    {
        $location = new SourceLocation(1, 1);
        $nameAssignment = new AssignmentNode(
            'name',
            '=',
            new LiteralNode('John Doe', 'string', $location),
            $location
        );

        $objectNode = new ObjectNode(
            'John',
            'Person',
            [$nameAssignment],
            $location
        );

        $program = new ProgramNode([$objectNode], $location);
        $flogicCode = $this->generator->generate($program);

        $this->assertStringContainsString('John:Person.', $flogicCode);
        $this->assertStringContainsString('John[name -> "John Doe"].', $flogicCode);
    }
}
