<?php

namespace OODSLToFLogic\CLI;

use OODSLToFLogic\Parser\Parser;
use OODSLToFLogic\CodeGen\FLogicGenerator;
use OODSLToFLogic\Utils\Logger;

/**
 * Command-line interface for the OO-DSL compiler
 */
class CompilerCommand
{
    private Parser $parser;
    private FLogicGenerator $generator;
    private Logger $logger;

    public function __construct()
    {
        $this->parser = new Parser();
        $this->generator = new FLogicGenerator();
        $this->logger = Logger::getInstance();
    }

    public function run(array $args): int
    {
        $options = $this->parseArguments($args);

        if ($options === null) {
            $this->showUsage();
            return 1;
        }

        if ($options['debug']) {
            $this->logger->setDebug(true);
        }

        return $this->compile($options);
    }

    private function parseArguments(array $args): ?array
    {
        $options = [
            'input' => null,
            'output' => null,
            'debug' => false,
            'help' => false,
        ];

        for ($i = 1; $i < count($args); $i++) {
            $arg = $args[$i];

            switch ($arg) {
                case '-h':
                case '--help':
                    $options['help'] = true;
                    break;

                case '-d':
                case '--debug':
                    $options['debug'] = true;
                    break;

                case '-o':
                case '--output':
                    if ($i + 1 < count($args)) {
                        $options['output'] = $args[++$i];
                    } else {
                        $this->logger->error("Option {$arg} requires a value");
                        return null;
                    }
                    break;

                default:
                    if (str_starts_with($arg, '-')) {
                        $this->logger->error("Unknown option: {$arg}");
                        return null;
                    } else {
                        if ($options['input'] === null) {
                            $options['input'] = $arg;
                        } else {
                            $this->logger->error("Multiple input files not supported");
                            return null;
                        }
                    }
                    break;
            }
        }

        if ($options['help']) {
            $this->showUsage();
            exit(0);
        }

        if ($options['input'] === null) {
            $this->logger->error("No input file specified");
            return null;
        }

        return $options;
    }

    private function compile(array $options): int
    {
        $inputFile = $options['input'];
        $outputFile = $options['output'] ?? $this->getDefaultOutputFile($inputFile);

        $this->logger->info("Compiling {$inputFile} to {$outputFile}");

        // Parse input file
        $this->logger->debug("Parsing input file...");
        $ast = $this->parser->parseFile($inputFile);

        if ($ast === null || $this->parser->hasErrors()) {
            $this->logger->error("Parse failed:");
            echo $this->parser->getErrorHandler()->formatErrors();
            return 1;
        }

        $this->logger->debug("Parse successful");

        // Generate F-Logic code
        $this->logger->debug("Generating F-Logic code...");
        $flogicCode = $this->generator->generate($ast);

        if ($this->generator->getErrorHandler()->hasErrors()) {
            $this->logger->error("Code generation failed:");
            echo $this->generator->getErrorHandler()->formatErrors();
            return 1;
        }

        $this->logger->debug("Code generation successful");

        // Write output file
        $this->logger->debug("Writing output file...");
        if (!$this->writeOutputFile($outputFile, $flogicCode)) {
            $this->logger->error("Failed to write output file: {$outputFile}");
            return 1;
        }

        $this->logger->info("Compilation successful!");

        // Show warnings if any
        if ($this->parser->getErrorHandler()->hasWarnings() ||
            $this->generator->getErrorHandler()->hasWarnings()) {
            echo "\nWarnings:\n";
            echo $this->parser->getErrorHandler()->formatErrors();
            echo $this->generator->getErrorHandler()->formatErrors();
        }

        return 0;
    }

    private function getDefaultOutputFile(string $inputFile): string
    {
        $pathInfo = pathinfo($inputFile);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.flr';
    }

    private function writeOutputFile(string $outputFile, string $content): bool
    {
        $directory = dirname($outputFile);

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0755, true)) {
                return false;
            }
        }

        return file_put_contents($outputFile, $content) !== false;
    }

    private function showUsage(): void
    {
        echo <<<USAGE
OO-DSL to F-Logic Compiler

Usage: oodsl-compile [options] <input-file>

Options:
    -h, --help          Show this help message
    -o, --output FILE   Specify output file (default: input.flr)
    -d, --debug         Enable debug output

Examples:
    oodsl-compile example.oodsl
    oodsl-compile -o output.flr input.oodsl
    oodsl-compile --debug example.oodsl

USAGE;
    }
}