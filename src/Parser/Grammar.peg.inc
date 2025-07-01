<?php

use OODSLToFLogic\AST\*;
use OODSLToFLogic\Utils\SourceLocation;

/*!* OODSLParser

# OO-DSL to F-Logic Grammar for hafriedlander/php-peg

Program: Statement*
    function Program_Statement(&$result, $sub) {
        if (!isset($result['statements'])) {
            $result['statements'] = array();
        }
        if (isset($sub['result'])) {
            $result['statements'][] = $sub['result'];
        }
    }

    function Program__finalise(&$result) {
        $location = new SourceLocation(1, 1, $this->currentFilename ?? null);
        return new ProgramNode($result['statements'] ?? [], $location);
    }

Statement: ClassDefinition | ObjectDefinition | MethodDefinition | RuleDefinition

# Class Definition
ClassDefinition: "class" __ name:Identifier __ inheritance:InheritanceClause? __ "{" __ body:ClassBody __ "}"
    function ClassDefinition__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        $properties = [];
        $methods = [];
        $structuralOnly = false;
        $parent = null;

        if (isset($result['inheritance']) && $result['inheritance']) {
            $parent = $result['inheritance']['parent'] ?? null;
            $structuralOnly = $result['inheritance']['structural'] ?? false;
        }

        if (isset($result['body'])) {
            foreach ($result['body'] as $item) {
                if ($item instanceof PropertyNode) {
                    $properties[] = $item;
                } elseif ($item instanceof MethodNode) {
                    $methods[] = $item;
                }
            }
        }

        return new ClassNode($result['name'], $parent, $structuralOnly, $properties, $methods, $location);
    }

InheritanceClause: "inherits" __ structural:("structure" __)? "from" __ parent:Identifier
    function InheritanceClause__finalise(&$result) {
        return [
            'parent' => $result['parent'],
            'structural' => isset($result['structural']) && !empty($result['structural'])
        ];
    }

ClassBody: item:ClassBodyItem*
    function ClassBody_item(&$result, $sub) {
        if (!isset($result['items'])) {
            $result['items'] = [];
        }
        if (isset($sub['result'])) {
            $result['items'][] = $sub['result'];
        }
    }

    function ClassBody__finalise(&$result) {
        return $result['items'] ?? [];
    }

ClassBodyItem: PropertyDefinition | MethodSignature

# Property Definition
PropertyDefinition: type:TypeSpecification __ name:Identifier __ constraint:Constraint? __ ";"
    function PropertyDefinition__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new PropertyNode(
            $result['name'],
            $result['type'],
            $result['constraint'] ?? null,
            $location
        );
    }

# Method Signature
MethodSignature: returnType:TypeSpecification __ name:Identifier __ "(" __ params:ParameterList? __ ")" __ ";"
    function MethodSignature__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new MethodNode(
            $result['name'],
            $result['params'] ?? [],
            $result['returnType'],
            null,
            true,
            $location
        );
    }

# Object Definition
ObjectDefinition: "object" __ name:Identifier __ ":" __ className:Identifier __ "{" __ assignments:AssignmentList? __ "}"
    function ObjectDefinition__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new ObjectNode(
            $result['name'],
            $result['className'],
            $result['assignments'] ?? [],
            $location
        );
    }

AssignmentList: assignment:Assignment*
    function AssignmentList_assignment(&$result, $sub) {
        if (!isset($result['assignments'])) {
            $result['assignments'] = [];
        }
        if (isset($sub['result'])) {
            $result['assignments'][] = $sub['result'];
        }
    }

    function AssignmentList__finalise(&$result) {
        return $result['assignments'] ?? [];
    }

Assignment: property:Identifier __ op:AssignmentOperator __ value:Expression __ ";"
    function Assignment__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new AssignmentNode(
            $result['property'],
            $result['op'],
            $result['value'],
            $location
        );
    }

AssignmentOperator: "+=" | "-=" | "="

# Method Definition (Implementation)
MethodDefinition: "method" __ className:Identifier "." methodName:Identifier __ "(" __ params:ParameterList? __ ")" __ returnType:("returns" __ TypeSpecification)? __ body:Block
    function MethodDefinition__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        $qualifiedName = $result['className'] . '.' . $result['methodName'];
        $retType = isset($result['returnType']) ? $result['returnType'][2] : null;

        return new MethodNode(
            $qualifiedName,
            $result['params'] ?? [],
            $retType,
            $result['body'],
            false,
            $location
        );
    }

# Rule Definition
RuleDefinition: "rule" __ name:Identifier __ "{" __ body:RuleBody __ "}"
    function RuleDefinition__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new RuleNode(
            $result['name'],
            $result['body']['condition'],
            $result['body']['conclusion'],
            $location
        );
    }

RuleBody: "if" __ "(" __ condition:Expression __ ")" __ "{" __ conclusion:Statement __ "}"
    function RuleBody__finalise(&$result) {
        return [
            'condition' => $result['condition'],
            'conclusion' => $result['conclusion']
        ];
    }

# Type System
TypeSpecification: CollectionType | PrimitiveType | CustomType

CollectionType: collectionType:("set" | "list") __ "<" __ elementType:TypeSpecification __ ">" __ constraint:Constraint?
    function CollectionType__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new TypeNode(
            $result['collectionType'],
            $result['elementType'],
            $result['constraint'] ?? null,
            $location
        );
    }

PrimitiveType: type:("string" | "integer" | "boolean" | "float")
    function PrimitiveType__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new TypeNode($result['type'], null, null, $location);
    }

CustomType: name:Identifier
    function CustomType__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new TypeNode($result['name'], null, null, $location);
    }

Constraint: "{" __ range:Range __ "}"
    function Constraint__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new ConstraintNode(
            $result['range']['min'],
            $result['range']['max'],
            $location
        );
    }

Range: min:Integer __ ".." __ max:(Integer | "*") | single:Integer
    function Range__finalise(&$result) {
        if (isset($result['single'])) {
            return ['min' => $result['single'], 'max' => $result['single']];
        } else {
            return [
                'min' => $result['min'],
                'max' => $result['max'] === '*' ? null : $result['max']
            ];
        }
    }

# Parameters
ParameterList: first:Parameter __ rest:("," __ Parameter)*
    function ParameterList_rest(&$result, $sub) {
        if (!isset($result['params'])) {
            $result['params'] = [];
        }
        if (isset($sub[2])) {
            $result['params'][] = $sub[2];
        }
    }

    function ParameterList__finalise(&$result) {
        $params = [$result['first']];
        if (isset($result['params'])) {
            $params = array_merge($params, $result['params']);
        }
        return $params;
    }

Parameter: type:TypeSpecification __ name:Identifier
    function Parameter__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new ParameterNode($result['name'], $result['type'], $location);
    }

# Expressions (Simplified)
Expression: BinaryExpression | PrimaryExpression

BinaryExpression: left:PrimaryExpression __ op:BinaryOperator __ right:Expression
    function BinaryExpression__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new BinaryExpressionNode(
            $result['left'],
            $result['op'],
            $result['right'],
            $location
        );
    }

BinaryOperator: "&&" | "||" | "==" | "!=" | "<=" | ">=" | "<" | ">" | "+" | "-" | "*" | "/"

PrimaryExpression: "(" __ expr:Expression __ ")" | CollectionMethodCall | MethodCall | PropertyAccess | Literal | Identifier
    function PrimaryExpression__finalise(&$result) {
        if (isset($result['expr'])) {
            return $result['expr'];
        }
        return $result;
    }



MethodCall: object:Identifier __ "." __ method:Identifier __ "(" __ args:ArgumentList? __ ")"
    function MethodCall__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        $objectNode = new IdentifierNode($result['object'], $location);
        return new MethodCallNode(
            $objectNode,
            $result['method'],
            $result['args'] ?? [],
            $location
        );
    }

PropertyAccess: object:Identifier __ "." __ property:Identifier
    function PropertyAccess__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        $objectNode = new IdentifierNode($result['object'], $location);
        return new PropertyAccessNode(
            $objectNode,
            $result['property'],
            $location
        );
    }

ArgumentList: first:Expression __ rest:("," __ Expression)*
    function ArgumentList_rest(&$result, $sub) {
        if (!isset($result['args'])) {
            $result['args'] = [];
        }
        if (isset($sub[2])) {
            $result['args'][] = $sub[2];
        }
    }

    function ArgumentList__finalise(&$result) {
        $args = [$result['first']];
        if (isset($result['args'])) {
            $args = array_merge($args, $result['args']);
        }
        return $args;
    }

Block: "{" __ statements:(Statement __)* __ "}"
    function Block_statements(&$result, $sub) {
        if (!isset($result['statements'])) {
            $result['statements'] = [];
        }
        if (isset($sub[0])) {
            $result['statements'][] = $sub[0];
        }
    }

    function Block__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new BlockNode($result['statements'] ?? [], $location);
    }

# Literals
Literal: String | Float | Integer | Boolean

String: '"' chars:StringChar* '"'
    function String_chars(&$result, $sub) {
        if (!isset($result['chars'])) {
            $result['chars'] = '';
        }
        $result['chars'] .= $sub;
    }

    function String__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new LiteralNode($result['chars'] ?? '', 'string', $location);
    }

StringChar: '\"' | /[^"]/

Float: /\d+\.\d+/
    function Float__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new LiteralNode(floatval($this->string), 'float', $location);
    }

Integer: /\d+/
    function Integer__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new LiteralNode(intval($this->string), 'integer', $location);
    }

Boolean: "true" | "false"
    function Boolean__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        $value = $this->string === 'true';
        return new LiteralNode($value, 'boolean', $location);
    }

# Identifier
Identifier: /[a-zA-Z_][a-zA-Z0-9_]*/
    function Identifier__finalise(&$result) {
        return $this->string;
    }

# Whitespace
__: /\s*/

*/

# Collection Method Calls (NEW)
CollectionMethodCall: object:Identifier __ "." __ property:Identifier __ "." __ method:CollectionMethod __ "(" __ ")"
    function CollectionMethodCall__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        $collection = $result['object'] . '.' . $result['property'];
        return new CollectionMethodCallNode(
            $collection,
            $result['method'],
            [],
            $location
        );
    }

CollectionMethod: "count" | "sum" | "size"
    function CollectionMethod__finalise(&$result) {
        return $this->string;
    }