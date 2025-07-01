<?php
namespace OODSLToFLogic\Parser\Generated;

use hafriedlander\Peg\Parser\Packrat;
use OODSLToFLogic\AST\ProgramNode;
use OODSLToFLogic\AST\ClassNode;
use OODSLToFLogic\AST\ObjectNode;
use OODSLToFLogic\AST\MethodNode;
use OODSLToFLogic\AST\RuleNode;
use OODSLToFLogic\Utils\SourceLocation;

class OODSLParser extends Packrat {

    /*!* OODSLParser

    Program: _ Declaration* _
        function Program__finalise(&$result) {
            $location = new SourceLocation(1, 1, $this->currentFilename ?? null);
            $statements = array();
            if (is_array($result)) {
                foreach ($result as $item) {
                    if (is_object($item)) {
                        $statements[] = $item;
                    }
                }
            }
            return new ProgramNode($statements, $location);
        }

    Declaration: ClassDecl | ObjectDecl | MethodDecl | RuleDecl

    ClassDecl: "class" __ Identifier Inheritance? _ "{" _ ClassBody _ "}"
        function ClassDecl__finalise(&$result) {
            $location = new SourceLocation(1, 1);
            $text = $result['text'] ?? '';
            preg_match('/class\s+(\w+)/', $text, $matches);
            $className = $matches[1] ?? 'Unknown';
            return new ClassNode(
                $className,
                null,
                false,
                array(),
                array(),
                $location
            );
        }

    Inheritance: __ "inherits" StructureWord? __ "from" __ Identifier

    StructureWord: "structure"

    ObjectDecl: "object" __ Identifier _ ":" _ Identifier _ "{" _ ObjectBody _ "}"
        function ObjectDecl__finalise(&$result) {
            $location = new SourceLocation(1, 1);
            $text = $result['text'] ?? '';
            preg_match('/object\s+(\w+)\s*:\s*(\w+)/', $text, $matches);
            $objectName = $matches[1] ?? 'Unknown';
            $className = $matches[2] ?? 'Unknown';
            return new ObjectNode(
                $objectName,
                $className,
                array(),
                $location
            );
        }

    MethodDecl: "method" __ DottedName _ "(" _ Params? _ ")" __ "returns" __ DataType _ "{" _ MethodBody _ "}"
        function MethodDecl__finalise(&$result) {
            $location = new SourceLocation(1, 1);
            $text = $result['text'] ?? '';
            preg_match('/method\s+([\w.]+)/', $text, $matches);
            $methodName = $matches[1] ?? 'Unknown';
            return new MethodNode(
                $methodName,
                array(),
                'boolean',
                array(),
                $location
            );
        }

    RuleDecl: "rule" __ Identifier _ "{" _ RuleBody _ "}"
        function RuleDecl__finalise(&$result) {
            $location = new SourceLocation(1, 1);
            $text = $result['text'] ?? '';
            preg_match('/rule\s+(\w+)/', $text, $matches);
            $ruleName = $matches[1] ?? 'Unknown';
            return new RuleNode(
                $ruleName,
                array(),
                $location
            );
        }

    Params: Param (_ "," _ Param)*

    Param: DataType __ Identifier

    RuleBody: "if" _ "(" _ Condition _ ")" _ "{" _ Actions _ "}"

    Condition: Expr CondTail*

    CondTail: _ LogicOp _ Expr

    LogicOp: "&&" | "||"

    Actions: Action*

    Action: DottedName _ "=" _ Expr _ ";" _

    DottedName: Identifier ("." Identifier)*

    MethodBody: BodyStmt*

    BodyStmt: ReturnStmt | Action

    ReturnStmt: "return" __ Expr _ ";" _

    Expr: CompExpr | MathExpr | Call | Value

    CompExpr: PropRef __ CompOp __ Expr

    MathExpr: MulExpr ((_ ("+" | "-") _) MulExpr)*

    MulExpr: UnaryExpr ((_ ("*" | "/") _) UnaryExpr)*

    UnaryExpr: Primary

    Primary: Call | PropRef | Number | String | Bool | Identifier | "(" _ Expr _ ")"

    Call: DottedName _ "(" _ Args? _ ")"

    PropRef: DottedName

    Args: Expr (_ "," _ Expr)*

    CompOp: ">=" | "<=" | ">" | "<" | "==" | "!="

    ClassBody: ClassItem*

    ClassItem: PropertyDecl | MethodSig

    ObjectBody: Assign*

    Assign: Identifier _ AssignOp _ Value _ ";" _

    AssignOp: "+=" | "-=" | "="

    PropertyDecl: DataType __ Identifier Constraint? _ ";" _

    MethodSig: DataType __ Identifier _ "(" _ Params? _ ")" _ ";" _

    Constraint: "{" Spec "}"

    Spec: Number (".." Number)?

    Value: SetValue | String | Number | Bool | Identifier

    SetValue: "{" _ Elements? _ "}"

    Elements: Identifier (_ "," _ Identifier)*

    String: / "[^"]*" /

    Number: / [0-9]+(\.[0-9]+)? /

    Bool: "true" | "false"

    DataType: CollType | SimpleType

    CollType: ("set" | "list") "<" DataType ">"

    SimpleType: "string" | "integer" | "boolean" | "float"

    Identifier: / [a-zA-Z_][a-zA-Z0-9_]* /

    # Optional whitespace
    _: (Space | Comment)*

    # Required whitespace
    __: (Space | Comment)+

    Space: / \s /

    Comment: LineComment

    LineComment: "//" / [^\n]* /

    */

}