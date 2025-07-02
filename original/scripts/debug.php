<?php

require_once __DIR__ . '/../vendor/autoload.php';

use hafriedlander\Peg\Compiler;

echo "=== DEBUGGING GRAMMAR COMPILATION ===\n\n";

$grammarFile = __DIR__ . '/../src/Parser/Grammar.peg.inc';
$outputFile = __DIR__ . '/../src/Parser/Generated/PEGParserGenerated.php';

echo "1. Checking grammar file...\n";
if (!file_exists($grammarFile)) {
    echo "❌ Grammar file not found: {$grammarFile}\n";
    exit(1);
}

echo "✅ Grammar file exists\n";
$grammar = file_get_contents($grammarFile);
echo "Content:\n";
echo str_repeat('-', 40) . "\n";
echo $grammar;
echo str_repeat('-', 40) . "\n\n";

echo "2. Attempting compilation...\n";
try {
    $compiler = new Compiler();
    $result = $compiler->compile($grammar); // Pass content, not filename!

    if (empty($result)) {
        echo "❌ Compilation failed - no output generated\n";
        exit(1);
    }

    echo "✅ Compilation successful\n";
    echo "Generated " . strlen($result) . " bytes\n\n";

    echo "3. Checking generated content...\n";
    echo "First 30 lines of generated code:\n";
    echo str_repeat('-', 40) . "\n";

    $lines = explode("\n", $result);
    for ($i = 0; $i < min(30, count($lines)); $i++) {
        echo sprintf("%2d: %s\n", $i + 1, $lines[$i]);
    }
    echo str_repeat('-', 40) . "\n\n";

    echo "4. Looking for match_Program method...\n";
    if (strpos($result, 'match_Program') !== false) {
        echo "✅ match_Program method found in generated code\n";
    } else {
        echo "❌ match_Program method NOT found in generated code\n";
        echo "Available methods:\n";
        preg_match_all('/function\s+(match_\w+)/', $result, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $method) {
                echo "  - {$method}\n";
            }
        } else {
            echo "  No match_ methods found!\n";
        }
    }

    echo "\n5. Saving to output file (same as your build script)...\n";

    // Ensure output directory exists
    $outputDir = dirname($outputFile);
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true);
    }

    file_put_contents($outputFile, $result);
    echo "✅ File saved to: {$outputFile}\n";

    echo "\n6. Syntax check...\n";
    $output = [];
    $returnCode = 0;
    exec("php -l {$outputFile} 2>&1", $output, $returnCode);

    if ($returnCode === 0) {
        echo "✅ Syntax is valid\n";
    } else {
        echo "❌ Syntax errors:\n";
        foreach ($output as $line) {
            echo "   {$line}\n";
        }
    }

    echo "\n7. Class inspection...\n";
    if (file_exists($outputFile)) {
        require_once $outputFile;

        // Check what classes are available
        $classes = get_declared_classes();
        $pegClasses = array_filter($classes, function($class) {
            return strpos($class, 'OODSLParser') !== false;
        });

        if (!empty($pegClasses)) {
            foreach ($pegClasses as $className) {
                echo "✅ Found class: {$className}\n";

                $reflection = new ReflectionClass($className);
                $methods = $reflection->getMethods();

                echo "Available methods in {$className}:\n";
                foreach ($methods as $method) {
                    if (strpos($method->getName(), 'match_') === 0) {
                        echo "  ✓ " . $method->getName() . "\n";
                    }
                }
            }
        } else {
            echo "❌ No OODSLParser class found\n";
            echo "Available classes containing 'Parser':\n";
            foreach ($classes as $class) {
                if (stripos($class, 'parser') !== false) {
                    echo "  - {$class}\n";
                }
            }
        }
    }

} catch (Exception $e) {
    echo "❌ Error during compilation: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}