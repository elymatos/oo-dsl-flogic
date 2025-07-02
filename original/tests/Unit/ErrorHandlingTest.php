<?php

namespace OODSLToFLogic\Tests\Unit;

use PHPUnit\Framework\TestCase;
use OODSLToFLogic\Parser\Parser;
use OODSLToFLogic\CodeGen\FLogicGenerator;
use OODSLToFLogic\CodeGen\TypeMapper;
use OODSLToFLogic\AST\*;
use OODSLToFLogic\Utils\SourceLocation;

class ErrorHandlingTest extends TestCase
{
    public function testParseErrorReporting(): void
    {
        $parser = new Parser();

        // Invalid syntax
        $source = 'class Person { string name }'; // Missing semicolon

        $ast = $parser->parse($source);

        $this->assertNull($ast);
        $this->assertTrue($parser->hasErrors());

        $errors = $parser->getErrorHandler()->getErrors();
        $this->assertNotEmpty($errors);
    }
}

