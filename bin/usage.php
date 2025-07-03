<?php
// usage.php
use OODSLFLogic\Parser\Generated\CommandParser;

require '../vendor/autoload.php'; // Assuming Composer autoloader
require_once __DIR__. '/../src/Parser/Generated/CommandParser.php'; // Include the generated parser class

$dslInput = 'User.ScheduleAppointment has {
  a UserId userId
  an AppointmentDatetime appointmentDatetime
  a Location location from {
    a LocationName locationName from location
    a Latitude latitude
    a Longitude longitude
  }
}';

try {
    // Instantiate the generated parser with the input string
    $parser = new CommandParser($dslInput);

    // Call the top-level rule to start parsing
    $ast = $parser->match_Command();

    if ($ast!== false) {
        echo "Successfully parsed DSL. Generated AST:\n";
        echo json_encode($ast, JSON_PRETTY_PRINT). "\n";
    } else {
        echo "Failed to parse DSL.\n";
        // You can inspect $parser->error() for more details on parsing failures
    }
} catch (\Exception $e) {
    echo "An error occurred during parsing: ". $e->getMessage(). "\n";
}