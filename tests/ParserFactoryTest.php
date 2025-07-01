<?php

require_once __DIR__ . '/../vendor/autoload.php';

use OODSLToFLogic\Parser\ParserFactory;

echo "🧪 Testing Parser Factory Setup...\n\n";

// Test SimpleParser (should work)
echo "Testing SimpleParser:\n";
$simpleParser = ParserFactory::create('simple');
echo "✅ SimpleParser created successfully\n";
echo "Type: " . get_class($simpleParser) . "\n\n";

// Test PEGParser (might not work yet)
echo "Testing PEGParser:\n";
try {
    $pegParser = ParserFactory::create('peg');
    echo "✅ PEGParser created successfully\n";
    echo "Type: " . get_class($pegParser) . "\n";

    if (method_exists($pegParser, 'isAvailable')) {
        if ($pegParser->isAvailable()) {
            echo "✅ PEG parser is ready to use\n";
        } else {
            echo "⚠️  PEG parser created but not yet generated. Run: composer run build-parser\n";
        }
    }
} catch (Exception $e) {
    echo "❌ PEGParser error: " . $e->getMessage() . "\n";
}

echo "\n🎯 Available parsers: " . implode(', ', ParserFactory::getAvailableParsers()) . "\n";
echo "\n✅ Phase 1 setup complete!\n";