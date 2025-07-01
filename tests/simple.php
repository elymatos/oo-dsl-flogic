<?php


require_once __DIR__ . '/../vendor/autoload.php';

// Let's test with a minimal grammar first
class SimpleTestParser extends \hafriedlander\Peg\Parser\Packrat
{

    /*!* SimpleTestParser

    Program: ClassDef+
        function Program_ClassDef(&$result, $sub) {
            if (!isset($result['classes'])) {
                $result['classes'] = [];
            }
            $result['classes'][] = $sub;
        }

        function Program__finalise(&$result) {
            return ['type' => 'program', 'classes' => $result['classes'] ?? []];
        }

    ClassDef: "class" __ Word __ "{" __ "}"
        function ClassDef_Word(&$result, $sub) {
            $result['name'] = $sub;
        }

        function ClassDef__finalise(&$result) {
            return ['type' => 'class', 'name' => $result['name'] ?? 'Unknown'];
        }

    Word: / [a-zA-Z_][a-zA-Z0-9_]* /
    __: / \s* /

    */
}

echo "=== Simple Grammar Test ===\n";

$input = 'class TestClass { }';
echo "Testing: $input\n";

try {
    $parser = new SimpleTestParser($input);
    $result = $parser->match_Program();

    if ($result === false) {
        echo "❌ Simple grammar also fails\n";
    } else {
        echo "✅ Simple grammar works\n";
        echo "Result: " . print_r($result, true) . "\n";
    }

} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}