<?php

namespace OODSLFLogic\AST;

abstract class TypeNode extends Node
{
    abstract public function getTypeName(): string;
}

