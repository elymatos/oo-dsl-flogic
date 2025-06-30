# OO-DSL to F-Logic Compiler

A Domain Specific Language (DSL) that provides object-oriented syntax for F-Logic ErgoAI, making logic programming more accessible to developers familiar with OOP paradigms.

## Overview

F-Logic ErgoAI is a powerful logic programming system, but its syntax can be intimidating for developers coming from object-oriented backgrounds. This DSL provides a familiar OO-like syntax that compiles to native F-Logic code, bridging the gap between OOP and logic programming.

## Features

- **Object-Oriented Syntax**: Classes, objects, inheritance, methods, and properties
- **Type System**: Built-in primitive types and collection types with constraints
- **Inheritance**: Both structural and behavioral inheritance
- **Method Definitions**: Support for method signatures and implementations
- **Rule System**: Declarative rules with familiar if-then syntax
- **Collection Constraints**: Cardinality constraints for properties and methods
- **Comprehensive Error Handling**: Clear error messages with source location
- **CLI Interface**: Easy-to-use command-line compiler

## Installation

### Requirements

- PHP 8.0 or higher
- Composer

### Install via Composer

```bash
composer require your-org/oo-dsl-flogic
```

### Development Installation

```bash
git clone https://github.com/your-org/oo-dsl-flogic.git
cd oo-dsl-flogic
composer install
chmod +x bin/oodsl-compile
```

## Quick Start

### 1. Create a DSL file (example.oodsl)

```javascript
class Person {
    string name;
    integer age;
    boolean isVegetarian;
    
    boolean isAdult();
}

object John : Person {
    name = "John Doe";
    age = 30;
    isVegetarian = true;
}

method Person.isAdult() returns boolean {
    return this.age >= 18;
}

rule AdultVegetarian {
    if (Person.isAdult() && Person.isVegetarian) {
        Person.isHealthy = true;
    }
}
```

### 2. Compile to F-Logic

```bash
./bin/oodsl-compile example.oodsl
```

### 3. Generated F-Logic output (example.flr)

```prolog
// Generated F-Logic code from OO-DSL
// Module: main

// Class: Person
Person[|name => \string, age => \integer, isVegetarian => \boolean, isAdult() => \boolean|].

// Object: John
John:Person.
John[name -> "John Doe"].
John[age -> 30].
John[isVegetarian].

// Method implementation: Person.isAdult
?Obj:Person[isAdult() -> ?Result] :- ?Obj[age -> ?Age], ?Age >= 18.

// Rule: AdultVegetarian
@!{AdultVegetarian} ?P:Person[isHealthy] :- 
    ?P[isAdult() -> \true], 
    ?P[isVegetarian].
```

## Language Syntax

### Class Definitions

```javascript
class ClassName inherits from ParentClass {
    // Properties with types
    string propertyName;
    integer count{1..5};        // With cardinality constraint
    set<Person> children;       // Collection type
    Person spouse{0..1};        // Optional (functional)
    
    // Method signatures
    boolean methodName();
    string calculate(integer param);
}
```

### Object Creation

```javascript
object ObjectName : ClassName {
    propertyName = "value";
    count = 3;
    children += {child1, child2};  // Set addition
    spouse = otherPerson;
}
```

### Method Implementation

```javascript
method ClassName.methodName(ParamType param) returns ReturnType {
    return expression;
}
```

### Rules

```javascript
rule RuleName {
    if (condition && anotherCondition) {
        conclusion;
    }
}
```

### Inheritance

```javascript
// Full inheritance (structure + behavior)
class Employee inherits from Person {
    string employeeId;
}

// Structural inheritance only
class Student inherits structure from Person {
    string studentId;
}
```

## Type System

### Primitive Types
- `string` → `\string`
- `integer` → `\integer`
- `boolean` → `\boolean`
- `float` → `\double`

### Collection Types
- `set<Type>` → Set-valued properties
- `list<Type>` → List-valued properties

### Cardinality Constraints
- `{n}` → Exactly n values
- `{min..max}` → Between min and max values
- `{0..1}` → Optional (functional)
- `{1..*}` → At least one value

## CLI Usage

```bash
# Basic compilation
oodsl-compile input.oodsl

# Specify output file
oodsl-compile -o output.flr input.oodsl

# Enable debug output
oodsl-compile --debug input.oodsl

# Show help
oodsl-compile --help
```

## Advanced Features

### Multiple Inheritance
```javascript
class Manager inherits from Employee, Leader {
    set<Employee> directReports;
}
```

### Complex Rules
```javascript
rule PromotionCandidate {
    if (Employee.yearsOfService > 5 && 
        Employee.performanceRating >= 4.0 &&
        Employee.department == "Engineering") {
        Employee.eligibleForPromotion = true;
    }
}
```

### Method Chaining
```javascript
rule HighPerformer {
    if (Employee.getPerformanceScore() > 90 &&
        Employee.department.getBudget() > 100000) {
        Employee.isHighPerformer = true;
    }
}
```

## F-Logic Mapping

| DSL Concept | F-Logic Equivalent |
|-------------|-------------------|
| Class inheritance | `Child::Parent.` |
| Class-level signature | `Class[|method => type|].` |
| Object-level signature | `Class[method => type].` |
| Object instantiation | `object:Class.` |
| Property assignment | `object[property -> value].` |
| Method call | `object[method(args) -> result]` |
| Rule definition | `@!{RuleName} head :- body.` |

## Development

### Project Structure
```
src/
├── Parser/          # PEG grammar and parser
├── AST/            # Abstract Syntax Tree nodes
├── CodeGen/        # F-Logic code generation
├── Utils/          # Utilities and error handling
└── CLI/            # Command-line interface

tests/
├── Unit/           # Unit tests
├── Integration/    # Integration tests
└── Examples/       # Example DSL files
```

### Running Tests
```bash
composer test
```

### Code Quality
```bash
composer stan      # Static analysis
composer cs        # Code style check
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Add tests for new functionality
4. Ensure all tests pass
5. Submit a pull request

## License

MIT License - see LICENSE file for details.

## Related Projects

- [ErgoAI](http://coherentknowledge.com/): The target F-Logic reasoning system
- [smuuf/php-peg](https://github.com/smuuf/php-peg): PEG parser library for PHP

## Support

- GitHub Issues: Report bugs and request features
- Documentation: See `docs/` directory for detailed documentation
- Examples: Check `tests/Examples/` for more complex examples