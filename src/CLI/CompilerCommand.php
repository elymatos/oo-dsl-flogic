<?php

namespace OODSLFLogic\CLI;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use OODSLFLogic\Parser\Parser;
use OODSLFLogic\CodeGen\FLogicGenerator;
use OODSLFLogic\Analysis\SemanticAnalyzer;

class CompilerCommand extends Command
{
    protected static $defaultName = 'compile';
    protected static $defaultDescription = 'Compile OO-DSL files to F-Logic ErgoAI';

    private Parser $parser;
    private FLogicGenerator $generator;
    private SemanticAnalyzer $analyzer;
    private Filesystem $filesystem;

    public function __construct()
    {
        parent::__construct();

        $this->parser = new Parser();
        $this->generator = new FLogicGenerator();
        $this->analyzer = new SemanticAnalyzer();
        $this->filesystem = new Filesystem();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument(
                'input',
                InputArgument::REQUIRED,
                'Input DSL file or directory'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Output file for F-Logic code'
            )
            ->addOption(
                'output-dir',
                'd',
                InputOption::VALUE_REQUIRED,
                'Output directory for F-Logic modules'
            )
            ->addOption(
                'module-name',
                'm',
                InputOption::VALUE_REQUIRED,
                'Module name for generated code'
            )
            ->addOption(
                'validate-only',
                null,
                InputOption::VALUE_NONE,
                'Only validate syntax without generating code'
            )
//            ->addOption(
//                'verbose',
//                'v',
//                InputOption::VALUE_NONE,
//                'Verbose output'
//            )
            ->addOption(
                'ast',
                null,
                InputOption::VALUE_NONE,
                'Output AST instead of F-Logic code'
            )
            ->addOption(
                'format',
                'f',
                InputOption::VALUE_REQUIRED,
                'Output format (flogic, json, dot)',
                'flogic'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $inputPath = $input->getArgument('input');
        $outputFile = $input->getOption('output');
        $outputDir = $input->getOption('output-dir');
        $moduleName = $input->getOption('module-name');
        $validateOnly = $input->getOption('validate-only');
        $verbose = $input->getOption('verbose');
        $showAst = $input->getOption('ast');
        $format = $input->getOption('format');

        // Set verbose mode
        $this->parser->getErrorHandler()->setVerbose($verbose);

        try {
            // Determine input files
            $inputFiles = $this->getInputFiles($inputPath);

            if (empty($inputFiles)) {
                $io->error("No DSL files found in: {$inputPath}");
                return Command::FAILURE;
            }

            $io->title('OO-DSL to F-Logic Compiler');

            if ($verbose) {
                $io->section('Input Files');
                $io->listing($inputFiles);
            }

            $allSuccessful = true;
            $results = [];

            foreach ($inputFiles as $file) {
                $io->section("Processing: " . basename($file));

                $result = $this->processFile($file, $io, $validateOnly, $showAst, $format);
                $results[$file] = $result;

                if (!$result['success']) {
                    $allSuccessful = false;
                }
            }

            // Generate output
            if ($allSuccessful && !$validateOnly) {
                $this->generateOutput($results, $outputFile, $outputDir, $moduleName, $io, $format);
            }

            // Summary
            $this->printSummary($results, $io);

            return $allSuccessful ? Command::SUCCESS : Command::FAILURE;

        } catch (\Exception $e) {
            $io->error("Compilation failed: " . $e->getMessage());

            if ($verbose) {
                $io->block($e->getTraceAsString(), 'TRACE', 'fg=gray');
            }

            return Command::FAILURE;
        }
    }

    private function getInputFiles(string $inputPath): array
    {
        $files = [];

        if (is_file($inputPath)) {
            if (pathinfo($inputPath, PATHINFO_EXTENSION) === 'oodsl') {
                $files[] = $inputPath;
            }
        } elseif (is_dir($inputPath)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($inputPath)
            );

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'oodsl') {
                    $files[] = $file->getPathname();
                }
            }
        }

        return $files;
    }

    private function processFile(
        string $file,
        SymfonyStyle $io,
        bool $validateOnly,
        bool $showAst,
        string $format
    ): array {
        $result = [
            'success' => false,
            'ast' => null,
            'flogic' => null,
            'errors' => []
        ];

        try {
            // Parse the file
            $ast = $this->parser->parseFile($file);

            $result['ast'] = $ast;

            $io->success("Parsed successfully");

            if ($showAst) {
                $this->displayAst($ast, $io, $format);
            }

            if (!$validateOnly) {
                // Semantic analysis
//                $analysisResult = $this->analyzer->analyze($ast);
//
//                if ($analysisResult->hasErrors()) {
//                    $result['errors'] = $analysisResult->getErrors();
//                    $io->error("Semantic analysis failed");
//
//                    foreach ($analysisResult->getErrors() as $error) {
//                        $io->text("  - {$error}");
//                    }
//
//                    return $result;
//                }
//
//                $io->success("Semantic analysis passed");

                // Generate F-Logic code
                $flogicCode = $this->generator->generate($ast);
                $result['flogic'] = $flogicCode;

                $io->success("F-Logic code generated");
            }

            $result['success'] = true;

        } catch (\Exception $e) {
            $result['errors'][] = $e->getMessage();
            $io->error("Failed to process file: " . $e->getMessage());
        }

        return $result;
    }

    private function displayAst($ast, SymfonyStyle $io, string $format): void
    {
        $io->section('Abstract Syntax Tree');

        switch ($format) {
            case 'json':
                $io->block(json_encode($ast->toArray(), JSON_PRETTY_PRINT), null, 'fg=cyan');
                break;
            case 'dot':
                $dotOutput = $this->generateDotNotation($ast);
                $io->block($dotOutput, null, 'fg=green');
                break;
            default:
                $io->block($this->formatAstForDisplay($ast), null, 'fg=yellow');
        }
    }

    private function generateOutput(
        array $results,
        ?string $outputFile,
        ?string $outputDir,
        ?string $moduleName,
        SymfonyStyle $io,
        string $format
    ): void {
        $io->section('Generating Output');

        if ($outputFile) {
            // Single file output
            $this->generateSingleFileOutput($results, $outputFile, $io, $format);
        } elseif ($outputDir) {
            // Multiple file output
            $this->generateMultiFileOutput($results, $outputDir, $moduleName, $io, $format);
        } else {
            // Output to console
            $this->outputToConsole($results, $io, $format);
        }
    }

    private function generateSingleFileOutput(
        array $results,
        string $outputFile,
        SymfonyStyle $io,
        string $format
    ): void {
        $combinedOutput = "";

        foreach ($results as $file => $result) {
            if ($result['success'] && $result['flogic']) {
                $combinedOutput .= "% Generated from: " . basename($file) . "\n";
                $combinedOutput .= $result['flogic'] . "\n\n";
            }
        }

        $this->filesystem->dumpFile($outputFile, $combinedOutput);
        $io->success("Output written to: {$outputFile}");
    }

    private function generateMultiFileOutput(
        array $results,
        string $outputDir,
        ?string $moduleName,
        SymfonyStyle $io,
        string $format
    ): void {
        $this->filesystem->mkdir($outputDir);

        foreach ($results as $file => $result) {
            if ($result['success'] && $result['flogic']) {
                $baseName = pathinfo($file, PATHINFO_FILENAME);
                $outputFile = $outputDir . '/' . $baseName . '.flr';

                $this->filesystem->dumpFile($outputFile, $result['flogic']);
                $io->text("Generated: {$outputFile}");
            }
        }

        $io->success("Output written to directory: {$outputDir}");
    }

    private function outputToConsole(array $results, SymfonyStyle $io, string $format): void
    {
        foreach ($results as $file => $result) {
            if ($result['success'] && $result['flogic']) {
                $io->section("Generated F-Logic for: " . basename($file));
                $io->block($result['flogic'], null, 'fg=green');
            }
        }
    }

    private function printSummary(array $results, SymfonyStyle $io): void
    {
        $io->section('Compilation Summary');

        $total = count($results);
        $successful = count(array_filter($results, fn($r) => $r['success']));
        $failed = $total - $successful;

        $io->table(
            ['Metric', 'Count'],
            [
                ['Total Files', $total],
                ['Successful', $successful],
                ['Failed', $failed]
            ]
        );

        if ($failed > 0) {
            $io->warning("Some files failed to compile. Check the error messages above.");
        } else {
            $io->success("All files compiled successfully!");
        }
    }

    private function formatAstForDisplay($node, int $indent = 0): string
    {
        $prefix = str_repeat('  ', $indent);
        $className = (new \ReflectionClass($node))->getShortName();
        $output = $prefix . $className;

        // Add node-specific information
        if (method_exists($node, 'name') && $node->name) {
            $name = is_object($node->name) ? $node->name->name : $node->name;
            $output .= " ({$name})";
        }

        $output .= "\n";

        // Recursively display child nodes
        $reflection = new \ReflectionClass($node);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($node);

            if (is_array($value)) {
                if (!empty($value)) {
                    $output .= $prefix . "  {$property->getName()}:\n";
                    foreach ($value as $item) {
                        if (is_object($item) && method_exists($item, 'accept')) {
                            $output .= $this->formatAstForDisplay($item, $indent + 2);
                        }
                    }
                }
            } elseif (is_object($value) && method_exists($value, 'accept')) {
                $output .= $prefix . "  {$property->getName()}:\n";
                $output .= $this->formatAstForDisplay($value, $indent + 2);
            }
        }

        return $output;
    }

    private function generateDotNotation($ast): string
    {
        $dot = "digraph AST {\n";
        $dot .= "  node [shape=box];\n";
        $nodeId = 0;

        $this->generateDotNode($ast, $nodeId, $dot);

        $dot .= "}\n";
        return $dot;
    }

    private function generateDotNode($node, int &$nodeId, string &$dot, int $parentId = null): int
    {
        $currentId = $nodeId++;
        $className = (new \ReflectionClass($node))->getShortName();

        $label = $className;
        if (method_exists($node, 'name') && $node->name) {
            $name = is_object($node->name) ? $node->name->name : $node->name;
            $label .= "\\n({$name})";
        }

        $dot .= "  {$currentId} [label=\"{$label}\"];\n";

        if ($parentId !== null) {
            $dot .= "  {$parentId} -> {$currentId};\n";
        }

        // Process child nodes
        $reflection = new \ReflectionClass($node);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($node);

            if (is_array($value)) {
                foreach ($value as $item) {
                    if (is_object($item) && method_exists($item, 'accept')) {
                        $this->generateDotNode($item, $nodeId, $dot, $currentId);
                    }
                }
            } elseif (is_object($value) && method_exists($value, 'accept')) {
                $this->generateDotNode($value, $nodeId, $dot, $currentId);
            }
        }

        return $currentId;
    }
}