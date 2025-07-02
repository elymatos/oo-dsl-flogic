<?php
// examples/usage_example.php
require_once __DIR__ . '/../vendor/autoload.php';

use FLogicDSL\Parser\OODSLParser;
use FLogicDSL\Translator\FLogicTranslator;
use FLogicDSL\Translator\TranslationContext;

/**
 * Example usage of the OODSL to F-Logic translator
 */

// Sample OODSL code
$dslCode = '
// Simple test
class Vehicle {
    string brand;
    integer year;
}

object Honda : Vehicle {
    brand = "Honda";
    year = 2020;
}

rule ModernVehicle {
    if (Vehicle.year >= 2020) {
        Vehicle.isModern = true;
    }
}
';

try {
    echo "=== OODSL to F-Logic ErgoAI Translator ===\n\n";

    echo "Input DSL Code:\n";
    echo "---------------\n";
    echo $dslCode . "\n\n";

    // Parse the DSL code
    echo "Parsing DSL code...\n";
    $parser = new OODSLParser($dslCode);
    $result = $parser->match_Program();

    if (!$result) {
        throw new Exception("Failed to parse DSL code");
    }

    echo "Parsing successful!\n\n";

    // Translate to F-Logic
    echo "Translating to F-Logic ErgoAI...\n";
    $context = new TranslationContext();
    $translator = new FLogicTranslator($context);
    $flogicCode = $translator->translate($result);

    echo "Output F-Logic Code:\n";
    echo "-------------------\n";
    echo $flogicCode . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

