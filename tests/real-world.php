
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "=== Debug Real-World DSL Test ===\n";

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
        echo "✅ Parse successful\n";

        // Debug what we actually got
        echo "Result type: " . gettype($result) . "\n";
        echo "Result class: " . (is_object($result) ? get_class($result) : 'not an object') . "\n";

        if (is_object($result)) {
            echo "Available methods: " . implode(', ', get_class_methods($result)) . "\n";

            if (method_exists($result, 'getStatements')) {
                $statements = $result->getStatements();
                echo "Statements type: " . gettype($statements) . "\n";
                echo "Statements count: " . (is_array($statements) ? count($statements) : 'not array') . "\n";

                if (is_array($statements)) {
                    foreach ($statements as $i => $stmt) {
                        echo "Statement $i type: " . gettype($stmt) . "\n";
                        if (is_object($stmt)) {
                            echo "Statement $i class: " . get_class($stmt) . "\n";
                            echo "Statement $i methods: " . implode(', ', get_class_methods($stmt)) . "\n";
                        } elseif (is_array($stmt)) {
                            echo "Statement $i is array with keys: " . implode(', ', array_keys($stmt)) . "\n";
                        }
                    }
                }
            }
        }
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}