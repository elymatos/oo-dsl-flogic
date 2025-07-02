# OO-DSL for F-Logic ErgoAI

A Domain Specific Language (DSL) that provides an Object-Oriented syntax for F-Logic ErgoAI, making logic programming more accessible to developers familiar with OOP paradigms.

## Overview

This project bridges the gap between Object-Oriented Programming and F-Logic by providing a familiar syntax that compiles to F-Logic ErgoAI code. The DSL makes ErgoAI knowledge base development more intuitive while retaining all the power of F-Logic reasoning.

## Features

- **OOP-like Syntax**: Familiar class, object, and method syntax
- **Inheritance Support**: Both structural and full inheritance
- **Type System**: Strong typing with primitive and user-defined types
- **Collections**: Built-in support for sets, lists, and bags with constraints
- **Method Definitions**: Object-oriented method implementations that compile to F-Logic rules
- **Business Rules**: Intuitive rule syntax for complex logic
- **Module System**: Organized code with imports and exports
- **Semantic Analysis**: Comprehensive validation and error reporting
- **CLI Tool**: Command-line interface for compilation

## Installation

### Prerequisites

- PHP 8.0 or higher
- Composer
- ErgoAI reasoner (for running generated F-Logic code)

### Setup

1. Clone the repository:
```bash
git clone https://github.com/your-org/oo-dsl-flogic.git
cd oo-dsl-flogic
```

2. Install dependencies:
```bash
composer install
```

3. Make the CLI tool executable:
```bash
chmod +x bin/oodsl-compile
```

4. Optionally, add to your PATH:
```bash
sudo ln -s $(pwd)/bin/oodsl-compile /usr/local/bin/oodsl-compile
```

## Quick Start

### 1. Create a DSL File

Create a file `example.oodsl`:

```javascript
class Person {
    string name;
    integer age;
    boolean isAdult();
}

object John : Person {
    name = "John Doe";
    age = 30;
}

method Person.isAdult() returns boolean {
    return this.age >= 18;
}

rule AdultPerson {
    if (Person.isAdult()) {
        Person.canVote = true;
    }
}

query FindAdults {
    select Person where Person.isAdult() == true;
}
```

### 2. Compile to F-Logic

```bash
oodsl-compile example.oodsl --output example.flr
```

### 3. Generated F-Logic Output

```prolog
% Generated F-Logic code from OO-DSL
% Generated at: 2025-07-02 10:30:00

% Class definition: Person
Person::Object.
Person[|name => \string, 
       age => \integer, 
       isAdult() => \boolean|].

% Object: John
John:Person.
John[name -> "John Doe"].
John[age -> 30].

% Method implementation: Person.isAdult
?P:Person[isAdult() -> ?Result] :-
    ?P[age -> ?A],
    ?A >= 18,
    ?Result \is \true.

% Rule: AdultPerson
@!{AdultPerson}
?P:Person[canVote] :-
    ?P:Person[isAdult() -> \true].

% Query: FindAdults
?- ?P:Person[isAdult() -> \true].
```

## Language Reference

### Class Definitions

```javascript
class ClassName inherits from ParentClass {
    // Field declarations
    string fieldName;
    integer count{1..10};  // With constraints
    set<Person> children;  // Collections
    
    // Method signatures
    boolean methodName(string param);
}
```

### Inheritance Types

```javascript
// Full inheritance (structure + behavior)
class Student inherits from Person {
    string studentId;
}

// Structural inheritance only
class Employee inherits structure from Person {
    string employeeId;
}
```

### Object Instances

```javascript
object instanceName : ClassName {
    fieldName = "value";
    numericField = 42;
    booleanField = true;
    setField += {item1, item2};  // Add to set
}
```

### Method Implementations

```javascript
method ClassName.methodName(paramType paramName) returns returnType {
    // Method body
    return expression;
}
```

### Business Rules

```javascript
rule RuleName {
    if (condition && anotherCondition) {
        consequence;
    }
}
```

### Queries

```javascript
query QueryName {
    select ClassName where condition;
}
```

### Module System

```javascript
module ModuleName {
    // Module contents
    export Class1, Class2;
}

import ModuleName.{Class1, Class2};
```

## CLI Usage

### Basic Compilation

```bash
# Compile single file
oodsl-compile input.oodsl --output output.flr

# Compile directory
oodsl-compile src/ --output-dir build/

# Validate syntax only
oodsl-compile input.oodsl --validate-only
```

### Advanced Options

```bash
# Verbose output
oodsl-compile input.oodsl --verbose

# Show AST
oodsl-compile input.oodsl --ast

# Different output formats
oodsl-compile input.oodsl --format json --ast
oodsl-compile input.oodsl --format dot --ast  # GraphViz format
```

### CLI Options

| Option | Description |
|--------|-------------|
| `--output, -o` | Output file for F-Logic code |
| `--output-dir, -d` | Output directory for multiple files |
| `--module-name, -m` | Module name for generated code |
| `--validate-only` | Only validate syntax without generating code |
| `--verbose, -v` | Verbose output |
| `--ast` | Output AST instead of F-Logic code |
| `--format, -f` | Output format (flogic, json, dot) |

## Examples

### Complete Person Domain Example

See `examples/person_domain.oodsl` for a comprehensive example demonstrating:

- Class inheritance
- Object relationships
- Method implementations
- Business rules
- Complex queries
- Module organization

### Family Relationships

```javascript
class Person {
    string name;
    Person spouse;
    set<Person> children;
    set<Person> parents;
}

rule MarriedCouple {
    if (Person.spouse != null) {
        Person.isMarried = true;
        Person.spouse.isMarried = true;
    }
}

rule ParentChild {
    if (Person.children.count() > 0) {
        Person.isParent = true;
    }
}

query FindGrandparents {
    select Person where Person.children.children.count() > 0;
}
```

### Business Rules Example

```javascript
class Customer {
    string name;
    float creditScore;
    integer age;
    boolean hasLoan;
}

rule LoanEligibility {
    if (Customer.creditScore > 700 && Customer.age >= 18) {
        Customer.isEligibleForLoan = true;
    }
}

rule HighValueCustomer {
    if (Customer.creditScore > 800 && Customer.hasLoan) {
        Customer.isPremiumCustomer = true;
    }
}
```

## F-Logic Mapping

### Key Translation Patterns

| DSL Construct | F-Logic Output |
|---------------|----------------|
| `class Person` | `Person::Object.` |
| `string name;` | `name => \string` |
| `Person spouse;` | `spouse => Person` |
| `set<Person> children;` | `children{0..*} => Person` |
| `object John : Person` | `John:Person.` |
| `name = "John";` | `John[name -> "John"].` |
| `isVegetarian = true;` | `John[isVegetarian].` |
| Method call | Frame access with variables |
| Business rules | Named rules with `@!{RuleName}` |

## Development

### Project Structure

```
oo-dsl-flogic/
├── src/
│   ├── Parser/           # Grammar and parsing
│   ├── AST/             # Abstract Syntax Tree nodes
│   ├── CodeGen/         # F-Logic code generation
│   ├── Analysis/        # Semantic analysis
│   ├── Utils/           # Utility classes
│   └── CLI/             # Command-line interface
├── tests/               # Unit and integration tests
├── examples/            # Example DSL files
├── bin/                 # Executable scripts
└── docs/               # Documentation
```

### Grammar Development

The grammar is defined in `src/Parser/Grammar.peg` using the php-peg syntax. To modify the language:

1. Edit the grammar file
2. Run `composer compile-grammar` to regenerate the parser
3. Update the AST nodes if needed
4. Update the code generator for new constructs

### Running Tests

```bash
# Run all tests
composer test

# Run with coverage
phpunit --coverage-html coverage/

# Check coding standards
composer cs-check

# Fix coding standards
composer cs-fix
```

## Integration with ErgoAI

### Using Generated F-Logic

1. Compile your DSL file:
```bash
oodsl-compile domain.oodsl --output domain.flr
```

2. Load in ErgoAI:
```prolog
?- [domain].
```

3. Query the knowledge base:
```prolog
?- ?X:Person[isAdult() -> \true].
```

### ErgoAI Studio Integration

The generated F-Logic files are compatible with ErgoAI Studio for:
- Interactive development
- Debugging
- Query testing
- Knowledge base exploration

## Advanced Features

### Type Constraints

```javascript
class Family {
    set<Person>{2..10} members;     // 2 to 10 members
    Person{1..2} parents;           // 1 or 2 parents
    list<Person> children;          // Ordered children
}
```

### Complex Expressions

```javascript
method Person.calculateBMI(float weight, float height) returns float {
    return weight / (height * height);
}

rule HealthyPerson {
    if (Person.calculateBMI(Person.weight, Person.height) >= 18.5 && 
        Person.calculateBMI(Person.weight, Person.height) <= 24.9) {
        Person.isHealthy = true;
    }
}
```

### Aggregations

```javascript
rule LargeFamily {
    if (Person.children.count() > 3) {
        Person.hasLargeFamily = true;
    }
}
```

## Troubleshooting

### Common Issues

1. **Parse Errors**: Check syntax against the grammar reference
2. **Semantic Errors**: Ensure all referenced classes and fields are defined
3. **Type Errors**: Verify type compatibility in assignments and method calls

### Debug Mode

Use verbose mode for detailed error information:

```bash
oodsl-compile problematic.oodsl --verbose
```

### Error Messages

The compiler provides detailed error messages with:
- File location (line and column)
- Context around the error
- Suggested fixes when possible

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass
6. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- ErgoAI team for the excellent F-Logic reasoner
- php-peg library for grammar parsing capabilities
- The F-Logic research community

## Support

- **Documentation**: See the `docs/` directory
- **Examples**: Check the `examples/` directory
- **Issues**: Report bugs on GitHub
- **Discussions**: Use GitHub Discussions for questions