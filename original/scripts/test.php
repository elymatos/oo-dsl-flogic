<?php
// test_parser_fix.php - Script to test the parser fixes

require_once __DIR__ . '/vendor/autoload.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;
use OODSLToFLogic\CodeGen\FLogicGenerator;
use OODSLToFLogic\AST\ProgramNode;

// Test DSL code
$testCode = '// Simple test
class Vehicle {
    string brand;
    integer year;
}

object Honda : Vehicle {
    brand = "Honda";
    year = 2020;
}';

echo "Testing DSL Parser Fix\n";
echo "======================\n\n";

echo "Input DSL code:\n";
echo $testCode . "\n\n";

try {
    // Parse the code
    echo "1. Parsing with OODSLParser...\n";
    $parser = new OODSLParser($testCode);
    $parser->currentFilename = 'test.oodsl';

    $result = $parser->match_Program();

    if ($result === false) {
        echo "❌ Parse failed!\n";
        exit(1);
    }

    echo "✅ Parse successful!\n";
    echo "Result type: " . (is_object($result) ? get_class($result) : gettype($result)) . "\n\n";

    // Check if we got a ProgramNode
    if ($result instanceof ProgramNode) {
        echo "✅ Got ProgramNode directly!\n";
        $programNode = $result;
    } else {
        echo "⚠️  Got " . gettype($result) . ", converting to ProgramNode...\n";

        // Simulate the CompilerCommand conversion logic
        $location = new \OODSLToFLogic\Utils\SourceLocation(1, 1, 'test');
        $statements = [];

        if (is_array($result)) {
            foreach ($result as $item) {
                if (is_object($item)) {
                    $statements[] = $item;
                } elseif (is_array($item)) {
                    foreach ($item as $subItem) {
                        if (is_object($subItem)) {
                            $statements[] = $subItem;
                        }
                    }
                }
            }
        }

        $programNode = new ProgramNode($statements, $location);
    }

    echo "Program has " . count($programNode->getStatements()) . " statements\n\n";

    // List the statements
    echo "2. Analyzing statements:\n";
    foreach ($programNode->getStatements() as $i => $statement) {
        echo "   Statement " . ($i + 1) . ": " . get_class($statement);
        if (method_exists($statement, 'getName')) {
            echo " (" . $statement->getName() . ")";
        }
        echo "\n";
    }
    echo "\n";

    // Generate F-Logic code
    echo "3. Generating F-Logic code...\n";
    $generator = new FLogicGenerator();
    $flogicCode = $generator->generate($programNode);

    echo "✅ F-Logic generation successful!\n\n";

    echo "Generated F-Logic code:\n";
    echo "========================\n";
    echo $flogicCode;
    echo "========================\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

echo "\n✅ Test completed successfully!\n";