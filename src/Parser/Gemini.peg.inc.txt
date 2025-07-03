<?php

namespace OODSLFLogic\Parser\Generated;

use hafriedlander\Peg\Parser\Basic; // Extend Parser\Basic as seen in Calculator.peg.inc [1]

/**
 * This class defines the grammar for our Command DSL.
 * It will be compiled by php-peg into a functional parser.
 */
class CommandParser extends Basic
{
    /*!* CommandGrammar
    # The top-level rule for our DSL.
    # It captures the entity, command name, and the list of values/parameters.
    # The '>' symbol indicates whitespace.
    Command : entity:Var "." command:Var _ "has" _ "{" values:Values "}"

    # Matches a collection of inputs wrapped in curly braces.
    Values : _ (value:(CompositeValue | sv:Value)) * _

    # Matches a simple value definition, e.g., "a UserId userId" or "an AppointmentDatetime appointmentDatetime".
    Value : v:(("an" | "a") _ class:Var _ param:Var _)

    # Matches a composite value definition, e.g., "a Location location from {... }".
    CompositeValue : ("an" | "a") _ class:Var _ param:Var _ "from" _ values:Values >

    # Matches an optional alias, e.g., "from location".
    Alias : _ "from" _ alias:Var >

    # Matches a variable name (alphanumeric characters and underscore).
    Var : /[A-Za-z0-9_]+/ >

    # Matches and consumes any whitespace (spaces, tabs, newlines, carriage returns).
    # This rule is used throughout the grammar to ignore spacing between tokens.
    _ : /[\s\t\n\r]* / >
    */

    function Command__finalise( &$result ) {
        $result['x']='test';
    }

    function Values__finalise( &$result ) {
        $result['y']='test';
    }

    function Value__finalise( &$result ) {
        $result['z']='test';
    }

    function CompositeValue__finalise( &$result ) {
    }

    function Alias__finalise( &$result ) {
    }

    function Var__finalise( &$result ) {
    }

}