<?php

namespace OODSLFLogic\Parser\Generated;

use hafriedlander\Peg\Parser\Basic; // Extend Parser\Basic as seen in Calculator.peg.inc [1]

/**
 * This class defines the grammar for our Command DSL.
 * It will be compiled by php-peg into a functional parser.
 */
class CommandParser extends Basic
{
    /* Command: entity:Var "." command:Var _ "has" _ "{" values:Values "}" */
    protected $match_Command_typestack = array('Command');
    function match_Command ($stack = array()) {
    	$matchrule = "Command"; $result = $this->construct($matchrule, $matchrule, null);
    	$_9 = NULL;
    	do {
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "entity" );
    		}
    		else { $_9 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '.') {
    			$this->pos += 1;
    			$result["text"] .= '.';
    		}
    		else { $_9 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "command" );
    		}
    		else { $_9 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_9 = FALSE; break; }
    		if (( $subres = $this->literal( 'has' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_9 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_9 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '{') {
    			$this->pos += 1;
    			$result["text"] .= '{';
    		}
    		else { $_9 = FALSE; break; }
    		$matcher = 'match_'.'Values'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "values" );
    		}
    		else { $_9 = FALSE; break; }
    		if (substr($this->string,$this->pos,1) == '}') {
    			$this->pos += 1;
    			$result["text"] .= '}';
    		}
    		else { $_9 = FALSE; break; }
    		$_9 = TRUE; break;
    	}
    	while(0);
    	if( $_9 === TRUE ) { return $this->finalise($result); }
    	if( $_9 === FALSE) { return FALSE; }
    }


    /* Values: _ (value:(CompositeValue | sv:Value)) * _ */
    protected $match_Values_typestack = array('Values');
    function match_Values ($stack = array()) {
    	$matchrule = "Values"; $result = $this->construct($matchrule, $matchrule, null);
    	$_22 = NULL;
    	do {
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_22 = FALSE; break; }
    		while (true) {
    			$res_20 = $result;
    			$pos_20 = $this->pos;
    			$_19 = NULL;
    			do {
    				$stack[] = $result; $result = $this->construct( $matchrule, "value" ); 
    				$_17 = NULL;
    				do {
    					$_15 = NULL;
    					do {
    						$res_12 = $result;
    						$pos_12 = $this->pos;
    						$matcher = 'match_'.'CompositeValue'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres );
    							$_15 = TRUE; break;
    						}
    						$result = $res_12;
    						$this->pos = $pos_12;
    						$matcher = 'match_'.'Value'; $key = $matcher; $pos = $this->pos;
    						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    						if ($subres !== FALSE) {
    							$this->store( $result, $subres, "sv" );
    							$_15 = TRUE; break;
    						}
    						$result = $res_12;
    						$this->pos = $pos_12;
    						$_15 = FALSE; break;
    					}
    					while(0);
    					if( $_15 === FALSE) { $_17 = FALSE; break; }
    					$_17 = TRUE; break;
    				}
    				while(0);
    				if( $_17 === TRUE ) {
    					$subres = $result; $result = array_pop($stack);
    					$this->store( $result, $subres, 'value' );
    				}
    				if( $_17 === FALSE) {
    					$result = array_pop($stack);
    					$_19 = FALSE; break;
    				}
    				$_19 = TRUE; break;
    			}
    			while(0);
    			if( $_19 === FALSE) {
    				$result = $res_20;
    				$this->pos = $pos_20;
    				unset( $res_20 );
    				unset( $pos_20 );
    				break;
    			}
    		}
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_22 = FALSE; break; }
    		$_22 = TRUE; break;
    	}
    	while(0);
    	if( $_22 === TRUE ) { return $this->finalise($result); }
    	if( $_22 === FALSE) { return FALSE; }
    }


    /* Value: v:(("an" | "a") _ class:Var _ param:Var _) */
    protected $match_Value_typestack = array('Value');
    function match_Value ($stack = array()) {
    	$matchrule = "Value"; $result = $this->construct($matchrule, $matchrule, null);
    	$stack[] = $result; $result = $this->construct( $matchrule, "v" ); 
    	$_36 = NULL;
    	do {
    		$_29 = NULL;
    		do {
    			$_27 = NULL;
    			do {
    				$res_24 = $result;
    				$pos_24 = $this->pos;
    				if (( $subres = $this->literal( 'an' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_27 = TRUE; break;
    				}
    				$result = $res_24;
    				$this->pos = $pos_24;
    				if (substr($this->string,$this->pos,1) == 'a') {
    					$this->pos += 1;
    					$result["text"] .= 'a';
    					$_27 = TRUE; break;
    				}
    				$result = $res_24;
    				$this->pos = $pos_24;
    				$_27 = FALSE; break;
    			}
    			while(0);
    			if( $_27 === FALSE) { $_29 = FALSE; break; }
    			$_29 = TRUE; break;
    		}
    		while(0);
    		if( $_29 === FALSE) { $_36 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_36 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "class" );
    		}
    		else { $_36 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_36 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "param" );
    		}
    		else { $_36 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_36 = FALSE; break; }
    		$_36 = TRUE; break;
    	}
    	while(0);
    	if( $_36 === TRUE ) {
    		$subres = $result; $result = array_pop($stack);
    		$this->store( $result, $subres, 'v' );
    		return $this->finalise($result);
    	}
    	if( $_36 === FALSE) {
    		$result = array_pop($stack);
    		return FALSE;
    	}
    }


    /* CompositeValue: ("an" | "a") _ class:Var _ param:Var _ "from" _ values:Values > */
    protected $match_CompositeValue_typestack = array('CompositeValue');
    function match_CompositeValue ($stack = array()) {
    	$matchrule = "CompositeValue"; $result = $this->construct($matchrule, $matchrule, null);
    	$_54 = NULL;
    	do {
    		$_43 = NULL;
    		do {
    			$_41 = NULL;
    			do {
    				$res_38 = $result;
    				$pos_38 = $this->pos;
    				if (( $subres = $this->literal( 'an' ) ) !== FALSE) {
    					$result["text"] .= $subres;
    					$_41 = TRUE; break;
    				}
    				$result = $res_38;
    				$this->pos = $pos_38;
    				if (substr($this->string,$this->pos,1) == 'a') {
    					$this->pos += 1;
    					$result["text"] .= 'a';
    					$_41 = TRUE; break;
    				}
    				$result = $res_38;
    				$this->pos = $pos_38;
    				$_41 = FALSE; break;
    			}
    			while(0);
    			if( $_41 === FALSE) { $_43 = FALSE; break; }
    			$_43 = TRUE; break;
    		}
    		while(0);
    		if( $_43 === FALSE) { $_54 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_54 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "class" );
    		}
    		else { $_54 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_54 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "param" );
    		}
    		else { $_54 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_54 = FALSE; break; }
    		if (( $subres = $this->literal( 'from' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_54 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_54 = FALSE; break; }
    		$matcher = 'match_'.'Values'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "values" );
    		}
    		else { $_54 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_54 = TRUE; break;
    	}
    	while(0);
    	if( $_54 === TRUE ) { return $this->finalise($result); }
    	if( $_54 === FALSE) { return FALSE; }
    }


    /* Alias: _ "from" _ alias:Var > */
    protected $match_Alias_typestack = array('Alias');
    function match_Alias ($stack = array()) {
    	$matchrule = "Alias"; $result = $this->construct($matchrule, $matchrule, null);
    	$_61 = NULL;
    	do {
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_61 = FALSE; break; }
    		if (( $subres = $this->literal( 'from' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_61 = FALSE; break; }
    		$matcher = 'match_'.'_'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres );
    		}
    		else { $_61 = FALSE; break; }
    		$matcher = 'match_'.'Var'; $key = $matcher; $pos = $this->pos;
    		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
    		if ($subres !== FALSE) {
    			$this->store( $result, $subres, "alias" );
    		}
    		else { $_61 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_61 = TRUE; break;
    	}
    	while(0);
    	if( $_61 === TRUE ) { return $this->finalise($result); }
    	if( $_61 === FALSE) { return FALSE; }
    }


    /* Var: /[A-Za-z0-9_]+/ > */
    protected $match_Var_typestack = array('Var');
    function match_Var ($stack = array()) {
    	$matchrule = "Var"; $result = $this->construct($matchrule, $matchrule, null);
    	$_65 = NULL;
    	do {
    		if (( $subres = $this->rx( '/[A-Za-z0-9_]+/' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_65 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_65 = TRUE; break;
    	}
    	while(0);
    	if( $_65 === TRUE ) { return $this->finalise($result); }
    	if( $_65 === FALSE) { return FALSE; }
    }


    /* _: /[\s\t\n\r]* / > */
    protected $match___typestack = array('_');
    function match__ ($stack = array()) {
    	$matchrule = "_"; $result = $this->construct($matchrule, $matchrule, null);
    	$_69 = NULL;
    	do {
    		if (( $subres = $this->rx( '/[\s\t\n\r]* /' ) ) !== FALSE) { $result["text"] .= $subres; }
    		else { $_69 = FALSE; break; }
    		if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
    		$_69 = TRUE; break;
    	}
    	while(0);
    	if( $_69 === TRUE ) { return $this->finalise($result); }
    	if( $_69 === FALSE) { return FALSE; }
    }




        function Command__finalise( &$result ) {
            print_r('command');
            print_r($result);
            $result['x']='teste';
        }

        function Values__finalise( &$result ) {
            print_r('values');
            print_r($result);
            $result['y']='teste';
        }

        function Value__finalise( &$result ) {
            print_r('value');
            print_r($result);
            $result['z']='teste';

        }

        function CompositeValue__finalise( &$result ) {
            print_r($result);
        }

        function Alias__finalise( &$result ) {
        }

        function Var__finalise( &$result ) {
            print_r('var');
            print_r($result);
        }

}