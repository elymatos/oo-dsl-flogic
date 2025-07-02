<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

use OODSLToFLogic\Parser\SimpleParser;
use OODSLToFLogic\Parser\Generated\OODSLParser;

echo "Testing SimpleParser:\n";
try {
    $simpleParser = new SimpleParser();
    echo "✅ SimpleParser created successfully\n";
    echo "Type: " . get_class($simpleParser) . "\n";
} catch (Exception $e) {
    echo "❌ SimpleParser error: " . $e->getMessage() . "\n";
}

echo "\nTesting PEGParser:\n";
try {
    $pegParser = new OODSLParser('class TestClass { }');
    echo "✅ PEGParser created successfully\n";
    echo "Type: " . get_class($pegParser) . "\n";

    // Test parsing
    echo "Attempting to parse: 'class TestClass { }'\n";
    $result = $pegParser->match_Program();

    if ($result !== false) {
        echo "✅ Parse successful\n";
        echo "Result type: " . gettype($result) . "\n";

        if (is_object($result)) {
            echo "Result class: " . get_class($result) . "\n";
            // If it's a ProgramNode, show its structure
            if (method_exists($result, 'getStatements')) {
                $statements = $result->getStatements();
                echo "Number of statements: " . count($statements) . "\n";
            }
        } else {
            echo "Result: " . print_r($result, true) . "\n";
        }
    } else {
        echo "❌ Parse failed\n";
        echo "Parser position: " . $pegParser->pos . "\n";
        echo "Input length: " . strlen($pegParser->string) . "\n";
    }

} catch (Error $e) {
    echo "❌ PEGParser fatal error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Exception $e) {
    echo "❌ PEGParser error: " . $e->getMessage() . "\n";
}