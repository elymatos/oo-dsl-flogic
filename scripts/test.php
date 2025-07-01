<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "=== PHASE 2 TEST: Identifiers and Literals ===\n\n";

function test($input, $description) {
    echo "Testing: {$description}\n";
    echo "Input: '{$input}'\n";

    try {
        $parser = new OODSLParser($input);
        $result = $parser->match_Program();

        if ($result !== false) {
            echo "✅ SUCCESS\n";
            echo "Result: " . print_r($result, true) . "\n";
        } else {
            echo "❌ FAILED - No match\n";
            echo "Parser stopped at position: " . $parser->pos . "\n";
        }
    } catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n";
    }

    echo str_repeat('-', 50) . "\n\n";
}

// Phase 2 tests
test('hello', 'Literal string');
test('Person', 'Simple identifier');
test('testClass', 'CamelCase identifier');
test('_private', 'Underscore identifier');
test('MyClass123', 'Identifier with numbers');
test('123Invalid', 'Invalid identifier (starts with number)');
test('class-name', 'Invalid identifier (contains hyphen)');
test('', 'Empty input');

echo "=== Phase 2 Complete ===\n";
echo "Expected results:\n";
echo "✅ hello, Person, testClass, _private, MyClass123\n";
echo "❌ 123Invalid, class-name, empty\n";
echo "\nIf results match expectations, proceed to Phase 3\n";