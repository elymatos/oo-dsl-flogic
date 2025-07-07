<?php

namespace OODSLFLogic\Parser\Generated;

use hafriedlander\Peg\Parser\Packrat;

use OODSLFLogic\AST\AssignmentNode;
use OODSLFLogic\AST\BinaryOpNode;
use OODSLFLogic\AST\BlockNode;
use OODSLFLogic\AST\BooleanNode;
use OODSLFLogic\AST\ClassNode;
use OODSLFLogic\AST\CollectionTypeNode;
use OODSLFLogic\AST\ConstraintNode;
use OODSLFLogic\AST\ExportNode;
use OODSLFLogic\AST\ExpressionNode;
use OODSLFLogic\AST\ExpressionStatementNode;
use OODSLFLogic\AST\FieldNode;
use OODSLFLogic\AST\FloatNode;
use OODSLFLogic\AST\IdentifierNode;
use OODSLFLogic\AST\IfNode;
use OODSLFLogic\AST\ImportNode;
use OODSLFLogic\AST\InheritanceNode;
use OODSLFLogic\AST\IntegerNode;
use OODSLFLogic\AST\LiteralNode;
use OODSLFLogic\AST\MethodCallNode;
use OODSLFLogic\AST\MethodNode;
use OODSLFLogic\AST\MethodSignatureNode;
use OODSLFLogic\AST\ModuleNode;
use OODSLFLogic\AST\Node;
use OODSLFLogic\AST\NodeVisitor;
use OODSLFLogic\AST\ObjectNode;
use OODSLFLogic\AST\ParameterNode;
use OODSLFLogic\AST\PrimitiveTypeNode;
use OODSLFLogic\AST\ProgramNode;
use OODSLFLogic\AST\PropertyAccessNode;
use OODSLFLogic\AST\QualifiedNameNode;
use OODSLFLogic\AST\QueryNode;
use OODSLFLogic\AST\RangeNode;
use OODSLFLogic\AST\ReturnNode;
use OODSLFLogic\AST\RuleNode;
use OODSLFLogic\AST\SelectNode;
use OODSLFLogic\AST\SetLiteralNode;
use OODSLFLogic\AST\SourceLocation;
use OODSLFLogic\AST\StringNode;
use OODSLFLogic\AST\ThisNode;
use OODSLFLogic\AST\TypeNode;
use OODSLFLogic\AST\UnaryOpNode;
use OODSLFLogic\AST\UserTypeNode;

class OODSLParser extends Packrat
{

    public ?string $currentFilename = null;

    /*!* OODSLParser

    # Global whitespace rule - Crucial for backtracking
    # This rule will automatically be applied between every token in other rules.
    #_: ( /[\s\t\n\r]* / | LineComment | BlockComment )*
    #_:  /[\s\t\n\r]* / >
    #_: (LineComment | BlockComment )*
    _:  /\s* /

    LineComment: /\/\/[^\n]*  / >
    BlockComment: /\/\*.*?\*\/ / >

    # Entry point - simplified
    Program: Statements

    # Simplified statement collection
    Statements: Statement*

    # Single statement with now implicit whitespace handling via '_'
    Statement: Declaration

    Declaration: ModuleDecl | ClassDecl | ObjectDecl | MethodDecl | RuleDecl | QueryDecl | ImportDecl | ExportDecl

    # Module declaration
    ModuleDecl: "module" > Identifier > "{" > ModuleBody > "}" >

    ModuleBody: (ModuleStatement* | _ ) >

    ModuleStatement: ClassDecl | ObjectDecl | MethodDecl | RuleDecl | ExportDecl

    # Class declaration - simplified
    ClassDecl: "class" > id:Identifier > inh:Inheritance? > "{" > ClassBody > "}" >
        function id(&$result, $sub ) {
            print_r($sub);
            print_r($result);
            print_r("----\n");
        }
        function inh(&$result, $sub ) {
            print_r($sub);
            print_r($result);
            print_r("----\n");
        }

    Inheritance: "inherits" > ( "structure" )? > "from" > inheritance:Identifier  >

    ClassBody: ClassMember*

    ClassMember: FieldDecl | MethodSignature

    # Field declaration - simplified
    FieldDecl: TypeSpec > Identifier > Constraint? ";" >

    # Type specifications
    TypeSpec: CollectionType | PrimitiveType | UserType

    PrimitiveType: "string" | "integer" | "boolean" | "float"

    UserType: Identifier >

    CollectionType: CollectionKeyword "<" TypeSpec ">" Constraint? >

    CollectionKeyword: "set" | "list" | "bag"

    Constraint: "{" ConstraintExpr "}" >

    ConstraintExpr: Range | Number

    Range: Number ".." Number >

    # Method signature
    MethodSignature: TypeSpec Identifier "(" ParamList? ")" ";" >

    # Object declaration
    ObjectDecl: "object" Identifier ":" Identifier "{" ObjectBody "}" >

    ObjectBody: Assignment* >

    Assignment: Identifier AssignOp Expression ";" >

    AssignOp: "+=" | "-=" | "="

    # Method declaration
    MethodDecl: "method" QualifiedName "(" ParamList? ")" ReturnType? BlockStmt >

    ReturnType: "returns" TypeSpec >

    ParamList: Parameter ( "," Parameter )* >

    Parameter: TypeSpec Identifier >

    # Rule declaration
    RuleDecl: "rule" Identifier "{" RuleBody "}" >

    RuleBody: IfStmt | Assignment

    # Query declaration
    QueryDecl: "query" Identifier "{" QueryBody "}" >

    QueryBody: "select" Identifier "where" Expression ";" >

    # Statements
    IfStmt: "if" "(" Expression ")" BlockStmt ElseClause? >

    ElseClause: "else" BlockStmt >

    BlockStmt: "{" StmtList "}" >

    StmtList: InnerStmt* >

    InnerStmt: Assignment | IfStmt | ReturnStmt | ExprStmt >

    ReturnStmt: "return" Expression ";" >

    ExprStmt: Expression ";" >

    # Expressions - left-associative, simplified
    Expression: LogicalExpr >

    LogicalExpr: ComparisonExpr ( LogicalOp ComparisonExpr )* >

    LogicalOp: "&&" | "||" | "and" | "or" >

    ComparisonExpr: AdditiveExpr ( ComparisonOp AdditiveExpr )? >

    ComparisonOp: "==" | "!=" | "<=" | ">=" | "<" | ">" >

    AdditiveExpr: MultiplicativeExpr ( AdditiveOp MultiplicativeExpr )* >

    AdditiveOp: "+" | "-" >

    MultiplicativeExpr: UnaryExpr ( MultiplicativeOp UnaryExpr )* >

    MultiplicativeOp: "*" | "/" | "%" >

    UnaryExpr: UnaryOp? PrimaryExpr >

    UnaryOp: "!" | "not" | "-"

    # Primary expressions - simplified ordering
    PrimaryExpr: Literal | MethodCall | PropertyAccess | ThisKeyword | ParenExpr | SetLiteral

    ParenExpr: "(" Expression ")" >

    ThisKeyword: "this"

    MethodCall: QualifiedName "(" ArgList? ")" >

    PropertyAccess: QualifiedName >

    QualifiedName: Identifier ( "." Identifier )* >

    ArgList: Expression ( "," Expression )* >

    SetLiteral: "{" ElemList? "}" >

    ElemList: Expression ( "," Expression )* >

    # Literals - simple order
    Literal: String | Float | Number | Boolean | Identifier

    String: /"[^"]*"/ >

    Float: /[0-9]+\.[0-9]+/ >

    Number: /[0-9]+/

    Boolean: "true" | "false"

    Identifier: / [a-zA-Z_][a-zA-Z0-9_]* /

    # Import/Export
    ImportDecl: "import" QualifiedName ImportList? ";" >

    ImportList: "." "{" IdentList "}" >

    ExportDecl: "export" IdentList ";" >

    IdentList: Identifier ( "," Identifier )* >

    */

    function whitespace() {
        $matched = preg_match( '/[ \n\r\t]+/', $this->string, $matches, PREG_OFFSET_CAPTURE, $this->pos ) ;
        if ( $matched && $matches[0][1] == $this->pos ) {
            $this->pos += strlen( $matches[0][0] );
            return ' ' ;
        }
        return FALSE ;
    }

    function Program__finalise(&$result)
    {
//        print_r("Program__finalise\n");
//        $result = new ProgramNode($result['Statements'] ?? []);
    }

    function Statements__finalise(&$result)
    {
//        print_r("Statements__finalise\n");
//        $statements = [];
//        foreach ($result as $item) {
//            if (is_object($item)) {
//                $statements[] = $item;
//            }
//        }
//        $result = $statements;
    }

    function Statement__finalise(&$result)
    {
//        print_r("Statement__finalise\n");
//        return $result['Declaration'];
    }

    function ModuleDecl__finalise(&$result)
    {
//        print_r("ModuleDecl__finalise\n");
//        $name = new IdentifierNode($result['Identifier']);
//        $result = new ModuleNode($name, $result['ModuleBody']);
    }

    function ModuleBody__finalise(&$result)
    {
//        $statements = [];
//        foreach ($result as $item) {
//            if (isset($item['ModuleStatement']) && is_object($item['ModuleStatement'])) {
//                $statements[] = $item['ModuleStatement'];
//            }
//        }
//        return $statements;
    }

    function ClassDecl__finalise(&$result)
    {
        print_r($result);
//        $name = new IdentifierNode($result['Identifier']);
//        $inheritance = $result['Inheritance'] ?? null;
//        return new ClassNode($name, $inheritance, $result['ClassBody']);
    }

    function Inheritance__finalise(&$result)
    {
//        $type = (count($result) > 2) ? 'structure' : null;
//        $parent = new IdentifierNode($result[count($result) - 1]);
//        return new InheritanceNode($type, $parent);
    }

    function ClassBody__finalise(&$result)
    {
//        $members = [];
//        foreach ($result as $item) {
//            if (isset($item['ClassMember']) && is_object($item['ClassMember'])) {
//                $members[] = $item['ClassMember'];
//            }
//        }
//        return $members;
    }

    function FieldDecl__finalise(&$result)
    {
//        $name = new IdentifierNode($result['Identifier']);
//        $constraint = $result['Constraint'] ?? null;
//        return new FieldNode($result['TypeSpec'], $name, $constraint);
    }

    function PrimitiveType__finalise(&$result)
    {
//        return new PrimitiveTypeNode($result['text']);
    }

    function UserType__finalise(&$result)
    {
//        return new UserTypeNode(new IdentifierNode($result['text']));
    }

    function CollectionType__finalise(&$result)
    {
//        $constraint = $result['Constraint'] ?? null;
//        return new CollectionTypeNode($result['CollectionKeyword'], $result['TypeSpec'], $constraint);
    }

    function Constraint__finalise(&$result)
    {
//        return new ConstraintNode($result['ConstraintExpr']);
    }

    function Range__finalise(&$result)
    {
//        return new RangeNode($result['Number'][0], $result['Number'][1]);
    }

    function MethodSignature__finalise(&$result)
    {
//        $name = new IdentifierNode($result['Identifier']);
//        $params = $result['ParamList'] ?? [];
//        return new MethodSignatureNode($result['TypeSpec'], $name, $params);
    }

    function ObjectDecl__finalise(&$result)
    {
//        $name = new IdentifierNode($result['Identifier'][0]);
//        $className = new IdentifierNode($result['Identifier'][1]);
//        return new ObjectNode($name, $className, $result['ObjectBody']);
    }

    function ObjectBody__finalise(&$result)
    {
//        $assignments = [];
//        foreach ($result as $item) {
//            if (isset($item['Assignment']) && is_object($item['Assignment'])) {
//                $assignments[] = $item['Assignment'];
//            }
//        }
//        return $assignments;
    }

    function Assignment__finalise(&$result)
    {
//        $target = new IdentifierNode($result['Identifier']);
//        return new AssignmentNode($target, $result['AssignOp'], $result['Expression']);
    }

    function MethodDecl__finalise(&$result)
    {
//        $params = $result['ParamList'] ?? [];
//        $returnType = $result['ReturnType'] ?? null;
//        return new MethodNode($result['QualifiedName'], $params, $returnType, $result['BlockStmt']);
    }

    function ReturnType__finalise(&$result)
    {
//        return $result['TypeSpec'];
    }

    function ParamList__finalise(&$result)
    {
//        $params = [$result['Parameter']];
//        for ($i = 1; $i < count($result); $i += 2) {
//            if (isset($result[$i + 1])) {
//                $params[] = $result[$i + 1];
//            }
//        }
//        return $params;
    }

    function Parameter__finalise(&$result)
    {
//        $name = new IdentifierNode($result['Identifier']);
//        return new ParameterNode($result['TypeSpec'], $name);
    }

    function RuleDecl__finalise(&$result)
    {
//        $name = new IdentifierNode($result['Identifier']);
//        return new RuleNode($name, $result['RuleBody']);
    }

    function QueryDecl__finalise(&$result)
    {
//        $name = new IdentifierNode($result['Identifier']);
//        return new QueryNode($name, $result['QueryBody']);
    }

    function QueryBody__finalise(&$result)
    {
//        $target = new IdentifierNode($result['Identifier']);
//        return new SelectNode($target, $result['Expression']);
    }

    function IfStmt__finalise(&$result)
    {
//        $elseBlock = $result['ElseClause'] ?? null;
//        return new IfNode($result['Expression'], $result['BlockStmt'], $elseBlock);
    }

    function ElseClause__finalise(&$result)
    {
//        return $result['BlockStmt'];
    }

    function BlockStmt__finalise(&$result)
    {
//        return new BlockNode($result['StmtList']);
    }

    function StmtList__finalise(&$result)
    {
//        $statements = [];
//        foreach ($result as $item) {
//            if (isset($item['InnerStmt']) && is_object($item['InnerStmt'])) {
//                $statements[] = $item['InnerStmt'];
//            }
//        }
//        return $statements;
    }

    function ReturnStmt__finalise(&$result)
    {
//        return new ReturnNode($result['Expression']);
    }

    function ExprStmt__finalise(&$result)
    {
//        return new ExpressionStatementNode($result['Expression']);
    }

    # Expressions - left-associative, simplified
    function LogicalExpr__finalise(&$result)
    {
//        $left = $result['ComparisonExpr'];
//        for ($i = 1; $i < count($result); $i += 2) {
//            if (isset($result[$i]) && isset($result[$i + 1])) {
//                $op = $result[$i];
//                $right = $result[$i + 1];
//                $left = new BinaryOpNode($left, $op, $right);
//            }
//        }
//        return $left;
    }

    function ComparisonExpr__finalise(&$result)
    {
//        if (count($result) > 1) {
//            return new BinaryOpNode($result['AdditiveExpr'], $result[1], $result[2]);
//        }
//        return $result['AdditiveExpr'];
    }

    function AdditiveExpr__finalise(&$result)
    {
//        $left = $result['MultiplicativeExpr'];
//        for ($i = 1; $i < count($result); $i += 2) {
//            if (isset($result[$i]) && isset($result[$i + 1])) {
//                $op = $result[$i];
//                $right = $result[$i + 1];
//                $left = new BinaryOpNode($left, $op, $right);
//            }
//        }
//        return $left;
    }

    function MultiplicativeExpr__finalise(&$result)
    {
//        $left = $result['UnaryExpr'];
//        for ($i = 1; $i < count($result); $i += 2) {
//            if (isset($result[$i]) && isset($result[$i + 1])) {
//                $op = $result[$i];
//                $right = $result[$i + 1];
//                $left = new BinaryOpNode($left, $op, $right);
//            }
//        }
//        return $left;
    }

    function UnaryExpr__finalise(&$result)
    {
//        if (isset($result['UnaryOp'])) {
//            return new UnaryOpNode($result['UnaryOp'], $result['PrimaryExpr']);
//        }
//        return $result['PrimaryExpr'];
    }

    function ParenExpr__finalise(&$result)
    {
//        return $result['Expression'];
    }

    function ThisKeyword__finalise(&$result)
    {
//        return new ThisNode();
    }

    function MethodCall__finalise(&$result)
    {
//        $args = $result['ArgList'] ?? [];
//        return new MethodCallNode($result['QualifiedName'], $args);
    }

    function PropertyAccess__finalise(&$result)
    {
//        return new PropertyAccessNode($result['QualifiedName']);
    }

    function QualifiedName__finalise(&$result)
    {
//        $parts = [new IdentifierNode($result['Identifier'])];
//        for ($i = 1; $i < count($result); $i += 2) {
//            if (isset($result[$i + 1])) {
//                $parts[] = new IdentifierNode($result[$i + 1]);
//            }
//        }
//        return new QualifiedNameNode($parts);
    }

    function ArgList__finalise(&$result)
    {
//        $args = [$result['Expression']];
//        for ($i = 1; $i < count($result); $i += 2) {
//            if (isset($result[$i + 1])) {
//                $args[] = $result[$i + 1];
//            }
//        }
//        return $args;
    }

    function SetLiteral__finalise(&$result)
    {
//        $elements = $result['ElemList'] ?? [];
//        return new SetLiteralNode($elements);
    }

    function ElemList__finalise(&$result)
    {
//        $elements = [$result['Expression']];
//        for ($i = 1; $i < count($result); $i += 2) {
//            if (isset($result[$i + 1])) {
//                $elements[] = $result[$i + 1];
//            }
//        }
//        return $elements;
    }

    function String__finalise(&$result)
    {
//        $value = substr($result['text'], 1, -1);
//        return new StringNode($value);
    }

    function Float__finalise(&$result)
    {
//        return new FloatNode((float)$result['text']);
    }

    function Number__finalise(&$result)
    {
//        return new IntegerNode((int)$result['text']);
    }

    function Boolean__finalise(&$result)
    {
//        return new BooleanNode($result['text'] === 'true');
    }

    function Identifier__finalise(&$result)
    {
//        return $result['text'];
    }

    function ImportDecl__finalise(&$result)
    {
//        $imports = $result['ImportList'] ?? null;
//        return new ImportNode($result['QualifiedName'], $imports);
    }

    function ImportList__finalise(&$result)
    {
//        return $result['IdentList'];
    }

    function ExportDecl__finalise(&$result)
    {
//        return new ExportNode($result['IdentList']);
    }

    function IdentList__finalise(&$result)
    {
//        $identifiers = [new IdentifierNode($result['Identifier'])];
//        for ($i = 1; $i < count($result); $i += 2) {
//            if (isset($result[$i + 1])) {
//                $identifiers[] = new IdentifierNode($result[$i + 1]);
//            }
//        }
//        return $identifiers;
    }


}