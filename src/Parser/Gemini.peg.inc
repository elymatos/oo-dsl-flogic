<?php

namespace OODSLFLogic\Parser\Generated;

use hafriedlander\Peg\Parser\Packrat;
/**
 * This class defines the grammar for our Command DSL.
 * It will be compiled by php-peg into a functional parser.
 */
class CommandParser extends Packrat
{
    /*! * CommandGrammar
    # The top-level rule for our DSL.
    # It captures the entity, command name, and the list of values/parameters.
    Command : entity:Var "." command:Var _ "has" _ "{" _ values:(CompositeValue / Value)* _ "}"

    # Matches a collection of inputs wrapped in curly braces.
    Values : "{" _ values:(CompositeValue / Value)* _ "}"

    # Matches a simple value definition, e.g., "a UserId userId" or "an AppointmentDatetime appointmentDatetime".
    Value : ("a" / "an") _ class:Var _ param:Var alias:Alias?

    # Matches a composite value definition, e.g., "a Location location from {... }".
    CompositeValue : ("a" / "an") _ class:Var _ param:Var _ "from" _ values:Values

    # Matches an optional alias, e.g., "from location".
    Alias : _ "from" _ alias:Var

    # Matches a variable name (alphanumeric characters and underscore).
    Var : /[A-Za-z0-9_]+/

    # Matches and consumes any whitespace (spaces, tabs, newlines, carriage returns).
    # This rule is used throughout the grammar to ignore spacing between tokens.
    _ : /[ \t\n\r]* /
    */
}