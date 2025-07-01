<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "=== Debug Parser Test ===\n";

try {
    $input = 'class TestClass { }';
    echo "Input: '$input'\n";

    $parser = new OODSLParser($input);
    echo "Parser created successfully\n";
    echo "Parser type: " . get_class($parser) . "\n";
    echo "Input length: " . strlen($parser->string) . "\n";

    // Try to parse step by step
    echo "\nTrying to parse Identifier...\n";
    $parser->pos = 6; // Skip "class "
    $identifierResult = $parser->match_Identifier();
    echo "Identifier result: " . var_export($identifierResult, true) . "\n";

    echo "\nTrying to parse full Program...\n";
    $parser->pos = 0; // Reset position
    $result = $parser->match_Program();

    echo "Parse result: " . var_export($result, true) . "\n";

} catch (Error $e) {
    echo "❌ Fatal error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}