<?php

namespace OODSLToFLogic\Parser\Generated;

use hafriedlander\Peg\Parser\Packrat;
use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\AST\ClassNode;
use OODSLToFLogic\AST\AttributeNode;
use OODSLToFLogic\AST\MethodNode;
use OODSLToFLogic\AST\ParameterNode;
use OODSLToFLogic\Utils\SourceLocation;

class OODSLParser extends Packrat {

    /*!* OODSLParser

    # Fix: Change from Statement* to ensure proper finalization
    Program: Statement+
        function Program_Statement(&$result, $sub) {
            if (!isset($result['statements'])) {
                $result['statements'] = [];
            }
            if ($sub !== null) {
                $result['statements'][] = $sub;
            }
        }

        function Program__finalise(&$result) {
            $location = new SourceLocation(1, 1, $this->currentFilename ?? null);
            $statements = isset($result['statements']) ? $result['statements'] : [];
            return new ProgramNode($statements, $location);
        }

    Statement: ClassDefinition

    # Class Definition with inheritance and body
    ClassDefinition: "class" __ Identifier __ Inheritance? __ "{" __ ClassBody __ "}"
        function ClassDefinition_Identifier(&$result, $sub) {
            $result['className'] = $sub;
        }

        function ClassDefinition_Inheritance(&$result, $sub) {
            $result['inheritance'] = $sub;
        }

        function ClassDefinition_ClassBody(&$result, $sub) {
            $result['body'] = $sub;
        }

        function ClassDefinition__finalise(&$result) {
            $location = new SourceLocation(1, 1);
            $className = $result['className'] ?? 'UnknownClass';
            $inheritance = $result['inheritance'] ?? null;
            $body = $result['body'] ?? ['attributes' => [], 'methods' => []];

            return new ClassNode(
                $className,
                $inheritance,
                false, // isAbstract
                $body['attributes'] ?? [],
                $body['methods'] ?? [],
                $location
            );
        }

    # Optional inheritance
    Inheritance: "extends" __ Identifier
        function Inheritance_Identifier(&$result, $sub) {
            return $sub;
        }

    # Class body with attributes and methods
    ClassBody: ClassMember*
        function ClassBody_ClassMember(&$result, $sub) {
            if (!isset($result['attributes'])) {
                $result['attributes'] = [];
            }
            if (!isset($result['methods'])) {
                $result['methods'] = [];
            }

            if ($sub !== null) {
                if (isset($sub['type']) && $sub['type'] === 'attribute') {
                    $result['attributes'][] = $sub['node'];
                } elseif (isset($sub['type']) && $sub['type'] === 'method') {
                    $result['methods'][] = $sub['node'];
                }
            }
        }

        function ClassBody__finalise(&$result) {
            return [
                'attributes' => $result['attributes'] ?? [],
                'methods' => $result['methods'] ?? []
            ];
        }

    ClassMember: AttributeDefinition | MethodDefinition

    # Attribute definition
    AttributeDefinition: Visibility? __ TypeHint? __ Identifier __ ";"
        function AttributeDefinition_Visibility(&$result, $sub) {
            $result['visibility'] = $sub;
        }

        function AttributeDefinition_TypeHint(&$result, $sub) {
            $result['typeHint'] = $sub;
        }

        function AttributeDefinition_Identifier(&$result, $sub) {
            $result['name'] = $sub;
        }

        function AttributeDefinition__finalise(&$result) {
            $location = new SourceLocation(1, 1);
            $node = new AttributeNode(
                $result['name'] ?? 'unknownAttr',
                $result['typeHint'] ?? null,
                $result['visibility'] ?? 'private',
                $location
            );

            return ['type' => 'attribute', 'node' => $node];
        }

    # Method definition
    MethodDefinition: Visibility? __ TypeHint? __ Identifier __ "(" __ ParameterList? __ ")" __ "{" __ "}"
        function MethodDefinition_Visibility(&$result, $sub) {
            $result['visibility'] = $sub;
        }

        function MethodDefinition_TypeHint(&$result, $sub) {
            $result['returnType'] = $sub;
        }

        function MethodDefinition_Identifier(&$result, $sub) {
            $result['name'] = $sub;
        }

        function MethodDefinition_ParameterList(&$result, $sub) {
            $result['parameters'] = $sub;
        }

        function MethodDefinition__finalise(&$result) {
            $location = new SourceLocation(1, 1);
            $node = new MethodNode(
                $result['name'] ?? 'unknownMethod',
                $result['parameters'] ?? [],
                $result['returnType'] ?? null,
                $result['visibility'] ?? 'public',
                false, // isAbstract
                false, // isStatic
                $location
            );

            return ['type' => 'method', 'node' => $node];
        }

    # Parameter list for methods
    ParameterList: Parameter ParameterTail*
        function ParameterList_Parameter(&$result, $sub) {
            $result = [$sub];
        }

        function ParameterList_ParameterTail(&$result, $sub) {
            if (is_array($result) && $sub !== null) {
                $result[] = $sub;
            }
        }

    ParameterTail: __ "," __ Parameter
        function ParameterTail_Parameter(&$result, $sub) {
            return $sub;
        }

    # Individual parameter
    Parameter: TypeHint? __ Identifier
        function Parameter_TypeHint(&$result, $sub) {
            $result['typeHint'] = $sub;
        }

        function Parameter_Identifier(&$result, $sub) {
            $result['name'] = $sub;
        }

        function Parameter__finalise(&$result) {
            $location = new SourceLocation(1, 1);
            return new ParameterNode(
                $result['name'] ?? 'unknownParam',
                $result['typeHint'] ?? null,
                $location
            );
        }

    # Visibility modifiers
    Visibility: "public" | "private" | "protected"

    # Type hints
    TypeHint: Identifier

    # Identifiers
    Identifier: / [a-zA-Z_][a-zA-Z0-9_]* /

    # Whitespace
    __: / \s* /

    */

}