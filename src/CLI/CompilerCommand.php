<?php

namespace OODSLToFLogic\CLI;

use OODSLToFLogic\Parser\Generated\OODSLParser; // Now matches the filename
use OODSLToFLogic\CodeGen\FLogicGenerator;
use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\Utils\SourceLocation;
use Exception;

class CompilerCommand
{
    private $options = [
        'output' => null,
        'debug' => false,
        'help' => false,
    ];

    public function run(array $argv): int
    {
        try {
            $this->parseArguments($argv);

            if ($this->options['help']) {
                $this->showHelp();
                return 0;
            }

            $inputFile = $this->getInputFile($argv);
            $outputFile = $this->getOutputFile($inputFile);

            return $this->compile($inputFile, $outputFile);

        } catch (Exception $e) {
            fwrite(STDERR, "Error: " . $e->getMessage() . "\n");
            return 1;
        }
    }

    private function parseArguments(array $argv): void
    {
        for ($i = 1; $i < count($argv); $i++) {
            $arg = $argv[$i];

            switch ($arg) {
                case '-h':
                case '--help':
                    $this->options['help'] = true;
                    break;

                case '-o':
                case '--output':
                    if (!isset($argv[$i + 1])) {
                        throw new Exception("Option {$arg} requires a value");
                    }
                    $this->options['output'] = $argv[++$i];
                    break;

                case '--debug':
                    $this->options['debug'] = true;
                    break;

                default:
                    if (str_starts_with($arg, '-')) {
                        throw new Exception("Unknown option: {$arg}");
                    }
                    // This is the input file, handled in getInputFile()
                    break;
            }
        }
    }

    private function getInputFile(array $argv): string
    {
        // Find the input file (non-option argument)
        for ($i = 1; $i < count($argv); $i++) {
            $arg = $argv[$i];

            // Skip options and their values
            if (str_starts_with($arg, '-')) {
                if (in_array($arg, ['-o', '--output'])) {
                    $i++; // Skip the option value
                }
                continue;
            }

            return $arg;
        }

        // No file provided, read from stdin
        return 'php://stdin';
    }

    private function getOutputFile(string $inputFile): string
    {
        // If output explicitly specified, use it
        if ($this->options['output']) {
            return $this->options['output'];
        }

        // If reading from stdin, output to stdout
        if ($inputFile === 'php://stdin') {
            return 'php://stdout';
        }

        // Generate .flr file from input file
        $pathInfo = pathinfo($inputFile);
        $baseName = $pathInfo['filename']; // filename without extension
        $directory = $pathInfo['dirname'];

        return $directory . DIRECTORY_SEPARATOR . $baseName . '.flr';
    }

    private function compile(string $inputFile, string $outputFile): int
    {
        try {
            // Read input
            if ($inputFile === 'php://stdin') {
                $input = stream_get_contents(STDIN);
            } else {
                if (!file_exists($inputFile)) {
                    throw new Exception("Input file not found: {$inputFile}");
                }
                $input = file_get_contents($inputFile);
            }

            if ($input === false || empty(trim($input))) {
                throw new Exception("No input provided or file is empty");
            }

            // Parse with PEG parser
            if ($this->options['debug']) {
                fwrite(STDERR, "Parsing input with OODSLParser...\n");
            }

            $parser = new OODSLParser($input);
            $ast = $parser->match_Program();

            if ($ast === false) {
                throw new Exception("Failed to parse input. Check DSL syntax.");
            }

            if ($this->options['debug']) {
                fwrite(STDERR, "Parse successful. AST type: " . (is_object($ast) ? get_class($ast) : gettype($ast)) . "\n");
            }

            // Fallback: if we get an array instead of ProgramNode, create one
            if (is_array($ast) && !($ast instanceof ProgramNode)) {
                if ($this->options['debug']) {
                    fwrite(STDERR, "Converting array result to ProgramNode...\n");
                }
                $location = new SourceLocation(1, 1);
                $ast = new ProgramNode([$ast], $location);
            }

            // Generate F-Logic code
            $generator = new FLogicGenerator();
            $flogicCode = $generator->generate($ast);

            // Write output
            if ($outputFile === 'php://stdout') {
                echo $flogicCode;
            } else {
                // Ensure output directory exists
                $outputDir = dirname($outputFile);
                if (!is_dir($outputDir)) {
                    if (!mkdir($outputDir, 0755, true)) {
                        throw new Exception("Could not create output directory: {$outputDir}");
                    }
                }

                if (file_put_contents($outputFile, $flogicCode) === false) {
                    throw new Exception("Could not write to output file: {$outputFile}");
                }

                if ($this->options['debug']) {
                    fwrite(STDERR, "Successfully compiled {$inputFile} -> {$outputFile}\n");
                } else {
                    echo "Compiled: {$inputFile} -> {$outputFile}\n";
                }
            }

            return 0;

        } catch (Exception $e) {
            throw new Exception("Compilation failed: " . $e->getMessage());
        }
    }

    private function showHelp(): void
    {
        echo <<<HELP
OO-DSL to F-Logic Compiler

USAGE:
    oodsl-compile [OPTIONS] [INPUT_FILE]

ARGUMENTS:
    INPUT_FILE    Input DSL file to compile (if omitted, reads from stdin)

OPTIONS:
    -o, --output FILE    Output file (default: INPUT_FILE with .flr extension)
    --debug             Enable debug output
    -h, --help          Show this help message

EXAMPLES:
    # Compile example.oodsl to example.flr
    oodsl-compile example.oodsl

    # Compile with custom output file
    oodsl-compile example.oodsl -o custom.flr

    # Compile from stdin to stdout
    echo 'class Person { string name; }' | oodsl-compile

    # Compile from stdin to file
    echo 'class Person { string name; }' | oodsl-compile -o output.flr

OUTPUT:
    - If no output file specified and input is a file: creates INPUT_FILE.flr
    - If no output file specified and input is stdin: outputs to stdout
    - If output file specified: writes to that file

HELP;
    }
}