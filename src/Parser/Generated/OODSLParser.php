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


    /* ClassDecl: "class" > id:Identifier > inh:Inheritance? > "{" > ClassBody > "}" > */
    protected $match_ClassDecl_typestack = array('ClassDecl');
    function match_ClassDecl ($stack = array()) {
    	$matchrule = "ClassDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_92 = NULL;
    	do {
    		if (( $subres = $this->literal( 'class' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_92 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "id" );
    		}
    		else { $_92 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$res_84 = $result;
    		$pos_84 = $this->pos;
    		$matcher = 'match_'.'Inheritance'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "inh" );
    		}
    		else {
    			$result = $res_84;
    			$this->pos = $pos_84;
    			unset( $res_84 );
    			unset( $pos_84 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_92 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$matcher = 'match_'.'ClassBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_92 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_92 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_92 = TRUE; break;
    	}
    	while(0);
    	if( $_92 === TRUE ) { return $this->finalise($result); }
    	if( $_92 === FALSE) { return FALSE; }
    }

public function ClassDecl_id (&$result, $sub ) {
        print_r($sub);
        print_r($result);
        print_r("----\n");
    }

public function ClassDecl_inh (&$result, $sub ) {
        print_r($sub);
        print_r($result);
        print_r("----\n");
    }

    /* Inheritance: "inherits" > ( "structure" )? > "from" > inheritance:Identifier  > */
    protected $match_Inheritance_typestack = array('Inheritance');
    function match_Inheritance ($stack = array()) {
    	$matchrule = "Inheritance"; $result = $this->construct($matchrule, $matchrule, null);
    	$_104 = NULL;
    	do {
    		if (( $subres = $this->literal( 'inherits' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_104 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$res_98 = $result;
    		$pos_98 = $this->pos;
    		$_97 = NULL;
    		do {
    			if (( $subres = $this->literal( 'structure' ) ) !== FALSE) { $result["text"] .= $subres; }
    			else { $_97 = FALSE; break; }
    			$_97 = TRUE; break;
    		}
    		while(0);
    		if( $_97 === FALSE) {
    			$result = $res_98;
    			$this->pos = $pos_98;
    			unset( $res_98 );
    			unset( $pos_98 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		if (( $subres = $this->literal( 'from' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_104 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "inheritance" );
    		}
    		else { $_104 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_104 = TRUE; break;
    	}
    	while(0);
    	if( $_104 === TRUE ) { return $this->finalise($result); }
    	if( $_104 === FALSE) { return FALSE; }
    }


    /* ClassBody: ClassMember* */
    protected $match_ClassBody_typestack = array('ClassBody');
    function match_ClassBody ($stack = array()) {
    	$matchrule = "ClassBody"; $result = $this->construct($matchrule, $matchrule, null);
    	while (true) {
    		$res_106 = $result;
    		$pos_106 = $this->pos;
    		$matcher = 'match_'.'ClassMember'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_106;
    			$this->pos = $pos_106;
    			unset( $res_106 );
    			unset( $pos_106 );
    			break;
    		}
    	}
    	return $this->finalise($result);
    }


    /* ClassMember: FieldDecl | MethodSignature */
    protected $match_ClassMember_typestack = array('ClassMember');
    function match_ClassMember ($stack = array()) {
    	$matchrule = "ClassMember"; $result = $this->construct($matchrule, $matchrule, null);
    	$_110 = NULL;
    	do {
    		$res_107 = $result;
    		$pos_107 = $this->pos;
    		$matcher = 'match_'.'FieldDecl'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_110 = TRUE; break;
    		}
    		$result = $res_107;
    		$this->pos = $pos_107;
    		$matcher = 'match_'.'MethodSignature'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_110 = TRUE; break;
    		}
    		$result = $res_107;
    		$this->pos = $pos_107;
    		$_110 = FALSE; break;
    	}
    	while(0);
    	if( $_110 === TRUE ) { return $this->finalise($result); }
    	if( $_110 === FALSE) { return FALSE; }
    }


    /* FieldDecl: TypeSpec > Identifier > Constraint? ";" > */
    protected $match_FieldDecl_typestack = array('FieldDecl');
    function match_FieldDecl ($stack = array()) {
    	$matchrule = "FieldDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_119 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_119 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_119 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$res_116 = $result;
    		$pos_116 = $this->pos;
    		$matcher = 'match_'.'Constraint'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_116;
    			$this->pos = $pos_116;
    			unset( $res_116 );
    			unset( $pos_116 );
    		}
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_119 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_119 = TRUE; break;
    	}
    	while(0);
    	if( $_119 === TRUE ) { return $this->finalise($result); }
    	if( $_119 === FALSE) { return FALSE; }
    }


    /* TypeSpec: CollectionType | PrimitiveType | UserType */
    protected $match_TypeSpec_typestack = array('TypeSpec');
    function match_TypeSpec ($stack = array()) {
    	$matchrule = "TypeSpec"; $result = $this->construct($matchrule, $matchrule, null);
    	$_128 = NULL;
    	do {
    		$res_121 = $result;
    		$pos_121 = $this->pos;
    		$matcher = 'match_'.'CollectionType'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_128 = TRUE; break;
    		}
    		$result = $res_121;
    		$this->pos = $pos_121;
    		$_126 = NULL;
    		do {
    			$res_123 = $result;
    			$pos_123 = $this->pos;
    			$matcher = 'match_'.'PrimitiveType'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_126 = TRUE; break;
    			}
    			$result = $res_123;
    			$this->pos = $pos_123;
    			$matcher = 'match_'.'UserType'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_126 = TRUE; break;
    			}
    			$result = $res_123;
    			$this->pos = $pos_123;
    			$_126 = FALSE; break;
    		}
    		while(0);
    		if( $_126 === TRUE ) { $_128 = TRUE; break; }
    		$result = $res_121;
    		$this->pos = $pos_121;
    		$_128 = FALSE; break;
    	}
    	while(0);
    	if( $_128 === TRUE ) { return $this->finalise($result); }
    	if( $_128 === FALSE) { return FALSE; }
    }


    /* PrimitiveType: "string" | "integer" | "boolean" | "float" */
    protected $match_PrimitiveType_typestack = array('PrimitiveType');
    function match_PrimitiveType ($stack = array()) {
    	$matchrule = "PrimitiveType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_141 = NULL;
    	do {
    		$res_130 = $result;
    		$pos_130 = $this->pos;
    		if (( $subres = $this->literal( 'string' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_141 = TRUE; break;
    		}
    		$result = $res_130;
    		$this->pos = $pos_130;
    		$_139 = NULL;
    		do {
    			$res_132 = $result;
    			$pos_132 = $this->pos;
    			if (( $subres = $this->literal( 'integer' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_139 = TRUE; break;
    			}
    			$result = $res_132;
    			$this->pos = $pos_132;
    			$_137 = NULL;
    			do {
    				$res_134 = $result;
    				$pos_134 = $this->pos;
    				if (( $subres = $this->literal( 'boolean' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_137 = TRUE; break;
    				}
    				$result = $res_134;
    				$this->pos = $pos_134;
    				if (( $subres = $this->literal( 'float' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_137 = TRUE; break;
    				}
    				$result = $res_134;
    				$this->pos = $pos_134;
    				$_137 = FALSE; break;
    			}
    			while(0);
    			if( $_137 === TRUE ) { $_139 = TRUE; break; }
    			$result = $res_132;
    			$this->pos = $pos_132;
    			$_139 = FALSE; break;
    		}
    		while(0);
    		if( $_139 === TRUE ) { $_141 = TRUE; break; }
    		$result = $res_130;
    		$this->pos = $pos_130;
    		$_141 = FALSE; break;
    	}
    	while(0);
    	if( $_141 === TRUE ) { return $this->finalise($result); }
    	if( $_141 === FALSE) { return FALSE; }
    }


    /* UserType: Identifier > */
    protected $match_UserType_typestack = array('UserType');
    function match_UserType ($stack = array()) {
    	$matchrule = "UserType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_145 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_145 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_145 = TRUE; break;
    	}
    	while(0);
    	if( $_145 === TRUE ) { return $this->finalise($result); }
    	if( $_145 === FALSE) { return FALSE; }
    }


    /* CollectionType: CollectionKeyword "<" TypeSpec ">" Constraint? > */
    protected $match_CollectionType_typestack = array('CollectionType');
    function match_CollectionType ($stack = array()) {
    	$matchrule = "CollectionType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_153 = NULL;
    	do {
    		$matcher = 'match_'.'CollectionKeyword'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_153 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '<') {
    			$this->pos += 1;
    			$result["text"] .= '<';
    		}
    		else { $_153 = FALSE; break; }
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_153 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '>') {
    			$this->pos += 1;
    			$result["text"] .= '>';
    		}
    		else { $_153 = FALSE; break; }
    		$res_151 = $result;
    		$pos_151 = $this->pos;
    		$matcher = 'match_'.'Constraint'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_151;
    			$this->pos = $pos_151;
    			unset( $res_151 );
    			unset( $pos_151 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_153 = TRUE; break;
    	}
    	while(0);
    	if( $_153 === TRUE ) { return $this->finalise($result); }
    	if( $_153 === FALSE) { return FALSE; }
    }


    /* CollectionKeyword: "set" | "list" | "bag" */
    protected $match_CollectionKeyword_typestack = array('CollectionKeyword');
    function match_CollectionKeyword ($stack = array()) {
    	$matchrule = "CollectionKeyword"; $result = $this->construct($matchrule, $matchrule, null);
    	$_162 = NULL;
    	do {
    		$res_155 = $result;
    		$pos_155 = $this->pos;
    		if (( $subres = $this->literal( 'set' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_162 = TRUE; break;
    		}
    		$result = $res_155;
    		$this->pos = $pos_155;
    		$_160 = NULL;
    		do {
    			$res_157 = $result;
    			$pos_157 = $this->pos;
    			if (( $subres = $this->literal( 'list' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_160 = TRUE; break;
    			}
    			$result = $res_157;
    			$this->pos = $pos_157;
    			if (( $subres = $this->literal( 'bag' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_160 = TRUE; break;
    			}
    			$result = $res_157;
    			$this->pos = $pos_157;
    			$_160 = FALSE; break;
    		}
    		while(0);
    		if( $_160 === TRUE ) { $_162 = TRUE; break; }
    		$result = $res_155;
    		$this->pos = $pos_155;
    		$_162 = FALSE; break;
    	}
    	while(0);
    	if( $_162 === TRUE ) { return $this->finalise($result); }
    	if( $_162 === FALSE) { return FALSE; }
    }


    /* Constraint: "{" ConstraintExpr "}" > */
    protected $match_Constraint_typestack = array('Constraint');
    function match_Constraint ($stack = array()) {
    	$matchrule = "Constraint"; $result = $this->construct($matchrule, $matchrule, null);
    	$_168 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_168 = FALSE; break; }
    		$matcher = 'match_'.'ConstraintExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_168 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_168 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_168 = TRUE; break;
    	}
    	while(0);
    	if( $_168 === TRUE ) { return $this->finalise($result); }
    	if( $_168 === FALSE) { return FALSE; }
    }


    /* ConstraintExpr: Range | Number */
    protected $match_ConstraintExpr_typestack = array('ConstraintExpr');
    function match_ConstraintExpr ($stack = array()) {
    	$matchrule = "ConstraintExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_173 = NULL;
    	do {
    		$res_170 = $result;
    		$pos_170 = $this->pos;
    		$matcher = 'match_'.'Range'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_173 = TRUE; break;
    		}
    		$result = $res_170;
    		$this->pos = $pos_170;
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_173 = TRUE; break;
    		}
    		$result = $res_170;
    		$this->pos = $pos_170;
    		$_173 = FALSE; break;
    	}
    	while(0);
    	if( $_173 === TRUE ) { return $this->finalise($result); }
    	if( $_173 === FALSE) { return FALSE; }
    }


    /* Range: Number ".." Number > */
    protected $match_Range_typestack = array('Range');
    function match_Range ($stack = array()) {
    	$matchrule = "Range"; $result = $this->construct($matchrule, $matchrule, null);
    	$_179 = NULL;
    	do {
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_179 = FALSE; break; }
    		if (( $subres = $this->literal( '..' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_179 = FALSE; break; }
    		$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_179 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_179 = TRUE; break;
    	}
    	while(0);
    	if( $_179 === TRUE ) { return $this->finalise($result); }
    	if( $_179 === FALSE) { return FALSE; }
    }


    /* MethodSignature: TypeSpec Identifier "(" ParamList? ")" ";" > */
    protected $match_MethodSignature_typestack = array('MethodSignature');
    function match_MethodSignature ($stack = array()) {
    	$matchrule = "MethodSignature"; $result = $this->construct($matchrule, $matchrule, null);
    	$_188 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_188 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_188 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_188 = FALSE; break; }
    		$res_184 = $result;
    		$pos_184 = $this->pos;
    		$matcher = 'match_'.'ParamList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_184;
    			$this->pos = $pos_184;
    			unset( $res_184 );
    			unset( $pos_184 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_188 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_188 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_188 = TRUE; break;
    	}
    	while(0);
    	if( $_188 === TRUE ) { return $this->finalise($result); }
    	if( $_188 === FALSE) { return FALSE; }
    }


    /* ObjectDecl: "object" Identifier ":" Identifier "{" ObjectBody "}" > */
    protected $match_ObjectDecl_typestack = array('ObjectDecl');
    function match_ObjectDecl ($stack = array()) {
    	$matchrule = "ObjectDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_198 = NULL;
    	do {
    		if (( $subres = $this->literal( 'object' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_198 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_198 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ':') {
    			$this->pos += 1;
    			$result["text"] .= ':';
    		}
    		else { $_198 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_198 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_198 = FALSE; break; }
    		$matcher = 'match_'.'ObjectBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_198 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_198 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_198 = TRUE; break;
    	}
    	while(0);
    	if( $_198 === TRUE ) { return $this->finalise($result); }
    	if( $_198 === FALSE) { return FALSE; }
    }


    /* ObjectBody: Assignment* > */
    protected $match_ObjectBody_typestack = array('ObjectBody');
    function match_ObjectBody ($stack = array()) {
    	$matchrule = "ObjectBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_202 = NULL;
    	do {
    		while (true) {
    			$res_200 = $result;
    			$pos_200 = $this->pos;
    			$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_200;
    				$this->pos = $pos_200;
    				unset( $res_200 );
    				unset( $pos_200 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_202 = TRUE; break;
    	}
    	while(0);
    	if( $_202 === TRUE ) { return $this->finalise($result); }
    	if( $_202 === FALSE) { return FALSE; }
    }


    /* Assignment: Identifier AssignOp Expression ";" > */
    protected $match_Assignment_typestack = array('Assignment');
    function match_Assignment ($stack = array()) {
    	$matchrule = "Assignment"; $result = $this->construct($matchrule, $matchrule, null);
    	$_209 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_209 = FALSE; break; }
    		$matcher = 'match_'.'AssignOp'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_209 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_209 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_209 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_209 = TRUE; break;
    	}
    	while(0);
    	if( $_209 === TRUE ) { return $this->finalise($result); }
    	if( $_209 === FALSE) { return FALSE; }
    }


    /* AssignOp: "+=" | "-=" | "=" */
    protected $match_AssignOp_typestack = array('AssignOp');
    function match_AssignOp ($stack = array()) {
    	$matchrule = "AssignOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_218 = NULL;
    	do {
    		$res_211 = $result;
    		$pos_211 = $this->pos;
    		if (( $subres = $this->literal( '+=' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_218 = TRUE; break;
    		}
    		$result = $res_211;
    		$this->pos = $pos_211;
    		$_216 = NULL;
    		do {
    			$res_213 = $result;
    			$pos_213 = $this->pos;
    			if (( $subres = $this->literal( '-=' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_216 = TRUE; break;
    			}
    			$result = $res_213;
    			$this->pos = $pos_213;
    			if (substr($this->string,$this->pos,1) == '=') {
    				$this->pos += 1;
    				$result["text"] .= '=';
    				$_216 = TRUE; break;
    			}
    			$result = $res_213;
    			$this->pos = $pos_213;
    			$_216 = FALSE; break;
    		}
    		while(0);
    		if( $_216 === TRUE ) { $_218 = TRUE; break; }
    		$result = $res_211;
    		$this->pos = $pos_211;
    		$_218 = FALSE; break;
    	}
    	while(0);
    	if( $_218 === TRUE ) { return $this->finalise($result); }
    	if( $_218 === FALSE) { return FALSE; }
    }


    /* MethodDecl: "method" QualifiedName "(" ParamList? ")" ReturnType? BlockStmt > */
    protected $match_MethodDecl_typestack = array('MethodDecl');
    function match_MethodDecl ($stack = array()) {
    	$matchrule = "MethodDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_228 = NULL;
    	do {
    		if (( $subres = $this->literal( 'method' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_228 = FALSE; break; }
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_228 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_228 = FALSE; break; }
    		$res_223 = $result;
    		$pos_223 = $this->pos;
    		$matcher = 'match_'.'ParamList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_223;
    			$this->pos = $pos_223;
    			unset( $res_223 );
    			unset( $pos_223 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_228 = FALSE; break; }
    		$res_225 = $result;
    		$pos_225 = $this->pos;
    		$matcher = 'match_'.'ReturnType'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_225;
    			$this->pos = $pos_225;
    			unset( $res_225 );
    			unset( $pos_225 );
    		}
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_228 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_228 = TRUE; break;
    	}
    	while(0);
    	if( $_228 === TRUE ) { return $this->finalise($result); }
    	if( $_228 === FALSE) { return FALSE; }
    }


    /* ReturnType: "returns" TypeSpec > */
    protected $match_ReturnType_typestack = array('ReturnType');
    function match_ReturnType ($stack = array()) {
    	$matchrule = "ReturnType"; $result = $this->construct($matchrule, $matchrule, null);
    	$_233 = NULL;
    	do {
    		if (( $subres = $this->literal( 'returns' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_233 = FALSE; break; }
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_233 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_233 = TRUE; break;
    	}
    	while(0);
    	if( $_233 === TRUE ) { return $this->finalise($result); }
    	if( $_233 === FALSE) { return FALSE; }
    }


    /* ParamList: Parameter ( "," Parameter )* > */
    protected $match_ParamList_typestack = array('ParamList');
    function match_ParamList ($stack = array()) {
    	$matchrule = "ParamList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_241 = NULL;
    	do {
    		$matcher = 'match_'.'Parameter'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_241 = FALSE; break; }
    		while (true) {
    			$res_239 = $result;
    			$pos_239 = $this->pos;
    			$_238 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_238 = FALSE; break; }
    				$matcher = 'match_'.'Parameter'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_238 = FALSE; break; }
    				$_238 = TRUE; break;
    			}
    			while(0);
    			if( $_238 === FALSE) {
    				$result = $res_239;
    				$this->pos = $pos_239;
    				unset( $res_239 );
    				unset( $pos_239 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_241 = TRUE; break;
    	}
    	while(0);
    	if( $_241 === TRUE ) { return $this->finalise($result); }
    	if( $_241 === FALSE) { return FALSE; }
    }


    /* Parameter: TypeSpec Identifier > */
    protected $match_Parameter_typestack = array('Parameter');
    function match_Parameter ($stack = array()) {
    	$matchrule = "Parameter"; $result = $this->construct($matchrule, $matchrule, null);
    	$_246 = NULL;
    	do {
    		$matcher = 'match_'.'TypeSpec'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_246 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_246 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_246 = TRUE; break;
    	}
    	while(0);
    	if( $_246 === TRUE ) { return $this->finalise($result); }
    	if( $_246 === FALSE) { return FALSE; }
    }


    /* RuleDecl: "rule" Identifier "{" RuleBody "}" > */
    protected $match_RuleDecl_typestack = array('RuleDecl');
    function match_RuleDecl ($stack = array()) {
    	$matchrule = "RuleDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_254 = NULL;
    	do {
    		if (( $subres = $this->literal( 'rule' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_254 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_254 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_254 = FALSE; break; }
    		$matcher = 'match_'.'RuleBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_254 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_254 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_254 = TRUE; break;
    	}
    	while(0);
    	if( $_254 === TRUE ) { return $this->finalise($result); }
    	if( $_254 === FALSE) { return FALSE; }
    }


    /* RuleBody: IfStmt | Assignment */
    protected $match_RuleBody_typestack = array('RuleBody');
    function match_RuleBody ($stack = array()) {
    	$matchrule = "RuleBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_259 = NULL;
    	do {
    		$res_256 = $result;
    		$pos_256 = $this->pos;
    		$matcher = 'match_'.'IfStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_259 = TRUE; break;
    		}
    		$result = $res_256;
    		$this->pos = $pos_256;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_259 = TRUE; break;
    		}
    		$result = $res_256;
    		$this->pos = $pos_256;
    		$_259 = FALSE; break;
    	}
    	while(0);
    	if( $_259 === TRUE ) { return $this->finalise($result); }
    	if( $_259 === FALSE) { return FALSE; }
    }


    /* QueryDecl: "query" Identifier "{" QueryBody "}" > */
    protected $match_QueryDecl_typestack = array('QueryDecl');
    function match_QueryDecl ($stack = array()) {
    	$matchrule = "QueryDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_267 = NULL;
    	do {
    		if (( $subres = $this->literal( 'query' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_267 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_267 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_267 = FALSE; break; }
    		$matcher = 'match_'.'QueryBody'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_267 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_267 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_267 = TRUE; break;
    	}
    	while(0);
    	if( $_267 === TRUE ) { return $this->finalise($result); }
    	if( $_267 === FALSE) { return FALSE; }
    }


    /* QueryBody: "select" Identifier "where" Expression ";" > */
    protected $match_QueryBody_typestack = array('QueryBody');
    function match_QueryBody ($stack = array()) {
    	$matchrule = "QueryBody"; $result = $this->construct($matchrule, $matchrule, null);
    	$_275 = NULL;
    	do {
    		if (( $subres = $this->literal( 'select' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_275 = FALSE; break; }
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_275 = FALSE; break; }
    		if (( $subres = $this->literal( 'where' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_275 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_275 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_275 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_275 = TRUE; break;
    	}
    	while(0);
    	if( $_275 === TRUE ) { return $this->finalise($result); }
    	if( $_275 === FALSE) { return FALSE; }
    }


    /* IfStmt: "if" "(" Expression ")" BlockStmt ElseClause? > */
    protected $match_IfStmt_typestack = array('IfStmt');
    function match_IfStmt ($stack = array()) {
    	$matchrule = "IfStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_284 = NULL;
    	do {
    		if (( $subres = $this->literal( 'if' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_284 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_284 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_284 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_284 = FALSE; break; }
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_284 = FALSE; break; }
    		$res_282 = $result;
    		$pos_282 = $this->pos;
    		$matcher = 'match_'.'ElseClause'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_282;
    			$this->pos = $pos_282;
    			unset( $res_282 );
    			unset( $pos_282 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_284 = TRUE; break;
    	}
    	while(0);
    	if( $_284 === TRUE ) { return $this->finalise($result); }
    	if( $_284 === FALSE) { return FALSE; }
    }


    /* ElseClause: "else" BlockStmt > */
    protected $match_ElseClause_typestack = array('ElseClause');
    function match_ElseClause ($stack = array()) {
    	$matchrule = "ElseClause"; $result = $this->construct($matchrule, $matchrule, null);
    	$_289 = NULL;
    	do {
    		if (( $subres = $this->literal( 'else' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_289 = FALSE; break; }
    		$matcher = 'match_'.'BlockStmt'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_289 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_289 = TRUE; break;
    	}
    	while(0);
    	if( $_289 === TRUE ) { return $this->finalise($result); }
    	if( $_289 === FALSE) { return FALSE; }
    }


    /* BlockStmt: "{" StmtList "}" > */
    protected $match_BlockStmt_typestack = array('BlockStmt');
    function match_BlockStmt ($stack = array()) {
    	$matchrule = "BlockStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_295 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_295 = FALSE; break; }
    		$matcher = 'match_'.'StmtList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_295 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_295 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_295 = TRUE; break;
    	}
    	while(0);
    	if( $_295 === TRUE ) { return $this->finalise($result); }
    	if( $_295 === FALSE) { return FALSE; }
    }


    /* StmtList: InnerStmt* > */
    protected $match_StmtList_typestack = array('StmtList');
    function match_StmtList ($stack = array()) {
    	$matchrule = "StmtList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_299 = NULL;
    	do {
    		while (true) {
    			$res_297 = $result;
    			$pos_297 = $this->pos;
    			$matcher = 'match_'.'InnerStmt'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else {
    				$result = $res_297;
    				$this->pos = $pos_297;
    				unset( $res_297 );
    				unset( $pos_297 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_299 = TRUE; break;
    	}
    	while(0);
    	if( $_299 === TRUE ) { return $this->finalise($result); }
    	if( $_299 === FALSE) { return FALSE; }
    }


    /* InnerStmt: Assignment | IfStmt | ReturnStmt | ExprStmt > */
    protected $match_InnerStmt_typestack = array('InnerStmt');
    function match_InnerStmt ($stack = array()) {
    	$matchrule = "InnerStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_315 = NULL;
    	do {
    		$res_301 = $result;
    		$pos_301 = $this->pos;
    		$matcher = 'match_'.'Assignment'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_315 = TRUE; break;
    		}
    		$result = $res_301;
    		$this->pos = $pos_301;
    		$_313 = NULL;
    		do {
    			$res_303 = $result;
    			$pos_303 = $this->pos;
    			$matcher = 'match_'.'IfStmt'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_313 = TRUE; break;
    			}
    			$result = $res_303;
    			$this->pos = $pos_303;
    			$_311 = NULL;
    			do {
    				$res_305 = $result;
    				$pos_305 = $this->pos;
    				$matcher = 'match_'.'ReturnStmt'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_311 = TRUE; break;
    				}
    				$result = $res_305;
    				$this->pos = $pos_305;
    				$_309 = NULL;
    				do {
    					$matcher = 'match_'.'ExprStmt'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    					}
    					else { $_309 = FALSE; break; }
    					if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    					$_309 = TRUE; break;
    				}
    				while(0);
    				if( $_309 === TRUE ) { $_311 = TRUE; break; }
    				$result = $res_305;
    				$this->pos = $pos_305;
    				$_311 = FALSE; break;
    			}
    			while(0);
    			if( $_311 === TRUE ) { $_313 = TRUE; break; }
    			$result = $res_303;
    			$this->pos = $pos_303;
    			$_313 = FALSE; break;
    		}
    		while(0);
    		if( $_313 === TRUE ) { $_315 = TRUE; break; }
    		$result = $res_301;
    		$this->pos = $pos_301;
    		$_315 = FALSE; break;
    	}
    	while(0);
    	if( $_315 === TRUE ) { return $this->finalise($result); }
    	if( $_315 === FALSE) { return FALSE; }
    }


    /* ReturnStmt: "return" Expression ";" > */
    protected $match_ReturnStmt_typestack = array('ReturnStmt');
    function match_ReturnStmt ($stack = array()) {
    	$matchrule = "ReturnStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_321 = NULL;
    	do {
    		if (( $subres = $this->literal( 'return' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_321 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_321 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_321 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_321 = TRUE; break;
    	}
    	while(0);
    	if( $_321 === TRUE ) { return $this->finalise($result); }
    	if( $_321 === FALSE) { return FALSE; }
    }


    /* ExprStmt: Expression ";" > */
    protected $match_ExprStmt_typestack = array('ExprStmt');
    function match_ExprStmt ($stack = array()) {
    	$matchrule = "ExprStmt"; $result = $this->construct($matchrule, $matchrule, null);
    	$_326 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_326 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_326 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_326 = TRUE; break;
    	}
    	while(0);
    	if( $_326 === TRUE ) { return $this->finalise($result); }
    	if( $_326 === FALSE) { return FALSE; }
    }


    /* Expression: LogicalExpr > */
    protected $match_Expression_typestack = array('Expression');
    function match_Expression ($stack = array()) {
    	$matchrule = "Expression"; $result = $this->construct($matchrule, $matchrule, null);
    	$_330 = NULL;
    	do {
    		$matcher = 'match_'.'LogicalExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_330 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_330 = TRUE; break;
    	}
    	while(0);
    	if( $_330 === TRUE ) { return $this->finalise($result); }
    	if( $_330 === FALSE) { return FALSE; }
    }


    /* LogicalExpr: ComparisonExpr ( LogicalOp ComparisonExpr )* > */
    protected $match_LogicalExpr_typestack = array('LogicalExpr');
    function match_LogicalExpr ($stack = array()) {
    	$matchrule = "LogicalExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_338 = NULL;
    	do {
    		$matcher = 'match_'.'ComparisonExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_338 = FALSE; break; }
    		while (true) {
    			$res_336 = $result;
    			$pos_336 = $this->pos;
    			$_335 = NULL;
    			do {
    				$matcher = 'match_'.'LogicalOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_335 = FALSE; break; }
    				$matcher = 'match_'.'ComparisonExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_335 = FALSE; break; }
    				$_335 = TRUE; break;
    			}
    			while(0);
    			if( $_335 === FALSE) {
    				$result = $res_336;
    				$this->pos = $pos_336;
    				unset( $res_336 );
    				unset( $pos_336 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_338 = TRUE; break;
    	}
    	while(0);
    	if( $_338 === TRUE ) { return $this->finalise($result); }
    	if( $_338 === FALSE) { return FALSE; }
    }


    /* LogicalOp: "&&" | "||" | "and" | "or" > */
    protected $match_LogicalOp_typestack = array('LogicalOp');
    function match_LogicalOp ($stack = array()) {
    	$matchrule = "LogicalOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_354 = NULL;
    	do {
    		$res_340 = $result;
    		$pos_340 = $this->pos;
    		if (( $subres = $this->literal( '&&' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_354 = TRUE; break;
    		}
    		$result = $res_340;
    		$this->pos = $pos_340;
    		$_352 = NULL;
    		do {
    			$res_342 = $result;
    			$pos_342 = $this->pos;
    			if (( $subres = $this->literal( '||' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_352 = TRUE; break;
    			}
    			$result = $res_342;
    			$this->pos = $pos_342;
    			$_350 = NULL;
    			do {
    				$res_344 = $result;
    				$pos_344 = $this->pos;
    				if (( $subres = $this->literal( 'and' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_350 = TRUE; break;
    				}
    				$result = $res_344;
    				$this->pos = $pos_344;
    				$_348 = NULL;
    				do {
    					if (( $subres = $this->literal( 'or' ) ) !== FALSE) { $result["text"] .= $subres; }
    					else { $_348 = FALSE; break; }
    					if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    					$_348 = TRUE; break;
    				}
    				while(0);
    				if( $_348 === TRUE ) { $_350 = TRUE; break; }
    				$result = $res_344;
    				$this->pos = $pos_344;
    				$_350 = FALSE; break;
    			}
    			while(0);
    			if( $_350 === TRUE ) { $_352 = TRUE; break; }
    			$result = $res_342;
    			$this->pos = $pos_342;
    			$_352 = FALSE; break;
    		}
    		while(0);
    		if( $_352 === TRUE ) { $_354 = TRUE; break; }
    		$result = $res_340;
    		$this->pos = $pos_340;
    		$_354 = FALSE; break;
    	}
    	while(0);
    	if( $_354 === TRUE ) { return $this->finalise($result); }
    	if( $_354 === FALSE) { return FALSE; }
    }


    /* ComparisonExpr: AdditiveExpr ( ComparisonOp AdditiveExpr )? > */
    protected $match_ComparisonExpr_typestack = array('ComparisonExpr');
    function match_ComparisonExpr ($stack = array()) {
    	$matchrule = "ComparisonExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_362 = NULL;
    	do {
    		$matcher = 'match_'.'AdditiveExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_362 = FALSE; break; }
    		$res_360 = $result;
    		$pos_360 = $this->pos;
    		$_359 = NULL;
    		do {
    			$matcher = 'match_'.'ComparisonOp'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else { $_359 = FALSE; break; }
    			$matcher = 'match_'.'AdditiveExpr'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    			}
    			else { $_359 = FALSE; break; }
    			$_359 = TRUE; break;
    		}
    		while(0);
    		if( $_359 === FALSE) {
    			$result = $res_360;
    			$this->pos = $pos_360;
    			unset( $res_360 );
    			unset( $pos_360 );
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_362 = TRUE; break;
    	}
    	while(0);
    	if( $_362 === TRUE ) { return $this->finalise($result); }
    	if( $_362 === FALSE) { return FALSE; }
    }


    /* ComparisonOp: "==" | "!=" | "<=" | ">=" | "<" | ">" > */
    protected $match_ComparisonOp_typestack = array('ComparisonOp');
    function match_ComparisonOp ($stack = array()) {
    	$matchrule = "ComparisonOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_386 = NULL;
    	do {
    		$res_364 = $result;
    		$pos_364 = $this->pos;
    		if (( $subres = $this->literal( '==' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_386 = TRUE; break;
    		}
    		$result = $res_364;
    		$this->pos = $pos_364;
    		$_384 = NULL;
    		do {
    			$res_366 = $result;
    			$pos_366 = $this->pos;
    			if (( $subres = $this->literal( '!=' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_384 = TRUE; break;
    			}
    			$result = $res_366;
    			$this->pos = $pos_366;
    			$_382 = NULL;
    			do {
    				$res_368 = $result;
    				$pos_368 = $this->pos;
    				if (( $subres = $this->literal( '<=' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_382 = TRUE; break;
    				}
    				$result = $res_368;
    				$this->pos = $pos_368;
    				$_380 = NULL;
    				do {
    					$res_370 = $result;
    					$pos_370 = $this->pos;
    					if (( $subres = $this->literal( '>=' ) ) !== FALSE) {
    						$result["text"] .= $subres;
    						$_380 = TRUE; break;
    					}
    					$result = $res_370;
    					$this->pos = $pos_370;
    					$_378 = NULL;
    					do {
    						$res_372 = $result;
    						$pos_372 = $this->pos;
    						if (substr($this->string,$this->pos,1) == '<') {
    							$this->pos += 1;
    							$result["text"] .= '<';
    							$_378 = TRUE; break;
    						}
    						$result = $res_372;
    						$this->pos = $pos_372;
    						$_376 = NULL;
    						do {
    							if (substr($this->string,$this->pos,1) == '>') {
    								$this->pos += 1;
    								$result["text"] .= '>';
    							}
    							else { $_376 = FALSE; break; }
    							if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    							$_376 = TRUE; break;
    						}
    						while(0);
    						if( $_376 === TRUE ) { $_378 = TRUE; break; }
    						$result = $res_372;
    						$this->pos = $pos_372;
    						$_378 = FALSE; break;
    					}
    					while(0);
    					if( $_378 === TRUE ) { $_380 = TRUE; break; }
    					$result = $res_370;
    					$this->pos = $pos_370;
    					$_380 = FALSE; break;
    				}
    				while(0);
    				if( $_380 === TRUE ) { $_382 = TRUE; break; }
    				$result = $res_368;
    				$this->pos = $pos_368;
    				$_382 = FALSE; break;
    			}
    			while(0);
    			if( $_382 === TRUE ) { $_384 = TRUE; break; }
    			$result = $res_366;
    			$this->pos = $pos_366;
    			$_384 = FALSE; break;
    		}
    		while(0);
    		if( $_384 === TRUE ) { $_386 = TRUE; break; }
    		$result = $res_364;
    		$this->pos = $pos_364;
    		$_386 = FALSE; break;
    	}
    	while(0);
    	if( $_386 === TRUE ) { return $this->finalise($result); }
    	if( $_386 === FALSE) { return FALSE; }
    }


    /* AdditiveExpr: MultiplicativeExpr ( AdditiveOp MultiplicativeExpr )* > */
    protected $match_AdditiveExpr_typestack = array('AdditiveExpr');
    function match_AdditiveExpr ($stack = array()) {
    	$matchrule = "AdditiveExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_394 = NULL;
    	do {
    		$matcher = 'match_'.'MultiplicativeExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_394 = FALSE; break; }
    		while (true) {
    			$res_392 = $result;
    			$pos_392 = $this->pos;
    			$_391 = NULL;
    			do {
    				$matcher = 'match_'.'AdditiveOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_391 = FALSE; break; }
    				$matcher = 'match_'.'MultiplicativeExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_391 = FALSE; break; }
    				$_391 = TRUE; break;
    			}
    			while(0);
    			if( $_391 === FALSE) {
    				$result = $res_392;
    				$this->pos = $pos_392;
    				unset( $res_392 );
    				unset( $pos_392 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_394 = TRUE; break;
    	}
    	while(0);
    	if( $_394 === TRUE ) { return $this->finalise($result); }
    	if( $_394 === FALSE) { return FALSE; }
    }


    /* AdditiveOp: "+" | "-" > */
    protected $match_AdditiveOp_typestack = array('AdditiveOp');
    function match_AdditiveOp ($stack = array()) {
    	$matchrule = "AdditiveOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_402 = NULL;
    	do {
    		$res_396 = $result;
    		$pos_396 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '+') {
    			$this->pos += 1;
    			$result["text"] .= '+';
    			$_402 = TRUE; break;
    		}
    		$result = $res_396;
    		$this->pos = $pos_396;
    		$_400 = NULL;
    		do {
    			if (substr($this->string,$this->pos,1) == '-') {
    				$this->pos += 1;
    				$result["text"] .= '-';
    			}
    			else { $_400 = FALSE; break; }
    			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    			$_400 = TRUE; break;
    		}
    		while(0);
    		if( $_400 === TRUE ) { $_402 = TRUE; break; }
    		$result = $res_396;
    		$this->pos = $pos_396;
    		$_402 = FALSE; break;
    	}
    	while(0);
    	if( $_402 === TRUE ) { return $this->finalise($result); }
    	if( $_402 === FALSE) { return FALSE; }
    }


    /* MultiplicativeExpr: UnaryExpr ( MultiplicativeOp UnaryExpr )* > */
    protected $match_MultiplicativeExpr_typestack = array('MultiplicativeExpr');
    function match_MultiplicativeExpr ($stack = array()) {
    	$matchrule = "MultiplicativeExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_410 = NULL;
    	do {
    		$matcher = 'match_'.'UnaryExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_410 = FALSE; break; }
    		while (true) {
    			$res_408 = $result;
    			$pos_408 = $this->pos;
    			$_407 = NULL;
    			do {
    				$matcher = 'match_'.'MultiplicativeOp'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_407 = FALSE; break; }
    				$matcher = 'match_'.'UnaryExpr'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_407 = FALSE; break; }
    				$_407 = TRUE; break;
    			}
    			while(0);
    			if( $_407 === FALSE) {
    				$result = $res_408;
    				$this->pos = $pos_408;
    				unset( $res_408 );
    				unset( $pos_408 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_410 = TRUE; break;
    	}
    	while(0);
    	if( $_410 === TRUE ) { return $this->finalise($result); }
    	if( $_410 === FALSE) { return FALSE; }
    }


    /* MultiplicativeOp: "*" | "/" | "%" > */
    protected $match_MultiplicativeOp_typestack = array('MultiplicativeOp');
    function match_MultiplicativeOp ($stack = array()) {
    	$matchrule = "MultiplicativeOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_422 = NULL;
    	do {
    		$res_412 = $result;
    		$pos_412 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '*') {
    			$this->pos += 1;
    			$result["text"] .= '*';
    			$_422 = TRUE; break;
    		}
    		$result = $res_412;
    		$this->pos = $pos_412;
    		$_420 = NULL;
    		do {
    			$res_414 = $result;
    			$pos_414 = $this->pos;
    			if (substr($this->string,$this->pos,1) == '/') {
    				$this->pos += 1;
    				$result["text"] .= '/';
    				$_420 = TRUE; break;
    			}
    			$result = $res_414;
    			$this->pos = $pos_414;
    			$_418 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == '%') {
    					$this->pos += 1;
    					$result["text"] .= '%';
    				}
    				else { $_418 = FALSE; break; }
    				if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    				$_418 = TRUE; break;
    			}
    			while(0);
    			if( $_418 === TRUE ) { $_420 = TRUE; break; }
    			$result = $res_414;
    			$this->pos = $pos_414;
    			$_420 = FALSE; break;
    		}
    		while(0);
    		if( $_420 === TRUE ) { $_422 = TRUE; break; }
    		$result = $res_412;
    		$this->pos = $pos_412;
    		$_422 = FALSE; break;
    	}
    	while(0);
    	if( $_422 === TRUE ) { return $this->finalise($result); }
    	if( $_422 === FALSE) { return FALSE; }
    }


    /* UnaryExpr: UnaryOp? PrimaryExpr > */
    protected $match_UnaryExpr_typestack = array('UnaryExpr');
    function match_UnaryExpr ($stack = array()) {
    	$matchrule = "UnaryExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_427 = NULL;
    	do {
    		$res_424 = $result;
    		$pos_424 = $this->pos;
    		$matcher = 'match_'.'UnaryOp'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_424;
    			$this->pos = $pos_424;
    			unset( $res_424 );
    			unset( $pos_424 );
    		}
    		$matcher = 'match_'.'PrimaryExpr'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_427 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_427 = TRUE; break;
    	}
    	while(0);
    	if( $_427 === TRUE ) { return $this->finalise($result); }
    	if( $_427 === FALSE) { return FALSE; }
    }


    /* UnaryOp: "!" | "not" | "-" */
    protected $match_UnaryOp_typestack = array('UnaryOp');
    function match_UnaryOp ($stack = array()) {
    	$matchrule = "UnaryOp"; $result = $this->construct($matchrule, $matchrule, null);
    	$_436 = NULL;
    	do {
    		$res_429 = $result;
    		$pos_429 = $this->pos;
    		if (substr($this->string,$this->pos,1) == '!') {
    			$this->pos += 1;
    			$result["text"] .= '!';
    			$_436 = TRUE; break;
    		}
    		$result = $res_429;
    		$this->pos = $pos_429;
    		$_434 = NULL;
    		do {
    			$res_431 = $result;
    			$pos_431 = $this->pos;
    			if (( $subres = $this->literal( 'not' ) ) !== FALSE) {
    				$result["text"] .= $subres;
    				$_434 = TRUE; break;
    			}
    			$result = $res_431;
    			$this->pos = $pos_431;
    			if (substr($this->string,$this->pos,1) == '-') {
    				$this->pos += 1;
    				$result["text"] .= '-';
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
    	if( $_436 === TRUE ) { return $this->finalise($result); }
    	if( $_436 === FALSE) { return FALSE; }
    }


    /* PrimaryExpr: Literal | MethodCall | PropertyAccess | ThisKeyword | ParenExpr | SetLiteral */
    protected $match_PrimaryExpr_typestack = array('PrimaryExpr');
    function match_PrimaryExpr ($stack = array()) {
    	$matchrule = "PrimaryExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_457 = NULL;
    	do {
    		$res_438 = $result;
    		$pos_438 = $this->pos;
    		$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_457 = TRUE; break;
    		}
    		$result = $res_438;
    		$this->pos = $pos_438;
    		$_455 = NULL;
    		do {
    			$res_440 = $result;
    			$pos_440 = $this->pos;
    			$matcher = 'match_'.'MethodCall'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_455 = TRUE; break;
    			}
    			$result = $res_440;
    			$this->pos = $pos_440;
    			$_453 = NULL;
    			do {
    				$res_442 = $result;
    				$pos_442 = $this->pos;
    				$matcher = 'match_'.'PropertyAccess'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_453 = TRUE; break;
    				}
    				$result = $res_442;
    				$this->pos = $pos_442;
    				$_451 = NULL;
    				do {
    					$res_444 = $result;
    					$pos_444 = $this->pos;
    					$matcher = 'match_'.'ThisKeyword'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_451 = TRUE; break;
    					}
    					$result = $res_444;
    					$this->pos = $pos_444;
    					$_449 = NULL;
    					do {
    						$res_446 = $result;
    						$pos_446 = $this->pos;
    						$matcher = 'match_'.'ParenExpr'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_449 = TRUE; break;
    						}
    						$result = $res_446;
    						$this->pos = $pos_446;
    						$matcher = 'match_'.'SetLiteral'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_449 = TRUE; break;
    						}
    						$result = $res_446;
    						$this->pos = $pos_446;
    						$_449 = FALSE; break;
    					}
    					while(0);
    					if( $_449 === TRUE ) { $_451 = TRUE; break; }
    					$result = $res_444;
    					$this->pos = $pos_444;
    					$_451 = FALSE; break;
    				}
    				while(0);
    				if( $_451 === TRUE ) { $_453 = TRUE; break; }
    				$result = $res_442;
    				$this->pos = $pos_442;
    				$_453 = FALSE; break;
    			}
    			while(0);
    			if( $_453 === TRUE ) { $_455 = TRUE; break; }
    			$result = $res_440;
    			$this->pos = $pos_440;
    			$_455 = FALSE; break;
    		}
    		while(0);
    		if( $_455 === TRUE ) { $_457 = TRUE; break; }
    		$result = $res_438;
    		$this->pos = $pos_438;
    		$_457 = FALSE; break;
    	}
    	while(0);
    	if( $_457 === TRUE ) { return $this->finalise($result); }
    	if( $_457 === FALSE) { return FALSE; }
    }


    /* ParenExpr: "(" Expression ")" > */
    protected $match_ParenExpr_typestack = array('ParenExpr');
    function match_ParenExpr ($stack = array()) {
    	$matchrule = "ParenExpr"; $result = $this->construct($matchrule, $matchrule, null);
    	$_463 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_463 = FALSE; break; }
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_463 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_463 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_463 = TRUE; break;
    	}
    	while(0);
    	if( $_463 === TRUE ) { return $this->finalise($result); }
    	if( $_463 === FALSE) { return FALSE; }
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
    	$_471 = NULL;
    	do {
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_471 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '(') {
    			$this->pos += 1;
    			$result["text"] .= '(';
    		}
    		else { $_471 = FALSE; break; }
    		$res_468 = $result;
    		$pos_468 = $this->pos;
    		$matcher = 'match_'.'ArgList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_468;
    			$this->pos = $pos_468;
    			unset( $res_468 );
    			unset( $pos_468 );
    		}
    		if (substr($this->string,$this->pos,1) == ')') {
    			$this->pos += 1;
    			$result["text"] .= ')';
    		}
    		else { $_471 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_471 = TRUE; break;
    	}
    	while(0);
    	if( $_471 === TRUE ) { return $this->finalise($result); }
    	if( $_471 === FALSE) { return FALSE; }
    }


    /* PropertyAccess: QualifiedName > */
    protected $match_PropertyAccess_typestack = array('PropertyAccess');
    function match_PropertyAccess ($stack = array()) {
    	$matchrule = "PropertyAccess"; $result = $this->construct($matchrule, $matchrule, null);
    	$_475 = NULL;
    	do {
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_475 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_475 = TRUE; break;
    	}
    	while(0);
    	if( $_475 === TRUE ) { return $this->finalise($result); }
    	if( $_475 === FALSE) { return FALSE; }
    }


    /* QualifiedName: Identifier ( "." Identifier )* > */
    protected $match_QualifiedName_typestack = array('QualifiedName');
    function match_QualifiedName ($stack = array()) {
    	$matchrule = "QualifiedName"; $result = $this->construct($matchrule, $matchrule, null);
    	$_483 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_483 = FALSE; break; }
    		while (true) {
    			$res_481 = $result;
    			$pos_481 = $this->pos;
    			$_480 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == '.') {
    					$this->pos += 1;
    					$result["text"] .= '.';
    				}
    				else { $_480 = FALSE; break; }
    				$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_480 = FALSE; break; }
    				$_480 = TRUE; break;
    			}
    			while(0);
    			if( $_480 === FALSE) {
    				$result = $res_481;
    				$this->pos = $pos_481;
    				unset( $res_481 );
    				unset( $pos_481 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_483 = TRUE; break;
    	}
    	while(0);
    	if( $_483 === TRUE ) { return $this->finalise($result); }
    	if( $_483 === FALSE) { return FALSE; }
    }


    /* ArgList: Expression ( "," Expression )* > */
    protected $match_ArgList_typestack = array('ArgList');
    function match_ArgList ($stack = array()) {
    	$matchrule = "ArgList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_491 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_491 = FALSE; break; }
    		while (true) {
    			$res_489 = $result;
    			$pos_489 = $this->pos;
    			$_488 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_488 = FALSE; break; }
    				$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_488 = FALSE; break; }
    				$_488 = TRUE; break;
    			}
    			while(0);
    			if( $_488 === FALSE) {
    				$result = $res_489;
    				$this->pos = $pos_489;
    				unset( $res_489 );
    				unset( $pos_489 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_491 = TRUE; break;
    	}
    	while(0);
    	if( $_491 === TRUE ) { return $this->finalise($result); }
    	if( $_491 === FALSE) { return FALSE; }
    }


    /* SetLiteral: "{" ElemList? "}" > */
    protected $match_SetLiteral_typestack = array('SetLiteral');
    function match_SetLiteral ($stack = array()) {
    	$matchrule = "SetLiteral"; $result = $this->construct($matchrule, $matchrule, null);
    	$_497 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_497 = FALSE; break; }
    		$res_494 = $result;
    		$pos_494 = $this->pos;
    		$matcher = 'match_'.'ElemList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_494;
    			$this->pos = $pos_494;
    			unset( $res_494 );
    			unset( $pos_494 );
    		}
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_497 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_497 = TRUE; break;
    	}
    	while(0);
    	if( $_497 === TRUE ) { return $this->finalise($result); }
    	if( $_497 === FALSE) { return FALSE; }
    }


    /* ElemList: Expression ( "," Expression )* > */
    protected $match_ElemList_typestack = array('ElemList');
    function match_ElemList ($stack = array()) {
    	$matchrule = "ElemList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_505 = NULL;
    	do {
    		$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_505 = FALSE; break; }
    		while (true) {
    			$res_503 = $result;
    			$pos_503 = $this->pos;
    			$_502 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_502 = FALSE; break; }
    				$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_502 = FALSE; break; }
    				$_502 = TRUE; break;
    			}
    			while(0);
    			if( $_502 === FALSE) {
    				$result = $res_503;
    				$this->pos = $pos_503;
    				unset( $res_503 );
    				unset( $pos_503 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_505 = TRUE; break;
    	}
    	while(0);
    	if( $_505 === TRUE ) { return $this->finalise($result); }
    	if( $_505 === FALSE) { return FALSE; }
    }


    /* Literal: String | Float | Number | Boolean | Identifier */
    protected $match_Literal_typestack = array('Literal');
    function match_Literal ($stack = array()) {
    	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
    	$_522 = NULL;
    	do {
    		$res_507 = $result;
    		$pos_507 = $this->pos;
    		$matcher = 'match_'.'String'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    			$_522 = TRUE; break;
    		}
    		$result = $res_507;
    		$this->pos = $pos_507;
    		$_520 = NULL;
    		do {
    			$res_509 = $result;
    			$pos_509 = $this->pos;
    			$matcher = 'match_'.'Float'; $key = $matcher; $pos = $this->pos;
    			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    			if ($subres !== FALSE) {
    				$this->store( $result, $subres );
    				$_520 = TRUE; break;
    			}
    			$result = $res_509;
    			$this->pos = $pos_509;
    			$_518 = NULL;
    			do {
    				$res_511 = $result;
    				$pos_511 = $this->pos;
    				$matcher = 'match_'.'Number'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    					$_518 = TRUE; break;
    				}
    				$result = $res_511;
    				$this->pos = $pos_511;
    				$_516 = NULL;
    				do {
    					$res_513 = $result;
    					$pos_513 = $this->pos;
    					$matcher = 'match_'.'Boolean'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_516 = TRUE; break;
    					}
    					$result = $res_513;
    					$this->pos = $pos_513;
    					$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    					if ($subres !== FALSE) {
    						$this->store( $result, $subres );
    						$_516 = TRUE; break;
    					}
    					$result = $res_513;
    					$this->pos = $pos_513;
    					$_516 = FALSE; break;
    				}
    				while(0);
    				if( $_516 === TRUE ) { $_518 = TRUE; break; }
    				$result = $res_511;
    				$this->pos = $pos_511;
    				$_518 = FALSE; break;
    			}
    			while(0);
    			if( $_518 === TRUE ) { $_520 = TRUE; break; }
    			$result = $res_509;
    			$this->pos = $pos_509;
    			$_520 = FALSE; break;
    		}
    		while(0);
    		if( $_520 === TRUE ) { $_522 = TRUE; break; }
    		$result = $res_507;
    		$this->pos = $pos_507;
    		$_522 = FALSE; break;
    	}
    	while(0);
    	if( $_522 === TRUE ) { return $this->finalise($result); }
    	if( $_522 === FALSE) { return FALSE; }
    }


    /* String: /"[^"]*"/ > */
    protected $match_String_typestack = array('String');
    function match_String ($stack = array()) {
    	$matchrule = "String"; $result = $this->construct($matchrule, $matchrule, null);
    	$_526 = NULL;
    	do {
    		if (( $subres = $this->rx( '/"[^"]*"/' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_526 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_526 = TRUE; break;
    	}
    	while(0);
    	if( $_526 === TRUE ) { return $this->finalise($result); }
    	if( $_526 === FALSE) { return FALSE; }
    }


    /* Float: /[0-9]+\.[0-9]+/ > */
    protected $match_Float_typestack = array('Float');
    function match_Float ($stack = array()) {
    	$matchrule = "Float"; $result = $this->construct($matchrule, $matchrule, null);
    	$_530 = NULL;
    	do {
    		if (( $subres = $this->rx( '/[0-9]+\.[0-9]+/' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_530 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_530 = TRUE; break;
    	}
    	while(0);
    	if( $_530 === TRUE ) { return $this->finalise($result); }
    	if( $_530 === FALSE) { return FALSE; }
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
    	$_536 = NULL;
    	do {
    		$res_533 = $result;
    		$pos_533 = $this->pos;
    		if (( $subres = $this->literal( 'true' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_536 = TRUE; break;
    		}
    		$result = $res_533;
    		$this->pos = $pos_533;
    		if (( $subres = $this->literal( 'false' ) ) !== FALSE) {
    			$result["text"] .= $subres;
    			$_536 = TRUE; break;
    		}
    		$result = $res_533;
    		$this->pos = $pos_533;
    		$_536 = FALSE; break;
    	}
    	while(0);
    	if( $_536 === TRUE ) { return $this->finalise($result); }
    	if( $_536 === FALSE) { return FALSE; }
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
    	$_544 = NULL;
    	do {
    		if (( $subres = $this->literal( 'import' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_544 = FALSE; break; }
    		$matcher = 'match_'.'QualifiedName'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_544 = FALSE; break; }
    		$res_541 = $result;
    		$pos_541 = $this->pos;
    		$matcher = 'match_'.'ImportList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else {
    			$result = $res_541;
    			$this->pos = $pos_541;
    			unset( $res_541 );
    			unset( $pos_541 );
    		}
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_544 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_544 = TRUE; break;
    	}
    	while(0);
    	if( $_544 === TRUE ) { return $this->finalise($result); }
    	if( $_544 === FALSE) { return FALSE; }
    }


    /* ImportList: "." "{" IdentList "}" > */
    protected $match_ImportList_typestack = array('ImportList');
    function match_ImportList ($stack = array()) {
    	$matchrule = "ImportList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_551 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '.') {
    			$this->pos += 1;
    			$result["text"] .= '.';
    		}
    		else { $_551 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_551 = FALSE; break; }
    		$matcher = 'match_'.'IdentList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_551 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_551 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_551 = TRUE; break;
    	}
    	while(0);
    	if( $_551 === TRUE ) { return $this->finalise($result); }
    	if( $_551 === FALSE) { return FALSE; }
    }


    /* ExportDecl: "export" IdentList ";" > */
    protected $match_ExportDecl_typestack = array('ExportDecl');
    function match_ExportDecl ($stack = array()) {
    	$matchrule = "ExportDecl"; $result = $this->construct($matchrule, $matchrule, null);
    	$_557 = NULL;
    	do {
    		if (( $subres = $this->literal( 'export' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_557 = FALSE; break; }
    		$matcher = 'match_'.'IdentList'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_557 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == ';') {
    			$this->pos += 1;
    			$result["text"] .= ';';
    		}
    		else { $_557 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_557 = TRUE; break;
    	}
    	while(0);
    	if( $_557 === TRUE ) { return $this->finalise($result); }
    	if( $_557 === FALSE) { return FALSE; }
    }


    /* IdentList: Identifier ( "," Identifier )* > */
    protected $match_IdentList_typestack = array('IdentList');
    function match_IdentList ($stack = array()) {
    	$matchrule = "IdentList"; $result = $this->construct($matchrule, $matchrule, null);
    	$_565 = NULL;
    	do {
    		$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_565 = FALSE; break; }
    		while (true) {
    			$res_563 = $result;
    			$pos_563 = $this->pos;
    			$_562 = NULL;
    			do {
    				if (substr($this->string,$this->pos,1) == ',') {
    					$this->pos += 1;
    					$result["text"] .= ',';
    				}
    				else { $_562 = FALSE; break; }
    				$matcher = 'match_'.'Identifier'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_562 = FALSE; break; }
    				$_562 = TRUE; break;
    			}
    			while(0);
    			if( $_562 === FALSE) {
    				$result = $res_563;
    				$this->pos = $pos_563;
    				unset( $res_563 );
    				unset( $pos_563 );
    				break;
    			}
    		}
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_565 = TRUE; break;
    	}
    	while(0);
    	if( $_565 === TRUE ) { return $this->finalise($result); }
    	if( $_565 === FALSE) { return FALSE; }
    }




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