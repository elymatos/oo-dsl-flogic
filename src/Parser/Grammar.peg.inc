<?php

use OODSLToFLogic\AST\*;
use OODSLToFLogic\Utils\SourceLocation;

/*!* OODSLParser

# Minimal grammar to test first
Program: Statement*
    function Program_Statement(&$result, $sub) {
        if (!isset($result['statements'])) {
            $result['statements'] = array();
        }
        if (isset($sub['result'])) {
            $result['statements'][] = $sub['result'];
        }
    }

    function Program__finalise(&$result) {
        $location = new SourceLocation(1, 1, $this->currentFilename ?? null);
        return new ProgramNode($result['statements'] ?? [], $location);
    }

Statement: ClassDefinition

# Simple Class Definition
ClassDefinition: "class" __ name:Identifier __ "{" __ "}"
    function ClassDefinition__finalise(&$result) {
        $location = new SourceLocation(1, 1);
        return new ClassNode($result['name'], null, false, [], [], $location);
    }

# Identifier
Identifier: /[a-zA-Z_][a-zA-Z0-9_]*/
    function Identifier__finalise(&$result) {
        return $this->string;
    }

# Whitespace
__: /\s*/

*/