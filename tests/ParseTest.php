// tests/ParserTest.php
<?php

namespace FLogicDSL\Tests;

use PHPUnit\Framework\TestCase;
use FLogicDSL\Parser\OODSLParser;

class ParserTest extends TestCase
{
    public function testSimpleClassParsing()
    {
        $dsl = '
        class Person {
            string name;
            integer age;
        }
        ';

        $parser = new OODSLParser($dsl);
        $result = $parser->match_Program();

        $this->assertNotNull($result);
        $this->assertInstanceOf('FLogicDSL\Parser\ProgramNode', $result);
    }

    public function testObjectDeclaration()
    {
        $dsl = '
        class Person {
            string name;
        }
        
        object John : Person {
            name = "John Doe";
        }
        ';

        $parser = new OODSLParser($dsl);
        $result = $parser->match_Program();

        $this->assertNotNull($result);
    }

    public function testRuleDeclaration()
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

        $parser = new OODSLParser($dsl);
        $result = $parser->match_Program();

        $this->assertNotNull($result);
    }

    public function testInheritance()
    {
        $dsl = '
        class Animal {
            string name;
        }
        
        class Dog inherits from Animal {
            string breed;
        }
        ';

        $parser = new OODSLParser($dsl);
        $result = $parser->match_Program();

        $this->assertNotNull($result);
    }

    public function testMethodDeclaration()
    {
        $dsl = '
        class Person {
            integer age;
            boolean isAdult();
        }
        
        method Person.isAdult() returns boolean {
            return this.age >= 18;
        }
        ';

        $parser = new OODSLParser($dsl);
        $result = $parser->match_Program();

        $this->assertNotNull($result);
    }

    public function testCollectionTypes()
    {
        $dsl = '
        class Family {
            set<Person> children;
            string surname;
        }
        ';

        $parser = new OODSLParser($dsl);
        $result = $parser->match_Program();

        $this->assertNotNull($result);
    }

    public function testChainedPropertyAccess()
    {
        $dsl = '
        class Person {
            Person spouse;
            integer age;
        }
        
        rule SpouseAge {
            if (Person.spouse.age > 30) {
                Person.hasOlderSpouse = true;
            }
        }
        ';

        $parser = new OODSLParser($dsl);
        $result = $parser->match_Program();

        $this->assertNotNull($result);
    }
}
