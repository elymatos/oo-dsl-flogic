<?php

namespace OODSLToFLogic\Tests\Unit;

use PHPUnit\Framework\TestCase;
use OODSLToFLogic\Parser\Parser;
use OODSLToFLogic\CodeGen\FLogicGenerator;
use OODSLToFLogic\CodeGen\TypeMapper;
use OODSLToFLogic\AST\*;
use OODSLToFLogic\Utils\SourceLocation;

class IntegrationTest extends TestCase
{
    public function testCompleteCompilation(): void
    {
        $source = '
            class Person {
                string name;
                integer age;
                boolean isAdult();
            }
            
            object John : Person {
                name = "John Doe";
                age = 30;
            }
            
            method Person.isAdult() returns boolean {
                return this.age >= 18;
            }
        ';

        $parser = new Parser();
        $generator = new FLogicGenerator();

        $ast = $parser->parse($source);
        $this->assertNotNull($ast);
        $this->assertFalse($parser->hasErrors());

        $flogicCode = $generator->generate($ast);
        $this->assertNotEmpty($flogicCode);

        // Verify key elements are present
        $this->assertStringContainsString('Person[|', $flogicCode);
        $this->assertStringContainsString('John:Person.', $flogicCode);
        $this->assertStringContainsString('John[name -> "John Doe"].', $flogicCode);
        $this->assertStringContainsString('?Obj:Person[isAdult()', $flogicCode);
    }
}