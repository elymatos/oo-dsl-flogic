<?php

require_once __DIR__ . '/../vendor/autoload.php';

use hafriedlander\Peg\Compiler;

echo "🔨 Building PEG Parser with smuuf/php-peg (hafriedlander-compatible API)...\n";

try {
    $compiler = new Compiler();

    echo "🔍 Available methods in Compiler class:\n";
    $methods = get_class_methods($compiler);
    foreach ($methods as $method) {
        echo "  - {$method}()\n";
    }

    $grammarFile = __DIR__ . '/../src/Parser/Grammar.peg.inc';
    $outputFile = __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

    // Check if grammar file exists
    if (!file_exists($grammarFile)) {
        echo "⚠️  Grammar file not found: {$grammarFile}\n";
        exit(1);
    }

    echo "📄 Input: {$grammarFile}\n";
    echo "📄 Output: {$outputFile}\n";

    // Try different possible methods
    if (method_exists($compiler, 'compileFile')) {
        echo "🔨 Using compileFile() method...\n";
        $compiler->compileFile($grammarFile, $outputFile);
    } elseif (method_exists($compiler, 'compile')) {
        echo "🔨 Using compile() method...\n";
        $grammar = file_get_contents($grammarFile);
        $result = $compiler->compile($grammar);
        file_put_contents($outputFile, $result);
    } elseif (method_exists($compiler, 'compileGrammar')) {
        echo "🔨 Using compileGrammar() method...\n";
        $grammar = file_get_contents($grammarFile);
        $result = $compiler->compileGrammar($grammar);
        file_put_contents($outputFile, $result);
    } else {
        throw new Exception("No suitable compile method found in Compiler class");
    }

    echo "✅ PEG Parser generated successfully!\n";

    if (file_exists($outputFile)) {
        $fileSize = filesize($outputFile);
        echo "📊 Generated file size: " . number_format($fileSize) . " bytes\n";
    }

} catch (Exception $e) {
    echo "❌ Error building PEG parser: " . $e->getMessage() . "\n";

    echo "\n🔍 Debugging info:\n";
    echo "Class: " . get_class($compiler) . "\n";
    echo "File: " . (new ReflectionClass($compiler))->getFileName() . "\n";

    exit(1);
}