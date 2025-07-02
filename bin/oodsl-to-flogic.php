<?php
// bin/oodsl-to-flogic.php
#!/usr/bin/env php

require_once __DIR__ . '/../vendor/autoload.php';

// Parse command line arguments
if ($argc < 2) {
    echo "Usage: php bin/oodsl-to-flogic.php <input.oodsl> [output.flr]\n";
    echo "       php bin/oodsl-to-flogic.php examples/simple_test.oodsl\n";
    echo "       php bin/oodsl-to-flogic.php input.oodsl output.flr\n";
    exit(1);
}

$inputFile = $argv[1];
$outputFile = $argv[2] ?? null;

// Generate output filename if not provided
if (!$outputFile) {
    $pathInfo = pathinfo($inputFile);
    $outputFile = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.flr';
}

echo "OODSL to F-Logic Converter\n";
echo "==========================\n\n";
echo "Input:  $inputFile\n";
echo "Output: $outputFile\n\n";

try {
    // Check input file exists
    if (!file_exists($inputFile)) {
        throw new Exception("Input file not found: $inputFile");
    }

    // Read OODSL content
    $oodslContent = file_get_contents($inputFile);
    echo "Read " . strlen($oodslContent) . " bytes from input file\n";

    // Load parser
    $parserFile = __DIR__ . '/../src/Parser/OODSLParser.php';
    if (!file_exists($parserFile)) {
        throw new Exception("Parser not found. Run: php bin/generate-parser.php");
    }

    require_once $parserFile;

    // Load translator
    $translatorFile = __DIR__ . '/../src/Translator/FLogicTranslator.php';
    $contextFile = __DIR__ . '/../src/Translator/TranslationContext.php';

    if (!file_exists($translatorFile) || !file_exists($contextFile)) {
        throw new Exception("Translator not found. Check src/Translator/ directory");
    }

    require_once $contextFile;
    require_once $translatorFile;

    echo "Parsing OODSL...\n";

    // Parse OODSL
    $parser = new FLogicDSL\Parser\OODSLParser($oodslContent);
    $ast = null;

    // Try different parsing methods
    if (method_exists($parser, 'parse')) {
        echo "calling method parse...\n";
        $ast = $parser->parse($oodslContent);
    } elseif (method_exists($parser, 'match_Program')) {
        $parser = new FLogicDSL\Parser\OODSLParser($oodslContent);
        echo "calling method match_program...\n";
        $ast = $parser->match_Program();
    } else {
        throw new Exception("Parser has no suitable parse method");
    }

    if (!$ast) {
        throw new Exception("Failed to parse OODSL content");
    }

    echo "✅ Parsed successfully!\n";

    // Debug: Show the actual AST structure
    echo "DEBUG: AST structure:\n";
    echo json_encode($ast, JSON_PRETTY_PRINT) . "\n\n";

    echo "Found " . count($ast['statements'] ?? []) . " statements\n";

    // Show parsed statements
    foreach ($ast['statements'] ?? [] as $i => $stmt) {
        if (is_array($stmt) && isset($stmt['type'])) {
            $name = isset($stmt['name']) ? " ({$stmt['name']})" : "";
            echo "  [$i] {$stmt['type']}$name\n";
        }
    }

    echo "\nTranslating to F-Logic...\n";

    // Convert array AST to proper AST node objects
    $programNode = convertArrayToASTNodes($ast);

    // Use the proper FLogicTranslator
    $context = new FLogicDSL\Translator\TranslationContext();
    $translator = new FLogicDSL\Translator\FLogicTranslator($context);

    $flogicContent = $translator->translate($programNode);

    echo "✅ Translation completed!\n";
    echo "Generated " . strlen($flogicContent) . " bytes of F-Logic code\n";

    // Write output
    $outputDir = dirname($outputFile);
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true);
    }

    file_put_contents($outputFile, $flogicContent);

    echo "✅ F-Logic written to: $outputFile\n\n";

    echo "Preview of generated F-Logic:\n";
    echo "=============================\n";
    echo $flogicContent;
    echo "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

/**
 * Convert array-based AST to proper AST node objects
 */
function convertArrayToASTNodes(array $ast): FLogicDSL\Parser\ProgramNode
{
    // Load AST node classes
    require_once __DIR__ . '/../src/Parser/ASTNode.php';

    $programNode = new FLogicDSL\Parser\ProgramNode();

    foreach ($ast['statements'] ?? [] as $stmt) {
        if (!is_array($stmt)) continue;

        $astNode = convertStatementToASTNode($stmt);
        if ($astNode) {
            $programNode->addChild($astNode);
        }
    }

    return $programNode;
}

/**
 * Convert statement array to AST node
 */
function convertStatementToASTNode(array $stmt): ?FLogicDSL\Parser\ASTNode
{
    switch ($stmt['type'] ?? '') {
        case 'ClassDeclaration':
            return convertClassDeclaration($stmt);

        case 'ObjectDeclaration':
            return convertObjectDeclaration($stmt);

        case 'RuleDeclaration':
            return convertRuleDeclaration($stmt);
    }

    return null;
}

/**
 * Convert class declaration
 */
function convertClassDeclaration(array $stmt): FLogicDSL\Parser\ClassDeclarationNode
{
    $node = new FLogicDSL\Parser\ClassDeclarationNode(
        $stmt['name'] ?? 'Unknown',
        $stmt['parentClass'] ?? null
    );

    foreach ($stmt['properties'] ?? [] as $prop) {
        $propNode = new FLogicDSL\Parser\PropertyDeclarationNode(
            $prop['dataType'] ?? 'string',
            $prop['name'] ?? 'unknown'
        );
        $node->addProperty($propNode);
    }

    return $node;
}

/**
 * Convert object declaration
 */
function convertObjectDeclaration(array $stmt): FLogicDSL\Parser\ObjectDeclarationNode
{
    $node = new FLogicDSL\Parser\ObjectDeclarationNode(
        $stmt['name'] ?? 'Unknown',
        $stmt['className'] ?? 'Unknown'
    );

    foreach ($stmt['properties'] ?? [] as $prop) {
        $valueNode = convertValueToExpression($prop['value'] ?? []);
        $propNode = new FLogicDSL\Parser\PropertyAssignmentNode(
            $prop['name'] ?? 'unknown',
            $valueNode,
            $prop['operator'] ?? '='
        );
        $node->addProperty($propNode);
    }

    return $node;
}

/**
 * Convert rule declaration
 */
function convertRuleDeclaration(array $stmt): FLogicDSL\Parser\RuleDeclarationNode
{
    $conditionNode = convertConditionToNode($stmt['condition'] ?? []);
    $actionNode = convertActionToNode($stmt['action'] ?? []);

    return new FLogicDSL\Parser\RuleDeclarationNode(
        $stmt['name'] ?? 'Unknown',
        $conditionNode,
        $actionNode
    );
}

/**
 * Convert condition to node
 */
function convertConditionToNode(array $condition): FLogicDSL\Parser\ConditionNode
{
    if ($condition['type'] === 'Comparison') {
        $leftExpr = convertValueToExpression($condition['left'] ?? []);
        $rightExpr = convertValueToExpression($condition['right'] ?? []);

        return new FLogicDSL\Parser\ComparisonConditionNode(
            $leftExpr,
            $rightExpr,
            $condition['operator'] ?? '=='
        );
    }

    // Fallback - create a simple comparison
    $leftExpr = new FLogicDSL\Parser\LiteralNode(true, 'boolean');
    $rightExpr = new FLogicDSL\Parser\LiteralNode(true, 'boolean');

    return new FLogicDSL\Parser\ComparisonConditionNode($leftExpr, $rightExpr, '==');
}

/**
 * Convert action to node
 */
function convertActionToNode(array $action): FLogicDSL\Parser\ActionNode
{
    if ($action['type'] === 'Assignment') {
        $targetExpr = convertValueToExpression($action['target'] ?? []);
        $valueExpr = convertValueToExpression($action['value'] ?? []);

        if ($targetExpr instanceof FLogicDSL\Parser\ChainedExpressionNode) {
            return new FLogicDSL\Parser\AssignmentActionNode($targetExpr, $valueExpr);
        }

        // Convert simple target to chained expression
        $chainedTarget = new FLogicDSL\Parser\ChainedExpressionNode('Object', ['property']);
        return new FLogicDSL\Parser\AssignmentActionNode($chainedTarget, $valueExpr);
    }

    // Fallback
    $chainedTarget = new FLogicDSL\Parser\ChainedExpressionNode('Object', ['property']);
    $valueExpr = new FLogicDSL\Parser\LiteralNode(true, 'boolean');
    return new FLogicDSL\Parser\AssignmentActionNode($chainedTarget, $valueExpr);
}

/**
 * Convert value to expression node
 */
function convertValueToExpression(array $value): FLogicDSL\Parser\ExpressionNode
{
    switch ($value['type'] ?? '') {
        case 'StringLiteral':
            return new FLogicDSL\Parser\LiteralNode($value['value'] ?? '', 'string');

        case 'IntegerLiteral':
            return new FLogicDSL\Parser\LiteralNode($value['value'] ?? 0, 'integer');

        case 'FloatLiteral':
            return new FLogicDSL\Parser\LiteralNode($value['value'] ?? 0.0, 'float');

        case 'BooleanLiteral':
            return new FLogicDSL\Parser\LiteralNode($value['value'] ?? false, 'boolean');

        case 'Identifier':
            return new FLogicDSL\Parser\LiteralNode($value['name'] ?? 'unknown', 'identifier');

        case 'ChainedExpression':
            $parts = $value['parts'] ?? [];
            if (count($parts) >= 2) {
                return new FLogicDSL\Parser\ChainedExpressionNode($parts[0], array_slice($parts, 1));
            }
            return new FLogicDSL\Parser\LiteralNode($parts[0] ?? 'unknown', 'identifier');
    }

    return new FLogicDSL\Parser\LiteralNode('unknown', 'string');
}
?>