<?php

require_once __DIR__ . '/../vendor/autoload.php';

use hafriedlander\Peg\Compiler;

try {
    $grammarFile = __DIR__ . '/../src/Parser/Grammar.peg.inc';
    $outputFile = __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

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

    print_r($result);

    if (empty($result)) {
        throw new Exception("Compilation failed - no output generated");
    }

//    // Add namespace to the generated result
//    $namespacedResult = "<?php\n\nnamespace OODSLToFLogic\\Parser\\Generated;\n\n" .
//        "use hafriedlander\\Peg\\Parser;\n" .
//        "use OODSLToFLogic\\AST\\ProgramNode;\n" .
//        "use OODSLToFLogic\\AST\\ClassNode;\n" .
//        "use OODSLToFLogic\\Utils\\SourceLocation;\n\n" .
//        substr($result, 5); // Remove "<?php" from beginning
//
    //file_put_contents($outputFile, $namespacedResult);
    file_put_contents($outputFile, $result);

    echo "✅ Parser compiled successfully!\n";
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

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}