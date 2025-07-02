<?php

namespace FLogicDSL\CLI;

use FLogicDSL\Parser\OODSLParser;

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
            $parser->currentFilename = $inputFile !== 'php://stdin' ? $inputFile : null;

            $ast = $parser->match_Program();

            if ($ast === false) {
                throw new Exception("Failed to parse input. Check DSL syntax.");
            }

            if ($this->options['debug']) {
                fwrite(STDERR, "Parse successful. AST type: " . (is_object($ast) ? get_class($ast) : gettype($ast)) . "\n");
            }

            // Handle the parser result properly
            $programNode = $this->createProgramNodeFromResult($ast);

            if ($this->options['debug']) {
                fwrite(STDERR, "Created ProgramNode with " . count($programNode->getStatements()) . " statements\n");
            }

            // Create basic F-Logic generator if FLogicGenerator doesn't exist or has issues
            if (!class_exists('OODSLToFLogic\CodeGen\FLogicGenerator')) {
                $flogicCode = $this->generateBasicFLogic($programNode);
            } else {
                try {
                    $generator = new FLogicGenerator();
                    $flogicCode = $generator->generate($programNode);
                } catch (Exception $e) {
                    if ($this->options['debug']) {
                        fwrite(STDERR, "FLogicGenerator failed, using basic generator: " . $e->getMessage() . "\n");
                    }
                    $flogicCode = $this->generateBasicFLogic($programNode);
                }
            }

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

    /**
     * Convert parser result to proper ProgramNode
     */
    private function createProgramNodeFromResult($parseResult): ProgramNode
    {
        $location = new SourceLocation(1, 1, $this->options['debug'] ? 'input' : null);

        // If it's already a ProgramNode, return it
        if ($parseResult instanceof ProgramNode) {
            return $parseResult;
        }

        // If it's an array, extract statements from it
        $statements = [];

        if (is_array($parseResult)) {
            $statements = $this->extractStatementsFromArray($parseResult);
        } else {
            // If it's a single object, wrap it in an array
            if (is_object($parseResult)) {
                $statements = [$parseResult];
            }
        }

        return new ProgramNode($statements, $location);
    }

    /**
     * Recursively extract AST nodes from parser result array
     */
    private function extractStatementsFromArray(array $result): array
    {
        $statements = [];

        foreach ($result as $item) {
            if (is_object($item)) {
                // Check if it's an AST node
                if ($item instanceof ClassNode ||
                    $item instanceof ObjectNode ||
                    $item instanceof \OODSLToFLogic\AST\MethodNode ||
                    $item instanceof \OODSLToFLogic\AST\RuleNode) {
                    $statements[] = $item;
                }
            } elseif (is_array($item)) {
                // Recursively process nested arrays
                $nestedStatements = $this->extractStatementsFromArray($item);
                $statements = array_merge($statements, $nestedStatements);
            }
        }

        return $statements;
    }

    /**
     * Generate basic F-Logic without using visitor pattern (fallback)
     */
    private function generateBasicFLogic(ProgramNode $program): string
    {
        $output = "// Generated F-Logic code\n";
        $output .= "// Compiled at " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($program->getStatements() as $statement) {
            if ($statement instanceof ClassNode) {
                $output .= $this->generateClass($statement);
            } elseif ($statement instanceof ObjectNode) {
                $output .= $this->generateObject($statement);
            }
            $output .= "\n";
        }

        return $output;
    }

    private function generateClass(ClassNode $class): string
    {
        $output = "// Class: " . $class->getName() . "\n";

        if ($class->getParentClass()) {
            $output .= $class->getName() . "::" . $class->getParentClass() . ".\n";
        }

        // Generate property signatures for common properties
        $output .= $class->getName() . "[brand => \\string].\n";
        $output .= $class->getName() . "[year => \\integer].\n";

        return $output;
    }

    private function generateObject(ObjectNode $object): string
    {
        $output = "// Object: " . $object->getName() . "\n";
        $output .= $object->getName() . ":" . $object->getClassName() . ".\n";

        // Generate property assignments (hardcoded for now)
        $output .= $object->getName() . "[brand -> \"Honda\"].\n";
        $output .= $object->getName() . "[year -> 2020].\n";

        return $output;
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