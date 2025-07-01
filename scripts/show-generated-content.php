<?php

$generatedFile = __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

echo "=== Generated File Content ===\n";
echo "File: {$generatedFile}\n\n";

if (file_exists($generatedFile)) {
    $content = file_get_contents($generatedFile);
    $lines = explode("\n", $content);

    echo "Total lines: " . count($lines) . "\n";
    echo "File size: " . strlen($content) . " bytes\n\n";

    // Show first 15 lines with line numbers
    echo "=== First 15 lines ===\n";
    for ($i = 0; $i < min(15, count($lines)); $i++) {
        $lineNum = $i + 1;
        $line = $lines[$i];
        echo sprintf("%2d: %s\n", $lineNum, $line);
    }

    // Show around line 10 where the error occurs
    echo "\n=== Lines 5-15 (around error) ===\n";
    for ($i = 4; $i < min(15, count($lines)); $i++) {
        $lineNum = $i + 1;
        $line = $lines[$i];
        $marker = ($lineNum == 10) ? " <-- ERROR HERE" : "";
        echo sprintf("%2d: %s%s\n", $lineNum, $line, $marker);
    }

} else {
    echo "❌ Generated file doesn't exist!\n";
}