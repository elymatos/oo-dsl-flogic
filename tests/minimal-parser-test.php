
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "=== Full Parser Test ===\n";

$testCases = [
    'class TestClass { }',
    'class AnotherClass { }',
    // Later we can test multiple classes if needed
];

foreach ($testCases as $i => $input) {
    echo "\n--- Test Case " . ($i + 1) . " ---\n";
    echo "Input: '$input'\n";

    try {
        $parser = new OODSLParser($input);
        $result = $parser->match_Program();

        if ($result === false) {
            echo "❌ Parse failed\n";
        } else {
            echo "✅ Parse successful\n";
            echo "Result type: " . gettype($result) . "\n";

            if (is_object($result)) {
                echo "Result class: " . get_class($result) . "\n";

                // If it's a ProgramNode, show its structure
                if (method_exists($result, 'getStatements')) {
                    $statements = $result->getStatements();
                    echo "Number of statements: " . count($statements) . "\n";

                    foreach ($statements as $j => $stmt) {
                        if (is_object($stmt) && method_exists($stmt, 'getName')) {
                            echo "Statement $j: Class '" . $stmt->getName() . "'\n";
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