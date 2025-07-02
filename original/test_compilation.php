<?php

require_once 'vendor/autoload.php';

use OODSLToFLogic\Parser\Parser;
use OODSLToFLogic\CodeGen\FLogicGenerator;

echo "OO-DSL to F-Logic Compiler Test\n";
echo "================================\n\n";

// Test 1: Simple class definition
echo "Test 1: Simple Class Definition\n";
echo "-------------------------------\n";

$source1 = '
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

echo "DSL Input:\n";
echo $source1 . "\n";

echo "Parsing...\n";
$ast = $parser->parse($source1);

if ($parser->hasErrors()) {
    echo "Parse Errors:\n";
    echo $parser->getErrorHandler()->formatErrors() . "\n";
} else {
    echo "Parse successful!\n\n";

    echo "Generating F-Logic code...\n";
    $flogicCode = $generator->generate($ast);

    if ($generator->getErrorHandler()->hasErrors()) {
        echo "Code Generation Errors:\n";
        echo $generator->getErrorHandler()->formatErrors() . "\n";
    } else {
        echo "F-Logic Output:\n";
        echo "---------------\n";
        echo $flogicCode . "\n";
    }
}

echo "\n" . str_repeat("=", 50) . "\n\n";

// Test 2: Inheritance example
echo "Test 2: Inheritance Example\n";
echo "---------------------------\n";

$source2 = '
class LivingBeing {
    string name;
    boolean isAlive;
}

class Person inherits from LivingBeing {
    integer age;
    set<Person> children;
}

object Mary : Person {
    name = "Mary Smith";
    age = 28;
    isAlive = true;
    children += {Alice, Bob};
}

rule AdultPerson {
    if (Person.age >= 18) {
        Person.isAdult = true;
    }
}
';

echo "DSL Input:\n";
echo $source2 . "\n";

echo "Parsing...\n";
$ast2 = $parser->parse($source2);

if ($parser->hasErrors()) {
    echo "Parse Errors:\n";
    echo $parser->getErrorHandler()->formatErrors() . "\n";
} else {
    echo "Parse successful!\n\n";

    echo "Generating F-Logic code...\n";
    $flogicCode2 = $generator->generate($ast2);

    if ($generator->getErrorHandler()->hasErrors()) {
        echo "Code Generation Errors:\n";
        echo $generator->getErrorHandler()->formatErrors() . "\n";
    } else {
        echo "F-Logic Output:\n";
        echo "---------------\n";
        echo $flogicCode2 . "\n";
    }
}

echo "\n" . str_repeat("=", 50) . "\n\n";

// Test 3: Error handling
echo "Test 3: Error Handling\n";
echo "----------------------\n";

$invalidSource = '
class Person {
    string name
    // Missing semicolon
    integer age;
}
';

echo "Invalid DSL Input (missing semicolon):\n";
echo $invalidSource . "\n";

echo "Parsing...\n";
$ast3 = $parser->parse($invalidSource);

if ($parser->hasErrors()) {
    echo "Parse Errors (expected):\n";
    echo $parser->getErrorHandler()->formatErrors() . "\n";
} else {
    echo "Unexpected: Parse succeeded\n";
}

echo "Test completed!\n";