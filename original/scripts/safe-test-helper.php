<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

function testParser($input, $description, $shouldSucceed = true) {
    echo "Testing: {$description}\n";
    echo "Input: '{$input}'\n";
    echo "Expected: " . ($shouldSucceed ? "✅ SUCCESS" : "❌ FAIL") . "\n";

    try {
        $parser = new OODSLParser($input);
        $result = $parser->match_Program();

        if ($result !== false) {
            echo "Actual: ✅ SUCCESS\n";
            if ($shouldSucceed) {
                echo "✅ Test PASSED\n";
            } else {
                echo "❌ Test FAILED (expected failure but got success)\n";
            }

            // Show the result type and structure
            if (is_object($result)) {
                echo "AST Node Type: " . get_class($result) . "\n";
                if (method_exists($result, 'getStatements')) {
                    echo "Number of statements: " . count($result->getStatements()) . "\n";
                }
            } else {
                echo "Result: " . print_r($result, true) . "\n";
            }
        } else {
            echo "Actual: ❌ FAILED\n";
            if (!$shouldSucceed) {
                echo "✅ Test PASSED\n";
            } else {
                echo "❌ Test FAILED (expected success but got failure)\n";
            }
        }
    } catch (Exception $e) {
        echo "Actual: ❌ ERROR: " . $e->getMessage() . "\n";
        if (!$shouldSucceed) {
            echo "✅ Test PASSED (error expected)\n";
        } else {
            echo "❌ Test FAILED (unexpected error)\n";
        }
    }

    echo str_repeat('-', 50) . "\n\n";
}

echo "=== PHASE 11 TEST: Complete AST Integration ===\n\n";

// Test complete examples that should generate proper AST nodes
testParser('class Person { 
    string name; 
    integer age; 
    boolean isAdult(); 
}', 'Complete class with properties and methods', true);

testParser('object john : Person { 
    name = "John Doe"; 
    age = 30; 
}', 'Complete object with assignments', true);

testParser('method Person.isAdult() returns boolean { 
    return this.age >= 18; 
}', 'Complete method definition', true);

testParser('rule AdultRule { 
    if (this.age >= 18) { 
        this.isAdult = true; 
    } 
}', 'Complete rule definition', true);

// Test inheritance
testParser('class Employee inherits from Person { 
    string employeeId; 
}', 'Class with inheritance', true);

testParser('class Student inherits structure from Person { 
    string studentId; 
}', 'Class with structure inheritance', true);

// Test constraints
testParser('class Person { 
    string name{1..1}; 
    integer age; 
}', 'Class with property constraints', true);

// Test method parameters
testParser('method Person.setAge(integer newAge) returns boolean { 
    return true; 
}', 'Method with parameters', true);

// Test complex rule
testParser('rule ComplexRule { 
    if (this.age >= 18 && this.isVegetarian == true) { 
        this.isHealthy = true; 
        this.canVote = true; 
    } 
}', 'Complex rule with multiple conditions and assignments', true);

// Backward compatibility
testParser('Person', 'Simple identifier', true);
testParser('hello', 'Simple literal', true);

echo "=== Phase 11 Summary ===\n";
echo "Expected: Complete AST nodes generated for all constructs\n";