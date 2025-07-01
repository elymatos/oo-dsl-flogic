<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "=== Comprehensive OO-DSL Parser Test ===\n";

$testCases = [
    // Simple class
    'class TestClass { }',

    // Class with inheritance
    'class Child extends Parent { }',

    // Class with attribute
    'class TestClass { 
        private string name; 
    }',

    // Class with method
    'class TestClass { 
        public getName() { } 
    }',

    // Class with method parameters
    'class TestClass { 
        public setName(string name) { } 
    }',

    // Complex class
    'class User extends Person { 
        private string email; 
        private int age;
        public getName() { }
        public setEmail(string email) { }
        protected validateAge(int age) { }
    }',
];

foreach ($testCases as $i => $input) {
    echo "\n--- Test Case " . ($i + 1) . " ---\n";
    echo "Input: " . trim($input) . "\n";

    try {
        $parser = new OODSLParser($input);
        $result = $parser->match_Program();

        if ($result === false) {
            echo "❌ Parse failed\n";
        } else {
            echo "✅ Parse successful\n";

            if (is_object($result) && method_exists($result, 'getStatements')) {
                $statements = $result->getStatements();
                echo "Statements found: " . count($statements) . "\n";

                foreach ($statements as $j => $stmt) {
                    if (is_object($stmt) && method_exists($stmt, 'getName')) {
                        echo "  Class: " . $stmt->getName();

                        if (method_exists($stmt, 'getParentClass') && $stmt->getParentClass()) {
                            echo " extends " . $stmt->getParentClass();
                        }

                        $attrs = method_exists($stmt, 'getAttributes') ? $stmt->getAttributes() : [];
                        $methods = method_exists($stmt, 'getMethods') ? $stmt->getMethods() : [];

                        echo " [" . count($attrs) . " attributes, " . count($methods) . " methods]\n";

                        foreach ($attrs as $attr) {
                            if (method_exists($attr, 'getName')) {
                                echo "    - Attribute: " . $attr->getName() . "\n";
                            }
                        }

                        foreach ($methods as $method) {
                            if (method_exists($method, 'getName')) {
                                echo "    - Method: " . $method->getName() . "()\n";
                            }
                        }
                    }
                }
            }
        }

    } catch (Error $e) {
        echo "❌ Fatal error: " . $e->getMessage() . "\n";
        echo "Line " . $e->getLine() . " in " . basename($e->getFile()) . "\n";
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "\n";
    }
}