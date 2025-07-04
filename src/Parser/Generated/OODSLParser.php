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

    /* _: ( /[\s\t\n\r]* / | LineComment | BlockComment )* > */
    protected $match___typestack = array('_');
    function match__ ($stack = array()) {
    	$matchrule = "_"; $result = $this->construct($matchrule, $matchrule, null);
    	$_12 = NULL;
    	do {
    		while (true) {
    			$res_10 = $result;
    			$pos_10 = $this->pos;
    			$_9 = NULL;
    			do {
    				$_7 = NULL;
    				do {
    					$res_0 = $result;
    					$pos_0 = $this->pos;
    					if (( $subres = $this->rx( '/[\s\t\n\r]* /' ) ) !== FALSE) {
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
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_12 = TRUE; break;
    	}
    	while(0);
    	if( $_12 === TRUE ) { return $this->finalise($result); }
    	if( $_12 === FALSE) { return FALSE; }
    }


    /* LineComment: /\/\/[^\n]*  / > */
    protected $match_LineComment_typestack = array('LineComment');
    function match_LineComment ($stack = array()) {
    	$matchrule = "LineComment"; $result = $this->construct($matchrule, $matchrule, null);
    	$_16 = NULL;
    	do {
    		if (( $subres = $this->rx( '/\/\/[^\n]*  /' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_16 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_16 = TRUE; break;
    	}
    	while(0);
    	if( $_16 === TRUE ) { return $this->finalise($result); }
    	if( $_16 === FALSE) { return FALSE; }
    }


    /* BlockComment: /\/\*.*?\*\/ / > */
    protected $match_BlockComment_typestack = array('BlockComment');
    function match_BlockComment ($stack = array()) {
    	$matchrule = "BlockComment"; $result = $this->construct($matchrule, $matchrule, null);
    	$_20 = NULL;
    	do {
    		if (( $subres = $this->rx( '/\/\*.*?\*\/ /' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_20 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_20 = TRUE; break;
    	}
    	while(0);
    	if( $_20 === TRUE ) { return $this->finalise($result); }
    	if( $_20 === FALSE) { return FALSE; }
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


    /* Statements: Statement* > */
    protected $match_Statements_typestack = array('Statements');
    function match_Statements ($stack = array()) {
    	$matchrule = "Statements"; $result = $this->construct($matchrule, $matchrule, null);
    	$_25 = NULL;
    	do {
    		while (true) {
    			$res_23 = $result;
    			$pos_23 = $this->pos;
    			$matcher = 'match_'.'Statement'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_23;
    				$this->pos = $pos_23;
    				unset( $res_23 );
    				unset( $pos_23 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_25 = TRUE; break;
    	}
    	while(0);
    	if( $_25 === TRUE ) { return $this->finalise($result); }
    	if( $_25 === FALSE) { return FALSE; }
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
    	$_55 = NULL;
    	do {
    		$res_28 = $result;
    		$pos_28 = $this->pos;
    		$matcher = 'match_'.'ModuleDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_55 = TRUE; break;
    		}
    		$result = $res_28;
    		$this->pos = $pos_28;
    		$_53 = NULL;
    		do {
    			$res_30 = $result;
    			$pos_30 = $this->pos;
    			$matcher = 'match_'.'ClassDecl'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_53 = TRUE; break;
    			}
    			$result = $res_30;
    			$this->pos = $pos_30;
    			$_51 = NULL;
    			do {
    				$res_32 = $result;
    				$pos_32 = $this->pos;
    				$matcher = 'match_'.'ObjectDecl'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_51 = TRUE; break;
    				}
    				$result = $res_32;
    				$this->pos = $pos_32;
    				$_49 = NULL;
    				do {
    					$res_34 = $result;
    					$pos_34 = $this->pos;
    					$matcher = 'match_'.'MethodDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_49 = TRUE; break;
    					}
    					$result = $res_34;
    					$this->pos = $pos_34;
    					$_47 = NULL;
    					do {
    						$res_36 = $result;
    						$pos_36 = $this->pos;
    						$matcher = 'match_'.'RuleDecl'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_47 = TRUE; break;
    						}
    						$result = $res_36;
    						$this->pos = $pos_36;
    						$_45 = NULL;
    						do {
    							$res_38 = $result;
    							$pos_38 = $this->pos;
    							$matcher = 'match_'.'QueryDecl'; $key = $matcher; $pos = $this->pos;
    							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    							if ($subres !== FALSE) {
    								$this->store( $result, $subres );
    								$_45 = TRUE; break;
    							}
    							$result = $res_38;
    							$this->pos = $pos_38;
    							$_43 = NULL;
    							do {
    								$res_40 = $result;
    								$pos_40 = $this->pos;
    								$matcher = 'match_'.'ImportDecl'; $key = $matcher; $pos = $this->pos;
    								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    								if ($subres !== FALSE) {
    									$this->store( $result, $subres );
    									$_43 = TRUE; break;
    								}
    								$result = $res_40;
    								$this->pos = $pos_40;
    								$matcher = 'match_'.'ExportDecl'; $key = $matcher; $pos = $this->pos;
    								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    								if ($subres !== FALSE) {
    									$this->store( $result, $subres );
    									$_43 = TRUE; break;
    								}
    								$result = $res_40;
    								$this->pos = $pos_40;
    								$_43 = FALSE; break;
    							}
    							while(0);
    							if( $_43 === TRUE ) { $_45 = TRUE; break; }
    							$result = $res_38;
    							$this->pos = $pos_38;
    							$_45 = FALSE; break;
    						}
    						while(0);
    						if( $_45 === TRUE ) { $_47 = TRUE; break; }
    						$result = $res_36;
    						$this->pos = $pos_36;
    						$_47 = FALSE; break;
    					}
    					while(0);
    					if( $_47 === TRUE ) { $_49 = TRUE; break; }
    					$result = $res_34;
    					$this->pos = $pos_34;
    					$_49 = FALSE; break;
    				}
    				while(0);
    				if( $_49 === TRUE ) { $_51 = TRUE; break; }
    				$result = $res_32;
    				$this->pos = $pos_32;
    				$_51 = FALSE; break;
    			}
    			while(0);
    			if( $_51 === TRUE ) { $_53 = TRUE; break; }
    			$result = $res_30;
    			$this->pos = $pos_30;
    			$_53 = FALSE; break;
    		}
    		while(0);
    		if( $_53 === TRUE ) { $_55 = TRUE; break; }
    		$result = $res_28;
    		$this->pos = $pos_28;
    		$_55 = FALSE; break;
    	}
    	while(0);
    	if( $_55 === TRUE ) { return $this->finalise($result); }
    	if( $_55 === FALSE) { return FALSE; }
    }


    /* ModuleDecl: "module" _ Identifier _ "{" _ ModuleBody _ "}" > */
    protected $match_ModuleDecl_typestack = array('ModuleDecl');
    function match_ModuleDecl ($stack = array()) {
    	$matchrule = "ModuleDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_67 = NULL;
    	do {
    		if (( $subres = $this->literal( 'module' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_67 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_67 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_67 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_67 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_67 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_67 = FALSE; break; }
    		$matcher = 'match_'.'ModuleBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_67 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_67 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_67 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_67 = TRUE; break;
    	}
    	while(0);
    	if( $_67 === TRUE ) { return $this->finalise($result); }
    	if( $_67 === FALSE) { return FALSE; }
    }


    /* ModuleBody: ModuleStatement* > */
    protected $match_ModuleBody_typestack = array('ModuleBody');
    function match_ModuleBody ($stack = array()) {
    	$matchrule = "ModuleBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_71 = NULL;
    	do {
    		while (true) {
    			$res_69 = $result;
    			$pos_69 = $this->pos;
    			$matcher = 'match_'.'ModuleStatement'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_69;
    				$this->pos = $pos_69;
    				unset( $res_69 );
    				unset( $pos_69 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_71 = TRUE; break;
    	}
    	while(0);
    	if( $_71 === TRUE ) { return $this->finalise($result); }
    	if( $_71 === FALSE) { return FALSE; }
    }


    /* ModuleStatement: ClassDecl | ObjectDecl | MethodDecl | RuleDecl | ExportDecl */
    protected $match_ModuleStatement_typestack = array('ModuleStatement');
    function match_ModuleStatement ($stack = array()) {
    	$matchrule = "ModuleStatement"; $result = $this->construct($matchrule, $matchrule, null);
    	$_88 = NULL;
    	do {
    		$res_73 = $result;
    		$pos_73 = $this->pos;
    		$matcher = 'match_'.'ClassDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_88 = TRUE; break;
    		}
    		$result = $res_73;
    		$this->pos = $pos_73;
    		$_86 = NULL;
    		do {
    			$res_75 = $result;
    			$pos_75 = $this->pos;
    			$matcher = 'match_'.'ObjectDecl'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_86 = TRUE; break;
    			}
    			$result = $res_75;
    			$this->pos = $pos_75;
    			$_84 = NULL;
    			do {
    				$res_77 = $result;
    				$pos_77 = $this->pos;
    				$matcher = 'match_'.'MethodDecl'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_84 = TRUE; break;
    				}
    				$result = $res_77;
    				$this->pos = $pos_77;
    				$_82 = NULL;
    				do {
    					$res_79 = $result;
    					$pos_79 = $this->pos;
    					$matcher = 'match_'.'RuleDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_82 = TRUE; break;
    					}
    					$result = $res_79;
    					$this->pos = $pos_79;
    					$matcher = 'match_'.'ExportDecl'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_82 = TRUE; break;
    					}
    					$result = $res_79;
    					$this->pos = $pos_79;
    					$_82 = FALSE; break;
    				}
    				while(0);
    				if( $_82 === TRUE ) { $_84 = TRUE; break; }
    				$result = $res_77;
    				$this->pos = $pos_77;
    				$_84 = FALSE; break;
    			}
    			while(0);
    			if( $_84 === TRUE ) { $_86 = TRUE; break; }
    			$result = $res_75;
    			$this->pos = $pos_75;
    			$_86 = FALSE; break;
    		}
    		while(0);
    		if( $_86 === TRUE ) { $_88 = TRUE; break; }
    		$result = $res_73;
    		$this->pos = $pos_73;
    		$_88 = FALSE; break;
    	}
    	while(0);
    	if( $_88 === TRUE ) { return $this->finalise($result); }
    	if( $_88 === FALSE) { return FALSE; }
    }


    /* ClassDecl: "class" Identifier Inheritance? "{" ClassBody "}" > */
    protected $match_ClassDecl_typestack = array('ClassDecl');
    function match_ClassDecl ($stack = array()) {
    	$matchrule = "ClassDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_97 = NULL;
    	do {
    		if (( $subres = $this->literal( 'class' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_97 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_97 = FALSE; break; }
    		$res_92 = $result;
    		$pos_92 = $this->pos;
    		$matcher = 'match_'.'Inheritance'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_92;
    			$this->pos = $pos_92;
    			unset( $res_92 );
    			unset( $pos_92 );
    		}
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_97 = FALSE; break; }
    		$matcher = 'match_'.'ClassBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_97 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_97 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_97 = TRUE; break;
    	}
    	while(0);
    	if( $_97 === TRUE ) { return $this->finalise($result); }
    	if( $_97 === FALSE) { return FALSE; }
    }


    /* Inheritance: "inherits" ( "structure" )? "from" Identifier  > */
    protected $match_Inheritance_typestack = array('Inheritance');
    function match_Inheritance ($stack = array()) {
    	$matchrule = "Inheritance"; $result = $this->construct($matchrule, $matchrule, null);
    	$_106 = NULL;
    	do {
    		if (( $subres = $this->literal( 'inherits' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_106 = FALSE; break; }
    		$res_102 = $result;
    		$pos_102 = $this->pos;
    		$_101 = NULL;
    		do {
    			if (( $subres = $this->literal( 'structure' ) ) !== FALSE) { $result["text"] .= $subres; }
    			else { $_101 = FALSE; break; }
    			$_101 = TRUE; break;
    		}
    		while(0);
    		if( $_101 === FALSE) {
    			$result = $res_102;
    			$this->pos = $pos_102;
    			unset( $res_102 );
    			unset( $pos_102 );
    		}
    		if (( $subres = $this->literal( 'from' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_106 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_106 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_106 = TRUE; break;
    	}
    	while(0);
    	if( $_106 === TRUE ) { return $this->finalise($result); }
    	if( $_106 === FALSE) { return FALSE; }
    }


    /* ClassBody: ClassMember* > */
    protected $match_ClassBody_typestack = array('ClassBody');
    function match_ClassBody ($stack = array()) {
    	$matchrule = "ClassBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_110 = NULL;
    	do {
    		while (true) {
    			$res_108 = $result;
    			$pos_108 = $this->pos;
    			$matcher = 'match_'.'ClassMember'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_108;
    				$this->pos = $pos_108;
    				unset( $res_108 );
    				unset( $pos_108 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_110 = TRUE; break;
    	}
    	while(0);
    	if( $_110 === TRUE ) { return $this->finalise($result); }
    	if( $_110 === FALSE) { return FALSE; }
    }


    /* ClassMember: FieldDecl | MethodSignature */
    protected $match_ClassMember_typestack = array('ClassMember');
    function match_ClassMember ($stack = array()) {
    	$matchrule = "ClassMember"; $result = $this->construct($matchrule, $matchrule, null);
    	$_115 = NULL;
    	do {
    		$res_112 = $result;
    		$pos_112 = $this->pos;
    		$matcher = 'match_'.'FieldDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_115 = TRUE; break;
    		}
    		$result = $res_112;
    		$this->pos = $pos_112;
    		$matcher = 'match_'.'MethodSignature'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_115 = TRUE; break;
    		}
    		$result = $res_112;
    		$this->pos = $pos_112;
    		$_115 = FALSE; break;
    	}
    	while(0);
    	if( $_115 === TRUE ) { return $this->finalise($result); }
    	if( $_115 === FALSE) { return FALSE; }
    }


    /* FieldDecl: TypeSpec Identifier Constraint? ";" > */
    protected $match_FieldDecl_typestack = array('FieldDecl');
    function match_FieldDecl ($stack = array()) {
    	$matchrule = "FieldDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_122 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_122 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_122 = FALSE; break; }
    		$res_119 = $result;
    		$pos_119 = $this->pos;
    		$matcher = 'match_'.'Constraint'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_119;
    			$this->pos = $pos_119;
    			unset( $res_119 );
    			unset( $pos_119 );
    		}
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_122 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_122 = TRUE; break;
    	}
    	while(0);
    	if( $_122 === TRUE ) { return $this->finalise($result); }
    	if( $_122 === FALSE) { return FALSE; }
    }


    /* TypeSpec: CollectionType | PrimitiveType | UserType */
    protected $match_TypeSpec_typestack = array('TypeSpec');
    function match_TypeSpec ($stack = array()) {
    	$matchrule = "TypeSpec"; $result = $this->construct($matchrule, $matchrule, null);
    	$_131 = NULL;
    	do {
    		$res_124 = $result;
    		$pos_124 = $this->pos;
    		$matcher = 'match_'.'CollectionType'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_131 = TRUE; break;
    		}
    		$result = $res_124;
    		$this->pos = $pos_124;
    		$_129 = NULL;
    		do {
    			$res_126 = $result;
    			$pos_126 = $this->pos;
    			$matcher = 'match_'.'PrimitiveType'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_129 = TRUE; break;
    			}
    			$result = $res_126;
    			$this->pos = $pos_126;
    			$matcher = 'match_'.'UserType'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_129 = TRUE; break;
    			}
    			$result = $res_126;
    			$this->pos = $pos_126;
    			$_129 = FALSE; break;
    		}
    		while(0);
    		if( $_129 === TRUE ) { $_131 = TRUE; break; }
    		$result = $res_124;
    		$this->pos = $pos_124;
    		$_131 = FALSE; break;
    	}
    	while(0);
    	if( $_131 === TRUE ) { return $this->finalise($result); }
    	if( $_131 === FALSE) { return FALSE; }
    }


    /* PrimitiveType: "string" | "integer" | "boolean" | "float" */
    protected $match_PrimitiveType_typestack = array('PrimitiveType');
    function match_PrimitiveType ($stack = array()) {
    	$matchrule = "PrimitiveType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_144 = NULL;
    	do {
    		$res_133 = $result;
    		$pos_133 = $this->pos;
    		if (( $subres = $this->literal( 'string' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_144 = TRUE; break;
    		}
    		$result = $res_133;
    		$this->pos = $pos_133;
    		$_142 = NULL;
    		do {
    			$res_135 = $result;
    			$pos_135 = $this->pos;
    			if (( $subres = $this->literal( 'integer' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_142 = TRUE; break;
    			}
    			$result = $res_135;
    			$this->pos = $pos_135;
    			$_140 = NULL;
    			do {
    				$res_137 = $result;
    				$pos_137 = $this->pos;
    				if (( $subres = $this->literal( 'boolean' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_140 = TRUE; break;
    				}
    				$result = $res_137;
    				$this->pos = $pos_137;
    				if (( $subres = $this->literal( 'float' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_140 = TRUE; break;
    				}
    				$result = $res_137;
    				$this->pos = $pos_137;
    				$_140 = FALSE; break;
    			}
    			while(0);
    			if( $_140 === TRUE ) { $_142 = TRUE; break; }
    			$result = $res_135;
    			$this->pos = $pos_135;
    			$_142 = FALSE; break;
    		}
    		while(0);
    		if( $_142 === TRUE ) { $_144 = TRUE; break; }
    		$result = $res_133;
    		$this->pos = $pos_133;
    		$_144 = FALSE; break;
    	}
    	while(0);
    	if( $_144 === TRUE ) { return $this->finalise($result); }
    	if( $_144 === FALSE) { return FALSE; }
    }


    /* UserType: Identifier > */
    protected $match_UserType_typestack = array('UserType');
    function match_UserType ($stack = array()) {
    	$matchrule = "UserType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_148 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_148 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_148 = TRUE; break;
    	}
    	while(0);
    	if( $_148 === TRUE ) { return $this->finalise($result); }
    	if( $_148 === FALSE) { return FALSE; }
    }


    /* CollectionType: CollectionKeyword "<" TypeSpec ">" Constraint? > */
    protected $match_CollectionType_typestack = array('CollectionType');
    function match_CollectionType ($stack = array()) {
    	$matchrule = "CollectionType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_156 = NULL;
    	do {
    		$matcher = 'match_'.'CollectionKeyword'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_156 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '<') {
    			$this->pos += 1;
    			$result["text"] .= '<';
    		}
    		else { $_156 = FALSE; break; }
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_156 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '>') {
    			$this->pos += 1;
    			$result["text"] .= '>';
    		}
    		else { $_156 = FALSE; break; }
    		$res_154 = $result;
    		$pos_154 = $this->pos;
    		$matcher = 'match_'.'Constraint'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_154;
    			$this->pos = $pos_154;
    			unset( $res_154 );
    			unset( $pos_154 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_156 = TRUE; break;
    	}
    	while(0);
    	if( $_156 === TRUE ) { return $this->finalise($result); }
    	if( $_156 === FALSE) { return FALSE; }
    }


    /* CollectionKeyword: "set" | "list" | "bag" */
    protected $match_CollectionKeyword_typestack = array('CollectionKeyword');
    function match_CollectionKeyword ($stack = array()) {
    	$matchrule = "CollectionKeyword"; $result = $this->construct($matchrule, $matchrule, null);
    	$_165 = NULL;
    	do {
    		$res_158 = $result;
    		$pos_158 = $this->pos;
    		if (( $subres = $this->literal( 'set' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_165 = TRUE; break;
    		}
    		$result = $res_158;
    		$this->pos = $pos_158;
    		$_163 = NULL;
    		do {
    			$res_160 = $result;
    			$pos_160 = $this->pos;
    			if (( $subres = $this->literal( 'list' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_163 = TRUE; break;
    			}
    			$result = $res_160;
    			$this->pos = $pos_160;
    			if (( $subres = $this->literal( 'bag' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_163 = TRUE; break;
    			}
    			$result = $res_160;
    			$this->pos = $pos_160;
    			$_163 = FALSE; break;
    		}
    		while(0);
    		if( $_163 === TRUE ) { $_165 = TRUE; break; }
    		$result = $res_158;
    		$this->pos = $pos_158;
    		$_165 = FALSE; break;
    	}
    	while(0);
    	if( $_165 === TRUE ) { return $this->finalise($result); }
    	if( $_165 === FALSE) { return FALSE; }
    }


    /* Constraint: "{" ConstraintExpr "}" > */
    protected $match_Constraint_typestack = array('Constraint');
    function match_Constraint ($stack = array()) {
    	$matchrule = "Constraint"; $result = $this->construct($matchrule, $matchrule, null);
    	$_171 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_171 = FALSE; break; }
    		$matcher = 'match_'.'ConstraintExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_171 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_171 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_171 = TRUE; break;
    	}
    	while(0);
    	if( $_171 === TRUE ) { return $this->finalise($result); }
    	if( $_171 === FALSE) { return FALSE; }
    }


    /* ConstraintExpr: Range | Number */
    protected $match_ConstraintExpr_typestack = array('ConstraintExpr');
    function match_ConstraintExpr ($stack = array()) {
    	$matchrule = "ConstraintExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_176 = NULL;
    	do {
    		$res_173 = $result;
    		$pos_173 = $this->pos;
    		$matcher = 'match_'.'Range'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_176 = TRUE; break;
    		}
    		$result = $res_173;
    		$this->pos = $pos_173;
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_176 = TRUE; break;
    		}
    		$result = $res_173;
    		$this->pos = $pos_173;
    		$_176 = FALSE; break;
    	}
    	while(0);
    	if( $_176 === TRUE ) { return $this->finalise($result); }
    	if( $_176 === FALSE) { return FALSE; }
    }


    /* Range: Number ".." Number > */
    protected $match_Range_typestack = array('Range');
    function match_Range ($stack = array()) {
    	$matchrule = "Range"; $result = $this->construct($matchrule, $matchrule, null);
    	$_182 = NULL;
    	do {
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_182 = FALSE; break; }
    		if (( $subres = $this->literal( '..' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_182 = FALSE; break; }
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_182 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_182 = TRUE; break;
    	}
    	while(0);
    	if( $_182 === TRUE ) { return $this->finalise($result); }
    	if( $_182 === FALSE) { return FALSE; }
    }


    /* MethodSignature: TypeSpec Identifier "(" ParamList? ")" ";" > */
    protected $match_MethodSignature_typestack = array('MethodSignature');
    function match_MethodSignature ($stack = array()) {
    	$matchrule = "MethodSignature"; $result = $this->construct($matchrule, $matchrule, null);
    	$_191 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_191 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_191 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_191 = FALSE; break; }
    		$res_187 = $result;
    		$pos_187 = $this->pos;
    		$matcher = 'match_'.'ParamList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_187;
    			$this->pos = $pos_187;
    			unset( $res_187 );
    			unset( $pos_187 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_191 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_191 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_191 = TRUE; break;
    	}
    	while(0);
    	if( $_191 === TRUE ) { return $this->finalise($result); }
    	if( $_191 === FALSE) { return FALSE; }
    }


    /* ObjectDecl: "object" Identifier ":" Identifier "{" ObjectBody "}" > */
    protected $match_ObjectDecl_typestack = array('ObjectDecl');
    function match_ObjectDecl ($stack = array()) {
    	$matchrule = "ObjectDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_201 = NULL;
    	do {
    		if (( $subres = $this->literal( 'object' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_201 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_201 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ':') {
    			$this->pos += 1;
    			$result["text"] .= ':';
    		}
    		else { $_201 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_201 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_201 = FALSE; break; }
    		$matcher = 'match_'.'ObjectBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_201 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_201 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_201 = TRUE; break;
    	}
    	while(0);
    	if( $_201 === TRUE ) { return $this->finalise($result); }
    	if( $_201 === FALSE) { return FALSE; }
    }


    /* ObjectBody: Assignment* > */
    protected $match_ObjectBody_typestack = array('ObjectBody');
    function match_ObjectBody ($stack = array()) {
    	$matchrule = "ObjectBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_205 = NULL;
    	do {
    		while (true) {
    			$res_203 = $result;
    			$pos_203 = $this->pos;
    			$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_203;
    				$this->pos = $pos_203;
    				unset( $res_203 );
    				unset( $pos_203 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_205 = TRUE; break;
    	}
    	while(0);
    	if( $_205 === TRUE ) { return $this->finalise($result); }
    	if( $_205 === FALSE) { return FALSE; }
    }


    /* Assignment: Identifier AssignOp Expression ";" > */
    protected $match_Assignment_typestack = array('Assignment');
    function match_Assignment ($stack = array()) {
    	$matchrule = "Assignment"; $result = $this->construct($matchrule, $matchrule, null);
    	$_212 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_212 = FALSE; break; }
    		$matcher = 'match_'.'AssignOp'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_212 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_212 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_212 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_212 = TRUE; break;
    	}
    	while(0);
    	if( $_212 === TRUE ) { return $this->finalise($result); }
    	if( $_212 === FALSE) { return FALSE; }
    }


    /* AssignOp: "+=" | "-=" | "=" */
    protected $match_AssignOp_typestack = array('AssignOp');
    function match_AssignOp ($stack = array()) {
    	$matchrule = "AssignOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_221 = NULL;
    	do {
    		$res_214 = $result;
    		$pos_214 = $this->pos;
    		if (( $subres = $this->literal( '+=' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_221 = TRUE; break;
    		}
    		$result = $res_214;
    		$this->pos = $pos_214;
    		$_219 = NULL;
    		do {
    			$res_216 = $result;
    			$pos_216 = $this->pos;
    			if (( $subres = $this->literal( '-=' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_219 = TRUE; break;
    			}
    			$result = $res_216;
    			$this->pos = $pos_216;
    			if (substr($this->string,$this->pos,1) == '=') {
    				$this->pos += 1;
    				$result["text"] .= '=';
    				$_219 = TRUE; break;
    			}
    			$result = $res_216;
    			$this->pos = $pos_216;
    			$_219 = FALSE; break;
    		}
    		while(0);
    		if( $_219 === TRUE ) { $_221 = TRUE; break; }
    		$result = $res_214;
    		$this->pos = $pos_214;
    		$_221 = FALSE; break;
    	}
    	while(0);
    	if( $_221 === TRUE ) { return $this->finalise($result); }
    	if( $_221 === FALSE) { return FALSE; }
    }


    /* MethodDecl: "method" QualifiedName "(" ParamList? ")" ReturnType? BlockStmt > */
    protected $match_MethodDecl_typestack = array('MethodDecl');
    function match_MethodDecl ($stack = array()) {
    	$matchrule = "MethodDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_231 = NULL;
    	do {
    		if (( $subres = $this->literal( 'method' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_231 = FALSE; break; }
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_231 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_231 = FALSE; break; }
    		$res_226 = $result;
    		$pos_226 = $this->pos;
    		$matcher = 'match_'.'ParamList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_226;
    			$this->pos = $pos_226;
    			unset( $res_226 );
    			unset( $pos_226 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_231 = FALSE; break; }
    		$res_228 = $result;
    		$pos_228 = $this->pos;
    		$matcher = 'match_'.'ReturnType'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_228;
    			$this->pos = $pos_228;
    			unset( $res_228 );
    			unset( $pos_228 );
    		}
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_231 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_231 = TRUE; break;
    	}
    	while(0);
    	if( $_231 === TRUE ) { return $this->finalise($result); }
    	if( $_231 === FALSE) { return FALSE; }
    }


    /* ReturnType: "returns" TypeSpec > */
    protected $match_ReturnType_typestack = array('ReturnType');
    function match_ReturnType ($stack = array()) {
    	$matchrule = "ReturnType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_236 = NULL;
    	do {
    		if (( $subres = $this->literal( 'returns' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_236 = FALSE; break; }
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_236 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_236 = TRUE; break;
    	}
    	while(0);
    	if( $_236 === TRUE ) { return $this->finalise($result); }
    	if( $_236 === FALSE) { return FALSE; }
    }


    /* ParamList: Parameter ( "," Parameter )* > */
    protected $match_ParamList_typestack = array('ParamList');
    function match_ParamList ($stack = array()) {
    	$matchrule = "ParamList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_244 = NULL;
    	do {
    		$matcher = 'match_'.'Parameter'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_244 = FALSE; break; }
    		while (true) {
    			$res_242 = $result;
    			$pos_242 = $this->pos;
    			$_241 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_241 = FALSE; break; }
    				$matcher = 'match_'.'Parameter'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_241 = FALSE; break; }
    				$_241 = TRUE; break;
    			}
    			while(0);
    			if( $_241 === FALSE) {
    				$result = $res_242;
    				$this->pos = $pos_242;
    				unset( $res_242 );
    				unset( $pos_242 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_244 = TRUE; break;
    	}
    	while(0);
    	if( $_244 === TRUE ) { return $this->finalise($result); }
    	if( $_244 === FALSE) { return FALSE; }
    }


    /* Parameter: TypeSpec Identifier > */
    protected $match_Parameter_typestack = array('Parameter');
    function match_Parameter ($stack = array()) {
    	$matchrule = "Parameter"; $result = $this->construct($matchrule, $matchrule, null);
    	$_249 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_249 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_249 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_249 = TRUE; break;
    	}
    	while(0);
    	if( $_249 === TRUE ) { return $this->finalise($result); }
    	if( $_249 === FALSE) { return FALSE; }
    }


    /* RuleDecl: "rule" Identifier "{" RuleBody "}" > */
    protected $match_RuleDecl_typestack = array('RuleDecl');
    function match_RuleDecl ($stack = array()) {
    	$matchrule = "RuleDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_257 = NULL;
    	do {
    		if (( $subres = $this->literal( 'rule' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_257 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_257 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_257 = FALSE; break; }
    		$matcher = 'match_'.'RuleBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_257 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_257 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_257 = TRUE; break;
    	}
    	while(0);
    	if( $_257 === TRUE ) { return $this->finalise($result); }
    	if( $_257 === FALSE) { return FALSE; }
    }


    /* RuleBody: IfStmt | Assignment */
    protected $match_RuleBody_typestack = array('RuleBody');
    function match_RuleBody ($stack = array()) {
    	$matchrule = "RuleBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_262 = NULL;
    	do {
    		$res_259 = $result;
    		$pos_259 = $this->pos;
    		$matcher = 'match_'.'IfStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_262 = TRUE; break;
    		}
    		$result = $res_259;
    		$this->pos = $pos_259;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_262 = TRUE; break;
    		}
    		$result = $res_259;
    		$this->pos = $pos_259;
    		$_262 = FALSE; break;
    	}
    	while(0);
    	if( $_262 === TRUE ) { return $this->finalise($result); }
    	if( $_262 === FALSE) { return FALSE; }
    }


    /* QueryDecl: "query" Identifier "{" QueryBody "}" > */
    protected $match_QueryDecl_typestack = array('QueryDecl');
    function match_QueryDecl ($stack = array()) {
    	$matchrule = "QueryDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_270 = NULL;
    	do {
    		if (( $subres = $this->literal( 'query' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_270 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_270 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_270 = FALSE; break; }
    		$matcher = 'match_'.'QueryBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_270 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_270 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_270 = TRUE; break;
    	}
    	while(0);
    	if( $_270 === TRUE ) { return $this->finalise($result); }
    	if( $_270 === FALSE) { return FALSE; }
    }


    /* QueryBody: "select" Identifier "where" Expression ";" > */
    protected $match_QueryBody_typestack = array('QueryBody');
    function match_QueryBody ($stack = array()) {
    	$matchrule = "QueryBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_278 = NULL;
    	do {
    		if (( $subres = $this->literal( 'select' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_278 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_278 = FALSE; break; }
    		if (( $subres = $this->literal( 'where' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_278 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_278 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_278 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_278 = TRUE; break;
    	}
    	while(0);
    	if( $_278 === TRUE ) { return $this->finalise($result); }
    	if( $_278 === FALSE) { return FALSE; }
    }


    /* IfStmt: "if" "(" Expression ")" BlockStmt ElseClause? > */
    protected $match_IfStmt_typestack = array('IfStmt');
    function match_IfStmt ($stack = array()) {
    	$matchrule = "IfStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_287 = NULL;
    	do {
    		if (( $subres = $this->literal( 'if' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_287 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_287 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_287 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_287 = FALSE; break; }
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_287 = FALSE; break; }
    		$res_285 = $result;
    		$pos_285 = $this->pos;
    		$matcher = 'match_'.'ElseClause'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_285;
    			$this->pos = $pos_285;
    			unset( $res_285 );
    			unset( $pos_285 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_287 = TRUE; break;
    	}
    	while(0);
    	if( $_287 === TRUE ) { return $this->finalise($result); }
    	if( $_287 === FALSE) { return FALSE; }
    }


    /* ElseClause: "else" BlockStmt > */
    protected $match_ElseClause_typestack = array('ElseClause');
    function match_ElseClause ($stack = array()) {
    	$matchrule = "ElseClause"; $result = $this->construct($matchrule, $matchrule, null);
    	$_292 = NULL;
    	do {
    		if (( $subres = $this->literal( 'else' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_292 = FALSE; break; }
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_292 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_292 = TRUE; break;
    	}
    	while(0);
    	if( $_292 === TRUE ) { return $this->finalise($result); }
    	if( $_292 === FALSE) { return FALSE; }
    }


    /* BlockStmt: "{" StmtList "}" > */
    protected $match_BlockStmt_typestack = array('BlockStmt');
    function match_BlockStmt ($stack = array()) {
    	$matchrule = "BlockStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_298 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_298 = FALSE; break; }
    		$matcher = 'match_'.'StmtList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_298 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_298 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_298 = TRUE; break;
    	}
    	while(0);
    	if( $_298 === TRUE ) { return $this->finalise($result); }
    	if( $_298 === FALSE) { return FALSE; }
    }


    /* StmtList: InnerStmt* > */
    protected $match_StmtList_typestack = array('StmtList');
    function match_StmtList ($stack = array()) {
    	$matchrule = "StmtList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_302 = NULL;
    	do {
    		while (true) {
    			$res_300 = $result;
    			$pos_300 = $this->pos;
    			$matcher = 'match_'.'InnerStmt'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_300;
    				$this->pos = $pos_300;
    				unset( $res_300 );
    				unset( $pos_300 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_302 = TRUE; break;
    	}
    	while(0);
    	if( $_302 === TRUE ) { return $this->finalise($result); }
    	if( $_302 === FALSE) { return FALSE; }
    }


    /* InnerStmt: Assignment | IfStmt | ReturnStmt | ExprStmt > */
    protected $match_InnerStmt_typestack = array('InnerStmt');
    function match_InnerStmt ($stack = array()) {
    	$matchrule = "InnerStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_318 = NULL;
    	do {
    		$res_304 = $result;
    		$pos_304 = $this->pos;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_318 = TRUE; break;
    		}
    		$result = $res_304;
    		$this->pos = $pos_304;
    		$_316 = NULL;
    		do {
    			$res_306 = $result;
    			$pos_306 = $this->pos;
    			$matcher = 'match_'.'IfStmt'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_316 = TRUE; break;
    			}
    			$result = $res_306;
    			$this->pos = $pos_306;
    			$_314 = NULL;
    			do {
    				$res_308 = $result;
    				$pos_308 = $this->pos;
    				$matcher = 'match_'.'ReturnStmt'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_314 = TRUE; break;
    				}
    				$result = $res_308;
    				$this->pos = $pos_308;
    				$_312 = NULL;
    				do {
    					$matcher = 'match_'.'ExprStmt'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    					}
    					else { $_312 = FALSE; break; }
    					if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    					$_312 = TRUE; break;
    				}
    				while(0);
    				if( $_312 === TRUE ) { $_314 = TRUE; break; }
    				$result = $res_308;
    				$this->pos = $pos_308;
    				$_314 = FALSE; break;
    			}
    			while(0);
    			if( $_314 === TRUE ) { $_316 = TRUE; break; }
    			$result = $res_306;
    			$this->pos = $pos_306;
    			$_316 = FALSE; break;
    		}
    		while(0);
    		if( $_316 === TRUE ) { $_318 = TRUE; break; }
    		$result = $res_304;
    		$this->pos = $pos_304;
    		$_318 = FALSE; break;
    	}
    	while(0);
    	if( $_318 === TRUE ) { return $this->finalise($result); }
    	if( $_318 === FALSE) { return FALSE; }
    }


    /* ReturnStmt: "return" Expression ";" > */
    protected $match_ReturnStmt_typestack = array('ReturnStmt');
    function match_ReturnStmt ($stack = array()) {
    	$matchrule = "ReturnStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_324 = NULL;
    	do {
    		if (( $subres = $this->literal( 'return' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_324 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_324 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_324 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_324 = TRUE; break;
    	}
    	while(0);
    	if( $_324 === TRUE ) { return $this->finalise($result); }
    	if( $_324 === FALSE) { return FALSE; }
    }


    /* ExprStmt: Expression ";" > */
    protected $match_ExprStmt_typestack = array('ExprStmt');
    function match_ExprStmt ($stack = array()) {
    	$matchrule = "ExprStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_329 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_329 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_329 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_329 = TRUE; break;
    	}
    	while(0);
    	if( $_329 === TRUE ) { return $this->finalise($result); }
    	if( $_329 === FALSE) { return FALSE; }
    }


    /* Expression: LogicalExpr > */
    protected $match_Expression_typestack = array('Expression');
    function match_Expression ($stack = array()) {
    	$matchrule = "Expression"; $result = $this->construct($matchrule, $matchrule, null);
    	$_333 = NULL;
    	do {
    		$matcher = 'match_'.'LogicalExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_333 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_333 = TRUE; break;
    	}
    	while(0);
    	if( $_333 === TRUE ) { return $this->finalise($result); }
    	if( $_333 === FALSE) { return FALSE; }
    }


    /* LogicalExpr: ComparisonExpr ( LogicalOp ComparisonExpr )* > */
    protected $match_LogicalExpr_typestack = array('LogicalExpr');
    function match_LogicalExpr ($stack = array()) {
    	$matchrule = "LogicalExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_341 = NULL;
    	do {
    		$matcher = 'match_'.'ComparisonExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_341 = FALSE; break; }
    		while (true) {
    			$res_339 = $result;
    			$pos_339 = $this->pos;
    			$_338 = NULL;
    			do {
    				$matcher = 'match_'.'LogicalOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_338 = FALSE; break; }
    				$matcher = 'match_'.'ComparisonExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_338 = FALSE; break; }
    				$_338 = TRUE; break;
    			}
    			while(0);
    			if( $_338 === FALSE) {
    				$result = $res_339;
    				$this->pos = $pos_339;
    				unset( $res_339 );
    				unset( $pos_339 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_341 = TRUE; break;
    	}
    	while(0);
    	if( $_341 === TRUE ) { return $this->finalise($result); }
    	if( $_341 === FALSE) { return FALSE; }
    }


    /* LogicalOp: "&&" | "||" | "and" | "or" > */
    protected $match_LogicalOp_typestack = array('LogicalOp');
    function match_LogicalOp ($stack = array()) {
    	$matchrule = "LogicalOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_357 = NULL;
    	do {
    		$res_343 = $result;
    		$pos_343 = $this->pos;
    		if (( $subres = $this->literal( '&&' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_357 = TRUE; break;
    		}
    		$result = $res_343;
    		$this->pos = $pos_343;
    		$_355 = NULL;
    		do {
    			$res_345 = $result;
    			$pos_345 = $this->pos;
    			if (( $subres = $this->literal( '||' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_355 = TRUE; break;
    			}
    			$result = $res_345;
    			$this->pos = $pos_345;
    			$_353 = NULL;
    			do {
    				$res_347 = $result;
    				$pos_347 = $this->pos;
    				if (( $subres = $this->literal( 'and' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_353 = TRUE; break;
    				}
    				$result = $res_347;
    				$this->pos = $pos_347;
    				$_351 = NULL;
    				do {
    					if (( $subres = $this->literal( 'or' ) ) !== FALSE) { $result["text"] .= $subres; }
    					else { $_351 = FALSE; break; }
    					if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    					$_351 = TRUE; break;
    				}
    				while(0);
    				if( $_351 === TRUE ) { $_353 = TRUE; break; }
    				$result = $res_347;
    				$this->pos = $pos_347;
    				$_353 = FALSE; break;
    			}
    			while(0);
    			if( $_353 === TRUE ) { $_355 = TRUE; break; }
    			$result = $res_345;
    			$this->pos = $pos_345;
    			$_355 = FALSE; break;
    		}
    		while(0);
    		if( $_355 === TRUE ) { $_357 = TRUE; break; }
    		$result = $res_343;
    		$this->pos = $pos_343;
    		$_357 = FALSE; break;
    	}
    	while(0);
    	if( $_357 === TRUE ) { return $this->finalise($result); }
    	if( $_357 === FALSE) { return FALSE; }
    }


    /* ComparisonExpr: AdditiveExpr ( ComparisonOp AdditiveExpr )? > */
    protected $match_ComparisonExpr_typestack = array('ComparisonExpr');
    function match_ComparisonExpr ($stack = array()) {
    	$matchrule = "ComparisonExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_365 = NULL;
    	do {
    		$matcher = 'match_'.'AdditiveExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_365 = FALSE; break; }
    		$res_363 = $result;
    		$pos_363 = $this->pos;
    		$_362 = NULL;
    		do {
    			$matcher = 'match_'.'ComparisonOp'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else { $_362 = FALSE; break; }
    			$matcher = 'match_'.'AdditiveExpr'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else { $_362 = FALSE; break; }
    			$_362 = TRUE; break;
    		}
    		while(0);
    		if( $_362 === FALSE) {
    			$result = $res_363;
    			$this->pos = $pos_363;
    			unset( $res_363 );
    			unset( $pos_363 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_365 = TRUE; break;
    	}
    	while(0);
    	if( $_365 === TRUE ) { return $this->finalise($result); }
    	if( $_365 === FALSE) { return FALSE; }
    }


    /* ComparisonOp: "==" | "!=" | "<=" | ">=" | "<" | ">" > */
    protected $match_ComparisonOp_typestack = array('ComparisonOp');
    function match_ComparisonOp ($stack = array()) {
    	$matchrule = "ComparisonOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_389 = NULL;
    	do {
    		$res_367 = $result;
    		$pos_367 = $this->pos;
    		if (( $subres = $this->literal( '==' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_389 = TRUE; break;
    		}
    		$result = $res_367;
    		$this->pos = $pos_367;
    		$_387 = NULL;
    		do {
    			$res_369 = $result;
    			$pos_369 = $this->pos;
    			if (( $subres = $this->literal( '!=' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_387 = TRUE; break;
    			}
    			$result = $res_369;
    			$this->pos = $pos_369;
    			$_385 = NULL;
    			do {
    				$res_371 = $result;
    				$pos_371 = $this->pos;
    				if (( $subres = $this->literal( '<=' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_385 = TRUE; break;
    				}
    				$result = $res_371;
    				$this->pos = $pos_371;
    				$_383 = NULL;
    				do {
    					$res_373 = $result;
    					$pos_373 = $this->pos;
    					if (( $subres = $this->literal( '>=' ) ) !== FALSE) {
    						$result["text"] .= $subres;
    						$_383 = TRUE; break;
    					}
    					$result = $res_373;
    					$this->pos = $pos_373;
    					$_381 = NULL;
    					do {
    						$res_375 = $result;
    						$pos_375 = $this->pos;
    						if (substr($this->string,$this->pos,1) == '<') {
    							$this->pos += 1;
    							$result["text"] .= '<';
    							$_381 = TRUE; break;
    						}
    						$result = $res_375;
    						$this->pos = $pos_375;
    						$_379 = NULL;
    						do {
    							if (substr($this->string,$this->pos,1) == '>') {
    								$this->pos += 1;
    								$result["text"] .= '>';
    							}
    							else { $_379 = FALSE; break; }
    							if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    							$_379 = TRUE; break;
    						}
    						while(0);
    						if( $_379 === TRUE ) { $_381 = TRUE; break; }
    						$result = $res_375;
    						$this->pos = $pos_375;
    						$_381 = FALSE; break;
    					}
    					while(0);
    					if( $_381 === TRUE ) { $_383 = TRUE; break; }
    					$result = $res_373;
    					$this->pos = $pos_373;
    					$_383 = FALSE; break;
    				}
    				while(0);
    				if( $_383 === TRUE ) { $_385 = TRUE; break; }
    				$result = $res_371;
    				$this->pos = $pos_371;
    				$_385 = FALSE; break;
    			}
    			while(0);
    			if( $_385 === TRUE ) { $_387 = TRUE; break; }
    			$result = $res_369;
    			$this->pos = $pos_369;
    			$_387 = FALSE; break;
    		}
    		while(0);
    		if( $_387 === TRUE ) { $_389 = TRUE; break; }
    		$result = $res_367;
    		$this->pos = $pos_367;
    		$_389 = FALSE; break;
    	}
    	while(0);
    	if( $_389 === TRUE ) { return $this->finalise($result); }
    	if( $_389 === FALSE) { return FALSE; }
    }


    /* AdditiveExpr: MultiplicativeExpr ( AdditiveOp MultiplicativeExpr )* > */
    protected $match_AdditiveExpr_typestack = array('AdditiveExpr');
    function match_AdditiveExpr ($stack = array()) {
    	$matchrule = "AdditiveExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_397 = NULL;
    	do {
    		$matcher = 'match_'.'MultiplicativeExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_397 = FALSE; break; }
    		while (true) {
    			$res_395 = $result;
    			$pos_395 = $this->pos;
    			$_394 = NULL;
    			do {
    				$matcher = 'match_'.'AdditiveOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_394 = FALSE; break; }
    				$matcher = 'match_'.'MultiplicativeExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_394 = FALSE; break; }
    				$_394 = TRUE; break;
    			}
    			while(0);
    			if( $_394 === FALSE) {
    				$result = $res_395;
    				$this->pos = $pos_395;
    				unset( $res_395 );
    				unset( $pos_395 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_397 = TRUE; break;
    	}
    	while(0);
    	if( $_397 === TRUE ) { return $this->finalise($result); }
    	if( $_397 === FALSE) { return FALSE; }
    }


    /* AdditiveOp: "+" | "-" > */
    protected $match_AdditiveOp_typestack = array('AdditiveOp');
    function match_AdditiveOp ($stack = array()) {
    	$matchrule = "AdditiveOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_405 = NULL;
    	do {
    		$res_399 = $result;
    		$pos_399 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '+') {
    			$this->pos += 1;
    			$result["text"] .= '+';
    			$_405 = TRUE; break;
    		}
    		$result = $res_399;
    		$this->pos = $pos_399;
    		$_403 = NULL;
    		do {
    			if (substr($this->string,$this->pos,1) == '-') {
    				$this->pos += 1;
    				$result["text"] .= '-';
    			}
    			else { $_403 = FALSE; break; }
    			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    			$_403 = TRUE; break;
    		}
    		while(0);
    		if( $_403 === TRUE ) { $_405 = TRUE; break; }
    		$result = $res_399;
    		$this->pos = $pos_399;
    		$_405 = FALSE; break;
    	}
    	while(0);
    	if( $_405 === TRUE ) { return $this->finalise($result); }
    	if( $_405 === FALSE) { return FALSE; }
    }


    /* MultiplicativeExpr: UnaryExpr ( MultiplicativeOp UnaryExpr )* > */
    protected $match_MultiplicativeExpr_typestack = array('MultiplicativeExpr');
    function match_MultiplicativeExpr ($stack = array()) {
    	$matchrule = "MultiplicativeExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_413 = NULL;
    	do {
    		$matcher = 'match_'.'UnaryExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_413 = FALSE; break; }
    		while (true) {
    			$res_411 = $result;
    			$pos_411 = $this->pos;
    			$_410 = NULL;
    			do {
    				$matcher = 'match_'.'MultiplicativeOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_410 = FALSE; break; }
    				$matcher = 'match_'.'UnaryExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_410 = FALSE; break; }
    				$_410 = TRUE; break;
    			}
    			while(0);
    			if( $_410 === FALSE) {
    				$result = $res_411;
    				$this->pos = $pos_411;
    				unset( $res_411 );
    				unset( $pos_411 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_413 = TRUE; break;
    	}
    	while(0);
    	if( $_413 === TRUE ) { return $this->finalise($result); }
    	if( $_413 === FALSE) { return FALSE; }
    }


    /* MultiplicativeOp: "*" | "/" | "%" > */
    protected $match_MultiplicativeOp_typestack = array('MultiplicativeOp');
    function match_MultiplicativeOp ($stack = array()) {
    	$matchrule = "MultiplicativeOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_425 = NULL;
    	do {
    		$res_415 = $result;
    		$pos_415 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '*') {
    			$this->pos += 1;
    			$result["text"] .= '*';
    			$_425 = TRUE; break;
    		}
    		$result = $res_415;
    		$this->pos = $pos_415;
    		$_423 = NULL;
    		do {
    			$res_417 = $result;
    			$pos_417 = $this->pos;
    			if (substr($this->string,$this->pos,1) == '/') {
    				$this->pos += 1;
    				$result["text"] .= '/';
    				$_423 = TRUE; break;
    			}
    			$result = $res_417;
    			$this->pos = $pos_417;
    			$_421 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == '%') {
    					$this->pos += 1;
    					$result["text"] .= '%';
    				}
    				else { $_421 = FALSE; break; }
    				if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    				$_421 = TRUE; break;
    			}
    			while(0);
    			if( $_421 === TRUE ) { $_423 = TRUE; break; }
    			$result = $res_417;
    			$this->pos = $pos_417;
    			$_423 = FALSE; break;
    		}
    		while(0);
    		if( $_423 === TRUE ) { $_425 = TRUE; break; }
    		$result = $res_415;
    		$this->pos = $pos_415;
    		$_425 = FALSE; break;
    	}
    	while(0);
    	if( $_425 === TRUE ) { return $this->finalise($result); }
    	if( $_425 === FALSE) { return FALSE; }
    }


    /* UnaryExpr: UnaryOp? PrimaryExpr > */
    protected $match_UnaryExpr_typestack = array('UnaryExpr');
    function match_UnaryExpr ($stack = array()) {
    	$matchrule = "UnaryExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_430 = NULL;
    	do {
    		$res_427 = $result;
    		$pos_427 = $this->pos;
    		$matcher = 'match_'.'UnaryOp'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_427;
    			$this->pos = $pos_427;
    			unset( $res_427 );
    			unset( $pos_427 );
    		}
    		$matcher = 'match_'.'PrimaryExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_430 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_430 = TRUE; break;
    	}
    	while(0);
    	if( $_430 === TRUE ) { return $this->finalise($result); }
    	if( $_430 === FALSE) { return FALSE; }
    }


    /* UnaryOp: "!" | "not" | "-" */
    protected $match_UnaryOp_typestack = array('UnaryOp');
    function match_UnaryOp ($stack = array()) {
    	$matchrule = "UnaryOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_439 = NULL;
    	do {
    		$res_432 = $result;
    		$pos_432 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '!') {
    			$this->pos += 1;
    			$result["text"] .= '!';
    			$_439 = TRUE; break;
    		}
    		$result = $res_432;
    		$this->pos = $pos_432;
    		$_437 = NULL;
    		do {
    			$res_434 = $result;
    			$pos_434 = $this->pos;
    			if (( $subres = $this->literal( 'not' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_437 = TRUE; break;
    			}
    			$result = $res_434;
    			$this->pos = $pos_434;
    			if (substr($this->string,$this->pos,1) == '-') {
    				$this->pos += 1;
    				$result["text"] .= '-';
    				$_437 = TRUE; break;
    			}
    			$result = $res_434;
    			$this->pos = $pos_434;
    			$_437 = FALSE; break;
    		}
    		while(0);
    		if( $_437 === TRUE ) { $_439 = TRUE; break; }
    		$result = $res_432;
    		$this->pos = $pos_432;
    		$_439 = FALSE; break;
    	}
    	while(0);
    	if( $_439 === TRUE ) { return $this->finalise($result); }
    	if( $_439 === FALSE) { return FALSE; }
    }


    /* PrimaryExpr: Literal | MethodCall | PropertyAccess | ThisKeyword | ParenExpr | SetLiteral */
    protected $match_PrimaryExpr_typestack = array('PrimaryExpr');
    function match_PrimaryExpr ($stack = array()) {
    	$matchrule = "PrimaryExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_460 = NULL;
    	do {
    		$res_441 = $result;
    		$pos_441 = $this->pos;
    		$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_460 = TRUE; break;
    		}
    		$result = $res_441;
    		$this->pos = $pos_441;
    		$_458 = NULL;
    		do {
    			$res_443 = $result;
    			$pos_443 = $this->pos;
    			$matcher = 'match_'.'MethodCall'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_458 = TRUE; break;
    			}
    			$result = $res_443;
    			$this->pos = $pos_443;
    			$_456 = NULL;
    			do {
    				$res_445 = $result;
    				$pos_445 = $this->pos;
    				$matcher = 'match_'.'PropertyAccess'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_456 = TRUE; break;
    				}
    				$result = $res_445;
    				$this->pos = $pos_445;
    				$_454 = NULL;
    				do {
    					$res_447 = $result;
    					$pos_447 = $this->pos;
    					$matcher = 'match_'.'ThisKeyword'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_454 = TRUE; break;
    					}
    					$result = $res_447;
    					$this->pos = $pos_447;
    					$_452 = NULL;
    					do {
    						$res_449 = $result;
    						$pos_449 = $this->pos;
    						$matcher = 'match_'.'ParenExpr'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_452 = TRUE; break;
    						}
    						$result = $res_449;
    						$this->pos = $pos_449;
    						$matcher = 'match_'.'SetLiteral'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_452 = TRUE; break;
    						}
    						$result = $res_449;
    						$this->pos = $pos_449;
    						$_452 = FALSE; break;
    					}
    					while(0);
    					if( $_452 === TRUE ) { $_454 = TRUE; break; }
    					$result = $res_447;
    					$this->pos = $pos_447;
    					$_454 = FALSE; break;
    				}
    				while(0);
    				if( $_454 === TRUE ) { $_456 = TRUE; break; }
    				$result = $res_445;
    				$this->pos = $pos_445;
    				$_456 = FALSE; break;
    			}
    			while(0);
    			if( $_456 === TRUE ) { $_458 = TRUE; break; }
    			$result = $res_443;
    			$this->pos = $pos_443;
    			$_458 = FALSE; break;
    		}
    		while(0);
    		if( $_458 === TRUE ) { $_460 = TRUE; break; }
    		$result = $res_441;
    		$this->pos = $pos_441;
    		$_460 = FALSE; break;
    	}
    	while(0);
    	if( $_460 === TRUE ) { return $this->finalise($result); }
    	if( $_460 === FALSE) { return FALSE; }
    }


    /* ParenExpr: "(" Expression ")" > */
    protected $match_ParenExpr_typestack = array('ParenExpr');
    function match_ParenExpr ($stack = array()) {
    	$matchrule = "ParenExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_466 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_466 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_466 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_466 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_466 = TRUE; break;
    	}
    	while(0);
    	if( $_466 === TRUE ) { return $this->finalise($result); }
    	if( $_466 === FALSE) { return FALSE; }
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
    	$_474 = NULL;
    	do {
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_474 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_474 = FALSE; break; }
    		$res_471 = $result;
    		$pos_471 = $this->pos;
    		$matcher = 'match_'.'ArgList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_471;
    			$this->pos = $pos_471;
    			unset( $res_471 );
    			unset( $pos_471 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_474 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_474 = TRUE; break;
    	}
    	while(0);
    	if( $_474 === TRUE ) { return $this->finalise($result); }
    	if( $_474 === FALSE) { return FALSE; }
    }


    /* PropertyAccess: QualifiedName > */
    protected $match_PropertyAccess_typestack = array('PropertyAccess');
    function match_PropertyAccess ($stack = array()) {
    	$matchrule = "PropertyAccess"; $result = $this->construct($matchrule, $matchrule, null);
    	$_478 = NULL;
    	do {
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_478 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_478 = TRUE; break;
    	}
    	while(0);
    	if( $_478 === TRUE ) { return $this->finalise($result); }
    	if( $_478 === FALSE) { return FALSE; }
    }


    /* QualifiedName: Identifier ( "." Identifier )* > */
    protected $match_QualifiedName_typestack = array('QualifiedName');
    function match_QualifiedName ($stack = array()) {
    	$matchrule = "QualifiedName"; $result = $this->construct($matchrule, $matchrule, null);
    	$_486 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_486 = FALSE; break; }
    		while (true) {
    			$res_484 = $result;
    			$pos_484 = $this->pos;
    			$_483 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == '.') {
    					$this->pos += 1;
    					$result["text"] .= '.';
    				}
    				else { $_483 = FALSE; break; }
    				$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_483 = FALSE; break; }
    				$_483 = TRUE; break;
    			}
    			while(0);
    			if( $_483 === FALSE) {
    				$result = $res_484;
    				$this->pos = $pos_484;
    				unset( $res_484 );
    				unset( $pos_484 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_486 = TRUE; break;
    	}
    	while(0);
    	if( $_486 === TRUE ) { return $this->finalise($result); }
    	if( $_486 === FALSE) { return FALSE; }
    }


    /* ArgList: Expression ( "," Expression )* > */
    protected $match_ArgList_typestack = array('ArgList');
    function match_ArgList ($stack = array()) {
    	$matchrule = "ArgList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_494 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_494 = FALSE; break; }
    		while (true) {
    			$res_492 = $result;
    			$pos_492 = $this->pos;
    			$_491 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_491 = FALSE; break; }
    				$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_491 = FALSE; break; }
    				$_491 = TRUE; break;
    			}
    			while(0);
    			if( $_491 === FALSE) {
    				$result = $res_492;
    				$this->pos = $pos_492;
    				unset( $res_492 );
    				unset( $pos_492 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_494 = TRUE; break;
    	}
    	while(0);
    	if( $_494 === TRUE ) { return $this->finalise($result); }
    	if( $_494 === FALSE) { return FALSE; }
    }


    /* SetLiteral: "{" ElemList? "}" > */
    protected $match_SetLiteral_typestack = array('SetLiteral');
    function match_SetLiteral ($stack = array()) {
    	$matchrule = "SetLiteral"; $result = $this->construct($matchrule, $matchrule, null);
    	$_500 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_500 = FALSE; break; }
    		$res_497 = $result;
    		$pos_497 = $this->pos;
    		$matcher = 'match_'.'ElemList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_497;
    			$this->pos = $pos_497;
    			unset( $res_497 );
    			unset( $pos_497 );
    		}
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_500 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_500 = TRUE; break;
    	}
    	while(0);
    	if( $_500 === TRUE ) { return $this->finalise($result); }
    	if( $_500 === FALSE) { return FALSE; }
    }


    /* ElemList: Expression ( "," Expression )* > */
    protected $match_ElemList_typestack = array('ElemList');
    function match_ElemList ($stack = array()) {
    	$matchrule = "ElemList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_508 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_508 = FALSE; break; }
    		while (true) {
    			$res_506 = $result;
    			$pos_506 = $this->pos;
    			$_505 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_505 = FALSE; break; }
    				$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_505 = FALSE; break; }
    				$_505 = TRUE; break;
    			}
    			while(0);
    			if( $_505 === FALSE) {
    				$result = $res_506;
    				$this->pos = $pos_506;
    				unset( $res_506 );
    				unset( $pos_506 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_508 = TRUE; break;
    	}
    	while(0);
    	if( $_508 === TRUE ) { return $this->finalise($result); }
    	if( $_508 === FALSE) { return FALSE; }
    }


    /* Literal: String | Float | Number | Boolean | Identifier */
    protected $match_Literal_typestack = array('Literal');
    function match_Literal ($stack = array()) {
    	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
    	$_525 = NULL;
    	do {
    		$res_510 = $result;
    		$pos_510 = $this->pos;
    		$matcher = 'match_'.'String'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_525 = TRUE; break;
    		}
    		$result = $res_510;
    		$this->pos = $pos_510;
    		$_523 = NULL;
    		do {
    			$res_512 = $result;
    			$pos_512 = $this->pos;
    			$matcher = 'match_'.'Float'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_523 = TRUE; break;
    			}
    			$result = $res_512;
    			$this->pos = $pos_512;
    			$_521 = NULL;
    			do {
    				$res_514 = $result;
    				$pos_514 = $this->pos;
    				$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_521 = TRUE; break;
    				}
    				$result = $res_514;
    				$this->pos = $pos_514;
    				$_519 = NULL;
    				do {
    					$res_516 = $result;
    					$pos_516 = $this->pos;
    					$matcher = 'match_'.'Boolean'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_519 = TRUE; break;
    					}
    					$result = $res_516;
    					$this->pos = $pos_516;
    					$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_519 = TRUE; break;
    					}
    					$result = $res_516;
    					$this->pos = $pos_516;
    					$_519 = FALSE; break;
    				}
    				while(0);
    				if( $_519 === TRUE ) { $_521 = TRUE; break; }
    				$result = $res_514;
    				$this->pos = $pos_514;
    				$_521 = FALSE; break;
    			}
    			while(0);
    			if( $_521 === TRUE ) { $_523 = TRUE; break; }
    			$result = $res_512;
    			$this->pos = $pos_512;
    			$_523 = FALSE; break;
    		}
    		while(0);
    		if( $_523 === TRUE ) { $_525 = TRUE; break; }
    		$result = $res_510;
    		$this->pos = $pos_510;
    		$_525 = FALSE; break;
    	}
    	while(0);
    	if( $_525 === TRUE ) { return $this->finalise($result); }
    	if( $_525 === FALSE) { return FALSE; }
    }


    /* String: /"[^"]*"/ > */
    protected $match_String_typestack = array('String');
    function match_String ($stack = array()) {
    	$matchrule = "String"; $result = $this->construct($matchrule, $matchrule, null);
    	$_529 = NULL;
    	do {
    		if (( $subres = $this->rx( '/"[^"]*"/' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_529 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_529 = TRUE; break;
    	}
    	while(0);
    	if( $_529 === TRUE ) { return $this->finalise($result); }
    	if( $_529 === FALSE) { return FALSE; }
    }


    /* Float: /[0-9]+\.[0-9]+/ > */
    protected $match_Float_typestack = array('Float');
    function match_Float ($stack = array()) {
    	$matchrule = "Float"; $result = $this->construct($matchrule, $matchrule, null);
    	$_533 = NULL;
    	do {
    		if (( $subres = $this->rx( '/[0-9]+\.[0-9]+/' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_533 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_533 = TRUE; break;
    	}
    	while(0);
    	if( $_533 === TRUE ) { return $this->finalise($result); }
    	if( $_533 === FALSE) { return FALSE; }
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
    	$_539 = NULL;
    	do {
    		$res_536 = $result;
    		$pos_536 = $this->pos;
    		if (( $subres = $this->literal( 'true' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_539 = TRUE; break;
    		}
    		$result = $res_536;
    		$this->pos = $pos_536;
    		if (( $subres = $this->literal( 'false' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_539 = TRUE; break;
    		}
    		$result = $res_536;
    		$this->pos = $pos_536;
    		$_539 = FALSE; break;
    	}
    	while(0);
    	if( $_539 === TRUE ) { return $this->finalise($result); }
    	if( $_539 === FALSE) { return FALSE; }
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
    	$_547 = NULL;
    	do {
    		if (( $subres = $this->literal( 'import' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_547 = FALSE; break; }
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_547 = FALSE; break; }
    		$res_544 = $result;
    		$pos_544 = $this->pos;
    		$matcher = 'match_'.'ImportList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_544;
    			$this->pos = $pos_544;
    			unset( $res_544 );
    			unset( $pos_544 );
    		}
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_547 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_547 = TRUE; break;
    	}
    	while(0);
    	if( $_547 === TRUE ) { return $this->finalise($result); }
    	if( $_547 === FALSE) { return FALSE; }
    }


    /* ImportList: "." "{" IdentList "}" > */
    protected $match_ImportList_typestack = array('ImportList');
    function match_ImportList ($stack = array()) {
    	$matchrule = "ImportList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_554 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '.') {
    			$this->pos += 1;
    			$result["text"] .= '.';
    		}
    		else { $_554 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_554 = FALSE; break; }
    		$matcher = 'match_'.'IdentList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_554 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_554 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_554 = TRUE; break;
    	}
    	while(0);
    	if( $_554 === TRUE ) { return $this->finalise($result); }
    	if( $_554 === FALSE) { return FALSE; }
    }


    /* ExportDecl: "export" IdentList ";" > */
    protected $match_ExportDecl_typestack = array('ExportDecl');
    function match_ExportDecl ($stack = array()) {
    	$matchrule = "ExportDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_560 = NULL;
    	do {
    		if (( $subres = $this->literal( 'export' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_560 = FALSE; break; }
    		$matcher = 'match_'.'IdentList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_560 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_560 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_560 = TRUE; break;
    	}
    	while(0);
    	if( $_560 === TRUE ) { return $this->finalise($result); }
    	if( $_560 === FALSE) { return FALSE; }
    }


    /* IdentList: Identifier ( "," Identifier )* > */
    protected $match_IdentList_typestack = array('IdentList');
    function match_IdentList ($stack = array()) {
    	$matchrule = "IdentList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_568 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_568 = FALSE; break; }
    		while (true) {
    			$res_566 = $result;
    			$pos_566 = $this->pos;
    			$_565 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_565 = FALSE; break; }
    				$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_565 = FALSE; break; }
    				$_565 = TRUE; break;
    			}
    			while(0);
    			if( $_565 === FALSE) {
    				$result = $res_566;
    				$this->pos = $pos_566;
    				unset( $res_566 );
    				unset( $pos_566 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_568 = TRUE; break;
    	}
    	while(0);
    	if( $_568 === TRUE ) { return $this->finalise($result); }
    	if( $_568 === FALSE) { return FALSE; }
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