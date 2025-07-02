<?php
// bin/generate-parser.php
#!/usr/bin/env php

require_once __DIR__ . '/../vendor/autoload.php';

use hafriedlander\Peg\Compiler;

echo "Parser Generator\n";
echo "================\n\n";

try {
    $grammarFile = __DIR__ . '/../src/Grammar/OODSLGrammar.peg';
    $outputFile = __DIR__ . '/../src/Parser/OODSLParser.php';

    // Ensure output directory exists
    $outputDir = dirname($outputFile);
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true);
        echo "Created directory: $outputDir\n";
    }

    echo "Compiling grammar from: $grammarFile\n";
    echo "Output to: $outputFile\n\n";

    if (!file_exists($grammarFile)) {
        throw new Exception("Grammar file not found: $grammarFile");
    }

    // Compile using PEG compiler
    $compiler = new Compiler();
    $grammar = file_get_contents($grammarFile);

    echo "Grammar size: " . strlen($grammar) . " bytes\n";
    echo "Compiling...\n";

    $result = $compiler->compile($grammar);

    if (empty($result)) {
        throw new Exception("Compilation failed - no output generated");
    }

    echo "✅ Grammar compiled successfully!\n";
    echo "Generated " . strlen($result) . " bytes\n";

    file_put_contents($outputFile, $result);

    echo "Output written to: $outputFile\n";

    // Validate syntax
    echo "Validating generated PHP syntax...\n";
    $output = [];
    $returnCode = 0;
    exec("php -l \"$outputFile\" 2>&1", $output, $returnCode);

    if ($returnCode !== 0) {
        echo "❌ Syntax error in generated file:\n";
        foreach ($output as $line) {
            echo "   $line\n";
        }
        throw new Exception("Generated file has syntax errors");
    }

    echo "✅ Generated file syntax is valid\n";

    // Check for expected methods
    $content = file_get_contents($outputFile);
    if (strpos($content, 'match_Program') !== false) {
        echo "✅ match_Program method found in output\n";
    } else {
        echo "⚠️  match_Program method not found - checking content...\n";
        echo "First 10 lines of generated file:\n";
        $lines = file($outputFile);
        for ($i = 0; $i < min(10, count($lines)); $i++) {
            echo sprintf("%2d: %s", $i + 1, $lines[$i]);
        }
    }

    echo "\n✅ Parser generation complete!\n";
    echo "Next step: php bin/test-parser.php\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}



