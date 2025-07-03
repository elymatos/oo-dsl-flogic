<?php

namespace OODSLFLogic\Parser\Generated;

use hafriedlander\Peg\Parser\Packrat;
/**
 * This class defines the grammar for our Command DSL.
 * It will be compiled by php-peg into a functional parser.
 */
class CommandParser extends Packrat
{
    /* Command: entity:Var "." command:Var _ "has" _ "{" _ values:(CompositeValue / Value)* _ "}" */
    protected $match_Command_typestack = array('Command');
    function match_Command ($stack = array()) {
    	$matchrule = "Command"; $result = $this->construct($matchrule, $matchrule, null);
    	$_14 = NULL;
    	do {
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "entity" );
    		}
    		else { $_14 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '.') {
    			$this->pos += 1;
    			$result["text"] .= '.';
    		}
    		else { $_14 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "command" );
    		}
    		else { $_14 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_14 = FALSE; break; }
    		if (( $subres = $this->literal( 'has' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_14 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_14 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_14 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_14 = FALSE; break; }
    		$stack[] = $result; $result = $this->construct( $matchrule, "values" ); 
    		while (true) {
    			$res_11 = $result;
    			$pos_11 = $this->pos;
    			$_10 = NULL;
    			do {
    				$matcher = 'match_'.'CompositeValue'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_10 = FALSE; break; }
    				$matcher = 'match_'.'Value'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_10 = FALSE; break; }
    				$_10 = TRUE; break;
    			}
    			while(0);
    			if( $_10 === FALSE) {
    				$result = $res_11;
    				$this->pos = $pos_11;
    				unset( $res_11 );
    				unset( $pos_11 );
    				break;
    			}
    		}
    		$subres = $result; $result = array_pop($stack);
    		$this->store( $result, $subres, 'values' );
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_14 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_14 = FALSE; break; }
    		$_14 = TRUE; break;
    	}
    	while(0);
    	if( $_14 === TRUE ) { return $this->finalise($result); }
    	if( $_14 === FALSE) { return FALSE; }
    }


    /* Values: "{" _ values:(CompositeValue / Value)* _ "}" */
    protected $match_Values_typestack = array('Values');
    function match_Values ($stack = array()) {
    	$matchrule = "Values"; $result = $this->construct($matchrule, $matchrule, null);
    	$_24 = NULL;
    	do {
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_24 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_24 = FALSE; break; }
    		$stack[] = $result; $result = $this->construct( $matchrule, "values" ); 
    		while (true) {
    			$res_21 = $result;
    			$pos_21 = $this->pos;
    			$_20 = NULL;
    			do {
    				$matcher = 'match_'.'CompositeValue'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_20 = FALSE; break; }
    				$matcher = 'match_'.'Value'; $key = $matcher; $pos = $this->pos;
    				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    				if ($subres !== FALSE) {
    					$this->store( $result, $subres );
    				}
    				else { $_20 = FALSE; break; }
    				$_20 = TRUE; break;
    			}
    			while(0);
    			if( $_20 === FALSE) {
    				$result = $res_21;
    				$this->pos = $pos_21;
    				unset( $res_21 );
    				unset( $pos_21 );
    				break;
    			}
    		}
    		$subres = $result; $result = array_pop($stack);
    		$this->store( $result, $subres, 'values' );
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_24 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_24 = FALSE; break; }
    		$_24 = TRUE; break;
    	}
    	while(0);
    	if( $_24 === TRUE ) { return $this->finalise($result); }
    	if( $_24 === FALSE) { return FALSE; }
    }


    /* Value: ("a" / "an") _ class:Var _ param:Var alias:Alias? */
    protected $match_Value_typestack = array('Value');
    function match_Value ($stack = array()) {
    	$matchrule = "Value"; $result = $this->construct($matchrule, $matchrule, null);
    	$_35 = NULL;
    	do {
    		$_28 = NULL;
    		do {
    			if (substr($this->string,$this->pos,1) == 'a') {
    				$this->pos += 1;
    				$result["text"] .= 'a';
    			}
    			else { $_28 = FALSE; break; }
    			if (( $subres = $this->literal( 'an' ) ) !== FALSE) { $result["text"] .= $subres; }
    			else { $_28 = FALSE; break; }
    			$_28 = TRUE; break;
    		}
    		while(0);
    		if( $_28 === FALSE) { $_35 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_35 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "class" );
    		}
    		else { $_35 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_35 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "param" );
    		}
    		else { $_35 = FALSE; break; }
    		$res_34 = $result;
    		$pos_34 = $this->pos;
    		$matcher = 'match_'.'Alias'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "alias" );
    		}
    		else {
    			$result = $res_34;
    			$this->pos = $pos_34;
    			unset( $res_34 );
    			unset( $pos_34 );
    		}
    		$_35 = TRUE; break;
    	}
    	while(0);
    	if( $_35 === TRUE ) { return $this->finalise($result); }
    	if( $_35 === FALSE) { return FALSE; }
    }


    /* CompositeValue: ("a" / "an") _ class:Var _ param:Var _ "from" _ values:Values */
    protected $match_CompositeValue_typestack = array('CompositeValue');
    function match_CompositeValue ($stack = array()) {
    	$matchrule = "CompositeValue"; $result = $this->construct($matchrule, $matchrule, null);
    	$_49 = NULL;
    	do {
    		$_39 = NULL;
    		do {
    			if (substr($this->string,$this->pos,1) == 'a') {
    				$this->pos += 1;
    				$result["text"] .= 'a';
    			}
    			else { $_39 = FALSE; break; }
    			if (( $subres = $this->literal( 'an' ) ) !== FALSE) { $result["text"] .= $subres; }
    			else { $_39 = FALSE; break; }
    			$_39 = TRUE; break;
    		}
    		while(0);
    		if( $_39 === FALSE) { $_49 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_49 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "class" );
    		}
    		else { $_49 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_49 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "param" );
    		}
    		else { $_49 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_49 = FALSE; break; }
    		if (( $subres = $this->literal( 'from' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_49 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_49 = FALSE; break; }
    		$matcher = 'match_'.'Values'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "values" );
    		}
    		else { $_49 = FALSE; break; }
    		$_49 = TRUE; break;
    	}
    	while(0);
    	if( $_49 === TRUE ) { return $this->finalise($result); }
    	if( $_49 === FALSE) { return FALSE; }
    }


    /* Alias: _ "from" _ alias:Var */
    protected $match_Alias_typestack = array('Alias');
    function match_Alias ($stack = array()) {
    	$matchrule = "Alias"; $result = $this->construct($matchrule, $matchrule, null);
    	$_55 = NULL;
    	do {
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_55 = FALSE; break; }
    		if (( $subres = $this->literal( 'from' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_55 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_55 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "alias" );
    		}
    		else { $_55 = FALSE; break; }
    		$_55 = TRUE; break;
    	}
    	while(0);
    	if( $_55 === TRUE ) { return $this->finalise($result); }
    	if( $_55 === FALSE) { return FALSE; }
    }


    /* Var: /[A-Za-z0-9_]+/ */
    protected $match_Var_typestack = array('Var');
    function match_Var ($stack = array()) {
    	$matchrule = "Var"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/[A-Za-z0-9_]+/' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }


    /* _: /[ \t\n\r]* / */
    protected $match___typestack = array('_');
    function match__ ($stack = array()) {
    	$matchrule = "_"; $result = $this->construct($matchrule, $matchrule, null);
    	if (( $subres = $this->rx( '/[ \t\n\r]* /' ) ) !== FALSE) {
    		$result["text"] .= $subres;
    		return $this->finalise($result);
    	}
    	else { return FALSE; }
    }



}