<?php

namespace FLogicDSL\Parser;

use hafriedlander\Peg\Parser\Basic;

class OODSLParser extends Basic {

/* Program: ( Statement )* */
protected $match_Program_typestack = ['Program'];
function match_Program($stack = []) {
	$matchrule = 'Program';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	while (\true) {
		$res_2 = $result;
		$pos_2 = $this->pos;
		$_1 = \null;
		do {
			$key = 'match_'.'Statement'; $pos = $this->pos;
			$subres = $this->packhas($key, $pos)
				? $this->packread($key, $pos)
				: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
			if ($subres !== \false) { $this->store($result, $subres); }
			else { $_1 = \false; break; }
			$_1 = \true; break;
		}
		while(\false);
		if($_1 === \false) {
			$result = $res_2;
			$this->setPos($pos_2);
			unset($res_2, $pos_2);
			break;
		}
	}
	return $this->finalise($result);
}


/* Statement: ClassDecl | ObjectDecl | RuleDecl | Comment | /\s+/ */
protected $match_Statement_typestack = ['Statement'];
function match_Statement($stack = []) {
	$matchrule = 'Statement';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_18 = \null;
	do {
		$res_3 = $result;
		$pos_3 = $this->pos;
		$key = 'match_'.'ClassDecl'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) {
			$this->store($result, $subres);
			$_18 = \true; break;
		}
		$result = $res_3;
		$this->setPos($pos_3);
		$_16 = \null;
		do {
			$res_5 = $result;
			$pos_5 = $this->pos;
			$key = 'match_'.'ObjectDecl'; $pos = $this->pos;
			$subres = $this->packhas($key, $pos)
				? $this->packread($key, $pos)
				: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
			if ($subres !== \false) {
				$this->store($result, $subres);
				$_16 = \true; break;
			}
			$result = $res_5;
			$this->setPos($pos_5);
			$_14 = \null;
			do {
				$res_7 = $result;
				$pos_7 = $this->pos;
				$key = 'match_'.'RuleDecl'; $pos = $this->pos;
				$subres = $this->packhas($key, $pos)
					? $this->packread($key, $pos)
					: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
				if ($subres !== \false) {
					$this->store($result, $subres);
					$_14 = \true; break;
				}
				$result = $res_7;
				$this->setPos($pos_7);
				$_12 = \null;
				do {
					$res_9 = $result;
					$pos_9 = $this->pos;
					$key = 'match_'.'Comment'; $pos = $this->pos;
					$subres = $this->packhas($key, $pos)
						? $this->packread($key, $pos)
						: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
					if ($subres !== \false) {
						$this->store($result, $subres);
						$_12 = \true; break;
					}
					$result = $res_9;
					$this->setPos($pos_9);
					if (($subres = $this->rx('/\s+/')) !== \false) {
						$result["text"] .= $subres;
						$_12 = \true; break;
					}
					$result = $res_9;
					$this->setPos($pos_9);
					$_12 = \false; break;
				}
				while(\false);
				if($_12 === \true) { $_14 = \true; break; }
				$result = $res_7;
				$this->setPos($pos_7);
				$_14 = \false; break;
			}
			while(\false);
			if($_14 === \true) { $_16 = \true; break; }
			$result = $res_5;
			$this->setPos($pos_5);
			$_16 = \false; break;
		}
		while(\false);
		if($_16 === \true) { $_18 = \true; break; }
		$result = $res_3;
		$this->setPos($pos_3);
		$_18 = \false; break;
	}
	while(\false);
	if($_18 === \true) { return $this->finalise($result); }
	if($_18 === \false) { return \false; }
}


/* ClassDecl: "class" /\s+/ Identifier Inheritance? /(\s*)/ "{" ClassBody "}" */
protected $match_ClassDecl_typestack = ['ClassDecl'];
function match_ClassDecl($stack = []) {
	$matchrule = 'ClassDecl';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_28 = \null;
	do {
		if (($subres = $this->literal('class')) !== \false) { $result["text"] .= $subres; }
		else { $_28 = \false; break; }
		if (($subres = $this->rx('/\s+/')) !== \false) { $result["text"] .= $subres; }
		else { $_28 = \false; break; }
		$key = 'match_'.'Identifier'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_28 = \false; break; }
		$res_23 = $result;
		$pos_23 = $this->pos;
		$key = 'match_'.'Inheritance'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else {
			$result = $res_23;
			$this->setPos($pos_23);
			unset($res_23, $pos_23);
		}
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_28 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '{') {
			$this->addPos(1);
			$result["text"] .= '{';
		}
		else { $_28 = \false; break; }
		$key = 'match_'.'ClassBody'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_28 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '}') {
			$this->addPos(1);
			$result["text"] .= '}';
		}
		else { $_28 = \false; break; }
		$_28 = \true; break;
	}
	while(\false);
	if($_28 === \true) { return $this->finalise($result); }
	if($_28 === \false) { return \false; }
}


/* Inheritance: /\s+/ "inherits" /\s+/ "from" /\s+/ Identifier */
protected $match_Inheritance_typestack = ['Inheritance'];
function match_Inheritance($stack = []) {
	$matchrule = 'Inheritance';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_36 = \null;
	do {
		if (($subres = $this->rx('/\s+/')) !== \false) { $result["text"] .= $subres; }
		else { $_36 = \false; break; }
		if (($subres = $this->literal('inherits')) !== \false) { $result["text"] .= $subres; }
		else { $_36 = \false; break; }
		if (($subres = $this->rx('/\s+/')) !== \false) { $result["text"] .= $subres; }
		else { $_36 = \false; break; }
		if (($subres = $this->literal('from')) !== \false) { $result["text"] .= $subres; }
		else { $_36 = \false; break; }
		if (($subres = $this->rx('/\s+/')) !== \false) { $result["text"] .= $subres; }
		else { $_36 = \false; break; }
		$key = 'match_'.'Identifier'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_36 = \false; break; }
		$_36 = \true; break;
	}
	while(\false);
	if($_36 === \true) { return $this->finalise($result); }
	if($_36 === \false) { return \false; }
}


/* ClassBody: ( PropertyDecl | /\s+/ )* */
protected $match_ClassBody_typestack = ['ClassBody'];
function match_ClassBody($stack = []) {
	$matchrule = 'ClassBody';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	while (\true) {
		$res_44 = $result;
		$pos_44 = $this->pos;
		$_43 = \null;
		do {
			$_41 = \null;
			do {
				$res_38 = $result;
				$pos_38 = $this->pos;
				$key = 'match_'.'PropertyDecl'; $pos = $this->pos;
				$subres = $this->packhas($key, $pos)
					? $this->packread($key, $pos)
					: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
				if ($subres !== \false) {
					$this->store($result, $subres);
					$_41 = \true; break;
				}
				$result = $res_38;
				$this->setPos($pos_38);
				if (($subres = $this->rx('/\s+/')) !== \false) {
					$result["text"] .= $subres;
					$_41 = \true; break;
				}
				$result = $res_38;
				$this->setPos($pos_38);
				$_41 = \false; break;
			}
			while(\false);
			if($_41 === \false) { $_43 = \false; break; }
			$_43 = \true; break;
		}
		while(\false);
		if($_43 === \false) {
			$result = $res_44;
			$this->setPos($pos_44);
			unset($res_44, $pos_44);
			break;
		}
	}
	return $this->finalise($result);
}


/* PropertyDecl: /(\s*)/ DataType /\s+/ Identifier /(\s*)/ ";" /(\s*)/ */
protected $match_PropertyDecl_typestack = ['PropertyDecl'];
function match_PropertyDecl($stack = []) {
	$matchrule = 'PropertyDecl';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_52 = \null;
	do {
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_52 = \false; break; }
		$key = 'match_'.'DataType'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_52 = \false; break; }
		if (($subres = $this->rx('/\s+/')) !== \false) { $result["text"] .= $subres; }
		else { $_52 = \false; break; }
		$key = 'match_'.'Identifier'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_52 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_52 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === ';') {
			$this->addPos(1);
			$result["text"] .= ';';
		}
		else { $_52 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_52 = \false; break; }
		$_52 = \true; break;
	}
	while(\false);
	if($_52 === \true) { return $this->finalise($result); }
	if($_52 === \false) { return \false; }
}


/* ObjectDecl: "object" /\s+/ Identifier /(\s*)/ ":" /(\s*)/ Identifier /(\s*)/ "{" ObjectBody "}" */
protected $match_ObjectDecl_typestack = ['ObjectDecl'];
function match_ObjectDecl($stack = []) {
	$matchrule = 'ObjectDecl';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_65 = \null;
	do {
		if (($subres = $this->literal('object')) !== \false) { $result["text"] .= $subres; }
		else { $_65 = \false; break; }
		if (($subres = $this->rx('/\s+/')) !== \false) { $result["text"] .= $subres; }
		else { $_65 = \false; break; }
		$key = 'match_'.'Identifier'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_65 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_65 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === ':') {
			$this->addPos(1);
			$result["text"] .= ':';
		}
		else { $_65 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_65 = \false; break; }
		$key = 'match_'.'Identifier'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_65 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_65 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '{') {
			$this->addPos(1);
			$result["text"] .= '{';
		}
		else { $_65 = \false; break; }
		$key = 'match_'.'ObjectBody'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_65 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '}') {
			$this->addPos(1);
			$result["text"] .= '}';
		}
		else { $_65 = \false; break; }
		$_65 = \true; break;
	}
	while(\false);
	if($_65 === \true) { return $this->finalise($result); }
	if($_65 === \false) { return \false; }
}


/* ObjectBody: ( PropertyAssign | /\s+/ )* */
protected $match_ObjectBody_typestack = ['ObjectBody'];
function match_ObjectBody($stack = []) {
	$matchrule = 'ObjectBody';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	while (\true) {
		$res_73 = $result;
		$pos_73 = $this->pos;
		$_72 = \null;
		do {
			$_70 = \null;
			do {
				$res_67 = $result;
				$pos_67 = $this->pos;
				$key = 'match_'.'PropertyAssign'; $pos = $this->pos;
				$subres = $this->packhas($key, $pos)
					? $this->packread($key, $pos)
					: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
				if ($subres !== \false) {
					$this->store($result, $subres);
					$_70 = \true; break;
				}
				$result = $res_67;
				$this->setPos($pos_67);
				if (($subres = $this->rx('/\s+/')) !== \false) {
					$result["text"] .= $subres;
					$_70 = \true; break;
				}
				$result = $res_67;
				$this->setPos($pos_67);
				$_70 = \false; break;
			}
			while(\false);
			if($_70 === \false) { $_72 = \false; break; }
			$_72 = \true; break;
		}
		while(\false);
		if($_72 === \false) {
			$result = $res_73;
			$this->setPos($pos_73);
			unset($res_73, $pos_73);
			break;
		}
	}
	return $this->finalise($result);
}


/* PropertyAssign: /(\s*)/ Identifier /(\s*)/ "=" /(\s*)/ Value /(\s*)/ ";" /(\s*)/ */
protected $match_PropertyAssign_typestack = ['PropertyAssign'];
function match_PropertyAssign($stack = []) {
	$matchrule = 'PropertyAssign';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_83 = \null;
	do {
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_83 = \false; break; }
		$key = 'match_'.'Identifier'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_83 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_83 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '=') {
			$this->addPos(1);
			$result["text"] .= '=';
		}
		else { $_83 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_83 = \false; break; }
		$key = 'match_'.'Value'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_83 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_83 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === ';') {
			$this->addPos(1);
			$result["text"] .= ';';
		}
		else { $_83 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_83 = \false; break; }
		$_83 = \true; break;
	}
	while(\false);
	if($_83 === \true) { return $this->finalise($result); }
	if($_83 === \false) { return \false; }
}


/* RuleDecl: "rule" /\s+/ Identifier /(\s*)/ "{" /(\s*)/ "if" /(\s*)/ "(" /(\s*)/ Condition /(\s*)/ ")" /(\s*)/ "{" /(\s*)/ Action /(\s*)/ "}" /(\s*)/ "}" */
protected $match_RuleDecl_typestack = ['RuleDecl'];
function match_RuleDecl($stack = []) {
	$matchrule = 'RuleDecl';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_106 = \null;
	do {
		if (($subres = $this->literal('rule')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/\s+/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		$key = 'match_'.'Identifier'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '{') {
			$this->addPos(1);
			$result["text"] .= '{';
		}
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (($subres = $this->literal('if')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '(') {
			$this->addPos(1);
			$result["text"] .= '(';
		}
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		$key = 'match_'.'Condition'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === ')') {
			$this->addPos(1);
			$result["text"] .= ')';
		}
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '{') {
			$this->addPos(1);
			$result["text"] .= '{';
		}
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		$key = 'match_'.'Action'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '}') {
			$this->addPos(1);
			$result["text"] .= '}';
		}
		else { $_106 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_106 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '}') {
			$this->addPos(1);
			$result["text"] .= '}';
		}
		else { $_106 = \false; break; }
		$_106 = \true; break;
	}
	while(\false);
	if($_106 === \true) { return $this->finalise($result); }
	if($_106 === \false) { return \false; }
}


/* Condition: Expr /(\s*)/ CompOp /(\s*)/ Expr */
protected $match_Condition_typestack = ['Condition'];
function match_Condition($stack = []) {
	$matchrule = 'Condition';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_113 = \null;
	do {
		$key = 'match_'.'Expr'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_113 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_113 = \false; break; }
		$key = 'match_'.'CompOp'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_113 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_113 = \false; break; }
		$key = 'match_'.'Expr'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_113 = \false; break; }
		$_113 = \true; break;
	}
	while(\false);
	if($_113 === \true) { return $this->finalise($result); }
	if($_113 === \false) { return \false; }
}


/* Action: Expr /(\s*)/ "=" /(\s*)/ Expr /(\s*)/ ";" */
protected $match_Action_typestack = ['Action'];
function match_Action($stack = []) {
	$matchrule = 'Action';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_122 = \null;
	do {
		$key = 'match_'.'Expr'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_122 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_122 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === '=') {
			$this->addPos(1);
			$result["text"] .= '=';
		}
		else { $_122 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_122 = \false; break; }
		$key = 'match_'.'Expr'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_122 = \false; break; }
		if (($subres = $this->rx('/(\s*)/')) !== \false) { $result["text"] .= $subres; }
		else { $_122 = \false; break; }
		if (\substr($this->string, $this->pos, 1) === ';') {
			$this->addPos(1);
			$result["text"] .= ';';
		}
		else { $_122 = \false; break; }
		$_122 = \true; break;
	}
	while(\false);
	if($_122 === \true) { return $this->finalise($result); }
	if($_122 === \false) { return \false; }
}


/* Expr: DottedName | Value */
protected $match_Expr_typestack = ['Expr'];
function match_Expr($stack = []) {
	$matchrule = 'Expr';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_127 = \null;
	do {
		$res_124 = $result;
		$pos_124 = $this->pos;
		$key = 'match_'.'DottedName'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) {
			$this->store($result, $subres);
			$_127 = \true; break;
		}
		$result = $res_124;
		$this->setPos($pos_124);
		$key = 'match_'.'Value'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) {
			$this->store($result, $subres);
			$_127 = \true; break;
		}
		$result = $res_124;
		$this->setPos($pos_124);
		$_127 = \false; break;
	}
	while(\false);
	if($_127 === \true) { return $this->finalise($result); }
	if($_127 === \false) { return \false; }
}


/* DottedName: Identifier ( "." Identifier )* */
protected $match_DottedName_typestack = ['DottedName'];
function match_DottedName($stack = []) {
	$matchrule = 'DottedName';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_134 = \null;
	do {
		$key = 'match_'.'Identifier'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_134 = \false; break; }
		while (\true) {
			$res_133 = $result;
			$pos_133 = $this->pos;
			$_132 = \null;
			do {
				if (\substr($this->string, $this->pos, 1) === '.') {
					$this->addPos(1);
					$result["text"] .= '.';
				}
				else { $_132 = \false; break; }
				$key = 'match_'.'Identifier'; $pos = $this->pos;
				$subres = $this->packhas($key, $pos)
					? $this->packread($key, $pos)
					: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
				if ($subres !== \false) { $this->store($result, $subres); }
				else { $_132 = \false; break; }
				$_132 = \true; break;
			}
			while(\false);
			if($_132 === \false) {
				$result = $res_133;
				$this->setPos($pos_133);
				unset($res_133, $pos_133);
				break;
			}
		}
		$_134 = \true; break;
	}
	while(\false);
	if($_134 === \true) { return $this->finalise($result); }
	if($_134 === \false) { return \false; }
}


/* Value: StringLit | Number | Bool | Identifier */
protected $match_Value_typestack = ['Value'];
function match_Value($stack = []) {
	$matchrule = 'Value';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_147 = \null;
	do {
		$res_136 = $result;
		$pos_136 = $this->pos;
		$key = 'match_'.'StringLit'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) {
			$this->store($result, $subres);
			$_147 = \true; break;
		}
		$result = $res_136;
		$this->setPos($pos_136);
		$_145 = \null;
		do {
			$res_138 = $result;
			$pos_138 = $this->pos;
			$key = 'match_'.'Number'; $pos = $this->pos;
			$subres = $this->packhas($key, $pos)
				? $this->packread($key, $pos)
				: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
			if ($subres !== \false) {
				$this->store($result, $subres);
				$_145 = \true; break;
			}
			$result = $res_138;
			$this->setPos($pos_138);
			$_143 = \null;
			do {
				$res_140 = $result;
				$pos_140 = $this->pos;
				$key = 'match_'.'Bool'; $pos = $this->pos;
				$subres = $this->packhas($key, $pos)
					? $this->packread($key, $pos)
					: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
				if ($subres !== \false) {
					$this->store($result, $subres);
					$_143 = \true; break;
				}
				$result = $res_140;
				$this->setPos($pos_140);
				$key = 'match_'.'Identifier'; $pos = $this->pos;
				$subres = $this->packhas($key, $pos)
					? $this->packread($key, $pos)
					: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
				if ($subres !== \false) {
					$this->store($result, $subres);
					$_143 = \true; break;
				}
				$result = $res_140;
				$this->setPos($pos_140);
				$_143 = \false; break;
			}
			while(\false);
			if($_143 === \true) { $_145 = \true; break; }
			$result = $res_138;
			$this->setPos($pos_138);
			$_145 = \false; break;
		}
		while(\false);
		if($_145 === \true) { $_147 = \true; break; }
		$result = $res_136;
		$this->setPos($pos_136);
		$_147 = \false; break;
	}
	while(\false);
	if($_147 === \true) { return $this->finalise($result); }
	if($_147 === \false) { return \false; }
}


/* StringLit: /"[^"]*"/ */
protected $match_StringLit_typestack = ['StringLit'];
function match_StringLit($stack = []) {
	$matchrule = 'StringLit';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	if (($subres = $this->rx('/"[^"]*"/')) !== \false) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return \false; }
}


/* Number: /[0-9]+(\.[0-9]+)?/ */
protected $match_Number_typestack = ['Number'];
function match_Number($stack = []) {
	$matchrule = 'Number';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	if (($subres = $this->rx('/[0-9]+(\.[0-9]+)?/')) !== \false) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return \false; }
}


/* Bool: "true" | "false" */
protected $match_Bool_typestack = ['Bool'];
function match_Bool($stack = []) {
	$matchrule = 'Bool';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_154 = \null;
	do {
		$res_151 = $result;
		$pos_151 = $this->pos;
		if (($subres = $this->literal('true')) !== \false) {
			$result["text"] .= $subres;
			$_154 = \true; break;
		}
		$result = $res_151;
		$this->setPos($pos_151);
		if (($subres = $this->literal('false')) !== \false) {
			$result["text"] .= $subres;
			$_154 = \true; break;
		}
		$result = $res_151;
		$this->setPos($pos_151);
		$_154 = \false; break;
	}
	while(\false);
	if($_154 === \true) { return $this->finalise($result); }
	if($_154 === \false) { return \false; }
}


/* CompOp: ">=" | "<=" | "==" | "!=" | ">" | "<" */
protected $match_CompOp_typestack = ['CompOp'];
function match_CompOp($stack = []) {
	$matchrule = 'CompOp';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_175 = \null;
	do {
		$res_156 = $result;
		$pos_156 = $this->pos;
		if (($subres = $this->literal('>=')) !== \false) {
			$result["text"] .= $subres;
			$_175 = \true; break;
		}
		$result = $res_156;
		$this->setPos($pos_156);
		$_173 = \null;
		do {
			$res_158 = $result;
			$pos_158 = $this->pos;
			if (($subres = $this->literal('<=')) !== \false) {
				$result["text"] .= $subres;
				$_173 = \true; break;
			}
			$result = $res_158;
			$this->setPos($pos_158);
			$_171 = \null;
			do {
				$res_160 = $result;
				$pos_160 = $this->pos;
				if (($subres = $this->literal('==')) !== \false) {
					$result["text"] .= $subres;
					$_171 = \true; break;
				}
				$result = $res_160;
				$this->setPos($pos_160);
				$_169 = \null;
				do {
					$res_162 = $result;
					$pos_162 = $this->pos;
					if (($subres = $this->literal('!=')) !== \false) {
						$result["text"] .= $subres;
						$_169 = \true; break;
					}
					$result = $res_162;
					$this->setPos($pos_162);
					$_167 = \null;
					do {
						$res_164 = $result;
						$pos_164 = $this->pos;
						if (\substr($this->string, $this->pos, 1) === '>') {
							$this->addPos(1);
							$result["text"] .= '>';
							$_167 = \true; break;
						}
						$result = $res_164;
						$this->setPos($pos_164);
						if (\substr($this->string, $this->pos, 1) === '<') {
							$this->addPos(1);
							$result["text"] .= '<';
							$_167 = \true; break;
						}
						$result = $res_164;
						$this->setPos($pos_164);
						$_167 = \false; break;
					}
					while(\false);
					if($_167 === \true) { $_169 = \true; break; }
					$result = $res_162;
					$this->setPos($pos_162);
					$_169 = \false; break;
				}
				while(\false);
				if($_169 === \true) { $_171 = \true; break; }
				$result = $res_160;
				$this->setPos($pos_160);
				$_171 = \false; break;
			}
			while(\false);
			if($_171 === \true) { $_173 = \true; break; }
			$result = $res_158;
			$this->setPos($pos_158);
			$_173 = \false; break;
		}
		while(\false);
		if($_173 === \true) { $_175 = \true; break; }
		$result = $res_156;
		$this->setPos($pos_156);
		$_175 = \false; break;
	}
	while(\false);
	if($_175 === \true) { return $this->finalise($result); }
	if($_175 === \false) { return \false; }
}


/* DataType: SimpleType */
protected $match_DataType_typestack = ['DataType'];
function match_DataType($stack = []) {
	$matchrule = 'DataType';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$key = 'match_'.'SimpleType'; $pos = $this->pos;
	$subres = $this->packhas($key, $pos)
		? $this->packread($key, $pos)
		: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
	if ($subres !== \false) {
		$this->store($result, $subres);
		return $this->finalise($result);
	}
	else { return \false; }
}


/* SimpleType: "string" | "integer" | "float" | "boolean" */
protected $match_SimpleType_typestack = ['SimpleType'];
function match_SimpleType($stack = []) {
	$matchrule = 'SimpleType';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_189 = \null;
	do {
		$res_178 = $result;
		$pos_178 = $this->pos;
		if (($subres = $this->literal('string')) !== \false) {
			$result["text"] .= $subres;
			$_189 = \true; break;
		}
		$result = $res_178;
		$this->setPos($pos_178);
		$_187 = \null;
		do {
			$res_180 = $result;
			$pos_180 = $this->pos;
			if (($subres = $this->literal('integer')) !== \false) {
				$result["text"] .= $subres;
				$_187 = \true; break;
			}
			$result = $res_180;
			$this->setPos($pos_180);
			$_185 = \null;
			do {
				$res_182 = $result;
				$pos_182 = $this->pos;
				if (($subres = $this->literal('float')) !== \false) {
					$result["text"] .= $subres;
					$_185 = \true; break;
				}
				$result = $res_182;
				$this->setPos($pos_182);
				if (($subres = $this->literal('boolean')) !== \false) {
					$result["text"] .= $subres;
					$_185 = \true; break;
				}
				$result = $res_182;
				$this->setPos($pos_182);
				$_185 = \false; break;
			}
			while(\false);
			if($_185 === \true) { $_187 = \true; break; }
			$result = $res_180;
			$this->setPos($pos_180);
			$_187 = \false; break;
		}
		while(\false);
		if($_187 === \true) { $_189 = \true; break; }
		$result = $res_178;
		$this->setPos($pos_178);
		$_189 = \false; break;
	}
	while(\false);
	if($_189 === \true) { return $this->finalise($result); }
	if($_189 === \false) { return \false; }
}


/* Identifier: /[a-zA-Z_][a-zA-Z0-9_]* / */
protected $match_Identifier_typestack = ['Identifier'];
function match_Identifier($stack = []) {
	$matchrule = 'Identifier';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	if (($subres = $this->rx('/[a-zA-Z_][a-zA-Z0-9_]* /')) !== \false) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return \false; }
}


/* Comment: /\/\/[^\n]*\n?/ */
protected $match_Comment_typestack = ['Comment'];
function match_Comment($stack = []) {
	$matchrule = 'Comment';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	if (($subres = $this->rx('/\/\/[^\n]*\n?/')) !== \false) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return \false; }
}




function Program__finalise(&$result) {
    $statements = array();

    if (is_array($result)) {
        foreach ($result as $item) {
            if ($item && is_array($item) && isset($item['type'])) {
                $statements[] = $item;
            }
        }
    }

    return array(
        'type' => 'Program',
        'statements' => $statements
    );
}

function ClassDecl__finalise(&$result) {
    // Simple text parsing as fallback
    $text = $result['text'] ?? '';

    if (preg_match('/class\s+(\w+)/', $text, $matches)) {
        $className = $matches[1];
    } else {
        $className = 'Unknown';
    }

    $parentClass = null;
    if (preg_match('/inherits\s+from\s+(\w+)/', $text, $matches)) {
        $parentClass = $matches[1];
    }

    // Extract properties
    $properties = array();
    if (preg_match_all('/(\w+)\s+(\w+)(\s*);/', $text, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $properties[] = array(
                'type' => 'PropertyDeclaration',
                'dataType' => $match[1],
                'name' => $match[2]
            );
        }
    }

    return array(
        'type' => 'ClassDeclaration',
        'name' => $className,
        'parentClass' => $parentClass,
        'properties' => $properties
    );
}

function ObjectDecl__finalise(&$result) {
    $text = $result['text'] ?? '';

    $objectName = 'Unknown';
    $className = 'Unknown';

    if (preg_match('/object\s+(\w+)(\s*):(\s*)(\w+)/', $text, $matches)) {
        $objectName = $matches[1];
        $className = $matches[2];
    }

    // Extract property assignments
    $properties = array();
    if (preg_match_all('/(\w+)(\s*)=(\s*)([^;]+);/', $text, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $value = $this->parseValueFromText(trim($match[2]));
            $properties[] = array(
                'type' => 'PropertyAssignment',
                'name' => $match[1],
                'value' => $value
            );
        }
    }

    return array(
        'type' => 'ObjectDeclaration',
        'name' => $objectName,
        'className' => $className,
        'properties' => $properties
    );
}

function RuleDecl__finalise(&$result) {
    $text = $result['text'] ?? '';

    $ruleName = 'Unknown';
    if (preg_match('/rule\s+(\w+)/', $text, $matches)) {
        $ruleName = $matches[1];
    }

    // Extract condition and action
    $condition = array();
    $action = array();

    if (preg_match('/if(\s*)\((\s*)([^)]+)\)/', $text, $matches)) {
        $conditionText = trim($matches[1]);
        if (preg_match('/([^<>=!]+)(\s*)(>=|<=|==|!=|>|<)(\s*)(.+)/', $conditionText, $condMatches)) {
            $condition = array(
                'type' => 'Comparison',
                'left' => $this->parseExpressionFromText(trim($condMatches[1])),
                'operator' => $condMatches[2],
                'right' => $this->parseExpressionFromText(trim($condMatches[3]))
            );
        }
    }

    if (preg_match('/\{(\s*)([^}]+)(\s*)\}(\s*)\}/', $text, $matches)) {
        $actionText = trim($matches[1]);
        if (preg_match('/([^=]+)(\s*)=(\s*)([^;]+);/', $actionText, $actMatches)) {
            $action = array(
                'type' => 'Assignment',
                'target' => $this->parseExpressionFromText(trim($actMatches[1])),
                'value' => $this->parseExpressionFromText(trim($actMatches[2]))
            );
        }
    }

    return array(
        'type' => 'RuleDeclaration',
        'name' => $ruleName,
        'condition' => $condition,
        'action' => $action
    );
}

function parseValueFromText($text) {
    $text = trim($text);

    // String literal
    if (preg_match('/^"([^"]*)"$/', $text, $matches)) {
        return array(
            'type' => 'StringLiteral',
            'value' => $matches[1]
        );
    }

    // Number
    if (preg_match('/^[0-9]+(\.[0-9]+)?$/', $text)) {
        $isFloat = strpos($text, '.') !== false;
        return array(
            'type' => $isFloat ? 'FloatLiteral' : 'IntegerLiteral',
            'value' => $isFloat ? (float)$text : (int)$text
        );
    }

    // Boolean
    if ($text === 'true' || $text === 'false') {
        return array(
            'type' => 'BooleanLiteral',
            'value' => $text === 'true'
        );
    }

    // Identifier
    return array(
        'type' => 'Identifier',
        'name' => $text
    );
}

function parseExpressionFromText($text) {
    $text = trim($text);

    // Check for dotted name
    if (strpos($text, '.') !== false) {
        $parts = explode('.', $text);
        $parts = array_map('trim', $parts);
        return array(
            'type' => 'ChainedExpression',
            'parts' => $parts
        );
    }

    // Try to parse as value first
    $value = $this->parseValueFromText($text);
    if ($value['type'] !== 'Identifier') {
        return $value;
    }

    // Return as identifier
    return array(
        'type' => 'Identifier',
        'name' => $text
    );
}

}
?>