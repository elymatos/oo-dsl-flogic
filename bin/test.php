<?php
require_once __DIR__ . '/../vendor/autoload.php';

$source = file_get_contents(__DIR__ ."/../examples/simple.oodsl");
print_r($source);
$parser = new \OODSLFLogic\Parser\Generated\OODSLParser($source);
print_r( "\ncalling method match_program...\n");
$result = $parser->match_ClassDecl();
print_r($result);
