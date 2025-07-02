<?php

namespace OODSLToFLogic\Tests\Unit;

use PHPUnit\Framework\TestCase;
use OODSLToFLogic\Parser\Parser;
use OODSLToFLogic\CodeGen\FLogicGenerator;
use OODSLToFLogic\CodeGen\TypeMapper;
use OODSLToFLogic\AST\*;
use OODSLToFLogic\Utils\SourceLocation;

class TypeMapperTest extends TestCase
{
    private TypeMapper $typeMapper;

    protected function setUp(): void
    {
        $this->typeMapper = new TypeMapper();
    }

    public function testMapPrimitiveTypes(): void
    {
        $stringType = new TypeNode('string');
        $integerType = new TypeNode('integer');
        $booleanType = new TypeNode('boolean');
        $floatType = new TypeNode('float');

        $this->assertEquals('\\string', $this->typeMapper->mapType($stringType));
        $this->assertEquals('\\integer', $this->typeMapper->mapType($integerType));
        $this->assertEquals('\\boolean', $this->typeMapper->mapType($booleanType));
        $this->assertEquals('\\double', $this->typeMapper->mapType($floatType));
    }

    public function testMapCustomType(): void
    {
        $personType = new TypeNode('Person');
        $this->assertEquals('Person', $this->typeMapper->mapType($personType));
    }

    public function testGenerateSignature(): void
    {
        $nameType = new TypeNode('string');
        $signature = $this->typeMapper->generateSignature('name', $nameType);

        $this->assertEquals('name => \\string', $signature);
    }

    public function testGenerateSignatureWithConstraint(): void
    {
        $location = new SourceLocation(1, 1);
        $childrenType = new TypeNode('set', new TypeNode('Person'), null, $location);
        $constraint = new ConstraintNode(0, 5, $location);

        $signature = $this->typeMapper->generateSignature('children', $childrenType, $constraint);

        $this->assertEquals('children{0..5} => Person', $signature);
    }

    public function testMapOperators(): void
    {
        $this->assertEquals(',', $this->typeMapper->mapOperator('&&'));
        $this->assertEquals(';', $this->typeMapper->mapOperator('||'));
        $this->assertEquals('=', $this->typeMapper->mapOperator('=='));
        $this->assertEquals('\\=', $this->typeMapper->mapOperator('!='));
        $this->assertEquals('=<', $this->typeMapper->mapOperator('<='));
    }

    public function testGenerateLiteral(): void
    {
        $this->assertEquals('"John Doe"', $this->typeMapper->generateLiteral('John Doe', 'string'));
        $this->assertEquals('30', $this->typeMapper->generateLiteral(30, 'integer'));
        $this->assertEquals('\\true', $this->typeMapper->generateLiteral(true, 'boolean'));
        $this->assertEquals('\\false', $this->typeMapper->generateLiteral(false, 'boolean'));
    }

    public function testGenerateVariable(): void
    {
        $this->assertEquals('?Person', $this->typeMapper->generateVariable('person'));
        $this->assertEquals('?Name', $this->typeMapper->generateVariable('name'));
    }
}
