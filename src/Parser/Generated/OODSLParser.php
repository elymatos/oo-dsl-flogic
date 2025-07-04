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

    /* _:  /\s* / */
    protected $match___typestack = array('_');
    function match__ ($stack = array()) {
    	$matchrule = "_"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/\s* /' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* LineComment: /\/\/[^\n]*  / > */
    protected $match_LineComment_typestack = array('LineComment');
    function match_LineComment ($stack = array()) {
    	$matchrule = "LineComment"; $result = $this->construct($matchrule, $matchrule, null);
    	$_3 = NULL;
    	do {
    		if (( $subres = $this->rx( '/\/\/[^\n]*  /' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_3 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_3 = TRUE; break;
    	}
    	while(0);
    	if( $_3 === TRUE ) { return $this->finalise($result); }
    	if( $_3 === FALSE) { return FALSE; }
    }


    /* BlockComment: /\/\*.*?\*\/ / > */
    protected $match_BlockComment_typestack = array('BlockComment');
    function match_BlockComment ($stack = array()) {
    	$matchrule = "BlockComment"; $result = $this->construct($matchrule, $matchrule, null);
    	$_7 = NULL;
    	do {
    		if (( $subres = $this->rx( '/\/\*.*?\*\/ /' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_7 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_7 = TRUE; break;
    	}
    	while(0);
    	if( $_7 === TRUE ) { return $this->finalise($result); }
    	if( $_7 === FALSE) { return FALSE; }
    }


    /* Program: Statements */
    protected $match_Program_typestack = array('Program');
    function match_Program ($stack = array()) {
    	$matchrule = "Program"; $result = $this->construct($matchrule, $matchrule, null);
    	$matcher = 'match_'.'Statements'; $key = $matcher; $pos = $this->pos;
    	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    	if ($subres !== FALSE) {
    		$this->store( $result, $subres );
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* Statements: Statement* */
    protected $match_Statements_typestack = array('Statements');
    function match_Statements ($stack = array()) {
    	$matchrule = "Statements"; $result = $this->construct($matchrule, $matchrule, null);
    	while (true) {
    		$res_10 = $result;
    		$pos_10 = $this->pos;
    		$matcher = 'match_'.'Statement'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_10;
    			$this->pos = $pos_10;
    			unset( $res_10 );
    			unset( $pos_10 );
    			break;
    		}
    	}
    	return $this->finalise($result);
    }


    /* Statement: Declaration */
    protected $match_Statement_typestack = array('Statement');
    function match_Statement ($stack = array()) {
    	$matchrule = "Statement"; $result = $this->construct($matchrule, $matchrule, null);
    	$matcher = 'match_'.'Declaration'; $key = $matcher; $pos = $this->pos;
    	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    	if ($subres !== FALSE) {
    		$this->store( $result, $subres );
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* Declaration: ModuleDecl | ClassDecl | ObjectDecl | MethodDecl | RuleDecl | QueryDecl | ImportDecl | ExportDecl */
    protected $match_Declaration_typestack = array('Declaration');
    function match_Declaration ($stack = array()) {
    	$matchrule = "Declaration"; $result = $this->construct($matchrule, $matchrule, null);
    	$_39 = NULL;
    	do {
    		$res_12 = $result;
    		$pos_12 = $this->pos;
    		$matcher = 'match_'.'ModuleDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_39 = TRUE; break;
    		}
    		$result = $res_12;
    		$this->pos = $pos_12;
    		$_37 = NULL;
    		do {
    			$res_14 = $result;
    			$pos_14 = $this->pos;
    			$matcher = 'match_'.'ClassDecl'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_37 = TRUE; break;
    			}
    			$result = $res_14;
    			$this->pos = $pos_14;
    			$_35 = NULL;
    			do {
    				$res_16 = $result;
    				$pos_16 = $this->pos;
    				$matcher = 'match_'.'ObjectDecl'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_35 = TRUE; break;
    				}
    				$result = $res_16;
    				$this->pos = $pos_16;
    				$_33 = NULL;
    				do {
    					$res_18 = $result;
    					$pos_18 = $this->pos;
    					$matcher = 'match_'.'MethodDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_33 = TRUE; break;
    					}
    					$result = $res_18;
    					$this->pos = $pos_18;
    					$_31 = NULL;
    					do {
    						$res_20 = $result;
    						$pos_20 = $this->pos;
    						$matcher = 'match_'.'RuleDecl'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_31 = TRUE; break;
    						}
    						$result = $res_20;
    						$this->pos = $pos_20;
    						$_29 = NULL;
    						do {
    							$res_22 = $result;
    							$pos_22 = $this->pos;
    							$matcher = 'match_'.'QueryDecl'; $key = $matcher; $pos = $this->pos;
    							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    							if ($subres !== FALSE) {
    								$this->store( $result, $subres );
    								$_29 = TRUE; break;
    							}
    							$result = $res_22;
    							$this->pos = $pos_22;
    							$_27 = NULL;
    							do {
    								$res_24 = $result;
    								$pos_24 = $this->pos;
    								$matcher = 'match_'.'ImportDecl'; $key = $matcher; $pos = $this->pos;
    								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    								if ($subres !== FALSE) {
    									$this->store( $result, $subres );
    									$_27 = TRUE; break;
    								}
    								$result = $res_24;
    								$this->pos = $pos_24;
    								$matcher = 'match_'.'ExportDecl'; $key = $matcher; $pos = $this->pos;
    								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    								if ($subres !== FALSE) {
    									$this->store( $result, $subres );
    									$_27 = TRUE; break;
    								}
    								$result = $res_24;
    								$this->pos = $pos_24;
    								$_27 = FALSE; break;
    							}
    							while(0);
    							if( $_27 === TRUE ) { $_29 = TRUE; break; }
    							$result = $res_22;
    							$this->pos = $pos_22;
    							$_29 = FALSE; break;
    						}
    						while(0);
    						if( $_29 === TRUE ) { $_31 = TRUE; break; }
    						$result = $res_20;
    						$this->pos = $pos_20;
    						$_31 = FALSE; break;
    					}
    					while(0);
    					if( $_31 === TRUE ) { $_33 = TRUE; break; }
    					$result = $res_18;
    					$this->pos = $pos_18;
    					$_33 = FALSE; break;
    				}
    				while(0);
    				if( $_33 === TRUE ) { $_35 = TRUE; break; }
    				$result = $res_16;
    				$this->pos = $pos_16;
    				$_35 = FALSE; break;
    			}
    			while(0);
    			if( $_35 === TRUE ) { $_37 = TRUE; break; }
    			$result = $res_14;
    			$this->pos = $pos_14;
    			$_37 = FALSE; break;
    		}
    		while(0);
    		if( $_37 === TRUE ) { $_39 = TRUE; break; }
    		$result = $res_12;
    		$this->pos = $pos_12;
    		$_39 = FALSE; break;
    	}
    	while(0);
    	if( $_39 === TRUE ) { return $this->finalise($result); }
    	if( $_39 === FALSE) { return FALSE; }
    }


    /* ModuleDecl: "module" > Identifier > "{" > ModuleBody > "}" > */
    protected $match_ModuleDecl_typestack = array('ModuleDecl');
    function match_ModuleDecl ($stack = array()) {
    	$matchrule = "ModuleDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_51 = NULL;
    	do {
    		if (( $subres = $this->literal( 'module' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_51 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_51 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_51 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$matcher = 'match_'.'ModuleBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_51 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_51 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_51 = TRUE; break;
    	}
    	while(0);
    	if( $_51 === TRUE ) { return $this->finalise($result); }
    	if( $_51 === FALSE) { return FALSE; }
    }


    /* ModuleBody: (ModuleStatement* | _ ) > */
    protected $match_ModuleBody_typestack = array('ModuleBody');
    function match_ModuleBody ($stack = array()) {
    	$matchrule = "ModuleBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_61 = NULL;
    	do {
    		$_58 = NULL;
    		do {
    			$_56 = NULL;
    			do {
    				$res_53 = $result;
    				$pos_53 = $this->pos;
    				while (true) {
    					$res_54 = $result;
    					$pos_54 = $this->pos;
    					$matcher = 'match_'.'ModuleStatement'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    					}
    					else {
    						$result = $res_54;
    						$this->pos = $pos_54;
    						unset( $res_54 );
    						unset( $pos_54 );
    						break;
    					}
    				}
    				$_56 = TRUE; break;
    				$result = $res_53;
    				$this->pos = $pos_53;
    				$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_56 = TRUE; break;
    				}
    				$result = $res_53;
    				$this->pos = $pos_53;
    				$_56 = FALSE; break;
    			}
    			while(0);
    			if( $_56 === FALSE) { $_58 = FALSE; break; }
    			$_58 = TRUE; break;
    		}
    		while(0);
    		if( $_58 === FALSE) { $_61 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_61 = TRUE; break;
    	}
    	while(0);
    	if( $_61 === TRUE ) { return $this->finalise($result); }
    	if( $_61 === FALSE) { return FALSE; }
    }


    /* ModuleStatement: ClassDecl | ObjectDecl | MethodDecl | RuleDecl | ExportDecl */
    protected $match_ModuleStatement_typestack = array('ModuleStatement');
    function match_ModuleStatement ($stack = array()) {
    	$matchrule = "ModuleStatement"; $result = $this->construct($matchrule, $matchrule, null);
    	$_78 = NULL;
    	do {
    		$res_63 = $result;
    		$pos_63 = $this->pos;
    		$matcher = 'match_'.'ClassDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_78 = TRUE; break;
    		}
    		$result = $res_63;
    		$this->pos = $pos_63;
    		$_76 = NULL;
    		do {
    			$res_65 = $result;
    			$pos_65 = $this->pos;
    			$matcher = 'match_'.'ObjectDecl'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_76 = TRUE; break;
    			}
    			$result = $res_65;
    			$this->pos = $pos_65;
    			$_74 = NULL;
    			do {
    				$res_67 = $result;
    				$pos_67 = $this->pos;
    				$matcher = 'match_'.'MethodDecl'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_74 = TRUE; break;
    				}
    				$result = $res_67;
    				$this->pos = $pos_67;
    				$_72 = NULL;
    				do {
    					$res_69 = $result;
    					$pos_69 = $this->pos;
    					$matcher = 'match_'.'RuleDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_72 = TRUE; break;
    					}
    					$result = $res_69;
    					$this->pos = $pos_69;
    					$matcher = 'match_'.'ExportDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_72 = TRUE; break;
    					}
    					$result = $res_69;
    					$this->pos = $pos_69;
    					$_72 = FALSE; break;
    				}
    				while(0);
    				if( $_72 === TRUE ) { $_74 = TRUE; break; }
    				$result = $res_67;
    				$this->pos = $pos_67;
    				$_74 = FALSE; break;
    			}
    			while(0);
    			if( $_74 === TRUE ) { $_76 = TRUE; break; }
    			$result = $res_65;
    			$this->pos = $pos_65;
    			$_76 = FALSE; break;
    		}
    		while(0);
    		if( $_76 === TRUE ) { $_78 = TRUE; break; }
    		$result = $res_63;
    		$this->pos = $pos_63;
    		$_78 = FALSE; break;
    	}
    	while(0);
    	if( $_78 === TRUE ) { return $this->finalise($result); }
    	if( $_78 === FALSE) { return FALSE; }
    }


    /* ClassDecl: "class" Identifier Inheritance? "{" ClassBody "}" > */
    protected $match_ClassDecl_typestack = array('ClassDecl');
    function match_ClassDecl ($stack = array()) {
    	$matchrule = "ClassDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_87 = NULL;
    	do {
    		if (( $subres = $this->literal( 'class' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_87 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_87 = FALSE; break; }
    		$res_82 = $result;
    		$pos_82 = $this->pos;
    		$matcher = 'match_'.'Inheritance'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_82;
    			$this->pos = $pos_82;
    			unset( $res_82 );
    			unset( $pos_82 );
    		}
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_87 = FALSE; break; }
    		$matcher = 'match_'.'ClassBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_87 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_87 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_87 = TRUE; break;
    	}
    	while(0);
    	if( $_87 === TRUE ) { return $this->finalise($result); }
    	if( $_87 === FALSE) { return FALSE; }
    }


    /* Inheritance: "inherits" ( "structure" )? "from" Identifier  > */
    protected $match_Inheritance_typestack = array('Inheritance');
    function match_Inheritance ($stack = array()) {
    	$matchrule = "Inheritance"; $result = $this->construct($matchrule, $matchrule, null);
    	$_96 = NULL;
    	do {
    		if (( $subres = $this->literal( 'inherits' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_96 = FALSE; break; }
    		$res_92 = $result;
    		$pos_92 = $this->pos;
    		$_91 = NULL;
    		do {
    			if (( $subres = $this->literal( 'structure' ) ) !== FALSE) { $result["text"] .= $subres; }
    			else { $_91 = FALSE; break; }
    			$_91 = TRUE; break;
    		}
    		while(0);
    		if( $_91 === FALSE) {
    			$result = $res_92;
    			$this->pos = $pos_92;
    			unset( $res_92 );
    			unset( $pos_92 );
    		}
    		if (( $subres = $this->literal( 'from' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_96 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_96 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_96 = TRUE; break;
    	}
    	while(0);
    	if( $_96 === TRUE ) { return $this->finalise($result); }
    	if( $_96 === FALSE) { return FALSE; }
    }


    /* ClassBody: ClassMember* > */
    protected $match_ClassBody_typestack = array('ClassBody');
    function match_ClassBody ($stack = array()) {
    	$matchrule = "ClassBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_100 = NULL;
    	do {
    		while (true) {
    			$res_98 = $result;
    			$pos_98 = $this->pos;
    			$matcher = 'match_'.'ClassMember'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_98;
    				$this->pos = $pos_98;
    				unset( $res_98 );
    				unset( $pos_98 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_100 = TRUE; break;
    	}
    	while(0);
    	if( $_100 === TRUE ) { return $this->finalise($result); }
    	if( $_100 === FALSE) { return FALSE; }
    }


    /* ClassMember: FieldDecl | MethodSignature */
    protected $match_ClassMember_typestack = array('ClassMember');
    function match_ClassMember ($stack = array()) {
    	$matchrule = "ClassMember"; $result = $this->construct($matchrule, $matchrule, null);
    	$_105 = NULL;
    	do {
    		$res_102 = $result;
    		$pos_102 = $this->pos;
    		$matcher = 'match_'.'FieldDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_105 = TRUE; break;
    		}
    		$result = $res_102;
    		$this->pos = $pos_102;
    		$matcher = 'match_'.'MethodSignature'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_105 = TRUE; break;
    		}
    		$result = $res_102;
    		$this->pos = $pos_102;
    		$_105 = FALSE; break;
    	}
    	while(0);
    	if( $_105 === TRUE ) { return $this->finalise($result); }
    	if( $_105 === FALSE) { return FALSE; }
    }


    /* FieldDecl: TypeSpec Identifier Constraint? ";" > */
    protected $match_FieldDecl_typestack = array('FieldDecl');
    function match_FieldDecl ($stack = array()) {
    	$matchrule = "FieldDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_112 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_112 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_112 = FALSE; break; }
    		$res_109 = $result;
    		$pos_109 = $this->pos;
    		$matcher = 'match_'.'Constraint'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_109;
    			$this->pos = $pos_109;
    			unset( $res_109 );
    			unset( $pos_109 );
    		}
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_112 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_112 = TRUE; break;
    	}
    	while(0);
    	if( $_112 === TRUE ) { return $this->finalise($result); }
    	if( $_112 === FALSE) { return FALSE; }
    }


    /* TypeSpec: CollectionType | PrimitiveType | UserType */
    protected $match_TypeSpec_typestack = array('TypeSpec');
    function match_TypeSpec ($stack = array()) {
    	$matchrule = "TypeSpec"; $result = $this->construct($matchrule, $matchrule, null);
    	$_121 = NULL;
    	do {
    		$res_114 = $result;
    		$pos_114 = $this->pos;
    		$matcher = 'match_'.'CollectionType'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_121 = TRUE; break;
    		}
    		$result = $res_114;
    		$this->pos = $pos_114;
    		$_119 = NULL;
    		do {
    			$res_116 = $result;
    			$pos_116 = $this->pos;
    			$matcher = 'match_'.'PrimitiveType'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_119 = TRUE; break;
    			}
    			$result = $res_116;
    			$this->pos = $pos_116;
    			$matcher = 'match_'.'UserType'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_119 = TRUE; break;
    			}
    			$result = $res_116;
    			$this->pos = $pos_116;
    			$_119 = FALSE; break;
    		}
    		while(0);
    		if( $_119 === TRUE ) { $_121 = TRUE; break; }
    		$result = $res_114;
    		$this->pos = $pos_114;
    		$_121 = FALSE; break;
    	}
    	while(0);
    	if( $_121 === TRUE ) { return $this->finalise($result); }
    	if( $_121 === FALSE) { return FALSE; }
    }


    /* PrimitiveType: "string" | "integer" | "boolean" | "float" */
    protected $match_PrimitiveType_typestack = array('PrimitiveType');
    function match_PrimitiveType ($stack = array()) {
    	$matchrule = "PrimitiveType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_134 = NULL;
    	do {
    		$res_123 = $result;
    		$pos_123 = $this->pos;
    		if (( $subres = $this->literal( 'string' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_134 = TRUE; break;
    		}
    		$result = $res_123;
    		$this->pos = $pos_123;
    		$_132 = NULL;
    		do {
    			$res_125 = $result;
    			$pos_125 = $this->pos;
    			if (( $subres = $this->literal( 'integer' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_132 = TRUE; break;
    			}
    			$result = $res_125;
    			$this->pos = $pos_125;
    			$_130 = NULL;
    			do {
    				$res_127 = $result;
    				$pos_127 = $this->pos;
    				if (( $subres = $this->literal( 'boolean' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_130 = TRUE; break;
    				}
    				$result = $res_127;
    				$this->pos = $pos_127;
    				if (( $subres = $this->literal( 'float' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_130 = TRUE; break;
    				}
    				$result = $res_127;
    				$this->pos = $pos_127;
    				$_130 = FALSE; break;
    			}
    			while(0);
    			if( $_130 === TRUE ) { $_132 = TRUE; break; }
    			$result = $res_125;
    			$this->pos = $pos_125;
    			$_132 = FALSE; break;
    		}
    		while(0);
    		if( $_132 === TRUE ) { $_134 = TRUE; break; }
    		$result = $res_123;
    		$this->pos = $pos_123;
    		$_134 = FALSE; break;
    	}
    	while(0);
    	if( $_134 === TRUE ) { return $this->finalise($result); }
    	if( $_134 === FALSE) { return FALSE; }
    }


    /* UserType: Identifier > */
    protected $match_UserType_typestack = array('UserType');
    function match_UserType ($stack = array()) {
    	$matchrule = "UserType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_138 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_138 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_138 = TRUE; break;
    	}
    	while(0);
    	if( $_138 === TRUE ) { return $this->finalise($result); }
    	if( $_138 === FALSE) { return FALSE; }
    }


    /* CollectionType: CollectionKeyword "<" TypeSpec ">" Constraint? > */
    protected $match_CollectionType_typestack = array('CollectionType');
    function match_CollectionType ($stack = array()) {
    	$matchrule = "CollectionType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_146 = NULL;
    	do {
    		$matcher = 'match_'.'CollectionKeyword'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_146 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '<') {
    			$this->pos += 1;
    			$result["text"] .= '<';
    		}
    		else { $_146 = FALSE; break; }
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_146 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '>') {
    			$this->pos += 1;
    			$result["text"] .= '>';
    		}
    		else { $_146 = FALSE; break; }
    		$res_144 = $result;
    		$pos_144 = $this->pos;
    		$matcher = 'match_'.'Constraint'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_144;
    			$this->pos = $pos_144;
    			unset( $res_144 );
    			unset( $pos_144 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_146 = TRUE; break;
    	}
    	while(0);
    	if( $_146 === TRUE ) { return $this->finalise($result); }
    	if( $_146 === FALSE) { return FALSE; }
    }


    /* CollectionKeyword: "set" | "list" | "bag" */
    protected $match_CollectionKeyword_typestack = array('CollectionKeyword');
    function match_CollectionKeyword ($stack = array()) {
    	$matchrule = "CollectionKeyword"; $result = $this->construct($matchrule, $matchrule, null);
    	$_155 = NULL;
    	do {
    		$res_148 = $result;
    		$pos_148 = $this->pos;
    		if (( $subres = $this->literal( 'set' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_155 = TRUE; break;
    		}
    		$result = $res_148;
    		$this->pos = $pos_148;
    		$_153 = NULL;
    		do {
    			$res_150 = $result;
    			$pos_150 = $this->pos;
    			if (( $subres = $this->literal( 'list' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_153 = TRUE; break;
    			}
    			$result = $res_150;
    			$this->pos = $pos_150;
    			if (( $subres = $this->literal( 'bag' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_153 = TRUE; break;
    			}
    			$result = $res_150;
    			$this->pos = $pos_150;
    			$_153 = FALSE; break;
    		}
    		while(0);
    		if( $_153 === TRUE ) { $_155 = TRUE; break; }
    		$result = $res_148;
    		$this->pos = $pos_148;
    		$_155 = FALSE; break;
    	}
    	while(0);
    	if( $_155 === TRUE ) { return $this->finalise($result); }
    	if( $_155 === FALSE) { return FALSE; }
    }


    /* Constraint: "{" ConstraintExpr "}" > */
    protected $match_Constraint_typestack = array('Constraint');
    function match_Constraint ($stack = array()) {
    	$matchrule = "Constraint"; $result = $this->construct($matchrule, $matchrule, null);
    	$_161 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_161 = FALSE; break; }
    		$matcher = 'match_'.'ConstraintExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_161 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_161 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_161 = TRUE; break;
    	}
    	while(0);
    	if( $_161 === TRUE ) { return $this->finalise($result); }
    	if( $_161 === FALSE) { return FALSE; }
    }


    /* ConstraintExpr: Range | Number */
    protected $match_ConstraintExpr_typestack = array('ConstraintExpr');
    function match_ConstraintExpr ($stack = array()) {
    	$matchrule = "ConstraintExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_166 = NULL;
    	do {
    		$res_163 = $result;
    		$pos_163 = $this->pos;
    		$matcher = 'match_'.'Range'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_166 = TRUE; break;
    		}
    		$result = $res_163;
    		$this->pos = $pos_163;
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_166 = TRUE; break;
    		}
    		$result = $res_163;
    		$this->pos = $pos_163;
    		$_166 = FALSE; break;
    	}
    	while(0);
    	if( $_166 === TRUE ) { return $this->finalise($result); }
    	if( $_166 === FALSE) { return FALSE; }
    }


    /* Range: Number ".." Number > */
    protected $match_Range_typestack = array('Range');
    function match_Range ($stack = array()) {
    	$matchrule = "Range"; $result = $this->construct($matchrule, $matchrule, null);
    	$_172 = NULL;
    	do {
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_172 = FALSE; break; }
    		if (( $subres = $this->literal( '..' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_172 = FALSE; break; }
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_172 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_172 = TRUE; break;
    	}
    	while(0);
    	if( $_172 === TRUE ) { return $this->finalise($result); }
    	if( $_172 === FALSE) { return FALSE; }
    }


    /* MethodSignature: TypeSpec Identifier "(" ParamList? ")" ";" > */
    protected $match_MethodSignature_typestack = array('MethodSignature');
    function match_MethodSignature ($stack = array()) {
    	$matchrule = "MethodSignature"; $result = $this->construct($matchrule, $matchrule, null);
    	$_181 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_181 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_181 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_181 = FALSE; break; }
    		$res_177 = $result;
    		$pos_177 = $this->pos;
    		$matcher = 'match_'.'ParamList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_177;
    			$this->pos = $pos_177;
    			unset( $res_177 );
    			unset( $pos_177 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_181 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_181 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_181 = TRUE; break;
    	}
    	while(0);
    	if( $_181 === TRUE ) { return $this->finalise($result); }
    	if( $_181 === FALSE) { return FALSE; }
    }


    /* ObjectDecl: "object" Identifier ":" Identifier "{" ObjectBody "}" > */
    protected $match_ObjectDecl_typestack = array('ObjectDecl');
    function match_ObjectDecl ($stack = array()) {
    	$matchrule = "ObjectDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_191 = NULL;
    	do {
    		if (( $subres = $this->literal( 'object' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_191 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_191 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ':') {
    			$this->pos += 1;
    			$result["text"] .= ':';
    		}
    		else { $_191 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_191 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_191 = FALSE; break; }
    		$matcher = 'match_'.'ObjectBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_191 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_191 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_191 = TRUE; break;
    	}
    	while(0);
    	if( $_191 === TRUE ) { return $this->finalise($result); }
    	if( $_191 === FALSE) { return FALSE; }
    }


    /* ObjectBody: Assignment* > */
    protected $match_ObjectBody_typestack = array('ObjectBody');
    function match_ObjectBody ($stack = array()) {
    	$matchrule = "ObjectBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_195 = NULL;
    	do {
    		while (true) {
    			$res_193 = $result;
    			$pos_193 = $this->pos;
    			$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_193;
    				$this->pos = $pos_193;
    				unset( $res_193 );
    				unset( $pos_193 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_195 = TRUE; break;
    	}
    	while(0);
    	if( $_195 === TRUE ) { return $this->finalise($result); }
    	if( $_195 === FALSE) { return FALSE; }
    }


    /* Assignment: Identifier AssignOp Expression ";" > */
    protected $match_Assignment_typestack = array('Assignment');
    function match_Assignment ($stack = array()) {
    	$matchrule = "Assignment"; $result = $this->construct($matchrule, $matchrule, null);
    	$_202 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_202 = FALSE; break; }
    		$matcher = 'match_'.'AssignOp'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_202 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_202 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_202 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_202 = TRUE; break;
    	}
    	while(0);
    	if( $_202 === TRUE ) { return $this->finalise($result); }
    	if( $_202 === FALSE) { return FALSE; }
    }


    /* AssignOp: "+=" | "-=" | "=" */
    protected $match_AssignOp_typestack = array('AssignOp');
    function match_AssignOp ($stack = array()) {
    	$matchrule = "AssignOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_211 = NULL;
    	do {
    		$res_204 = $result;
    		$pos_204 = $this->pos;
    		if (( $subres = $this->literal( '+=' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_211 = TRUE; break;
    		}
    		$result = $res_204;
    		$this->pos = $pos_204;
    		$_209 = NULL;
    		do {
    			$res_206 = $result;
    			$pos_206 = $this->pos;
    			if (( $subres = $this->literal( '-=' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_209 = TRUE; break;
    			}
    			$result = $res_206;
    			$this->pos = $pos_206;
    			if (substr($this->string,$this->pos,1) == '=') {
    				$this->pos += 1;
    				$result["text"] .= '=';
    				$_209 = TRUE; break;
    			}
    			$result = $res_206;
    			$this->pos = $pos_206;
    			$_209 = FALSE; break;
    		}
    		while(0);
    		if( $_209 === TRUE ) { $_211 = TRUE; break; }
    		$result = $res_204;
    		$this->pos = $pos_204;
    		$_211 = FALSE; break;
    	}
    	while(0);
    	if( $_211 === TRUE ) { return $this->finalise($result); }
    	if( $_211 === FALSE) { return FALSE; }
    }


    /* MethodDecl: "method" QualifiedName "(" ParamList? ")" ReturnType? BlockStmt > */
    protected $match_MethodDecl_typestack = array('MethodDecl');
    function match_MethodDecl ($stack = array()) {
    	$matchrule = "MethodDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_221 = NULL;
    	do {
    		if (( $subres = $this->literal( 'method' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_221 = FALSE; break; }
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_221 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_221 = FALSE; break; }
    		$res_216 = $result;
    		$pos_216 = $this->pos;
    		$matcher = 'match_'.'ParamList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_216;
    			$this->pos = $pos_216;
    			unset( $res_216 );
    			unset( $pos_216 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_221 = FALSE; break; }
    		$res_218 = $result;
    		$pos_218 = $this->pos;
    		$matcher = 'match_'.'ReturnType'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_218;
    			$this->pos = $pos_218;
    			unset( $res_218 );
    			unset( $pos_218 );
    		}
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_221 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_221 = TRUE; break;
    	}
    	while(0);
    	if( $_221 === TRUE ) { return $this->finalise($result); }
    	if( $_221 === FALSE) { return FALSE; }
    }


    /* ReturnType: "returns" TypeSpec > */
    protected $match_ReturnType_typestack = array('ReturnType');
    function match_ReturnType ($stack = array()) {
    	$matchrule = "ReturnType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_226 = NULL;
    	do {
    		if (( $subres = $this->literal( 'returns' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_226 = FALSE; break; }
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_226 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_226 = TRUE; break;
    	}
    	while(0);
    	if( $_226 === TRUE ) { return $this->finalise($result); }
    	if( $_226 === FALSE) { return FALSE; }
    }


    /* ParamList: Parameter ( "," Parameter )* > */
    protected $match_ParamList_typestack = array('ParamList');
    function match_ParamList ($stack = array()) {
    	$matchrule = "ParamList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_234 = NULL;
    	do {
    		$matcher = 'match_'.'Parameter'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_234 = FALSE; break; }
    		while (true) {
    			$res_232 = $result;
    			$pos_232 = $this->pos;
    			$_231 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_231 = FALSE; break; }
    				$matcher = 'match_'.'Parameter'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_231 = FALSE; break; }
    				$_231 = TRUE; break;
    			}
    			while(0);
    			if( $_231 === FALSE) {
    				$result = $res_232;
    				$this->pos = $pos_232;
    				unset( $res_232 );
    				unset( $pos_232 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_234 = TRUE; break;
    	}
    	while(0);
    	if( $_234 === TRUE ) { return $this->finalise($result); }
    	if( $_234 === FALSE) { return FALSE; }
    }


    /* Parameter: TypeSpec Identifier > */
    protected $match_Parameter_typestack = array('Parameter');
    function match_Parameter ($stack = array()) {
    	$matchrule = "Parameter"; $result = $this->construct($matchrule, $matchrule, null);
    	$_239 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_239 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_239 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_239 = TRUE; break;
    	}
    	while(0);
    	if( $_239 === TRUE ) { return $this->finalise($result); }
    	if( $_239 === FALSE) { return FALSE; }
    }


    /* RuleDecl: "rule" Identifier "{" RuleBody "}" > */
    protected $match_RuleDecl_typestack = array('RuleDecl');
    function match_RuleDecl ($stack = array()) {
    	$matchrule = "RuleDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_247 = NULL;
    	do {
    		if (( $subres = $this->literal( 'rule' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_247 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_247 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_247 = FALSE; break; }
    		$matcher = 'match_'.'RuleBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_247 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_247 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_247 = TRUE; break;
    	}
    	while(0);
    	if( $_247 === TRUE ) { return $this->finalise($result); }
    	if( $_247 === FALSE) { return FALSE; }
    }


    /* RuleBody: IfStmt | Assignment */
    protected $match_RuleBody_typestack = array('RuleBody');
    function match_RuleBody ($stack = array()) {
    	$matchrule = "RuleBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_252 = NULL;
    	do {
    		$res_249 = $result;
    		$pos_249 = $this->pos;
    		$matcher = 'match_'.'IfStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_252 = TRUE; break;
    		}
    		$result = $res_249;
    		$this->pos = $pos_249;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_252 = TRUE; break;
    		}
    		$result = $res_249;
    		$this->pos = $pos_249;
    		$_252 = FALSE; break;
    	}
    	while(0);
    	if( $_252 === TRUE ) { return $this->finalise($result); }
    	if( $_252 === FALSE) { return FALSE; }
    }


    /* QueryDecl: "query" Identifier "{" QueryBody "}" > */
    protected $match_QueryDecl_typestack = array('QueryDecl');
    function match_QueryDecl ($stack = array()) {
    	$matchrule = "QueryDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_260 = NULL;
    	do {
    		if (( $subres = $this->literal( 'query' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_260 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_260 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_260 = FALSE; break; }
    		$matcher = 'match_'.'QueryBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_260 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_260 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_260 = TRUE; break;
    	}
    	while(0);
    	if( $_260 === TRUE ) { return $this->finalise($result); }
    	if( $_260 === FALSE) { return FALSE; }
    }


    /* QueryBody: "select" Identifier "where" Expression ";" > */
    protected $match_QueryBody_typestack = array('QueryBody');
    function match_QueryBody ($stack = array()) {
    	$matchrule = "QueryBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_268 = NULL;
    	do {
    		if (( $subres = $this->literal( 'select' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_268 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_268 = FALSE; break; }
    		if (( $subres = $this->literal( 'where' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_268 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_268 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_268 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_268 = TRUE; break;
    	}
    	while(0);
    	if( $_268 === TRUE ) { return $this->finalise($result); }
    	if( $_268 === FALSE) { return FALSE; }
    }


    /* IfStmt: "if" "(" Expression ")" BlockStmt ElseClause? > */
    protected $match_IfStmt_typestack = array('IfStmt');
    function match_IfStmt ($stack = array()) {
    	$matchrule = "IfStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_277 = NULL;
    	do {
    		if (( $subres = $this->literal( 'if' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_277 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_277 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_277 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_277 = FALSE; break; }
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_277 = FALSE; break; }
    		$res_275 = $result;
    		$pos_275 = $this->pos;
    		$matcher = 'match_'.'ElseClause'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_275;
    			$this->pos = $pos_275;
    			unset( $res_275 );
    			unset( $pos_275 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_277 = TRUE; break;
    	}
    	while(0);
    	if( $_277 === TRUE ) { return $this->finalise($result); }
    	if( $_277 === FALSE) { return FALSE; }
    }


    /* ElseClause: "else" BlockStmt > */
    protected $match_ElseClause_typestack = array('ElseClause');
    function match_ElseClause ($stack = array()) {
    	$matchrule = "ElseClause"; $result = $this->construct($matchrule, $matchrule, null);
    	$_282 = NULL;
    	do {
    		if (( $subres = $this->literal( 'else' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_282 = FALSE; break; }
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_282 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_282 = TRUE; break;
    	}
    	while(0);
    	if( $_282 === TRUE ) { return $this->finalise($result); }
    	if( $_282 === FALSE) { return FALSE; }
    }


    /* BlockStmt: "{" StmtList "}" > */
    protected $match_BlockStmt_typestack = array('BlockStmt');
    function match_BlockStmt ($stack = array()) {
    	$matchrule = "BlockStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_288 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_288 = FALSE; break; }
    		$matcher = 'match_'.'StmtList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_288 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_288 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_288 = TRUE; break;
    	}
    	while(0);
    	if( $_288 === TRUE ) { return $this->finalise($result); }
    	if( $_288 === FALSE) { return FALSE; }
    }


    /* StmtList: InnerStmt* > */
    protected $match_StmtList_typestack = array('StmtList');
    function match_StmtList ($stack = array()) {
    	$matchrule = "StmtList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_292 = NULL;
    	do {
    		while (true) {
    			$res_290 = $result;
    			$pos_290 = $this->pos;
    			$matcher = 'match_'.'InnerStmt'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_290;
    				$this->pos = $pos_290;
    				unset( $res_290 );
    				unset( $pos_290 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_292 = TRUE; break;
    	}
    	while(0);
    	if( $_292 === TRUE ) { return $this->finalise($result); }
    	if( $_292 === FALSE) { return FALSE; }
    }


    /* InnerStmt: Assignment | IfStmt | ReturnStmt | ExprStmt > */
    protected $match_InnerStmt_typestack = array('InnerStmt');
    function match_InnerStmt ($stack = array()) {
    	$matchrule = "InnerStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_308 = NULL;
    	do {
    		$res_294 = $result;
    		$pos_294 = $this->pos;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_308 = TRUE; break;
    		}
    		$result = $res_294;
    		$this->pos = $pos_294;
    		$_306 = NULL;
    		do {
    			$res_296 = $result;
    			$pos_296 = $this->pos;
    			$matcher = 'match_'.'IfStmt'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_306 = TRUE; break;
    			}
    			$result = $res_296;
    			$this->pos = $pos_296;
    			$_304 = NULL;
    			do {
    				$res_298 = $result;
    				$pos_298 = $this->pos;
    				$matcher = 'match_'.'ReturnStmt'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_304 = TRUE; break;
    				}
    				$result = $res_298;
    				$this->pos = $pos_298;
    				$_302 = NULL;
    				do {
    					$matcher = 'match_'.'ExprStmt'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    					}
    					else { $_302 = FALSE; break; }
    					if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    					$_302 = TRUE; break;
    				}
    				while(0);
    				if( $_302 === TRUE ) { $_304 = TRUE; break; }
    				$result = $res_298;
    				$this->pos = $pos_298;
    				$_304 = FALSE; break;
    			}
    			while(0);
    			if( $_304 === TRUE ) { $_306 = TRUE; break; }
    			$result = $res_296;
    			$this->pos = $pos_296;
    			$_306 = FALSE; break;
    		}
    		while(0);
    		if( $_306 === TRUE ) { $_308 = TRUE; break; }
    		$result = $res_294;
    		$this->pos = $pos_294;
    		$_308 = FALSE; break;
    	}
    	while(0);
    	if( $_308 === TRUE ) { return $this->finalise($result); }
    	if( $_308 === FALSE) { return FALSE; }
    }


    /* ReturnStmt: "return" Expression ";" > */
    protected $match_ReturnStmt_typestack = array('ReturnStmt');
    function match_ReturnStmt ($stack = array()) {
    	$matchrule = "ReturnStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_314 = NULL;
    	do {
    		if (( $subres = $this->literal( 'return' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_314 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_314 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_314 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_314 = TRUE; break;
    	}
    	while(0);
    	if( $_314 === TRUE ) { return $this->finalise($result); }
    	if( $_314 === FALSE) { return FALSE; }
    }


    /* ExprStmt: Expression ";" > */
    protected $match_ExprStmt_typestack = array('ExprStmt');
    function match_ExprStmt ($stack = array()) {
    	$matchrule = "ExprStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_319 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_319 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_319 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_319 = TRUE; break;
    	}
    	while(0);
    	if( $_319 === TRUE ) { return $this->finalise($result); }
    	if( $_319 === FALSE) { return FALSE; }
    }


    /* Expression: LogicalExpr > */
    protected $match_Expression_typestack = array('Expression');
    function match_Expression ($stack = array()) {
    	$matchrule = "Expression"; $result = $this->construct($matchrule, $matchrule, null);
    	$_323 = NULL;
    	do {
    		$matcher = 'match_'.'LogicalExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_323 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_323 = TRUE; break;
    	}
    	while(0);
    	if( $_323 === TRUE ) { return $this->finalise($result); }
    	if( $_323 === FALSE) { return FALSE; }
    }


    /* LogicalExpr: ComparisonExpr ( LogicalOp ComparisonExpr )* > */
    protected $match_LogicalExpr_typestack = array('LogicalExpr');
    function match_LogicalExpr ($stack = array()) {
    	$matchrule = "LogicalExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_331 = NULL;
    	do {
    		$matcher = 'match_'.'ComparisonExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_331 = FALSE; break; }
    		while (true) {
    			$res_329 = $result;
    			$pos_329 = $this->pos;
    			$_328 = NULL;
    			do {
    				$matcher = 'match_'.'LogicalOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_328 = FALSE; break; }
    				$matcher = 'match_'.'ComparisonExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_328 = FALSE; break; }
    				$_328 = TRUE; break;
    			}
    			while(0);
    			if( $_328 === FALSE) {
    				$result = $res_329;
    				$this->pos = $pos_329;
    				unset( $res_329 );
    				unset( $pos_329 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_331 = TRUE; break;
    	}
    	while(0);
    	if( $_331 === TRUE ) { return $this->finalise($result); }
    	if( $_331 === FALSE) { return FALSE; }
    }


    /* LogicalOp: "&&" | "||" | "and" | "or" > */
    protected $match_LogicalOp_typestack = array('LogicalOp');
    function match_LogicalOp ($stack = array()) {
    	$matchrule = "LogicalOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_347 = NULL;
    	do {
    		$res_333 = $result;
    		$pos_333 = $this->pos;
    		if (( $subres = $this->literal( '&&' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_347 = TRUE; break;
    		}
    		$result = $res_333;
    		$this->pos = $pos_333;
    		$_345 = NULL;
    		do {
    			$res_335 = $result;
    			$pos_335 = $this->pos;
    			if (( $subres = $this->literal( '||' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_345 = TRUE; break;
    			}
    			$result = $res_335;
    			$this->pos = $pos_335;
    			$_343 = NULL;
    			do {
    				$res_337 = $result;
    				$pos_337 = $this->pos;
    				if (( $subres = $this->literal( 'and' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_343 = TRUE; break;
    				}
    				$result = $res_337;
    				$this->pos = $pos_337;
    				$_341 = NULL;
    				do {
    					if (( $subres = $this->literal( 'or' ) ) !== FALSE) { $result["text"] .= $subres; }
    					else { $_341 = FALSE; break; }
    					if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    					$_341 = TRUE; break;
    				}
    				while(0);
    				if( $_341 === TRUE ) { $_343 = TRUE; break; }
    				$result = $res_337;
    				$this->pos = $pos_337;
    				$_343 = FALSE; break;
    			}
    			while(0);
    			if( $_343 === TRUE ) { $_345 = TRUE; break; }
    			$result = $res_335;
    			$this->pos = $pos_335;
    			$_345 = FALSE; break;
    		}
    		while(0);
    		if( $_345 === TRUE ) { $_347 = TRUE; break; }
    		$result = $res_333;
    		$this->pos = $pos_333;
    		$_347 = FALSE; break;
    	}
    	while(0);
    	if( $_347 === TRUE ) { return $this->finalise($result); }
    	if( $_347 === FALSE) { return FALSE; }
    }


    /* ComparisonExpr: AdditiveExpr ( ComparisonOp AdditiveExpr )? > */
    protected $match_ComparisonExpr_typestack = array('ComparisonExpr');
    function match_ComparisonExpr ($stack = array()) {
    	$matchrule = "ComparisonExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_355 = NULL;
    	do {
    		$matcher = 'match_'.'AdditiveExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_355 = FALSE; break; }
    		$res_353 = $result;
    		$pos_353 = $this->pos;
    		$_352 = NULL;
    		do {
    			$matcher = 'match_'.'ComparisonOp'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else { $_352 = FALSE; break; }
    			$matcher = 'match_'.'AdditiveExpr'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else { $_352 = FALSE; break; }
    			$_352 = TRUE; break;
    		}
    		while(0);
    		if( $_352 === FALSE) {
    			$result = $res_353;
    			$this->pos = $pos_353;
    			unset( $res_353 );
    			unset( $pos_353 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_355 = TRUE; break;
    	}
    	while(0);
    	if( $_355 === TRUE ) { return $this->finalise($result); }
    	if( $_355 === FALSE) { return FALSE; }
    }


    /* ComparisonOp: "==" | "!=" | "<=" | ">=" | "<" | ">" > */
    protected $match_ComparisonOp_typestack = array('ComparisonOp');
    function match_ComparisonOp ($stack = array()) {
    	$matchrule = "ComparisonOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_379 = NULL;
    	do {
    		$res_357 = $result;
    		$pos_357 = $this->pos;
    		if (( $subres = $this->literal( '==' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_379 = TRUE; break;
    		}
    		$result = $res_357;
    		$this->pos = $pos_357;
    		$_377 = NULL;
    		do {
    			$res_359 = $result;
    			$pos_359 = $this->pos;
    			if (( $subres = $this->literal( '!=' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_377 = TRUE; break;
    			}
    			$result = $res_359;
    			$this->pos = $pos_359;
    			$_375 = NULL;
    			do {
    				$res_361 = $result;
    				$pos_361 = $this->pos;
    				if (( $subres = $this->literal( '<=' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_375 = TRUE; break;
    				}
    				$result = $res_361;
    				$this->pos = $pos_361;
    				$_373 = NULL;
    				do {
    					$res_363 = $result;
    					$pos_363 = $this->pos;
    					if (( $subres = $this->literal( '>=' ) ) !== FALSE) {
    						$result["text"] .= $subres;
    						$_373 = TRUE; break;
    					}
    					$result = $res_363;
    					$this->pos = $pos_363;
    					$_371 = NULL;
    					do {
    						$res_365 = $result;
    						$pos_365 = $this->pos;
    						if (substr($this->string,$this->pos,1) == '<') {
    							$this->pos += 1;
    							$result["text"] .= '<';
    							$_371 = TRUE; break;
    						}
    						$result = $res_365;
    						$this->pos = $pos_365;
    						$_369 = NULL;
    						do {
    							if (substr($this->string,$this->pos,1) == '>') {
    								$this->pos += 1;
    								$result["text"] .= '>';
    							}
    							else { $_369 = FALSE; break; }
    							if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    							$_369 = TRUE; break;
    						}
    						while(0);
    						if( $_369 === TRUE ) { $_371 = TRUE; break; }
    						$result = $res_365;
    						$this->pos = $pos_365;
    						$_371 = FALSE; break;
    					}
    					while(0);
    					if( $_371 === TRUE ) { $_373 = TRUE; break; }
    					$result = $res_363;
    					$this->pos = $pos_363;
    					$_373 = FALSE; break;
    				}
    				while(0);
    				if( $_373 === TRUE ) { $_375 = TRUE; break; }
    				$result = $res_361;
    				$this->pos = $pos_361;
    				$_375 = FALSE; break;
    			}
    			while(0);
    			if( $_375 === TRUE ) { $_377 = TRUE; break; }
    			$result = $res_359;
    			$this->pos = $pos_359;
    			$_377 = FALSE; break;
    		}
    		while(0);
    		if( $_377 === TRUE ) { $_379 = TRUE; break; }
    		$result = $res_357;
    		$this->pos = $pos_357;
    		$_379 = FALSE; break;
    	}
    	while(0);
    	if( $_379 === TRUE ) { return $this->finalise($result); }
    	if( $_379 === FALSE) { return FALSE; }
    }


    /* AdditiveExpr: MultiplicativeExpr ( AdditiveOp MultiplicativeExpr )* > */
    protected $match_AdditiveExpr_typestack = array('AdditiveExpr');
    function match_AdditiveExpr ($stack = array()) {
    	$matchrule = "AdditiveExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_387 = NULL;
    	do {
    		$matcher = 'match_'.'MultiplicativeExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_387 = FALSE; break; }
    		while (true) {
    			$res_385 = $result;
    			$pos_385 = $this->pos;
    			$_384 = NULL;
    			do {
    				$matcher = 'match_'.'AdditiveOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_384 = FALSE; break; }
    				$matcher = 'match_'.'MultiplicativeExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_384 = FALSE; break; }
    				$_384 = TRUE; break;
    			}
    			while(0);
    			if( $_384 === FALSE) {
    				$result = $res_385;
    				$this->pos = $pos_385;
    				unset( $res_385 );
    				unset( $pos_385 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_387 = TRUE; break;
    	}
    	while(0);
    	if( $_387 === TRUE ) { return $this->finalise($result); }
    	if( $_387 === FALSE) { return FALSE; }
    }


    /* AdditiveOp: "+" | "-" > */
    protected $match_AdditiveOp_typestack = array('AdditiveOp');
    function match_AdditiveOp ($stack = array()) {
    	$matchrule = "AdditiveOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_395 = NULL;
    	do {
    		$res_389 = $result;
    		$pos_389 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '+') {
    			$this->pos += 1;
    			$result["text"] .= '+';
    			$_395 = TRUE; break;
    		}
    		$result = $res_389;
    		$this->pos = $pos_389;
    		$_393 = NULL;
    		do {
    			if (substr($this->string,$this->pos,1) == '-') {
    				$this->pos += 1;
    				$result["text"] .= '-';
    			}
    			else { $_393 = FALSE; break; }
    			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    			$_393 = TRUE; break;
    		}
    		while(0);
    		if( $_393 === TRUE ) { $_395 = TRUE; break; }
    		$result = $res_389;
    		$this->pos = $pos_389;
    		$_395 = FALSE; break;
    	}
    	while(0);
    	if( $_395 === TRUE ) { return $this->finalise($result); }
    	if( $_395 === FALSE) { return FALSE; }
    }


    /* MultiplicativeExpr: UnaryExpr ( MultiplicativeOp UnaryExpr )* > */
    protected $match_MultiplicativeExpr_typestack = array('MultiplicativeExpr');
    function match_MultiplicativeExpr ($stack = array()) {
    	$matchrule = "MultiplicativeExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_403 = NULL;
    	do {
    		$matcher = 'match_'.'UnaryExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_403 = FALSE; break; }
    		while (true) {
    			$res_401 = $result;
    			$pos_401 = $this->pos;
    			$_400 = NULL;
    			do {
    				$matcher = 'match_'.'MultiplicativeOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_400 = FALSE; break; }
    				$matcher = 'match_'.'UnaryExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_400 = FALSE; break; }
    				$_400 = TRUE; break;
    			}
    			while(0);
    			if( $_400 === FALSE) {
    				$result = $res_401;
    				$this->pos = $pos_401;
    				unset( $res_401 );
    				unset( $pos_401 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_403 = TRUE; break;
    	}
    	while(0);
    	if( $_403 === TRUE ) { return $this->finalise($result); }
    	if( $_403 === FALSE) { return FALSE; }
    }


    /* MultiplicativeOp: "*" | "/" | "%" > */
    protected $match_MultiplicativeOp_typestack = array('MultiplicativeOp');
    function match_MultiplicativeOp ($stack = array()) {
    	$matchrule = "MultiplicativeOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_415 = NULL;
    	do {
    		$res_405 = $result;
    		$pos_405 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '*') {
    			$this->pos += 1;
    			$result["text"] .= '*';
    			$_415 = TRUE; break;
    		}
    		$result = $res_405;
    		$this->pos = $pos_405;
    		$_413 = NULL;
    		do {
    			$res_407 = $result;
    			$pos_407 = $this->pos;
    			if (substr($this->string,$this->pos,1) == '/') {
    				$this->pos += 1;
    				$result["text"] .= '/';
    				$_413 = TRUE; break;
    			}
    			$result = $res_407;
    			$this->pos = $pos_407;
    			$_411 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == '%') {
    					$this->pos += 1;
    					$result["text"] .= '%';
    				}
    				else { $_411 = FALSE; break; }
    				if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    				$_411 = TRUE; break;
    			}
    			while(0);
    			if( $_411 === TRUE ) { $_413 = TRUE; break; }
    			$result = $res_407;
    			$this->pos = $pos_407;
    			$_413 = FALSE; break;
    		}
    		while(0);
    		if( $_413 === TRUE ) { $_415 = TRUE; break; }
    		$result = $res_405;
    		$this->pos = $pos_405;
    		$_415 = FALSE; break;
    	}
    	while(0);
    	if( $_415 === TRUE ) { return $this->finalise($result); }
    	if( $_415 === FALSE) { return FALSE; }
    }


    /* UnaryExpr: UnaryOp? PrimaryExpr > */
    protected $match_UnaryExpr_typestack = array('UnaryExpr');
    function match_UnaryExpr ($stack = array()) {
    	$matchrule = "UnaryExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_420 = NULL;
    	do {
    		$res_417 = $result;
    		$pos_417 = $this->pos;
    		$matcher = 'match_'.'UnaryOp'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_417;
    			$this->pos = $pos_417;
    			unset( $res_417 );
    			unset( $pos_417 );
    		}
    		$matcher = 'match_'.'PrimaryExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_420 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_420 = TRUE; break;
    	}
    	while(0);
    	if( $_420 === TRUE ) { return $this->finalise($result); }
    	if( $_420 === FALSE) { return FALSE; }
    }


    /* UnaryOp: "!" | "not" | "-" */
    protected $match_UnaryOp_typestack = array('UnaryOp');
    function match_UnaryOp ($stack = array()) {
    	$matchrule = "UnaryOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_429 = NULL;
    	do {
    		$res_422 = $result;
    		$pos_422 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '!') {
    			$this->pos += 1;
    			$result["text"] .= '!';
    			$_429 = TRUE; break;
    		}
    		$result = $res_422;
    		$this->pos = $pos_422;
    		$_427 = NULL;
    		do {
    			$res_424 = $result;
    			$pos_424 = $this->pos;
    			if (( $subres = $this->literal( 'not' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_427 = TRUE; break;
    			}
    			$result = $res_424;
    			$this->pos = $pos_424;
    			if (substr($this->string,$this->pos,1) == '-') {
    				$this->pos += 1;
    				$result["text"] .= '-';
    				$_427 = TRUE; break;
    			}
    			$result = $res_424;
    			$this->pos = $pos_424;
    			$_427 = FALSE; break;
    		}
    		while(0);
    		if( $_427 === TRUE ) { $_429 = TRUE; break; }
    		$result = $res_422;
    		$this->pos = $pos_422;
    		$_429 = FALSE; break;
    	}
    	while(0);
    	if( $_429 === TRUE ) { return $this->finalise($result); }
    	if( $_429 === FALSE) { return FALSE; }
    }


    /* PrimaryExpr: Literal | MethodCall | PropertyAccess | ThisKeyword | ParenExpr | SetLiteral */
    protected $match_PrimaryExpr_typestack = array('PrimaryExpr');
    function match_PrimaryExpr ($stack = array()) {
    	$matchrule = "PrimaryExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_450 = NULL;
    	do {
    		$res_431 = $result;
    		$pos_431 = $this->pos;
    		$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_450 = TRUE; break;
    		}
    		$result = $res_431;
    		$this->pos = $pos_431;
    		$_448 = NULL;
    		do {
    			$res_433 = $result;
    			$pos_433 = $this->pos;
    			$matcher = 'match_'.'MethodCall'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_448 = TRUE; break;
    			}
    			$result = $res_433;
    			$this->pos = $pos_433;
    			$_446 = NULL;
    			do {
    				$res_435 = $result;
    				$pos_435 = $this->pos;
    				$matcher = 'match_'.'PropertyAccess'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_446 = TRUE; break;
    				}
    				$result = $res_435;
    				$this->pos = $pos_435;
    				$_444 = NULL;
    				do {
    					$res_437 = $result;
    					$pos_437 = $this->pos;
    					$matcher = 'match_'.'ThisKeyword'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_444 = TRUE; break;
    					}
    					$result = $res_437;
    					$this->pos = $pos_437;
    					$_442 = NULL;
    					do {
    						$res_439 = $result;
    						$pos_439 = $this->pos;
    						$matcher = 'match_'.'ParenExpr'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_442 = TRUE; break;
    						}
    						$result = $res_439;
    						$this->pos = $pos_439;
    						$matcher = 'match_'.'SetLiteral'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_442 = TRUE; break;
    						}
    						$result = $res_439;
    						$this->pos = $pos_439;
    						$_442 = FALSE; break;
    					}
    					while(0);
    					if( $_442 === TRUE ) { $_444 = TRUE; break; }
    					$result = $res_437;
    					$this->pos = $pos_437;
    					$_444 = FALSE; break;
    				}
    				while(0);
    				if( $_444 === TRUE ) { $_446 = TRUE; break; }
    				$result = $res_435;
    				$this->pos = $pos_435;
    				$_446 = FALSE; break;
    			}
    			while(0);
    			if( $_446 === TRUE ) { $_448 = TRUE; break; }
    			$result = $res_433;
    			$this->pos = $pos_433;
    			$_448 = FALSE; break;
    		}
    		while(0);
    		if( $_448 === TRUE ) { $_450 = TRUE; break; }
    		$result = $res_431;
    		$this->pos = $pos_431;
    		$_450 = FALSE; break;
    	}
    	while(0);
    	if( $_450 === TRUE ) { return $this->finalise($result); }
    	if( $_450 === FALSE) { return FALSE; }
    }


    /* ParenExpr: "(" Expression ")" > */
    protected $match_ParenExpr_typestack = array('ParenExpr');
    function match_ParenExpr ($stack = array()) {
    	$matchrule = "ParenExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_456 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_456 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_456 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_456 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_456 = TRUE; break;
    	}
    	while(0);
    	if( $_456 === TRUE ) { return $this->finalise($result); }
    	if( $_456 === FALSE) { return FALSE; }
    }


    /* ThisKeyword: "this" */
    protected $match_ThisKeyword_typestack = array('ThisKeyword');
    function match_ThisKeyword ($stack = array()) {
    	$matchrule = "ThisKeyword"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->literal( 'this' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* MethodCall: QualifiedName "(" ArgList? ")" > */
    protected $match_MethodCall_typestack = array('MethodCall');
    function match_MethodCall ($stack = array()) {
    	$matchrule = "MethodCall"; $result = $this->construct($matchrule, $matchrule, null);
    	$_464 = NULL;
    	do {
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_464 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_464 = FALSE; break; }
    		$res_461 = $result;
    		$pos_461 = $this->pos;
    		$matcher = 'match_'.'ArgList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_461;
    			$this->pos = $pos_461;
    			unset( $res_461 );
    			unset( $pos_461 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_464 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_464 = TRUE; break;
    	}
    	while(0);
    	if( $_464 === TRUE ) { return $this->finalise($result); }
    	if( $_464 === FALSE) { return FALSE; }
    }


    /* PropertyAccess: QualifiedName > */
    protected $match_PropertyAccess_typestack = array('PropertyAccess');
    function match_PropertyAccess ($stack = array()) {
    	$matchrule = "PropertyAccess"; $result = $this->construct($matchrule, $matchrule, null);
    	$_468 = NULL;
    	do {
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_468 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_468 = TRUE; break;
    	}
    	while(0);
    	if( $_468 === TRUE ) { return $this->finalise($result); }
    	if( $_468 === FALSE) { return FALSE; }
    }


    /* QualifiedName: Identifier ( "." Identifier )* > */
    protected $match_QualifiedName_typestack = array('QualifiedName');
    function match_QualifiedName ($stack = array()) {
    	$matchrule = "QualifiedName"; $result = $this->construct($matchrule, $matchrule, null);
    	$_476 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_476 = FALSE; break; }
    		while (true) {
    			$res_474 = $result;
    			$pos_474 = $this->pos;
    			$_473 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == '.') {
    					$this->pos += 1;
    					$result["text"] .= '.';
    				}
    				else { $_473 = FALSE; break; }
    				$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_473 = FALSE; break; }
    				$_473 = TRUE; break;
    			}
    			while(0);
    			if( $_473 === FALSE) {
    				$result = $res_474;
    				$this->pos = $pos_474;
    				unset( $res_474 );
    				unset( $pos_474 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_476 = TRUE; break;
    	}
    	while(0);
    	if( $_476 === TRUE ) { return $this->finalise($result); }
    	if( $_476 === FALSE) { return FALSE; }
    }


    /* ArgList: Expression ( "," Expression )* > */
    protected $match_ArgList_typestack = array('ArgList');
    function match_ArgList ($stack = array()) {
    	$matchrule = "ArgList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_484 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_484 = FALSE; break; }
    		while (true) {
    			$res_482 = $result;
    			$pos_482 = $this->pos;
    			$_481 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_481 = FALSE; break; }
    				$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_481 = FALSE; break; }
    				$_481 = TRUE; break;
    			}
    			while(0);
    			if( $_481 === FALSE) {
    				$result = $res_482;
    				$this->pos = $pos_482;
    				unset( $res_482 );
    				unset( $pos_482 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_484 = TRUE; break;
    	}
    	while(0);
    	if( $_484 === TRUE ) { return $this->finalise($result); }
    	if( $_484 === FALSE) { return FALSE; }
    }


    /* SetLiteral: "{" ElemList? "}" > */
    protected $match_SetLiteral_typestack = array('SetLiteral');
    function match_SetLiteral ($stack = array()) {
    	$matchrule = "SetLiteral"; $result = $this->construct($matchrule, $matchrule, null);
    	$_490 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_490 = FALSE; break; }
    		$res_487 = $result;
    		$pos_487 = $this->pos;
    		$matcher = 'match_'.'ElemList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_487;
    			$this->pos = $pos_487;
    			unset( $res_487 );
    			unset( $pos_487 );
    		}
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_490 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_490 = TRUE; break;
    	}
    	while(0);
    	if( $_490 === TRUE ) { return $this->finalise($result); }
    	if( $_490 === FALSE) { return FALSE; }
    }


    /* ElemList: Expression ( "," Expression )* > */
    protected $match_ElemList_typestack = array('ElemList');
    function match_ElemList ($stack = array()) {
    	$matchrule = "ElemList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_498 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_498 = FALSE; break; }
    		while (true) {
    			$res_496 = $result;
    			$pos_496 = $this->pos;
    			$_495 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_495 = FALSE; break; }
    				$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_495 = FALSE; break; }
    				$_495 = TRUE; break;
    			}
    			while(0);
    			if( $_495 === FALSE) {
    				$result = $res_496;
    				$this->pos = $pos_496;
    				unset( $res_496 );
    				unset( $pos_496 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_498 = TRUE; break;
    	}
    	while(0);
    	if( $_498 === TRUE ) { return $this->finalise($result); }
    	if( $_498 === FALSE) { return FALSE; }
    }


    /* Literal: String | Float | Number | Boolean | Identifier */
    protected $match_Literal_typestack = array('Literal');
    function match_Literal ($stack = array()) {
    	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
    	$_515 = NULL;
    	do {
    		$res_500 = $result;
    		$pos_500 = $this->pos;
    		$matcher = 'match_'.'String'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_515 = TRUE; break;
    		}
    		$result = $res_500;
    		$this->pos = $pos_500;
    		$_513 = NULL;
    		do {
    			$res_502 = $result;
    			$pos_502 = $this->pos;
    			$matcher = 'match_'.'Float'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_513 = TRUE; break;
    			}
    			$result = $res_502;
    			$this->pos = $pos_502;
    			$_511 = NULL;
    			do {
    				$res_504 = $result;
    				$pos_504 = $this->pos;
    				$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_511 = TRUE; break;
    				}
    				$result = $res_504;
    				$this->pos = $pos_504;
    				$_509 = NULL;
    				do {
    					$res_506 = $result;
    					$pos_506 = $this->pos;
    					$matcher = 'match_'.'Boolean'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_509 = TRUE; break;
    					}
    					$result = $res_506;
    					$this->pos = $pos_506;
    					$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_509 = TRUE; break;
    					}
    					$result = $res_506;
    					$this->pos = $pos_506;
    					$_509 = FALSE; break;
    				}
    				while(0);
    				if( $_509 === TRUE ) { $_511 = TRUE; break; }
    				$result = $res_504;
    				$this->pos = $pos_504;
    				$_511 = FALSE; break;
    			}
    			while(0);
    			if( $_511 === TRUE ) { $_513 = TRUE; break; }
    			$result = $res_502;
    			$this->pos = $pos_502;
    			$_513 = FALSE; break;
    		}
    		while(0);
    		if( $_513 === TRUE ) { $_515 = TRUE; break; }
    		$result = $res_500;
    		$this->pos = $pos_500;
    		$_515 = FALSE; break;
    	}
    	while(0);
    	if( $_515 === TRUE ) { return $this->finalise($result); }
    	if( $_515 === FALSE) { return FALSE; }
    }


    /* String: /"[^"]*"/ > */
    protected $match_String_typestack = array('String');
    function match_String ($stack = array()) {
    	$matchrule = "String"; $result = $this->construct($matchrule, $matchrule, null);
    	$_519 = NULL;
    	do {
    		if (( $subres = $this->rx( '/"[^"]*"/' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_519 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_519 = TRUE; break;
    	}
    	while(0);
    	if( $_519 === TRUE ) { return $this->finalise($result); }
    	if( $_519 === FALSE) { return FALSE; }
    }


    /* Float: /[0-9]+\.[0-9]+/ > */
    protected $match_Float_typestack = array('Float');
    function match_Float ($stack = array()) {
    	$matchrule = "Float"; $result = $this->construct($matchrule, $matchrule, null);
    	$_523 = NULL;
    	do {
    		if (( $subres = $this->rx( '/[0-9]+\.[0-9]+/' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_523 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_523 = TRUE; break;
    	}
    	while(0);
    	if( $_523 === TRUE ) { return $this->finalise($result); }
    	if( $_523 === FALSE) { return FALSE; }
    }


    /* Number: /[0-9]+/ */
    protected $match_Number_typestack = array('Number');
    function match_Number ($stack = array()) {
    	$matchrule = "Number"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/[0-9]+/' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* Boolean: "true" | "false" */
    protected $match_Boolean_typestack = array('Boolean');
    function match_Boolean ($stack = array()) {
    	$matchrule = "Boolean"; $result = $this->construct($matchrule, $matchrule, null);
    	$_529 = NULL;
    	do {
    		$res_526 = $result;
    		$pos_526 = $this->pos;
    		if (( $subres = $this->literal( 'true' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_529 = TRUE; break;
    		}
    		$result = $res_526;
    		$this->pos = $pos_526;
    		if (( $subres = $this->literal( 'false' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_529 = TRUE; break;
    		}
    		$result = $res_526;
    		$this->pos = $pos_526;
    		$_529 = FALSE; break;
    	}
    	while(0);
    	if( $_529 === TRUE ) { return $this->finalise($result); }
    	if( $_529 === FALSE) { return FALSE; }
    }


    /* Identifier: / [a-zA-Z_][a-zA-Z0-9_]* / */
    protected $match_Identifier_typestack = array('Identifier');
    function match_Identifier ($stack = array()) {
    	$matchrule = "Identifier"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/ [a-zA-Z_][a-zA-Z0-9_]* /' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* ImportDecl: "import" QualifiedName ImportList? ";" > */
    protected $match_ImportDecl_typestack = array('ImportDecl');
    function match_ImportDecl ($stack = array()) {
    	$matchrule = "ImportDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_537 = NULL;
    	do {
    		if (( $subres = $this->literal( 'import' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_537 = FALSE; break; }
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_537 = FALSE; break; }
    		$res_534 = $result;
    		$pos_534 = $this->pos;
    		$matcher = 'match_'.'ImportList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_534;
    			$this->pos = $pos_534;
    			unset( $res_534 );
    			unset( $pos_534 );
    		}
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_537 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_537 = TRUE; break;
    	}
    	while(0);
    	if( $_537 === TRUE ) { return $this->finalise($result); }
    	if( $_537 === FALSE) { return FALSE; }
    }


    /* ImportList: "." "{" IdentList "}" > */
    protected $match_ImportList_typestack = array('ImportList');
    function match_ImportList ($stack = array()) {
    	$matchrule = "ImportList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_544 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '.') {
    			$this->pos += 1;
    			$result["text"] .= '.';
    		}
    		else { $_544 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_544 = FALSE; break; }
    		$matcher = 'match_'.'IdentList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_544 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_544 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_544 = TRUE; break;
    	}
    	while(0);
    	if( $_544 === TRUE ) { return $this->finalise($result); }
    	if( $_544 === FALSE) { return FALSE; }
    }


    /* ExportDecl: "export" IdentList ";" > */
    protected $match_ExportDecl_typestack = array('ExportDecl');
    function match_ExportDecl ($stack = array()) {
    	$matchrule = "ExportDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_550 = NULL;
    	do {
    		if (( $subres = $this->literal( 'export' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_550 = FALSE; break; }
    		$matcher = 'match_'.'IdentList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_550 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_550 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_550 = TRUE; break;
    	}
    	while(0);
    	if( $_550 === TRUE ) { return $this->finalise($result); }
    	if( $_550 === FALSE) { return FALSE; }
    }


    /* IdentList: Identifier ( "," Identifier )* > */
    protected $match_IdentList_typestack = array('IdentList');
    function match_IdentList ($stack = array()) {
    	$matchrule = "IdentList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_558 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_558 = FALSE; break; }
    		while (true) {
    			$res_556 = $result;
    			$pos_556 = $this->pos;
    			$_555 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_555 = FALSE; break; }
    				$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_555 = FALSE; break; }
    				$_555 = TRUE; break;
    			}
    			while(0);
    			if( $_555 === FALSE) {
    				$result = $res_556;
    				$this->pos = $pos_556;
    				unset( $res_556 );
    				unset( $pos_556 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_558 = TRUE; break;
    	}
    	while(0);
    	if( $_558 === TRUE ) { return $this->finalise($result); }
    	if( $_558 === FALSE) { return FALSE; }
    }




    function whitespace() {
        $matched = preg_match( '/[ \t]+/', $this->string, $matches, PREG_OFFSET_CAPTURE, $this->pos ) ;
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