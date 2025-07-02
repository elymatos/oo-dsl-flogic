#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use hafriedlander\Peg\Compiler;
class ParserBuilder
{
    private string $grammarFile;
    private string $outputFile;

    public function __construct()
    {
        ini_set("memory_limit", "10240M");
        $this->grammarFile = __DIR__ . '/../src/Parser/Grammar.peg.inc';
        $this->outputFile = __DIR__ . '/../src/Parser/Generated/OODSLParser.php';
    }

    public function build(): void
    {
        echo "Building parser from grammar...\n";

        if (!file_exists($this->grammarFile)) {
            echo "Error: Grammar file not found: {$this->grammarFile}\n";
            exit(1);
        }

        // Ensure output directory exists
        $outputDir = dirname($this->outputFile);
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }
        try {
            // Compile the grammar
            $compiler = new Compiler();
            print_r('====='. $this->grammarFile ."\n");
            $grammar = file_get_contents($this->grammarFile);
            print_r('===== size = '. strlen($grammar) ."\n" . $grammar);
            $result = $compiler->compile($grammar);
            print_r("*** " . strlen($result) ."\n");

            // Write the generated parser
            file_put_contents($this->outputFile, $result);

            echo "Parser generated successfully: {$this->outputFile}\n";

        } catch (\Exception $e) {
            echo "Error generating parser: " . $e->getMessage() . "\n";
            exit(1);
        }
    }

    public function clean(): void
    {
        if (file_exists($this->outputFile)) {
            unlink($this->outputFile);
            echo "Cleaned generated parser file.\n";
        }
    }
}

// Handle command line arguments
$command = $argv[1] ?? 'build';

$builder = new ParserBuilder();

switch ($command) {
    case 'build':
        $builder->build();
        break;

    case 'clean':
        $builder->clean();
        break;

    case 'rebuild':
        $builder->clean();
        $builder->build();
        break;

    default:
        echo "Usage: php build-parser.php [build|clean|rebuild]\n";
        exit(1);
}