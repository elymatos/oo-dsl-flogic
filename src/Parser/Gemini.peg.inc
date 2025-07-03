<?php

namespace OODSLFLogic\Parser\Generated;

use hafriedlander\Peg\Parser\Packrat;
/**
 * This class defines the grammar for our Command DSL.
 * It will be compiled by php-peg into a functional parser.
 */
class CommandParser extends Packrat
{
    /*!* CommandGrammar
    # The top-level rule for our DSL.
    # It captures the entity, command name, and the list of values/parameters.
    Command : entity:Var "." command:Var _ "has" _ "{" _ values:(CompositeValue / Value)* _ "}"
        {
        // This attached function is executed when the 'Command' rule successfully matches.
        // The named sub-expressions (entity, command, values) are available as variables.
        // We construct the main AST object here.
        return [
            'entity' => $entity,
            'command' => $command,
            'values' => $values,
        ];
        }

    # Matches a collection of inputs wrapped in curly braces.
    Values : "{" _ values:(CompositeValue / Value)* _ "}"
    {
        // This function simply returns the array of parsed values.
        // The (CompositeValue / Value)* part ensures we get an array of matched items.
        return $values;
    }

    # Matches a simple value definition, e.g., "a UserId userId" or "an AppointmentDatetime appointmentDatetime".
    Value : ("a" / "an") _ class:Var _ param:Var alias:Alias?
    {
        // Constructs an associative array for a single value entry in the AST.
        // 'alias' will be null if the 'Alias?' (optional) rule doesn't match.
        return [
            'class' => $class,
            'param' => $param,
            'alias' => $alias,
            'type' => 'value',
        ];
    }

    # Matches a composite value definition, e.g., "a Location location from {... }".
    CompositeValue : ("a" / "an") _ class:Var _ param:Var _ "from" _ values:Values
    {
        // Constructs an associative array for a composite value entry.
        // It includes the nested 'values' array from the 'Values' rule.
        return [
            'class' => $class,
            'param' => $param,
            'type' => 'composite',
            'values' => $values,
        ];
    }

    # Matches an optional alias, e.g., "from location".
    Alias : _ "from" _ alias:Var
    {
        // Returns the alias string directly.
        return $alias;
    }

    # Matches a variable name (alphanumeric characters and underscore).
    Var : /[A-Za-z0-9_]+/
    {
        // For simple regex matches, $this->text contains the matched string.
        // We return it directly to be used as the value for 'entity', 'command', 'class', 'param', or 'alias'.
        return $this->text;
    }

    # Matches and consumes any whitespace (spaces, tabs, newlines, carriage returns).
    # This rule is used throughout the grammar to ignore spacing between tokens.
    _ : /[ \t\n\r]* /
{
    // Returning null ensures that whitespace doesn't appear in the final AST.
return null;
}
*/
}