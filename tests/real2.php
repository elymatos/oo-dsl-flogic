<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "=== Working Real-World DSL Test ===\n";

$complexExample = '
class Person {
    private string name;
    private int age;
    
    public getName() { }
    public setName(string name) { }
    public getAge() { }
    public setAge(int age) { }
}

class Employee extends Person {
    private string department;
    private float salary;
    
    public getDepartment() { }
    public setSalary(float salary) { }
    protected calculateBonus(float percentage) { }
}
';

try {
    $parser = new OODSLParser($complexExample);
    $result = $parser->match_Program();

    if ($result === false) {
        echo "❌ Parse failed\n";
    } else {
        echo "✅ Parse successful!\n";
        echo "Result type: " . gettype($result) . "\n";

        if (is_object($result)) {
            echo "Result class: " . get_class($result) . "\n";

            if (method_exists($result, 'getStatements')) {
                $statements = $result->getStatements();
                echo "Found " . count($statements) . " statements\n";

                foreach ($statements as $i => $statement) {
                    echo "\n--- Statement " . ($i + 1) . " ---\n";
                    echo "Type: " . gettype($statement) . "\n";

                    if (is_object($statement)) {
                        echo "Class: " . get_class($statement) . "\n";

                        if (method_exists($statement, 'getName')) {
                            echo "Name: " . $statement->getName() . "\n";
                        }

                        if (method_exists($statement, 'getParentClass')) {
                            $parent = $statement->getParentClass();
                            if ($parent) {
                                echo "Extends: " . $parent . "\n";
                            }
                        }

                        if (method_exists($statement, 'getAttributes')) {
                            $attributes = $statement->getAttributes();
                            echo "Attributes: " . count($attributes) . "\n";
                            foreach ($attributes as $attr) {
                                if (is_object($attr) && method_exists($attr, 'getName')) {
                                    $vis = method_exists($attr, 'getVisibility') ? $attr->getVisibility() : 'unknown';
                                    $type = method_exists($attr, 'getTypeHint') ? $attr->getTypeHint() : 'mixed';
                                    echo "  - $vis $type " . $attr->getName() . "\n";
                                }
                            }
                        }

                        if (method_exists($statement, 'getMethods')) {
                            $methods = $statement->getMethods();
                            echo "Methods: " . count($methods) . "\n";
                            foreach ($methods as $method) {
                                if (is_object($method) && method_exists($method, 'getName')) {
                                    $vis = method_exists($method, 'getVisibility') ? $method->getVisibility() : 'public';
                                    echo "  - $vis " . $method->getName() . "()\n";
                                }
                            }
                        }
                    } else {
                        echo "⚠️  Statement is not an object!\n";
                        if (is_array($statement)) {
                            echo "Keys: " . implode(', ', array_keys($statement)) . "\n";
                        }
                    }
                }
            } else {
                echo "⚠️  Result doesn't have getStatements() method\n";
                echo "Available methods: " . implode(', ', get_class_methods($result)) . "\n";
            }
        } else {
            echo "⚠️  Result is not an object\n";
            if (is_array($result)) {
                echo "Array keys: " . implode(', ', array_keys($result)) . "\n";
            }
        }
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Summary ===\n";
echo "If this test shows the parser is working correctly, then the issue was fixed!\n";
echo "If it still shows arrays instead of objects, we need to debug the grammar further.\n";