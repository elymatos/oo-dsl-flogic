# F-Logic ErgoAI DSL Parser

A PHP-based parser and translator for converting Object-Oriented Domain Specific Language (OODSL) to F-Logic ErgoAI syntax using **smuuf/php-peg** - the modern, PHP 8.4 compatible PEG parser.

## Features

- **Class declarations** with inheritance
- **Object instantiation** with property assignments
- **Method signatures** and implementations
- **Rule definitions** with complex conditions
- **Collection types** (set, list) with cardinality constraints
- **Chained property access** (Person.spouse.age)
- **Boolean expressions** with AND/OR logic
- **Method calls** with parameters
- **PHP 8.4 compatible** using smuuf/php-peg

## Installation

1. **Clone the repository:**
```bash
git clone <repository-url>
cd flogic-dsl-parser
```

2. **Install dependencies:**
```bash
composer install
```

3. **Generate the parser:**
```bash
composer run generate-parser
```

4. **Test the parser:**
```bash
composer run test-parser
```

## Usage

### Basic Example

```php
<?php
require_once 'vendor/autoload.php';

use FLogicDSL\Parser\OODSLParser;
use FLogicDSL\Translator\FLogicTranslator;

$dslCode = '
class Person {
    string name;
    integer age;
}

object John : Person {
    name = "John Doe";
    age = 30;
}

rule Adult {
    if (Person.age >= 18) {
        Person.isAdult = true;
    }
}
';

// Parse the DSL using smuuf/php-peg
$parser = new OODSLParser();
$ast = $parser->parse($dslCode);

if ($ast) {
    echo "Parsing successful!\n";
    print_r($ast);
    
    // Translate to F-Logic (when AST integration is complete)
    // $translator = new FLogicTranslator();
    // $flogicCode = $translator->translate($ast);
    // echo $flogicCode;
} else {
    echo "Parsing failed!";
}
```

### Command Line Testing

```bash
# Test the parser with built-in examples
composer run test-parser

# Generate parser from grammar
composer run generate-parser

# Run unit tests
composer run test
```

## Technical Details

### PEG Library: smuuf/php-peg

This project uses **smuuf/php-peg** which is:
- ✅ **PHP 8.4 compatible** - No deprecation warnings
- ✅ **Actively maintained** - Updated fork of hafriedlander/php-peg
- ✅ **Modern PHP features** - Uses current PHP syntax and features
- ✅ **Better error handling** - Improved debugging and error reporting

### Grammar Definition

The grammar is defined using smuuf/php-peg's array-based syntax in `src/Grammar/OODSLGrammar.peg`:

```php
protected const GRAMMAR = [
    'Program' => [
        'rule' => '(Statement)*',
        'handler' => 'handleProgram'
    ],
    'ClassDeclaration' => [
        'rule' => '"class" _ name:Identifier inheritance:InheritanceClause? __ "{" __ body:ClassBody __ "}"',
        'handler' => 'handleClassDeclaration'
    ],
    // ... more rules
];
```

### Parser Generation

The parser generation process:

1. **Primary Method**: Uses smuuf/php-peg to generate from grammar
2. **Fallback Method**: Creates manual recursive descent parser if PEG fails
3. **Automatic Detection**: Detects available libraries and chooses the best method

## DSL Syntax Examples

### Class Declaration
```
class Person {
    string name;
    integer age;
    boolean isActive;
}
```

### Inheritance
```
class Employee inherits from Person {
    string department;
    float salary;
}
```

### Object Declaration
```
object John : Person {
    name = "John Doe";
    age = 30;
    isActive = true;
}
```

### Collection Properties
```
class Family {
    set<Person> children;
    string surname;
}

object SmithFamily : Family {
    surname = "Smith";
    children += {alice, bob, charlie};
}
```

### Rules with Conditions
```
rule Adult {
    if (Person.age >= 18) {
        Person.isAdult = true;
    }
}

rule PowerCouple {
    if (Person.salary > 70000.0 && Person.spouse.salary > 60000.0) {
        Person.isPowerCouple = true;
    }
}
```

### Method Declarations
```
class Person {
    boolean isAdult();
    string getFullName();
}

method Person.isAdult() returns boolean {
    return this.age >= 18;
}
```

### Chained Property Access
```
rule SpouseAge {
    if (Person.spouse.age > 30) {
        Person.hasOlderSpouse = true;
    }
}
```

## F-Logic ErgoAI Output

The DSL translates to F-Logic ErgoAI syntax:

| OODSL Construct | F-Logic ErgoAI Output |
|-----------------|----------------------|
| `class Person { string name; }` | `Person[name => string].` |
| `object John : Person { name = "John"; }` | `John:Person[name -> "John"].` |
| `class Dog inherits from Animal` | `Dog::Animal.` |
| `set<Person> children` | `children *=> Person` |
| `Person.spouse.age > 30` | `?Person[spouse -> ?Spouse], ?Spouse[age -> ?Age], ?Age > 30` |
| `rule Adult { if (Person.age >= 18) { Person.isAdult = true; } }` | `@!{Adult} ?Person[isAdult -> true] :- ?Person:Person, ?Person[age -> ?Age], ?Age >= 18.` |

## Project Structure

```
flogic-dsl-parser/
├── composer.json                  # smuuf/php-peg dependency
├── README.md
├── bin/
│   ├── generate-parser.php        # Parser generator (smuuf/php-peg)
│   └── test-parser.php           # Test script
├── src/
│   ├── Grammar/
│   │   └── OODSLGrammar.peg      # PEG grammar (smuuf format)
│   ├── Parser/
│   │   ├── OODSLParser.php       # Generated/manual parser
│   │   └── ASTNode.php           # AST node classes
│   └── Translator/
│       ├── FLogicTranslator.php   # F-Logic translator
│       └── TranslationContext.php # Translation context
├── tests/
│   ├── ParserTest.php            # Parser tests
│   └── TranslatorTest.php        # Translator tests
└── examples/
    └── simple_test.oodsl         # Example DSL files
```

## PHP 8.4 Compatibility

✅ **Fully compatible with PHP 8.4**
- No deprecation warnings
- Uses modern smuuf/php-peg library
- Clean error handling
- Updated composer dependencies

## Troubleshooting

### Parser Generation Issues

The system automatically handles different scenarios:

1. **smuuf/php-peg available**: Uses modern PEG generation
2. **PEG generation fails**: Falls back to manual parser
3. **Both fail**: Provides clear error messages

### Testing Individual Components

```bash
# Test parser only
composer run test-parser

# Test with verbose output
php bin/test-parser.php

# Check parser file
ls -la src/Parser/OODSLParser.php
```

### Common Issues

1. **Composer install fails**: Ensure PHP >= 8.0
2. **Parser generation fails**: Check permissions on src/Parser/ directory
3. **Tests fail**: Run `composer run test-parser` for diagnostics

## Development

### Adding New Grammar Rules

1. Edit `src/Grammar/OODSLGrammar.peg` using smuuf/php-peg syntax
2. Add rule to `GRAMMAR` array with proper handler
3. Implement handler method in parser class
4. Regenerate: `composer run generate-parser`
5. Test: `composer run test-parser`

### smuuf/php-peg Grammar Syntax

```php
'RuleName' => [
    'rule' => 'grammar_expression',
    'handler' => 'handleRuleName'  // optional
],
```

### Adding New Translation Patterns

1. Update AST nodes if needed
2. Add visitor methods to `FLogicTranslator`
3. Update translation context
4. Add test cases

## License

MIT License - see LICENSE file for details.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Ensure PHP 8.4 compatibility
4. Add tests for new functionality
5. Submit a pull request

## Links

- [smuuf/php-peg](https://github.com/smuuf/php-peg) - Modern PEG parser for PHP
- [F-Logic ErgoAI](http://coherentknowledge.com/ergoAI/) - F-Logic reasoning system