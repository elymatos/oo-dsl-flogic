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

    /* _: ( /\s+/ | LineComment | BlockComment )* */
    protected $match___typestack = array('_');
    function match__ ($stack = array()) {
    	$matchrule = "_"; $result = $this->construct($matchrule, $matchrule, null);
    	while (true) {
    		$res_10 = $result;
    		$pos_10 = $this->pos;
    		$_9 = NULL;
    		do {
    			$_7 = NULL;
    			do {
    				$res_0 = $result;
    				$pos_0 = $this->pos;
    				if (( $subres = $this->rx( '/\s+/' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_7 = TRUE; break;
    				}
    				$result = $res_0;
    				$this->pos = $pos_0;
    				$_5 = NULL;
    				do {
    					$res_2 = $result;
    					$pos_2 = $this->pos;
    					$matcher = 'match_'.'LineComment'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_5 = TRUE; break;
    					}
    					$result = $res_2;
    					$this->pos = $pos_2;
    					$matcher = 'match_'.'BlockComment'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_5 = TRUE; break;
    					}
    					$result = $res_2;
    					$this->pos = $pos_2;
    					$_5 = FALSE; break;
    				}
    				while(0);
    				if( $_5 === TRUE ) { $_7 = TRUE; break; }
    				$result = $res_0;
    				$this->pos = $pos_0;
    				$_7 = FALSE; break;
    			}
    			while(0);
    			if( $_7 === FALSE) { $_9 = FALSE; break; }
    			$_9 = TRUE; break;
    		}
    		while(0);
    		if( $_9 === FALSE) {
    			$result = $res_10;
    			$this->pos = $pos_10;
    			unset( $res_10 );
    			unset( $pos_10 );
    			break;
    		}
    	}
    	return $this->finalise($result);
    }


    /* LineComment: /\/\/[^\n]*  / */
    protected $match_LineComment_typestack = array('LineComment');
    function match_LineComment ($stack = array()) {
    	$matchrule = "LineComment"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/\/\/[^\n]*  /' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* BlockComment: /\/\*.*?\*\/ / */
    protected $match_BlockComment_typestack = array('BlockComment');
    function match_BlockComment ($stack = array()) {
    	$matchrule = "BlockComment"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/\/\*.*?\*\/ /' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
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
    		$res_14 = $result;
    		$pos_14 = $this->pos;
    		$matcher = 'match_'.'Statement'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_14;
    			$this->pos = $pos_14;
    			unset( $res_14 );
    			unset( $pos_14 );
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
    	$_43 = NULL;
    	do {
    		$res_16 = $result;
    		$pos_16 = $this->pos;
    		$matcher = 'match_'.'ModuleDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_43 = TRUE; break;
    		}
    		$result = $res_16;
    		$this->pos = $pos_16;
    		$_41 = NULL;
    		do {
    			$res_18 = $result;
    			$pos_18 = $this->pos;
    			$matcher = 'match_'.'ClassDecl'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_41 = TRUE; break;
    			}
    			$result = $res_18;
    			$this->pos = $pos_18;
    			$_39 = NULL;
    			do {
    				$res_20 = $result;
    				$pos_20 = $this->pos;
    				$matcher = 'match_'.'ObjectDecl'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_39 = TRUE; break;
    				}
    				$result = $res_20;
    				$this->pos = $pos_20;
    				$_37 = NULL;
    				do {
    					$res_22 = $result;
    					$pos_22 = $this->pos;
    					$matcher = 'match_'.'MethodDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_37 = TRUE; break;
    					}
    					$result = $res_22;
    					$this->pos = $pos_22;
    					$_35 = NULL;
    					do {
    						$res_24 = $result;
    						$pos_24 = $this->pos;
    						$matcher = 'match_'.'RuleDecl'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_35 = TRUE; break;
    						}
    						$result = $res_24;
    						$this->pos = $pos_24;
    						$_33 = NULL;
    						do {
    							$res_26 = $result;
    							$pos_26 = $this->pos;
    							$matcher = 'match_'.'QueryDecl'; $key = $matcher; $pos = $this->pos;
    							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    							if ($subres !== FALSE) {
    								$this->store( $result, $subres );
    								$_33 = TRUE; break;
    							}
    							$result = $res_26;
    							$this->pos = $pos_26;
    							$_31 = NULL;
    							do {
    								$res_28 = $result;
    								$pos_28 = $this->pos;
    								$matcher = 'match_'.'ImportDecl'; $key = $matcher; $pos = $this->pos;
    								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    								if ($subres !== FALSE) {
    									$this->store( $result, $subres );
    									$_31 = TRUE; break;
    								}
    								$result = $res_28;
    								$this->pos = $pos_28;
    								$matcher = 'match_'.'ExportDecl'; $key = $matcher; $pos = $this->pos;
    								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    								if ($subres !== FALSE) {
    									$this->store( $result, $subres );
    									$_31 = TRUE; break;
    								}
    								$result = $res_28;
    								$this->pos = $pos_28;
    								$_31 = FALSE; break;
    							}
    							while(0);
    							if( $_31 === TRUE ) { $_33 = TRUE; break; }
    							$result = $res_26;
    							$this->pos = $pos_26;
    							$_33 = FALSE; break;
    						}
    						while(0);
    						if( $_33 === TRUE ) { $_35 = TRUE; break; }
    						$result = $res_24;
    						$this->pos = $pos_24;
    						$_35 = FALSE; break;
    					}
    					while(0);
    					if( $_35 === TRUE ) { $_37 = TRUE; break; }
    					$result = $res_22;
    					$this->pos = $pos_22;
    					$_37 = FALSE; break;
    				}
    				while(0);
    				if( $_37 === TRUE ) { $_39 = TRUE; break; }
    				$result = $res_20;
    				$this->pos = $pos_20;
    				$_39 = FALSE; break;
    			}
    			while(0);
    			if( $_39 === TRUE ) { $_41 = TRUE; break; }
    			$result = $res_18;
    			$this->pos = $pos_18;
    			$_41 = FALSE; break;
    		}
    		while(0);
    		if( $_41 === TRUE ) { $_43 = TRUE; break; }
    		$result = $res_16;
    		$this->pos = $pos_16;
    		$_43 = FALSE; break;
    	}
    	while(0);
    	if( $_43 === TRUE ) { return $this->finalise($result); }
    	if( $_43 === FALSE) { return FALSE; }
    }


    /* ModuleDecl: "module" Identifier "{" ModuleBody "}" */
    protected $match_ModuleDecl_typestack = array('ModuleDecl');
    function match_ModuleDecl ($stack = array()) {
    	$matchrule = "ModuleDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_50 = NULL;
    	do {
    		if (( $subres = $this->literal( 'module' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_50 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_50 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_50 = FALSE; break; }
    		$matcher = 'match_'.'ModuleBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_50 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_50 = FALSE; break; }
    		$_50 = TRUE; break;
    	}
    	while(0);
    	if( $_50 === TRUE ) { return $this->finalise($result); }
    	if( $_50 === FALSE) { return FALSE; }
    }


    /* ModuleBody: ModuleStatement* */
    protected $match_ModuleBody_typestack = array('ModuleBody');
    function match_ModuleBody ($stack = array()) {
    	$matchrule = "ModuleBody"; $result = $this->construct($matchrule, $matchrule, null);
    	while (true) {
    		$res_52 = $result;
    		$pos_52 = $this->pos;
    		$matcher = 'match_'.'ModuleStatement'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_52;
    			$this->pos = $pos_52;
    			unset( $res_52 );
    			unset( $pos_52 );
    			break;
    		}
    	}
    	return $this->finalise($result);
    }


    /* ModuleStatement: ClassDecl | ObjectDecl | MethodDecl | RuleDecl | ExportDecl */
    protected $match_ModuleStatement_typestack = array('ModuleStatement');
    function match_ModuleStatement ($stack = array()) {
    	$matchrule = "ModuleStatement"; $result = $this->construct($matchrule, $matchrule, null);
    	$_68 = NULL;
    	do {
    		$res_53 = $result;
    		$pos_53 = $this->pos;
    		$matcher = 'match_'.'ClassDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_68 = TRUE; break;
    		}
    		$result = $res_53;
    		$this->pos = $pos_53;
    		$_66 = NULL;
    		do {
    			$res_55 = $result;
    			$pos_55 = $this->pos;
    			$matcher = 'match_'.'ObjectDecl'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_66 = TRUE; break;
    			}
    			$result = $res_55;
    			$this->pos = $pos_55;
    			$_64 = NULL;
    			do {
    				$res_57 = $result;
    				$pos_57 = $this->pos;
    				$matcher = 'match_'.'MethodDecl'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_64 = TRUE; break;
    				}
    				$result = $res_57;
    				$this->pos = $pos_57;
    				$_62 = NULL;
    				do {
    					$res_59 = $result;
    					$pos_59 = $this->pos;
    					$matcher = 'match_'.'RuleDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_62 = TRUE; break;
    					}
    					$result = $res_59;
    					$this->pos = $pos_59;
    					$matcher = 'match_'.'ExportDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_62 = TRUE; break;
    					}
    					$result = $res_59;
    					$this->pos = $pos_59;
    					$_62 = FALSE; break;
    				}
    				while(0);
    				if( $_62 === TRUE ) { $_64 = TRUE; break; }
    				$result = $res_57;
    				$this->pos = $pos_57;
    				$_64 = FALSE; break;
    			}
    			while(0);
    			if( $_64 === TRUE ) { $_66 = TRUE; break; }
    			$result = $res_55;
    			$this->pos = $pos_55;
    			$_66 = FALSE; break;
    		}
    		while(0);
    		if( $_66 === TRUE ) { $_68 = TRUE; break; }
    		$result = $res_53;
    		$this->pos = $pos_53;
    		$_68 = FALSE; break;
    	}
    	while(0);
    	if( $_68 === TRUE ) { return $this->finalise($result); }
    	if( $_68 === FALSE) { return FALSE; }
    }


    /* ClassDecl: "class" Identifier Inheritance? "{" ClassBody "}" */
    protected $match_ClassDecl_typestack = array('ClassDecl');
    function match_ClassDecl ($stack = array()) {
    	$matchrule = "ClassDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_76 = NULL;
    	do {
    		if (( $subres = $this->literal( 'class' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_76 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_76 = FALSE; break; }
    		$res_72 = $result;
    		$pos_72 = $this->pos;
    		$matcher = 'match_'.'Inheritance'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_72;
    			$this->pos = $pos_72;
    			unset( $res_72 );
    			unset( $pos_72 );
    		}
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_76 = FALSE; break; }
    		$matcher = 'match_'.'ClassBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_76 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_76 = FALSE; break; }
    		$_76 = TRUE; break;
    	}
    	while(0);
    	if( $_76 === TRUE ) { return $this->finalise($result); }
    	if( $_76 === FALSE) { return FALSE; }
    }


    /* Inheritance: "inherits" ( "structure" )? "from" Identifier */
    protected $match_Inheritance_typestack = array('Inheritance');
    function match_Inheritance ($stack = array()) {
    	$matchrule = "Inheritance"; $result = $this->construct($matchrule, $matchrule, null);
    	$_84 = NULL;
    	do {
    		if (( $subres = $this->literal( 'inherits' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_84 = FALSE; break; }
    		$res_81 = $result;
    		$pos_81 = $this->pos;
    		$_80 = NULL;
    		do {
    			if (( $subres = $this->literal( 'structure' ) ) !== FALSE) { $result["text"] .= $subres; }
    			else { $_80 = FALSE; break; }
    			$_80 = TRUE; break;
    		}
    		while(0);
    		if( $_80 === FALSE) {
    			$result = $res_81;
    			$this->pos = $pos_81;
    			unset( $res_81 );
    			unset( $pos_81 );
    		}
    		if (( $subres = $this->literal( 'from' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_84 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_84 = FALSE; break; }
    		$_84 = TRUE; break;
    	}
    	while(0);
    	if( $_84 === TRUE ) { return $this->finalise($result); }
    	if( $_84 === FALSE) { return FALSE; }
    }


    /* ClassBody: ClassMember* */
    protected $match_ClassBody_typestack = array('ClassBody');
    function match_ClassBody ($stack = array()) {
    	$matchrule = "ClassBody"; $result = $this->construct($matchrule, $matchrule, null);
    	while (true) {
    		$res_86 = $result;
    		$pos_86 = $this->pos;
    		$matcher = 'match_'.'ClassMember'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_86;
    			$this->pos = $pos_86;
    			unset( $res_86 );
    			unset( $pos_86 );
    			break;
    		}
    	}
    	return $this->finalise($result);
    }


    /* ClassMember: FieldDecl | MethodSignature */
    protected $match_ClassMember_typestack = array('ClassMember');
    function match_ClassMember ($stack = array()) {
    	$matchrule = "ClassMember"; $result = $this->construct($matchrule, $matchrule, null);
    	$_90 = NULL;
    	do {
    		$res_87 = $result;
    		$pos_87 = $this->pos;
    		$matcher = 'match_'.'FieldDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_90 = TRUE; break;
    		}
    		$result = $res_87;
    		$this->pos = $pos_87;
    		$matcher = 'match_'.'MethodSignature'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_90 = TRUE; break;
    		}
    		$result = $res_87;
    		$this->pos = $pos_87;
    		$_90 = FALSE; break;
    	}
    	while(0);
    	if( $_90 === TRUE ) { return $this->finalise($result); }
    	if( $_90 === FALSE) { return FALSE; }
    }


    /* FieldDecl: TypeSpec Identifier Constraint? ";" */
    protected $match_FieldDecl_typestack = array('FieldDecl');
    function match_FieldDecl ($stack = array()) {
    	$matchrule = "FieldDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_96 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_96 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_96 = FALSE; break; }
    		$res_94 = $result;
    		$pos_94 = $this->pos;
    		$matcher = 'match_'.'Constraint'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_94;
    			$this->pos = $pos_94;
    			unset( $res_94 );
    			unset( $pos_94 );
    		}
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_96 = FALSE; break; }
    		$_96 = TRUE; break;
    	}
    	while(0);
    	if( $_96 === TRUE ) { return $this->finalise($result); }
    	if( $_96 === FALSE) { return FALSE; }
    }


    /* TypeSpec: CollectionType | PrimitiveType | UserType */
    protected $match_TypeSpec_typestack = array('TypeSpec');
    function match_TypeSpec ($stack = array()) {
    	$matchrule = "TypeSpec"; $result = $this->construct($matchrule, $matchrule, null);
    	$_105 = NULL;
    	do {
    		$res_98 = $result;
    		$pos_98 = $this->pos;
    		$matcher = 'match_'.'CollectionType'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_105 = TRUE; break;
    		}
    		$result = $res_98;
    		$this->pos = $pos_98;
    		$_103 = NULL;
    		do {
    			$res_100 = $result;
    			$pos_100 = $this->pos;
    			$matcher = 'match_'.'PrimitiveType'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_103 = TRUE; break;
    			}
    			$result = $res_100;
    			$this->pos = $pos_100;
    			$matcher = 'match_'.'UserType'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_103 = TRUE; break;
    			}
    			$result = $res_100;
    			$this->pos = $pos_100;
    			$_103 = FALSE; break;
    		}
    		while(0);
    		if( $_103 === TRUE ) { $_105 = TRUE; break; }
    		$result = $res_98;
    		$this->pos = $pos_98;
    		$_105 = FALSE; break;
    	}
    	while(0);
    	if( $_105 === TRUE ) { return $this->finalise($result); }
    	if( $_105 === FALSE) { return FALSE; }
    }


    /* PrimitiveType: "string" | "integer" | "boolean" | "float" */
    protected $match_PrimitiveType_typestack = array('PrimitiveType');
    function match_PrimitiveType ($stack = array()) {
    	$matchrule = "PrimitiveType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_118 = NULL;
    	do {
    		$res_107 = $result;
    		$pos_107 = $this->pos;
    		if (( $subres = $this->literal( 'string' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_118 = TRUE; break;
    		}
    		$result = $res_107;
    		$this->pos = $pos_107;
    		$_116 = NULL;
    		do {
    			$res_109 = $result;
    			$pos_109 = $this->pos;
    			if (( $subres = $this->literal( 'integer' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_116 = TRUE; break;
    			}
    			$result = $res_109;
    			$this->pos = $pos_109;
    			$_114 = NULL;
    			do {
    				$res_111 = $result;
    				$pos_111 = $this->pos;
    				if (( $subres = $this->literal( 'boolean' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_114 = TRUE; break;
    				}
    				$result = $res_111;
    				$this->pos = $pos_111;
    				if (( $subres = $this->literal( 'float' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_114 = TRUE; break;
    				}
    				$result = $res_111;
    				$this->pos = $pos_111;
    				$_114 = FALSE; break;
    			}
    			while(0);
    			if( $_114 === TRUE ) { $_116 = TRUE; break; }
    			$result = $res_109;
    			$this->pos = $pos_109;
    			$_116 = FALSE; break;
    		}
    		while(0);
    		if( $_116 === TRUE ) { $_118 = TRUE; break; }
    		$result = $res_107;
    		$this->pos = $pos_107;
    		$_118 = FALSE; break;
    	}
    	while(0);
    	if( $_118 === TRUE ) { return $this->finalise($result); }
    	if( $_118 === FALSE) { return FALSE; }
    }


    /* UserType: Identifier */
    protected $match_UserType_typestack = array('UserType');
    function match_UserType ($stack = array()) {
    	$matchrule = "UserType"; $result = $this->construct($matchrule, $matchrule, null);
    	$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    	if ($subres !== FALSE) {
    		$this->store( $result, $subres );
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* CollectionType: CollectionKeyword "<" TypeSpec ">" Constraint? */
    protected $match_CollectionType_typestack = array('CollectionType');
    function match_CollectionType ($stack = array()) {
    	$matchrule = "CollectionType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_126 = NULL;
    	do {
    		$matcher = 'match_'.'CollectionKeyword'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_126 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '<') {
    			$this->pos += 1;
    			$result["text"] .= '<';
    		}
    		else { $_126 = FALSE; break; }
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_126 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '>') {
    			$this->pos += 1;
    			$result["text"] .= '>';
    		}
    		else { $_126 = FALSE; break; }
    		$res_125 = $result;
    		$pos_125 = $this->pos;
    		$matcher = 'match_'.'Constraint'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_125;
    			$this->pos = $pos_125;
    			unset( $res_125 );
    			unset( $pos_125 );
    		}
    		$_126 = TRUE; break;
    	}
    	while(0);
    	if( $_126 === TRUE ) { return $this->finalise($result); }
    	if( $_126 === FALSE) { return FALSE; }
    }


    /* CollectionKeyword: "set" | "list" | "bag" */
    protected $match_CollectionKeyword_typestack = array('CollectionKeyword');
    function match_CollectionKeyword ($stack = array()) {
    	$matchrule = "CollectionKeyword"; $result = $this->construct($matchrule, $matchrule, null);
    	$_135 = NULL;
    	do {
    		$res_128 = $result;
    		$pos_128 = $this->pos;
    		if (( $subres = $this->literal( 'set' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_135 = TRUE; break;
    		}
    		$result = $res_128;
    		$this->pos = $pos_128;
    		$_133 = NULL;
    		do {
    			$res_130 = $result;
    			$pos_130 = $this->pos;
    			if (( $subres = $this->literal( 'list' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_133 = TRUE; break;
    			}
    			$result = $res_130;
    			$this->pos = $pos_130;
    			if (( $subres = $this->literal( 'bag' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_133 = TRUE; break;
    			}
    			$result = $res_130;
    			$this->pos = $pos_130;
    			$_133 = FALSE; break;
    		}
    		while(0);
    		if( $_133 === TRUE ) { $_135 = TRUE; break; }
    		$result = $res_128;
    		$this->pos = $pos_128;
    		$_135 = FALSE; break;
    	}
    	while(0);
    	if( $_135 === TRUE ) { return $this->finalise($result); }
    	if( $_135 === FALSE) { return FALSE; }
    }


    /* Constraint: "{" ConstraintExpr "}" */
    protected $match_Constraint_typestack = array('Constraint');
    function match_Constraint ($stack = array()) {
    	$matchrule = "Constraint"; $result = $this->construct($matchrule, $matchrule, null);
    	$_140 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_140 = FALSE; break; }
    		$matcher = 'match_'.'ConstraintExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_140 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_140 = FALSE; break; }
    		$_140 = TRUE; break;
    	}
    	while(0);
    	if( $_140 === TRUE ) { return $this->finalise($result); }
    	if( $_140 === FALSE) { return FALSE; }
    }


    /* ConstraintExpr: Range | Number */
    protected $match_ConstraintExpr_typestack = array('ConstraintExpr');
    function match_ConstraintExpr ($stack = array()) {
    	$matchrule = "ConstraintExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_145 = NULL;
    	do {
    		$res_142 = $result;
    		$pos_142 = $this->pos;
    		$matcher = 'match_'.'Range'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_145 = TRUE; break;
    		}
    		$result = $res_142;
    		$this->pos = $pos_142;
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_145 = TRUE; break;
    		}
    		$result = $res_142;
    		$this->pos = $pos_142;
    		$_145 = FALSE; break;
    	}
    	while(0);
    	if( $_145 === TRUE ) { return $this->finalise($result); }
    	if( $_145 === FALSE) { return FALSE; }
    }


    /* Range: Number ".." Number */
    protected $match_Range_typestack = array('Range');
    function match_Range ($stack = array()) {
    	$matchrule = "Range"; $result = $this->construct($matchrule, $matchrule, null);
    	$_150 = NULL;
    	do {
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_150 = FALSE; break; }
    		if (( $subres = $this->literal( '..' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_150 = FALSE; break; }
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_150 = FALSE; break; }
    		$_150 = TRUE; break;
    	}
    	while(0);
    	if( $_150 === TRUE ) { return $this->finalise($result); }
    	if( $_150 === FALSE) { return FALSE; }
    }


    /* MethodSignature: TypeSpec Identifier "(" ParamList? ")" ";" */
    protected $match_MethodSignature_typestack = array('MethodSignature');
    function match_MethodSignature ($stack = array()) {
    	$matchrule = "MethodSignature"; $result = $this->construct($matchrule, $matchrule, null);
    	$_158 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_158 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_158 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_158 = FALSE; break; }
    		$res_155 = $result;
    		$pos_155 = $this->pos;
    		$matcher = 'match_'.'ParamList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_155;
    			$this->pos = $pos_155;
    			unset( $res_155 );
    			unset( $pos_155 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_158 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_158 = FALSE; break; }
    		$_158 = TRUE; break;
    	}
    	while(0);
    	if( $_158 === TRUE ) { return $this->finalise($result); }
    	if( $_158 === FALSE) { return FALSE; }
    }


    /* ObjectDecl: "object" Identifier ":" Identifier "{" ObjectBody "}" */
    protected $match_ObjectDecl_typestack = array('ObjectDecl');
    function match_ObjectDecl ($stack = array()) {
    	$matchrule = "ObjectDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_167 = NULL;
    	do {
    		if (( $subres = $this->literal( 'object' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_167 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_167 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ':') {
    			$this->pos += 1;
    			$result["text"] .= ':';
    		}
    		else { $_167 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_167 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_167 = FALSE; break; }
    		$matcher = 'match_'.'ObjectBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_167 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_167 = FALSE; break; }
    		$_167 = TRUE; break;
    	}
    	while(0);
    	if( $_167 === TRUE ) { return $this->finalise($result); }
    	if( $_167 === FALSE) { return FALSE; }
    }


    /* ObjectBody: Assignment* */
    protected $match_ObjectBody_typestack = array('ObjectBody');
    function match_ObjectBody ($stack = array()) {
    	$matchrule = "ObjectBody"; $result = $this->construct($matchrule, $matchrule, null);
    	while (true) {
    		$res_169 = $result;
    		$pos_169 = $this->pos;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_169;
    			$this->pos = $pos_169;
    			unset( $res_169 );
    			unset( $pos_169 );
    			break;
    		}
    	}
    	return $this->finalise($result);
    }


    /* Assignment: Identifier AssignOp Expression ";" */
    protected $match_Assignment_typestack = array('Assignment');
    function match_Assignment ($stack = array()) {
    	$matchrule = "Assignment"; $result = $this->construct($matchrule, $matchrule, null);
    	$_174 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_174 = FALSE; break; }
    		$matcher = 'match_'.'AssignOp'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_174 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_174 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_174 = FALSE; break; }
    		$_174 = TRUE; break;
    	}
    	while(0);
    	if( $_174 === TRUE ) { return $this->finalise($result); }
    	if( $_174 === FALSE) { return FALSE; }
    }


    /* AssignOp: "+=" | "-=" | "=" */
    protected $match_AssignOp_typestack = array('AssignOp');
    function match_AssignOp ($stack = array()) {
    	$matchrule = "AssignOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_183 = NULL;
    	do {
    		$res_176 = $result;
    		$pos_176 = $this->pos;
    		if (( $subres = $this->literal( '+=' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_183 = TRUE; break;
    		}
    		$result = $res_176;
    		$this->pos = $pos_176;
    		$_181 = NULL;
    		do {
    			$res_178 = $result;
    			$pos_178 = $this->pos;
    			if (( $subres = $this->literal( '-=' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_181 = TRUE; break;
    			}
    			$result = $res_178;
    			$this->pos = $pos_178;
    			if (substr($this->string,$this->pos,1) == '=') {
    				$this->pos += 1;
    				$result["text"] .= '=';
    				$_181 = TRUE; break;
    			}
    			$result = $res_178;
    			$this->pos = $pos_178;
    			$_181 = FALSE; break;
    		}
    		while(0);
    		if( $_181 === TRUE ) { $_183 = TRUE; break; }
    		$result = $res_176;
    		$this->pos = $pos_176;
    		$_183 = FALSE; break;
    	}
    	while(0);
    	if( $_183 === TRUE ) { return $this->finalise($result); }
    	if( $_183 === FALSE) { return FALSE; }
    }


    /* MethodDecl: "method" QualifiedName "(" ParamList? ")" ReturnType? BlockStmt */
    protected $match_MethodDecl_typestack = array('MethodDecl');
    function match_MethodDecl ($stack = array()) {
    	$matchrule = "MethodDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_192 = NULL;
    	do {
    		if (( $subres = $this->literal( 'method' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_192 = FALSE; break; }
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_192 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_192 = FALSE; break; }
    		$res_188 = $result;
    		$pos_188 = $this->pos;
    		$matcher = 'match_'.'ParamList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_188;
    			$this->pos = $pos_188;
    			unset( $res_188 );
    			unset( $pos_188 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_192 = FALSE; break; }
    		$res_190 = $result;
    		$pos_190 = $this->pos;
    		$matcher = 'match_'.'ReturnType'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_190;
    			$this->pos = $pos_190;
    			unset( $res_190 );
    			unset( $pos_190 );
    		}
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_192 = FALSE; break; }
    		$_192 = TRUE; break;
    	}
    	while(0);
    	if( $_192 === TRUE ) { return $this->finalise($result); }
    	if( $_192 === FALSE) { return FALSE; }
    }


    /* ReturnType: "returns" TypeSpec */
    protected $match_ReturnType_typestack = array('ReturnType');
    function match_ReturnType ($stack = array()) {
    	$matchrule = "ReturnType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_196 = NULL;
    	do {
    		if (( $subres = $this->literal( 'returns' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_196 = FALSE; break; }
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_196 = FALSE; break; }
    		$_196 = TRUE; break;
    	}
    	while(0);
    	if( $_196 === TRUE ) { return $this->finalise($result); }
    	if( $_196 === FALSE) { return FALSE; }
    }


    /* ParamList: Parameter ( "," Parameter )* */
    protected $match_ParamList_typestack = array('ParamList');
    function match_ParamList ($stack = array()) {
    	$matchrule = "ParamList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_203 = NULL;
    	do {
    		$matcher = 'match_'.'Parameter'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_203 = FALSE; break; }
    		while (true) {
    			$res_202 = $result;
    			$pos_202 = $this->pos;
    			$_201 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_201 = FALSE; break; }
    				$matcher = 'match_'.'Parameter'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_201 = FALSE; break; }
    				$_201 = TRUE; break;
    			}
    			while(0);
    			if( $_201 === FALSE) {
    				$result = $res_202;
    				$this->pos = $pos_202;
    				unset( $res_202 );
    				unset( $pos_202 );
    				break;
    			}
    		}
    		$_203 = TRUE; break;
    	}
    	while(0);
    	if( $_203 === TRUE ) { return $this->finalise($result); }
    	if( $_203 === FALSE) { return FALSE; }
    }


    /* Parameter: TypeSpec Identifier */
    protected $match_Parameter_typestack = array('Parameter');
    function match_Parameter ($stack = array()) {
    	$matchrule = "Parameter"; $result = $this->construct($matchrule, $matchrule, null);
    	$_207 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_207 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_207 = FALSE; break; }
    		$_207 = TRUE; break;
    	}
    	while(0);
    	if( $_207 === TRUE ) { return $this->finalise($result); }
    	if( $_207 === FALSE) { return FALSE; }
    }


    /* RuleDecl: "rule" Identifier "{" RuleBody "}" */
    protected $match_RuleDecl_typestack = array('RuleDecl');
    function match_RuleDecl ($stack = array()) {
    	$matchrule = "RuleDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_214 = NULL;
    	do {
    		if (( $subres = $this->literal( 'rule' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_214 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_214 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_214 = FALSE; break; }
    		$matcher = 'match_'.'RuleBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_214 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_214 = FALSE; break; }
    		$_214 = TRUE; break;
    	}
    	while(0);
    	if( $_214 === TRUE ) { return $this->finalise($result); }
    	if( $_214 === FALSE) { return FALSE; }
    }


    /* RuleBody: IfStmt | Assignment */
    protected $match_RuleBody_typestack = array('RuleBody');
    function match_RuleBody ($stack = array()) {
    	$matchrule = "RuleBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_219 = NULL;
    	do {
    		$res_216 = $result;
    		$pos_216 = $this->pos;
    		$matcher = 'match_'.'IfStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_219 = TRUE; break;
    		}
    		$result = $res_216;
    		$this->pos = $pos_216;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_219 = TRUE; break;
    		}
    		$result = $res_216;
    		$this->pos = $pos_216;
    		$_219 = FALSE; break;
    	}
    	while(0);
    	if( $_219 === TRUE ) { return $this->finalise($result); }
    	if( $_219 === FALSE) { return FALSE; }
    }


    /* QueryDecl: "query" Identifier "{" QueryBody "}" */
    protected $match_QueryDecl_typestack = array('QueryDecl');
    function match_QueryDecl ($stack = array()) {
    	$matchrule = "QueryDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_226 = NULL;
    	do {
    		if (( $subres = $this->literal( 'query' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_226 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_226 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_226 = FALSE; break; }
    		$matcher = 'match_'.'QueryBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_226 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_226 = FALSE; break; }
    		$_226 = TRUE; break;
    	}
    	while(0);
    	if( $_226 === TRUE ) { return $this->finalise($result); }
    	if( $_226 === FALSE) { return FALSE; }
    }


    /* QueryBody: "select" Identifier "where" Expression ";" */
    protected $match_QueryBody_typestack = array('QueryBody');
    function match_QueryBody ($stack = array()) {
    	$matchrule = "QueryBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_233 = NULL;
    	do {
    		if (( $subres = $this->literal( 'select' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_233 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_233 = FALSE; break; }
    		if (( $subres = $this->literal( 'where' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_233 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_233 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_233 = FALSE; break; }
    		$_233 = TRUE; break;
    	}
    	while(0);
    	if( $_233 === TRUE ) { return $this->finalise($result); }
    	if( $_233 === FALSE) { return FALSE; }
    }


    /* IfStmt: "if" "(" Expression ")" BlockStmt ElseClause? */
    protected $match_IfStmt_typestack = array('IfStmt');
    function match_IfStmt ($stack = array()) {
    	$matchrule = "IfStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_241 = NULL;
    	do {
    		if (( $subres = $this->literal( 'if' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_241 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_241 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_241 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_241 = FALSE; break; }
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_241 = FALSE; break; }
    		$res_240 = $result;
    		$pos_240 = $this->pos;
    		$matcher = 'match_'.'ElseClause'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_240;
    			$this->pos = $pos_240;
    			unset( $res_240 );
    			unset( $pos_240 );
    		}
    		$_241 = TRUE; break;
    	}
    	while(0);
    	if( $_241 === TRUE ) { return $this->finalise($result); }
    	if( $_241 === FALSE) { return FALSE; }
    }


    /* ElseClause: "else" BlockStmt */
    protected $match_ElseClause_typestack = array('ElseClause');
    function match_ElseClause ($stack = array()) {
    	$matchrule = "ElseClause"; $result = $this->construct($matchrule, $matchrule, null);
    	$_245 = NULL;
    	do {
    		if (( $subres = $this->literal( 'else' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_245 = FALSE; break; }
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_245 = FALSE; break; }
    		$_245 = TRUE; break;
    	}
    	while(0);
    	if( $_245 === TRUE ) { return $this->finalise($result); }
    	if( $_245 === FALSE) { return FALSE; }
    }


    /* BlockStmt: "{" StmtList "}" */
    protected $match_BlockStmt_typestack = array('BlockStmt');
    function match_BlockStmt ($stack = array()) {
    	$matchrule = "BlockStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_250 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_250 = FALSE; break; }
    		$matcher = 'match_'.'StmtList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_250 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_250 = FALSE; break; }
    		$_250 = TRUE; break;
    	}
    	while(0);
    	if( $_250 === TRUE ) { return $this->finalise($result); }
    	if( $_250 === FALSE) { return FALSE; }
    }


    /* StmtList: InnerStmt* */
    protected $match_StmtList_typestack = array('StmtList');
    function match_StmtList ($stack = array()) {
    	$matchrule = "StmtList"; $result = $this->construct($matchrule, $matchrule, null);
    	while (true) {
    		$res_252 = $result;
    		$pos_252 = $this->pos;
    		$matcher = 'match_'.'InnerStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_252;
    			$this->pos = $pos_252;
    			unset( $res_252 );
    			unset( $pos_252 );
    			break;
    		}
    	}
    	return $this->finalise($result);
    }


    /* InnerStmt: Assignment | IfStmt | ReturnStmt | ExprStmt */
    protected $match_InnerStmt_typestack = array('InnerStmt');
    function match_InnerStmt ($stack = array()) {
    	$matchrule = "InnerStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_264 = NULL;
    	do {
    		$res_253 = $result;
    		$pos_253 = $this->pos;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_264 = TRUE; break;
    		}
    		$result = $res_253;
    		$this->pos = $pos_253;
    		$_262 = NULL;
    		do {
    			$res_255 = $result;
    			$pos_255 = $this->pos;
    			$matcher = 'match_'.'IfStmt'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_262 = TRUE; break;
    			}
    			$result = $res_255;
    			$this->pos = $pos_255;
    			$_260 = NULL;
    			do {
    				$res_257 = $result;
    				$pos_257 = $this->pos;
    				$matcher = 'match_'.'ReturnStmt'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_260 = TRUE; break;
    				}
    				$result = $res_257;
    				$this->pos = $pos_257;
    				$matcher = 'match_'.'ExprStmt'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_260 = TRUE; break;
    				}
    				$result = $res_257;
    				$this->pos = $pos_257;
    				$_260 = FALSE; break;
    			}
    			while(0);
    			if( $_260 === TRUE ) { $_262 = TRUE; break; }
    			$result = $res_255;
    			$this->pos = $pos_255;
    			$_262 = FALSE; break;
    		}
    		while(0);
    		if( $_262 === TRUE ) { $_264 = TRUE; break; }
    		$result = $res_253;
    		$this->pos = $pos_253;
    		$_264 = FALSE; break;
    	}
    	while(0);
    	if( $_264 === TRUE ) { return $this->finalise($result); }
    	if( $_264 === FALSE) { return FALSE; }
    }


    /* ReturnStmt: "return" Expression ";" */
    protected $match_ReturnStmt_typestack = array('ReturnStmt');
    function match_ReturnStmt ($stack = array()) {
    	$matchrule = "ReturnStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_269 = NULL;
    	do {
    		if (( $subres = $this->literal( 'return' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_269 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_269 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_269 = FALSE; break; }
    		$_269 = TRUE; break;
    	}
    	while(0);
    	if( $_269 === TRUE ) { return $this->finalise($result); }
    	if( $_269 === FALSE) { return FALSE; }
    }


    /* ExprStmt: Expression ";" */
    protected $match_ExprStmt_typestack = array('ExprStmt');
    function match_ExprStmt ($stack = array()) {
    	$matchrule = "ExprStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_273 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_273 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_273 = FALSE; break; }
    		$_273 = TRUE; break;
    	}
    	while(0);
    	if( $_273 === TRUE ) { return $this->finalise($result); }
    	if( $_273 === FALSE) { return FALSE; }
    }


    /* Expression: LogicalExpr */
    protected $match_Expression_typestack = array('Expression');
    function match_Expression ($stack = array()) {
    	$matchrule = "Expression"; $result = $this->construct($matchrule, $matchrule, null);
    	$matcher = 'match_'.'LogicalExpr'; $key = $matcher; $pos = $this->pos;
    	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    	if ($subres !== FALSE) {
    		$this->store( $result, $subres );
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* LogicalExpr: ComparisonExpr ( LogicalOp ComparisonExpr )* */
    protected $match_LogicalExpr_typestack = array('LogicalExpr');
    function match_LogicalExpr ($stack = array()) {
    	$matchrule = "LogicalExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_281 = NULL;
    	do {
    		$matcher = 'match_'.'ComparisonExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_281 = FALSE; break; }
    		while (true) {
    			$res_280 = $result;
    			$pos_280 = $this->pos;
    			$_279 = NULL;
    			do {
    				$matcher = 'match_'.'LogicalOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_279 = FALSE; break; }
    				$matcher = 'match_'.'ComparisonExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_279 = FALSE; break; }
    				$_279 = TRUE; break;
    			}
    			while(0);
    			if( $_279 === FALSE) {
    				$result = $res_280;
    				$this->pos = $pos_280;
    				unset( $res_280 );
    				unset( $pos_280 );
    				break;
    			}
    		}
    		$_281 = TRUE; break;
    	}
    	while(0);
    	if( $_281 === TRUE ) { return $this->finalise($result); }
    	if( $_281 === FALSE) { return FALSE; }
    }


    /* LogicalOp: "&&" | "||" | "and" | "or" */
    protected $match_LogicalOp_typestack = array('LogicalOp');
    function match_LogicalOp ($stack = array()) {
    	$matchrule = "LogicalOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_294 = NULL;
    	do {
    		$res_283 = $result;
    		$pos_283 = $this->pos;
    		if (( $subres = $this->literal( '&&' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_294 = TRUE; break;
    		}
    		$result = $res_283;
    		$this->pos = $pos_283;
    		$_292 = NULL;
    		do {
    			$res_285 = $result;
    			$pos_285 = $this->pos;
    			if (( $subres = $this->literal( '||' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_292 = TRUE; break;
    			}
    			$result = $res_285;
    			$this->pos = $pos_285;
    			$_290 = NULL;
    			do {
    				$res_287 = $result;
    				$pos_287 = $this->pos;
    				if (( $subres = $this->literal( 'and' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_290 = TRUE; break;
    				}
    				$result = $res_287;
    				$this->pos = $pos_287;
    				if (( $subres = $this->literal( 'or' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_290 = TRUE; break;
    				}
    				$result = $res_287;
    				$this->pos = $pos_287;
    				$_290 = FALSE; break;
    			}
    			while(0);
    			if( $_290 === TRUE ) { $_292 = TRUE; break; }
    			$result = $res_285;
    			$this->pos = $pos_285;
    			$_292 = FALSE; break;
    		}
    		while(0);
    		if( $_292 === TRUE ) { $_294 = TRUE; break; }
    		$result = $res_283;
    		$this->pos = $pos_283;
    		$_294 = FALSE; break;
    	}
    	while(0);
    	if( $_294 === TRUE ) { return $this->finalise($result); }
    	if( $_294 === FALSE) { return FALSE; }
    }


    /* ComparisonExpr: AdditiveExpr ( ComparisonOp AdditiveExpr )? */
    protected $match_ComparisonExpr_typestack = array('ComparisonExpr');
    function match_ComparisonExpr ($stack = array()) {
    	$matchrule = "ComparisonExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_301 = NULL;
    	do {
    		$matcher = 'match_'.'AdditiveExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_301 = FALSE; break; }
    		$res_300 = $result;
    		$pos_300 = $this->pos;
    		$_299 = NULL;
    		do {
    			$matcher = 'match_'.'ComparisonOp'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else { $_299 = FALSE; break; }
    			$matcher = 'match_'.'AdditiveExpr'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else { $_299 = FALSE; break; }
    			$_299 = TRUE; break;
    		}
    		while(0);
    		if( $_299 === FALSE) {
    			$result = $res_300;
    			$this->pos = $pos_300;
    			unset( $res_300 );
    			unset( $pos_300 );
    		}
    		$_301 = TRUE; break;
    	}
    	while(0);
    	if( $_301 === TRUE ) { return $this->finalise($result); }
    	if( $_301 === FALSE) { return FALSE; }
    }


    /* ComparisonOp: "==" | "!=" | "<=" | ">=" | "<" | ">" */
    protected $match_ComparisonOp_typestack = array('ComparisonOp');
    function match_ComparisonOp ($stack = array()) {
    	$matchrule = "ComparisonOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_322 = NULL;
    	do {
    		$res_303 = $result;
    		$pos_303 = $this->pos;
    		if (( $subres = $this->literal( '==' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_322 = TRUE; break;
    		}
    		$result = $res_303;
    		$this->pos = $pos_303;
    		$_320 = NULL;
    		do {
    			$res_305 = $result;
    			$pos_305 = $this->pos;
    			if (( $subres = $this->literal( '!=' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_320 = TRUE; break;
    			}
    			$result = $res_305;
    			$this->pos = $pos_305;
    			$_318 = NULL;
    			do {
    				$res_307 = $result;
    				$pos_307 = $this->pos;
    				if (( $subres = $this->literal( '<=' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_318 = TRUE; break;
    				}
    				$result = $res_307;
    				$this->pos = $pos_307;
    				$_316 = NULL;
    				do {
    					$res_309 = $result;
    					$pos_309 = $this->pos;
    					if (( $subres = $this->literal( '>=' ) ) !== FALSE) {
    						$result["text"] .= $subres;
    						$_316 = TRUE; break;
    					}
    					$result = $res_309;
    					$this->pos = $pos_309;
    					$_314 = NULL;
    					do {
    						$res_311 = $result;
    						$pos_311 = $this->pos;
    						if (substr($this->string,$this->pos,1) == '<') {
    							$this->pos += 1;
    							$result["text"] .= '<';
    							$_314 = TRUE; break;
    						}
    						$result = $res_311;
    						$this->pos = $pos_311;
    						if (substr($this->string,$this->pos,1) == '>') {
    							$this->pos += 1;
    							$result["text"] .= '>';
    							$_314 = TRUE; break;
    						}
    						$result = $res_311;
    						$this->pos = $pos_311;
    						$_314 = FALSE; break;
    					}
    					while(0);
    					if( $_314 === TRUE ) { $_316 = TRUE; break; }
    					$result = $res_309;
    					$this->pos = $pos_309;
    					$_316 = FALSE; break;
    				}
    				while(0);
    				if( $_316 === TRUE ) { $_318 = TRUE; break; }
    				$result = $res_307;
    				$this->pos = $pos_307;
    				$_318 = FALSE; break;
    			}
    			while(0);
    			if( $_318 === TRUE ) { $_320 = TRUE; break; }
    			$result = $res_305;
    			$this->pos = $pos_305;
    			$_320 = FALSE; break;
    		}
    		while(0);
    		if( $_320 === TRUE ) { $_322 = TRUE; break; }
    		$result = $res_303;
    		$this->pos = $pos_303;
    		$_322 = FALSE; break;
    	}
    	while(0);
    	if( $_322 === TRUE ) { return $this->finalise($result); }
    	if( $_322 === FALSE) { return FALSE; }
    }


    /* AdditiveExpr: MultiplicativeExpr ( AdditiveOp MultiplicativeExpr )* */
    protected $match_AdditiveExpr_typestack = array('AdditiveExpr');
    function match_AdditiveExpr ($stack = array()) {
    	$matchrule = "AdditiveExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_329 = NULL;
    	do {
    		$matcher = 'match_'.'MultiplicativeExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_329 = FALSE; break; }
    		while (true) {
    			$res_328 = $result;
    			$pos_328 = $this->pos;
    			$_327 = NULL;
    			do {
    				$matcher = 'match_'.'AdditiveOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_327 = FALSE; break; }
    				$matcher = 'match_'.'MultiplicativeExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_327 = FALSE; break; }
    				$_327 = TRUE; break;
    			}
    			while(0);
    			if( $_327 === FALSE) {
    				$result = $res_328;
    				$this->pos = $pos_328;
    				unset( $res_328 );
    				unset( $pos_328 );
    				break;
    			}
    		}
    		$_329 = TRUE; break;
    	}
    	while(0);
    	if( $_329 === TRUE ) { return $this->finalise($result); }
    	if( $_329 === FALSE) { return FALSE; }
    }


    /* AdditiveOp: "+" | "-" */
    protected $match_AdditiveOp_typestack = array('AdditiveOp');
    function match_AdditiveOp ($stack = array()) {
    	$matchrule = "AdditiveOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_334 = NULL;
    	do {
    		$res_331 = $result;
    		$pos_331 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '+') {
    			$this->pos += 1;
    			$result["text"] .= '+';
    			$_334 = TRUE; break;
    		}
    		$result = $res_331;
    		$this->pos = $pos_331;
    		if (substr($this->string,$this->pos,1) == '-') {
    			$this->pos += 1;
    			$result["text"] .= '-';
    			$_334 = TRUE; break;
    		}
    		$result = $res_331;
    		$this->pos = $pos_331;
    		$_334 = FALSE; break;
    	}
    	while(0);
    	if( $_334 === TRUE ) { return $this->finalise($result); }
    	if( $_334 === FALSE) { return FALSE; }
    }


    /* MultiplicativeExpr: UnaryExpr ( MultiplicativeOp UnaryExpr )* */
    protected $match_MultiplicativeExpr_typestack = array('MultiplicativeExpr');
    function match_MultiplicativeExpr ($stack = array()) {
    	$matchrule = "MultiplicativeExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_341 = NULL;
    	do {
    		$matcher = 'match_'.'UnaryExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_341 = FALSE; break; }
    		while (true) {
    			$res_340 = $result;
    			$pos_340 = $this->pos;
    			$_339 = NULL;
    			do {
    				$matcher = 'match_'.'MultiplicativeOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_339 = FALSE; break; }
    				$matcher = 'match_'.'UnaryExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_339 = FALSE; break; }
    				$_339 = TRUE; break;
    			}
    			while(0);
    			if( $_339 === FALSE) {
    				$result = $res_340;
    				$this->pos = $pos_340;
    				unset( $res_340 );
    				unset( $pos_340 );
    				break;
    			}
    		}
    		$_341 = TRUE; break;
    	}
    	while(0);
    	if( $_341 === TRUE ) { return $this->finalise($result); }
    	if( $_341 === FALSE) { return FALSE; }
    }


    /* MultiplicativeOp: "*" | "/" | "%" */
    protected $match_MultiplicativeOp_typestack = array('MultiplicativeOp');
    function match_MultiplicativeOp ($stack = array()) {
    	$matchrule = "MultiplicativeOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_350 = NULL;
    	do {
    		$res_343 = $result;
    		$pos_343 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '*') {
    			$this->pos += 1;
    			$result["text"] .= '*';
    			$_350 = TRUE; break;
    		}
    		$result = $res_343;
    		$this->pos = $pos_343;
    		$_348 = NULL;
    		do {
    			$res_345 = $result;
    			$pos_345 = $this->pos;
    			if (substr($this->string,$this->pos,1) == '/') {
    				$this->pos += 1;
    				$result["text"] .= '/';
    				$_348 = TRUE; break;
    			}
    			$result = $res_345;
    			$this->pos = $pos_345;
    			if (substr($this->string,$this->pos,1) == '%') {
    				$this->pos += 1;
    				$result["text"] .= '%';
    				$_348 = TRUE; break;
    			}
    			$result = $res_345;
    			$this->pos = $pos_345;
    			$_348 = FALSE; break;
    		}
    		while(0);
    		if( $_348 === TRUE ) { $_350 = TRUE; break; }
    		$result = $res_343;
    		$this->pos = $pos_343;
    		$_350 = FALSE; break;
    	}
    	while(0);
    	if( $_350 === TRUE ) { return $this->finalise($result); }
    	if( $_350 === FALSE) { return FALSE; }
    }


    /* UnaryExpr: UnaryOp? PrimaryExpr */
    protected $match_UnaryExpr_typestack = array('UnaryExpr');
    function match_UnaryExpr ($stack = array()) {
    	$matchrule = "UnaryExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_354 = NULL;
    	do {
    		$res_352 = $result;
    		$pos_352 = $this->pos;
    		$matcher = 'match_'.'UnaryOp'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_352;
    			$this->pos = $pos_352;
    			unset( $res_352 );
    			unset( $pos_352 );
    		}
    		$matcher = 'match_'.'PrimaryExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_354 = FALSE; break; }
    		$_354 = TRUE; break;
    	}
    	while(0);
    	if( $_354 === TRUE ) { return $this->finalise($result); }
    	if( $_354 === FALSE) { return FALSE; }
    }


    /* UnaryOp: "!" | "not" | "-" */
    protected $match_UnaryOp_typestack = array('UnaryOp');
    function match_UnaryOp ($stack = array()) {
    	$matchrule = "UnaryOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_363 = NULL;
    	do {
    		$res_356 = $result;
    		$pos_356 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '!') {
    			$this->pos += 1;
    			$result["text"] .= '!';
    			$_363 = TRUE; break;
    		}
    		$result = $res_356;
    		$this->pos = $pos_356;
    		$_361 = NULL;
    		do {
    			$res_358 = $result;
    			$pos_358 = $this->pos;
    			if (( $subres = $this->literal( 'not' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_361 = TRUE; break;
    			}
    			$result = $res_358;
    			$this->pos = $pos_358;
    			if (substr($this->string,$this->pos,1) == '-') {
    				$this->pos += 1;
    				$result["text"] .= '-';
    				$_361 = TRUE; break;
    			}
    			$result = $res_358;
    			$this->pos = $pos_358;
    			$_361 = FALSE; break;
    		}
    		while(0);
    		if( $_361 === TRUE ) { $_363 = TRUE; break; }
    		$result = $res_356;
    		$this->pos = $pos_356;
    		$_363 = FALSE; break;
    	}
    	while(0);
    	if( $_363 === TRUE ) { return $this->finalise($result); }
    	if( $_363 === FALSE) { return FALSE; }
    }


    /* PrimaryExpr: Literal | MethodCall | PropertyAccess | ThisKeyword | ParenExpr | SetLiteral */
    protected $match_PrimaryExpr_typestack = array('PrimaryExpr');
    function match_PrimaryExpr ($stack = array()) {
    	$matchrule = "PrimaryExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_384 = NULL;
    	do {
    		$res_365 = $result;
    		$pos_365 = $this->pos;
    		$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_384 = TRUE; break;
    		}
    		$result = $res_365;
    		$this->pos = $pos_365;
    		$_382 = NULL;
    		do {
    			$res_367 = $result;
    			$pos_367 = $this->pos;
    			$matcher = 'match_'.'MethodCall'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_382 = TRUE; break;
    			}
    			$result = $res_367;
    			$this->pos = $pos_367;
    			$_380 = NULL;
    			do {
    				$res_369 = $result;
    				$pos_369 = $this->pos;
    				$matcher = 'match_'.'PropertyAccess'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_380 = TRUE; break;
    				}
    				$result = $res_369;
    				$this->pos = $pos_369;
    				$_378 = NULL;
    				do {
    					$res_371 = $result;
    					$pos_371 = $this->pos;
    					$matcher = 'match_'.'ThisKeyword'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_378 = TRUE; break;
    					}
    					$result = $res_371;
    					$this->pos = $pos_371;
    					$_376 = NULL;
    					do {
    						$res_373 = $result;
    						$pos_373 = $this->pos;
    						$matcher = 'match_'.'ParenExpr'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_376 = TRUE; break;
    						}
    						$result = $res_373;
    						$this->pos = $pos_373;
    						$matcher = 'match_'.'SetLiteral'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_376 = TRUE; break;
    						}
    						$result = $res_373;
    						$this->pos = $pos_373;
    						$_376 = FALSE; break;
    					}
    					while(0);
    					if( $_376 === TRUE ) { $_378 = TRUE; break; }
    					$result = $res_371;
    					$this->pos = $pos_371;
    					$_378 = FALSE; break;
    				}
    				while(0);
    				if( $_378 === TRUE ) { $_380 = TRUE; break; }
    				$result = $res_369;
    				$this->pos = $pos_369;
    				$_380 = FALSE; break;
    			}
    			while(0);
    			if( $_380 === TRUE ) { $_382 = TRUE; break; }
    			$result = $res_367;
    			$this->pos = $pos_367;
    			$_382 = FALSE; break;
    		}
    		while(0);
    		if( $_382 === TRUE ) { $_384 = TRUE; break; }
    		$result = $res_365;
    		$this->pos = $pos_365;
    		$_384 = FALSE; break;
    	}
    	while(0);
    	if( $_384 === TRUE ) { return $this->finalise($result); }
    	if( $_384 === FALSE) { return FALSE; }
    }


    /* ParenExpr: "(" Expression ")" */
    protected $match_ParenExpr_typestack = array('ParenExpr');
    function match_ParenExpr ($stack = array()) {
    	$matchrule = "ParenExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_389 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_389 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_389 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_389 = FALSE; break; }
    		$_389 = TRUE; break;
    	}
    	while(0);
    	if( $_389 === TRUE ) { return $this->finalise($result); }
    	if( $_389 === FALSE) { return FALSE; }
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


    /* MethodCall: QualifiedName "(" ArgList? ")" */
    protected $match_MethodCall_typestack = array('MethodCall');
    function match_MethodCall ($stack = array()) {
    	$matchrule = "MethodCall"; $result = $this->construct($matchrule, $matchrule, null);
    	$_396 = NULL;
    	do {
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_396 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_396 = FALSE; break; }
    		$res_394 = $result;
    		$pos_394 = $this->pos;
    		$matcher = 'match_'.'ArgList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_394;
    			$this->pos = $pos_394;
    			unset( $res_394 );
    			unset( $pos_394 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_396 = FALSE; break; }
    		$_396 = TRUE; break;
    	}
    	while(0);
    	if( $_396 === TRUE ) { return $this->finalise($result); }
    	if( $_396 === FALSE) { return FALSE; }
    }


    /* PropertyAccess: QualifiedName */
    protected $match_PropertyAccess_typestack = array('PropertyAccess');
    function match_PropertyAccess ($stack = array()) {
    	$matchrule = "PropertyAccess"; $result = $this->construct($matchrule, $matchrule, null);
    	$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    	if ($subres !== FALSE) {
    		$this->store( $result, $subres );
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* QualifiedName: Identifier ( "." Identifier )* */
    protected $match_QualifiedName_typestack = array('QualifiedName');
    function match_QualifiedName ($stack = array()) {
    	$matchrule = "QualifiedName"; $result = $this->construct($matchrule, $matchrule, null);
    	$_404 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_404 = FALSE; break; }
    		while (true) {
    			$res_403 = $result;
    			$pos_403 = $this->pos;
    			$_402 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == '.') {
    					$this->pos += 1;
    					$result["text"] .= '.';
    				}
    				else { $_402 = FALSE; break; }
    				$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_402 = FALSE; break; }
    				$_402 = TRUE; break;
    			}
    			while(0);
    			if( $_402 === FALSE) {
    				$result = $res_403;
    				$this->pos = $pos_403;
    				unset( $res_403 );
    				unset( $pos_403 );
    				break;
    			}
    		}
    		$_404 = TRUE; break;
    	}
    	while(0);
    	if( $_404 === TRUE ) { return $this->finalise($result); }
    	if( $_404 === FALSE) { return FALSE; }
    }


    /* ArgList: Expression ( "," Expression )* */
    protected $match_ArgList_typestack = array('ArgList');
    function match_ArgList ($stack = array()) {
    	$matchrule = "ArgList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_411 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_411 = FALSE; break; }
    		while (true) {
    			$res_410 = $result;
    			$pos_410 = $this->pos;
    			$_409 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_409 = FALSE; break; }
    				$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_409 = FALSE; break; }
    				$_409 = TRUE; break;
    			}
    			while(0);
    			if( $_409 === FALSE) {
    				$result = $res_410;
    				$this->pos = $pos_410;
    				unset( $res_410 );
    				unset( $pos_410 );
    				break;
    			}
    		}
    		$_411 = TRUE; break;
    	}
    	while(0);
    	if( $_411 === TRUE ) { return $this->finalise($result); }
    	if( $_411 === FALSE) { return FALSE; }
    }


    /* SetLiteral: "{" ElemList? "}" */
    protected $match_SetLiteral_typestack = array('SetLiteral');
    function match_SetLiteral ($stack = array()) {
    	$matchrule = "SetLiteral"; $result = $this->construct($matchrule, $matchrule, null);
    	$_416 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_416 = FALSE; break; }
    		$res_414 = $result;
    		$pos_414 = $this->pos;
    		$matcher = 'match_'.'ElemList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_414;
    			$this->pos = $pos_414;
    			unset( $res_414 );
    			unset( $pos_414 );
    		}
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_416 = FALSE; break; }
    		$_416 = TRUE; break;
    	}
    	while(0);
    	if( $_416 === TRUE ) { return $this->finalise($result); }
    	if( $_416 === FALSE) { return FALSE; }
    }


    /* ElemList: Expression ( "," Expression )* */
    protected $match_ElemList_typestack = array('ElemList');
    function match_ElemList ($stack = array()) {
    	$matchrule = "ElemList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_423 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_423 = FALSE; break; }
    		while (true) {
    			$res_422 = $result;
    			$pos_422 = $this->pos;
    			$_421 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_421 = FALSE; break; }
    				$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_421 = FALSE; break; }
    				$_421 = TRUE; break;
    			}
    			while(0);
    			if( $_421 === FALSE) {
    				$result = $res_422;
    				$this->pos = $pos_422;
    				unset( $res_422 );
    				unset( $pos_422 );
    				break;
    			}
    		}
    		$_423 = TRUE; break;
    	}
    	while(0);
    	if( $_423 === TRUE ) { return $this->finalise($result); }
    	if( $_423 === FALSE) { return FALSE; }
    }


    /* Literal: String | Float | Number | Boolean | Identifier */
    protected $match_Literal_typestack = array('Literal');
    function match_Literal ($stack = array()) {
    	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
    	$_440 = NULL;
    	do {
    		$res_425 = $result;
    		$pos_425 = $this->pos;
    		$matcher = 'match_'.'String'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_440 = TRUE; break;
    		}
    		$result = $res_425;
    		$this->pos = $pos_425;
    		$_438 = NULL;
    		do {
    			$res_427 = $result;
    			$pos_427 = $this->pos;
    			$matcher = 'match_'.'Float'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_438 = TRUE; break;
    			}
    			$result = $res_427;
    			$this->pos = $pos_427;
    			$_436 = NULL;
    			do {
    				$res_429 = $result;
    				$pos_429 = $this->pos;
    				$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_436 = TRUE; break;
    				}
    				$result = $res_429;
    				$this->pos = $pos_429;
    				$_434 = NULL;
    				do {
    					$res_431 = $result;
    					$pos_431 = $this->pos;
    					$matcher = 'match_'.'Boolean'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_434 = TRUE; break;
    					}
    					$result = $res_431;
    					$this->pos = $pos_431;
    					$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_434 = TRUE; break;
    					}
    					$result = $res_431;
    					$this->pos = $pos_431;
    					$_434 = FALSE; break;
    				}
    				while(0);
    				if( $_434 === TRUE ) { $_436 = TRUE; break; }
    				$result = $res_429;
    				$this->pos = $pos_429;
    				$_436 = FALSE; break;
    			}
    			while(0);
    			if( $_436 === TRUE ) { $_438 = TRUE; break; }
    			$result = $res_427;
    			$this->pos = $pos_427;
    			$_438 = FALSE; break;
    		}
    		while(0);
    		if( $_438 === TRUE ) { $_440 = TRUE; break; }
    		$result = $res_425;
    		$this->pos = $pos_425;
    		$_440 = FALSE; break;
    	}
    	while(0);
    	if( $_440 === TRUE ) { return $this->finalise($result); }
    	if( $_440 === FALSE) { return FALSE; }
    }


    /* String: /"[^"]*"/ */
    protected $match_String_typestack = array('String');
    function match_String ($stack = array()) {
    	$matchrule = "String"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/"[^"]*"/' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* Float: /[0-9]+\.[0-9]+/ */
    protected $match_Float_typestack = array('Float');
    function match_Float ($stack = array()) {
    	$matchrule = "Float"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/[0-9]+\.[0-9]+/' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
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
    	$_448 = NULL;
    	do {
    		$res_445 = $result;
    		$pos_445 = $this->pos;
    		if (( $subres = $this->literal( 'true' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_448 = TRUE; break;
    		}
    		$result = $res_445;
    		$this->pos = $pos_445;
    		if (( $subres = $this->literal( 'false' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_448 = TRUE; break;
    		}
    		$result = $res_445;
    		$this->pos = $pos_445;
    		$_448 = FALSE; break;
    	}
    	while(0);
    	if( $_448 === TRUE ) { return $this->finalise($result); }
    	if( $_448 === FALSE) { return FALSE; }
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


    /* ImportDecl: "import" QualifiedName ImportList? ";" */
    protected $match_ImportDecl_typestack = array('ImportDecl');
    function match_ImportDecl ($stack = array()) {
    	$matchrule = "ImportDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_455 = NULL;
    	do {
    		if (( $subres = $this->literal( 'import' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_455 = FALSE; break; }
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_455 = FALSE; break; }
    		$res_453 = $result;
    		$pos_453 = $this->pos;
    		$matcher = 'match_'.'ImportList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_453;
    			$this->pos = $pos_453;
    			unset( $res_453 );
    			unset( $pos_453 );
    		}
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_455 = FALSE; break; }
    		$_455 = TRUE; break;
    	}
    	while(0);
    	if( $_455 === TRUE ) { return $this->finalise($result); }
    	if( $_455 === FALSE) { return FALSE; }
    }


    /* ImportList: "." "{" IdentList "}" */
    protected $match_ImportList_typestack = array('ImportList');
    function match_ImportList ($stack = array()) {
    	$matchrule = "ImportList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_461 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '.') {
    			$this->pos += 1;
    			$result["text"] .= '.';
    		}
    		else { $_461 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_461 = FALSE; break; }
    		$matcher = 'match_'.'IdentList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_461 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_461 = FALSE; break; }
    		$_461 = TRUE; break;
    	}
    	while(0);
    	if( $_461 === TRUE ) { return $this->finalise($result); }
    	if( $_461 === FALSE) { return FALSE; }
    }


    /* ExportDecl: "export" IdentList ";" */
    protected $match_ExportDecl_typestack = array('ExportDecl');
    function match_ExportDecl ($stack = array()) {
    	$matchrule = "ExportDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_466 = NULL;
    	do {
    		if (( $subres = $this->literal( 'export' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_466 = FALSE; break; }
    		$matcher = 'match_'.'IdentList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_466 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_466 = FALSE; break; }
    		$_466 = TRUE; break;
    	}
    	while(0);
    	if( $_466 === TRUE ) { return $this->finalise($result); }
    	if( $_466 === FALSE) { return FALSE; }
    }


    /* IdentList: Identifier ( "," Identifier )* */
    protected $match_IdentList_typestack = array('IdentList');
    function match_IdentList ($stack = array()) {
    	$matchrule = "IdentList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_473 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_473 = FALSE; break; }
    		while (true) {
    			$res_472 = $result;
    			$pos_472 = $this->pos;
    			$_471 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_471 = FALSE; break; }
    				$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_471 = FALSE; break; }
    				$_471 = TRUE; break;
    			}
    			while(0);
    			if( $_471 === FALSE) {
    				$result = $res_472;
    				$this->pos = $pos_472;
    				unset( $res_472 );
    				unset( $pos_472 );
    				break;
    			}
    		}
    		$_473 = TRUE; break;
    	}
    	while(0);
    	if( $_473 === TRUE ) { return $this->finalise($result); }
    	if( $_473 === FALSE) { return FALSE; }
    }



    function Program__finalise(&$result)
    {
        print_r("Program__finalise\n");
        print_r($result);
        //$result['Program'] = new ProgramNode($result['Statements'] ?? []);
        //$result['Program'] =
    }

    function Statements__finalise(&$result)
    {
        print_r("Statements__finalise\n");
        print_r($result);
        $statements = [];
        foreach ($result as $item) {
            if (is_object($item)) {
                $statements[] = $item;
            }
        }
        $result['Statements'] = $statements;
    }

    function Statement__finalise(&$result)
    {
        print_r("Statement__finalise\n");
        print_r($result);
        return $result['Declaration'];
    }

    function ModuleDecl__finalise(&$result)
    {
        print_r("ModuleDecl__finalise\n");
        $name = new IdentifierNode($result['Identifier']);
        $result = new ModuleNode($name, $result['ModuleBody']);
    }

    function ModuleBody__finalise(&$result)
    {
        $statements = [];
        foreach ($result as $item) {
            if (isset($item['ModuleStatement']) && is_object($item['ModuleStatement'])) {
                $statements[] = $item['ModuleStatement'];
            }
        }
        return $statements;
    }

    function ClassDecl__finalise(&$result)
    {
        $name = new IdentifierNode($result['Identifier']);
        $inheritance = $result['Inheritance'] ?? null;
        return new ClassNode($name, $inheritance, $result['ClassBody']);
    }

    function Inheritance__finalise(&$result)
    {
        $type = (count($result) > 2) ? 'structure' : null;
        $parent = new IdentifierNode($result[count($result) - 1]);
        return new InheritanceNode($type, $parent);
    }

    function ClassBody__finalise(&$result)
    {
        $members = [];
        foreach ($result as $item) {
            if (isset($item['ClassMember']) && is_object($item['ClassMember'])) {
                $members[] = $item['ClassMember'];
            }
        }
        return $members;
    }

    function FieldDecl__finalise(&$result)
    {
        $name = new IdentifierNode($result['Identifier']);
        $constraint = $result['Constraint'] ?? null;
        return new FieldNode($result['TypeSpec'], $name, $constraint);
    }

    function PrimitiveType__finalise(&$result)
    {
        return new PrimitiveTypeNode($result['text']);
    }

    function UserType__finalise(&$result)
    {
        return new UserTypeNode(new IdentifierNode($result['text']));
    }

    function CollectionType__finalise(&$result)
    {
        $constraint = $result['Constraint'] ?? null;
        return new CollectionTypeNode($result['CollectionKeyword'], $result['TypeSpec'], $constraint);
    }

    function Constraint__finalise(&$result)
    {
        return new ConstraintNode($result['ConstraintExpr']);
    }

    function Range__finalise(&$result)
    {
        return new RangeNode($result['Number'][0], $result['Number'][1]);
    }

    function MethodSignature__finalise(&$result)
    {
        $name = new IdentifierNode($result['Identifier']);
        $params = $result['ParamList'] ?? [];
        return new MethodSignatureNode($result['TypeSpec'], $name, $params);
    }

    function ObjectDecl__finalise(&$result)
    {
        $name = new IdentifierNode($result['Identifier'][0]);
        $className = new IdentifierNode($result['Identifier'][1]);
        return new ObjectNode($name, $className, $result['ObjectBody']);
    }

    function ObjectBody__finalise(&$result)
    {
        $assignments = [];
        foreach ($result as $item) {
            if (isset($item['Assignment']) && is_object($item['Assignment'])) {
                $assignments[] = $item['Assignment'];
            }
        }
        return $assignments;
    }

    function Assignment__finalise(&$result)
    {
        $target = new IdentifierNode($result['Identifier']);
        return new AssignmentNode($target, $result['AssignOp'], $result['Expression']);
    }

    function MethodDecl__finalise(&$result)
    {
        $params = $result['ParamList'] ?? [];
        $returnType = $result['ReturnType'] ?? null;
        return new MethodNode($result['QualifiedName'], $params, $returnType, $result['BlockStmt']);
    }

    function ReturnType__finalise(&$result)
    {
        return $result['TypeSpec'];
    }

    function ParamList__finalise(&$result)
    {
        $params = [$result['Parameter']];
        for ($i = 1; $i < count($result); $i += 2) {
            if (isset($result[$i + 1])) {
                $params[] = $result[$i + 1];
            }
        }
        return $params;
    }

    function Parameter__finalise(&$result)
    {
        $name = new IdentifierNode($result['Identifier']);
        return new ParameterNode($result['TypeSpec'], $name);
    }

    function RuleDecl__finalise(&$result)
    {
        $name = new IdentifierNode($result['Identifier']);
        return new RuleNode($name, $result['RuleBody']);
    }

    function QueryDecl__finalise(&$result)
    {
        $name = new IdentifierNode($result['Identifier']);
        return new QueryNode($name, $result['QueryBody']);
    }

    function QueryBody__finalise(&$result)
    {
        $target = new IdentifierNode($result['Identifier']);
        return new SelectNode($target, $result['Expression']);
    }

    function IfStmt__finalise(&$result)
    {
        $elseBlock = $result['ElseClause'] ?? null;
        return new IfNode($result['Expression'], $result['BlockStmt'], $elseBlock);
    }

    function ElseClause__finalise(&$result)
    {
        return $result['BlockStmt'];
    }

    function BlockStmt__finalise(&$result)
    {
        return new BlockNode($result['StmtList']);
    }

    function StmtList__finalise(&$result)
    {
        $statements = [];
        foreach ($result as $item) {
            if (isset($item['InnerStmt']) && is_object($item['InnerStmt'])) {
                $statements[] = $item['InnerStmt'];
            }
        }
        return $statements;
    }

    function ReturnStmt__finalise(&$result)
    {
        return new ReturnNode($result['Expression']);
    }

    function ExprStmt__finalise(&$result)
    {
        return new ExpressionStatementNode($result['Expression']);
    }

    # Expressions - left-associative, simplified
    function LogicalExpr__finalise(&$result)
    {
        $left = $result['ComparisonExpr'];
        for ($i = 1; $i < count($result); $i += 2) {
            if (isset($result[$i]) && isset($result[$i + 1])) {
                $op = $result[$i];
                $right = $result[$i + 1];
                $left = new BinaryOpNode($left, $op, $right);
            }
        }
        return $left;
    }

    function ComparisonExpr__finalise(&$result)
    {
        if (count($result) > 1) {
            return new BinaryOpNode($result['AdditiveExpr'], $result[1], $result[2]);
        }
        return $result['AdditiveExpr'];
    }

    function AdditiveExpr__finalise(&$result)
    {
        $left = $result['MultiplicativeExpr'];
        for ($i = 1; $i < count($result); $i += 2) {
            if (isset($result[$i]) && isset($result[$i + 1])) {
                $op = $result[$i];
                $right = $result[$i + 1];
                $left = new BinaryOpNode($left, $op, $right);
            }
        }
        return $left;
    }

    function MultiplicativeExpr__finalise(&$result)
    {
        $left = $result['UnaryExpr'];
        for ($i = 1; $i < count($result); $i += 2) {
            if (isset($result[$i]) && isset($result[$i + 1])) {
                $op = $result[$i];
                $right = $result[$i + 1];
                $left = new BinaryOpNode($left, $op, $right);
            }
        }
        return $left;
    }

    function UnaryExpr__finalise(&$result)
    {
        if (isset($result['UnaryOp'])) {
            return new UnaryOpNode($result['UnaryOp'], $result['PrimaryExpr']);
        }
        return $result['PrimaryExpr'];
    }

    function ParenExpr__finalise(&$result)
    {
        return $result['Expression'];
    }

    function ThisKeyword__finalise(&$result)
    {
        return new ThisNode();
    }

    function MethodCall__finalise(&$result)
    {
        $args = $result['ArgList'] ?? [];
        return new MethodCallNode($result['QualifiedName'], $args);
    }

    function PropertyAccess__finalise(&$result)
    {
        return new PropertyAccessNode($result['QualifiedName']);
    }

    function QualifiedName__finalise(&$result)
    {
        $parts = [new IdentifierNode($result['Identifier'])];
        for ($i = 1; $i < count($result); $i += 2) {
            if (isset($result[$i + 1])) {
                $parts[] = new IdentifierNode($result[$i + 1]);
            }
        }
        return new QualifiedNameNode($parts);
    }

    function ArgList__finalise(&$result)
    {
        $args = [$result['Expression']];
        for ($i = 1; $i < count($result); $i += 2) {
            if (isset($result[$i + 1])) {
                $args[] = $result[$i + 1];
            }
        }
        return $args;
    }

    function SetLiteral__finalise(&$result)
    {
        $elements = $result['ElemList'] ?? [];
        return new SetLiteralNode($elements);
    }

    function ElemList__finalise(&$result)
    {
        $elements = [$result['Expression']];
        for ($i = 1; $i < count($result); $i += 2) {
            if (isset($result[$i + 1])) {
                $elements[] = $result[$i + 1];
            }
        }
        return $elements;
    }

    function String__finalise(&$result)
    {
        $value = substr($result['text'], 1, -1);
        return new StringNode($value);
    }

    function Float__finalise(&$result)
    {
        return new FloatNode((float)$result['text']);
    }

    function Number__finalise(&$result)
    {
        return new IntegerNode((int)$result['text']);
    }

    function Boolean__finalise(&$result)
    {
        return new BooleanNode($result['text'] === 'true');
    }

    function Identifier__finalise(&$result)
    {
        return $result['text'];
    }

    function ImportDecl__finalise(&$result)
    {
        $imports = $result['ImportList'] ?? null;
        return new ImportNode($result['QualifiedName'], $imports);
    }

    function ImportList__finalise(&$result)
    {
        return $result['IdentList'];
    }

    function ExportDecl__finalise(&$result)
    {
        return new ExportNode($result['IdentList']);
    }

    function IdentList__finalise(&$result)
    {
        $identifiers = [new IdentifierNode($result['Identifier'])];
        for ($i = 1; $i < count($result); $i += 2) {
            if (isset($result[$i + 1])) {
                $identifiers[] = new IdentifierNode($result[$i + 1]);
            }
        }
        return $identifiers;
    }


}