<?php
// compiler.php
require 'vendor/autoload.php'; // Assuming Composer autoloader is set up

use hafriedlander\Peg\Compiler; // Use this namespace as smuuf/php-peg maintains it

$grammarFile = __DIR__. '/../src/Parser/Gemini.peg.inc';
$outputFile = __DIR__. '/../src/Parser/Generated/CommandParser.php';

try {
    $grammar = file_get_contents($grammarFile);
    $compiler = new Compiler();
    $output = $compiler->compile($grammar);
    file_put_contents($outputFile, $output);
    echo "Parser compiled successfully to {$outputFile}\n";
} catch (\Exception $e) {
    echo "Error compiling parser: ". $e->getMessage(). "\n";
}