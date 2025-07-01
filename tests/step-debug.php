<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "=== Step-by-Step Debug ===\n";

// Test progressively more complex examples
$testCases = [
    'Simple class' => 'class TestClass { }',

    'Class with one attribute' => 'class TestClass { 
        private string name; 
    }',

    'Class with one method' => 'class TestClass { 
        public getName() { } 
    }',

    'Two simple classes' => 'class A { } class B { }',

    'Complex single class' => 'class Person {
        private string name;
        public getName() { }
    }',
];

foreach ($testCases as $name => $input) {
    echo "\n--- Testing: $name ---\n";
    echo "Input: " . str_replace(["\n", "    "], [" ", ""], trim($input)) . "\n";

    try {
        $parser = new OODSLParser($input);
        $result = $parser->match_Program();

        if ($result === false) {
            echo "❌ Parse failed\n";

            // Try to get more info about where it failed
            echo "Trying individual components...\n";

            // Test if it can at least recognize a class
            $classParser = new OODSLParser($input);
            $classResult = $classParser->match_ClassDefinition();
            if ($classResult !== false) {
                echo "  ✅ ClassDefinition matches\n";
            } else {
                echo "  ❌ ClassDefinition fails\n";
            }

        } else {
            echo "✅ Parse successful\n";
            echo "Result type: " . gettype($result) . "\n";
            if (is_object($result)) {
                echo "Result class: " . get_class($result) . "\n";
            }
        }

    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "\n";
    }
}