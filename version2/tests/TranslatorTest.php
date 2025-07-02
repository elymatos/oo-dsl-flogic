<?php

namespace FLogicDSL\Tests;

use PHPUnit\Framework\TestCase;
use FLogicDSL\Parser\OODSLParser;
use FLogicDSL\Translator\FLogicTranslator;
use FLogicDSL\Translator\TranslationContext;

class TranslatorTest extends TestCase
{
    private function parseAndTranslate(string $dsl): string
    {
        $parser = new OODSLParser($dsl);
        $ast = $parser->match_Program();
        $this->assertNotNull($ast, "Failed to parse DSL");

        $context = new TranslationContext();
        $translator = new FLogicTranslator($context);
        return $translator->translate($ast);
    }

    public function testSimpleClassTranslation()
    {
        $dsl = '
        class Person {
            string name;
            integer age;
        }
        ';

        $flogic = $this->parseAndTranslate($dsl);

        $this->assertStringContains('Person[name => string, age => integer]', $flogic);
    }

    public function testObjectTranslation()
    {
        $dsl = '
        class Person {
            string name;
        }
        
        object John : Person {
            name = "John Doe";
        }
        ';

        $flogic = $this->parseAndTranslate($dsl);

        $this->assertStringContains('John:Person', $flogic);
        $this->assertStringContains('John[name -> "John Doe"]', $flogic);
    }

    public function testInheritanceTranslation()
    {
        $dsl = '
        class Animal {
            string name;
        }
        
        class Dog inherits from Animal {
            string breed;
        }
        ';

        $flogic = $this->parseAndTranslate($dsl);

        $this->assertStringContains('Dog::Animal', $flogic);
    }

    public function testRuleTranslation()
    {
        $dsl = '
        class Person {
            integer age;
        }
        
        rule Adult {
            if (Person.age >= 18) {
                Person.isAdult = true;
            }
        }
        ';

        $flogic = $this->parseAndTranslate($dsl);

        $this->assertStringContains('@!{Adult}', $flogic);
        $this->assertStringContains('?Person[isAdult -> true]', $flogic);
        $this->assertStringContains('?Age >= 18', $flogic);
    }

    public function testCollectionTranslation()
    {
        $dsl = '
        class Family {
            set<Person> children;
        }
        
        object SmithFamily : Family {
            children += {alice, bob};
        }
        ';

        $flogic = $this->parseAndTranslate($dsl);

        $this->assertStringContains('children *=> Person', $flogic);
        $this->assertStringContains('children -> {alice, bob}', $flogic);
    }
}

