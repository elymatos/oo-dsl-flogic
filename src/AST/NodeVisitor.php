<?php

namespace OODSLFLogic\AST;

interface NodeVisitor
{
    public function visit(Node $node): mixed;
}