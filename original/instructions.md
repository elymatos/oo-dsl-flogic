# Setup and Installation Guide

## Complete System Setup

You now have a complete OO-DSL to F-Logic compiler system! Here's how to set it up and get it running:

### 1. Create Project Directory

```bash
mkdir oo-dsl-flogic
cd oo-dsl-flogic
```

### 2. Initialize Composer

```bash
composer init
# Follow the prompts or use the composer.json provided
```

### 3. Install Dependencies

```bash
composer require smuuf/php-peg
composer require --dev phpunit/phpunit phpstan/phpstan squizlabs/php_codesniffer
```

### 4. Create Directory Structure

```bash
# Create all directories
mkdir -p src/{Parser,AST,CodeGen,Analysis,Utils,CLI}
mkdir -p bin
mkdir -p tests/{Unit,Integration,Examples}
mkdir -p docs

# Make bin executable
chmod +x bin/oodsl-compile
```

### 5. Copy All Files

Copy each of the provided files to their respective locations:

- `composer.json` → project root
- `README.md` → project root
- All PHP classes → `src/` subdirectories
- `Grammar.peg` → `src/Parser/`
- `oodsl-compile` → `bin/`
- Example files → `tests/Examples/`
- Test files → `tests/Unit/`

### 6. Update Composer Autoloader

```bash
composer dump-autoload
```

### 7. Test the Installation

```bash
# Run unit tests
composer test

# Test the CLI compiler
./bin/oodsl-compile tests/Examples/basic_class.oodsl

# With debug output
./bin/oodsl-compile --debug tests/Examples/basic_class.oodsl
```

## Important Notes for PHP-PEG Integration

The current implementation uses a placeholder for the actual PHP-PEG integration. You'll need to:

### 1. Study smuuf/php-peg Documentation

```bash
# Install and study the library
composer require smuuf/php-peg
# Read: https://github.com/smuuf/php-peg
```

### 2. Adapt the Grammar File

The `Grammar.peg` file needs to be adapted to work with smuuf/php-peg's specific syntax. Key adjustments:

- **Actions**: PHP-PEG uses `{...}` for semantic actions
- **Method calls**: Update how AST nodes are created in actions
- **Error handling**: Integrate with smuuf/php-peg's error reporting

### 3. Update Parser.php

The `Parser.php` class needs proper integration with smuuf/php-peg:

```php
// Example of how to integrate:
use Smuuf\Peg\Parser as PegParser;

class Parser {
    private function initializePegParser(): void {
        $grammar = file_get_contents(__DIR__ . '/Grammar.peg');
        $this->pegParser = new PegParser($grammar);
    }
}
```

## Testing Your Setup

### 1. Create a Simple Test File

```javascript
// test.oodsl
class Person {
    string name;
    integer age;
}

object John : Person {
    name = "John Doe";
    age = 30;
}
```

### 2. Compile It

```bash
./bin/oodsl-compile test.oodsl
cat test.flr  # View the generated F-Logic code
```

### 3. Expected Output

```prolog
// Generated F-Logic code from OO-DSL
// Module: main

// Class: Person
Person[|name => \string, age => \integer|].

// Object: John
John:Person.
John[name -> "John Doe"].
John[age -> 30].
```

## Development Workflow

### 1. Grammar Development

- Edit `src/Parser/Grammar.peg`
- Test with small examples
- Verify AST generation

### 2. Code Generation

- Modify `src/CodeGen/FLogicGenerator.php`
- Add new F-Logic constructs
- Test with existing examples

### 3. Testing

```bash
# Run tests
composer test

# Static analysis
composer stan

# Code style
composer cs
```

## Extending the System

### Adding New Language Features

1. **Update Grammar**: Add new syntax rules to `Grammar.peg`
2. **Create AST Nodes**: Add corresponding AST node classes
3. **Update Generator**: Handle new nodes in `FLogicGenerator`
4. **Add Tests**: Create tests for new features

### Common Extensions

- **Modules**: Import/export system
- **Annotations**: Metadata for classes/methods
- **Constraints**: More complex constraint types
- **Queries**: Built-in query syntax
- **Functions**: Pure functions vs methods

## Troubleshooting

### Grammar Issues
- Use PHP-PEG's debugging features
- Test grammar incrementally
- Check for left recursion

### Code Generation Issues
- Add debug output to generator
- Verify AST structure
- Test F-Logic output in ErgoAI

### Performance Issues
- Profile with Xdebug
- Optimize grammar rules
- Cache parsed results

## Next Steps

1. **Complete PHP-PEG Integration**: Adapt grammar to work with smuuf/php-peg
2. **Enhanced Error Reporting**: Better error messages with source locations
3. **IDE Support**: Syntax highlighting and autocomplete
4. **Documentation**: Complete language reference
5. **Examples**: More complex real-world examples
6. **Optimization**: Performance improvements for large files

This system provides a solid foundation for your OO-DSL to F-Logic compiler. The modular architecture makes it easy to extend and maintain as your requirements evolve.