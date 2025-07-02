<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "=== PHASE 1 TEST: Basic Literal Parsing ===\n\n";

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

// Phase 1 tests
test('hello', 'Exact match');
test('Hello', 'Case mismatch (should fail)');
test('hello world', 'Extra text (should succeed but not consume all)');
test('hi', 'Wrong word (should fail)');
test('', 'Empty input (should fail)');

echo "=== Phase 1 Complete ===\n";
echo "If all expected results are correct, proceed to Phase 2\n";