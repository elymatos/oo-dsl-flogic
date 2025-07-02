<?php

require_once __DIR__ . '/../vendor/autoload.php';

use hafriedlander\Peg\Compiler;

try {
    $grammarFile = __DIR__ . '/../src/Parser/Grammar.peg.inc';
    $outputFile = __DIR__ . '/../src/Parser/Generated/OODSLParser.php'; // Changed filename

    // Ensure output directory exists
    $outputDir = dirname($outputFile);
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true);
    }

    echo "Compiling grammar from: {$grammarFile}\n";

    if (!file_exists($grammarFile)) {
        throw new Exception("Grammar file not found: {$grammarFile}");
    }

    $compiler = new Compiler();
    $grammar = file_get_contents($grammarFile);
    $result = $compiler->compile($grammar);

    if (empty($result)) {
        throw new Exception("Compilation failed - no output generated");
    }

    echo "✅ Grammar compiled successfully!\n";
    echo "Generated " . strlen($result) . " bytes\n";

    file_put_contents($outputFile, $result);

    echo "Output: {$outputFile}\n";

    // Validate syntax
    $output = [];
    $returnCode = 0;
    exec("php -l {$outputFile} 2>&1", $output, $returnCode);

    if ($returnCode !== 0) {
        echo "❌ Syntax error in generated file:\n";
        foreach ($output as $line) {
            echo "   {$line}\n";
        }
        throw new Exception("Generated file has syntax errors");
    }

    echo "✅ Generated file syntax is valid\n";

    // Quick check for match methods
    $content = file_get_contents($outputFile);
    if (strpos($content, 'match_Program') !== false) {
        echo "✅ match_Program method found in output\n";
    } else {
        echo "❌ match_Program method still not found\n";
        echo "First 20 lines of generated file:\n";
        $lines = file($outputFile);
        for ($i = 0; $i < min(20, count($lines)); $i++) {
            echo sprintf("%2d: %s", $i + 1, $lines[$i]);
        }
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}