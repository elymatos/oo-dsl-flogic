# OO-like DSL for F-Logic ErgoAI - Design Specification


## Key F-Logic ErgoAI Translation Patterns:

1. **Classes** → Class signatures with `=>`
2. **Objects** → Instance declarations with `:`
3. **Properties** → Frame slots with `->`
4. **Collections** → Multivalued slots with `*=>`
5. **Inheritance** → ISA relations with `::`
6. **Methods** → Method signatures and implementations
7. **Rules** → Named rules with `@!{RuleName}`
8. **Conditions** → Horn clause bodies
9. **Chained access** → Multiple frame accesses
10. **Boolean logic** → Prolog conjunction/disjunction
11. **Collections operations** → Cardinality operators `|...|`



## Overview
This DSL provides an intuitive, object-oriented syntax that compiles to F-Logic ErgoAI code, making logic programming accessible to developers familiar with OOP paradigms.

## Core Language Mappings

### 1. Class Definitions

**DSL Syntax:**
```javascript
class Person inherits from LivingBeing {
    // Type signatures (structural inheritance)
    string name;
    integer age;
    Person spouse;
    set<Person> children;
    boolean isVegetarian;
    
    // Method signatures
    integer calculateAgeIn(Year birthYear);
    boolean isAdult();
}
```

**Generated F-Logic:**
```prolog
% Class hierarchy
Person::LivingBeing.

% Class-level signatures (inheritable)
Person[|name => \string, 
       age => \integer, 
       spouse => Person, 
       children{0..*} => Person,
       isVegetarian => \boolean,
       calculateAgeIn(\integer) => \integer,
       isAdult() => \boolean|].
```

### 2. Object Creation & Facts

**DSL Syntax:**
```javascript
object John : Person {
    name = "John Doe";
    age = 30;
    spouse = Mary;
    children += {Bob, Alice};
    isVegetarian = true;
}
```

**Generated F-Logic:**
```prolog
% Object instantiation
John:Person.

% Object-level facts
John[name -> "John Doe"].
John[age -> 30].
John[spouse -> Mary].
John[children -> Bob].
John[children -> Alice].
John[isVegetarian].
```

### 3. Method Implementations (Rules)

**DSL Syntax:**
```javascript
method Person.calculateAgeIn(Year birthYear) returns integer {
    return CurrentYear - birthYear;
}

method Person.isAdult() returns boolean {
    return this.age >= 18;
}
```

**Generated F-Logic:**
```prolog
% Method implementations
?P:Person[calculateAgeIn(?BY) -> ?Age] :-
    ?Age \is CurrentYear - ?BY.

?P:Person[isAdult() -> \true] :-
    ?P[age -> ?A],
    ?A >= 18.
```

### 4. Complex Rules

**DSL Syntax:**
```javascript
rule HappyPerson {
    if (Person.isVegetarian && Person.spouse.isVegetarian) {
        Person.isHappy = true;
    }
}

rule AdultWithChildren {
    if (Person.isAdult() && Person.children.count() > 0) {
        Person.hasResponsibilities = true;
    }
}
```

**Generated F-Logic:**
```prolog
% Named rules
@!{HappyPerson}
?P:Person[isHappy] :-
    ?P[isVegetarian],
    ?P[spouse -> ?S],
    ?S[isVegetarian].

@!{AdultWithChildren}
?P:Person[hasResponsibilities] :-
    ?P[isAdult() -> \true],
    ?P[children -> ?C],
    \aggregate(?Count, ?C, \count) > 0.
```

### 5. Queries

**DSL Syntax:**
```javascript
query FindVegetarians {
    select Person where Person.isVegetarian == true;
}

query FindAdults {
    select Person where Person.isAdult() == true;
}
```

**Generated F-Logic:**
```prolog
% Query definitions
?- ?P:Person[isVegetarian].

?- ?P:Person[isAdult() -> \true].
```

## Advanced Features

### 1. Inheritance Types

**DSL Syntax:**
```javascript
// Structural inheritance only
class Student inherits structure from Person {
    string studentId;
}

// Full inheritance (structure + behavior)
class Employee inherits from Person {
    string employeeId;
    Company employer;
}
```

**Generated F-Logic:**
```prolog
% Structural inheritance
Student::Person.
Student[|studentId => \string|].

% Full inheritance
Employee::Person.
Employee[|employeeId => \string, employer => Company|].
```

### 2. Module System

**DSL Syntax:**
```javascript
module PersonDomain {
    class Person { ... }
    class Company { ... }
    
    export Person, Company;
}

import PersonDomain.{Person, Company};
```

**Generated F-Logic:**
```prolog
% Module definition
@{PersonDomain}
Person::Object.
Company::Object.

% Module exports
@{PersonDomain}
\export Person, Company.
```

### 3. Collections and Constraints

**DSL Syntax:**
```javascript
class Family {
    set<Person>{2..10} members;     // 2 to 10 members
    Person{1..2} parents;           // 1 or 2 parents
    list<Person> children;          // ordered children
}
```

**Generated F-Logic:**
```prolog
Family[|members{2..10} => Person,
        parents{1..2} => Person,
        children => \list|].
```

## Grammar Structure for PHP-PEG

### Core Grammar Rules

```peg
Program = Module*

Module = "module" Identifier "{" ModuleBody "}" / Statement*

ModuleBody = (ClassDef / ObjectDef / MethodDef / Rule / Export / Import)*

ClassDef = "class" Identifier InheritanceClause? "{" ClassBody "}"

InheritanceClause = "inherits" ("structure")? "from" Identifier

ClassBody = (FieldDef / MethodSignature / MethodDef)*

FieldDef = TypeSpec Identifier Constraint? ";"

TypeSpec = PrimitiveType / CollectionType / Identifier

PrimitiveType = "string" / "integer" / "boolean" / "float"

CollectionType = ("set" / "list") "<" TypeSpec ">" Constraint?

Constraint = "{" (Integer / Range) "}"

Range = Integer ".." Integer

MethodSignature = TypeSpec Identifier "(" ParameterList? ")" ";"

MethodDef = "method" QualifiedName "(" ParameterList? ")" 
           ("returns" TypeSpec)? BlockStatement

ObjectDef = "object" Identifier ":" Identifier "{" ObjectBody "}"

ObjectBody = Assignment*

Assignment = Identifier AssignOp Expression ";"

AssignOp = "=" / "+=" / "-="

Rule = "rule" Identifier "{" RuleBody "}"

RuleBody = IfStatement / Assignment

IfStatement = "if" "(" Expression ")" BlockStatement ("else" BlockStatement)?

Expression = LogicalExpression

LogicalExpression = ComparisonExpression (LogicalOp ComparisonExpression)*

LogicalOp = "&&" / "||" / "and" / "or"

ComparisonExpression = AdditiveExpression (ComparisonOp AdditiveExpression)?

ComparisonOp = "==" / "!=" / "<" / ">" / "<=" / ">="

AdditiveExpression = MultiplicativeExpression (AdditiveOp MultiplicativeExpression)*

AdditiveOp = "+" / "-"

MultiplicativeExpression = UnaryExpression (MultiplicativeOp UnaryExpression)*

MultiplicativeOp = "*" / "/" / "%"

UnaryExpression = UnaryOp? PrimaryExpression

UnaryOp = "!" / "not" / "-"

PrimaryExpression = 
    Identifier |
    Number |
    String |
    Boolean |
    "this" |
    "(" Expression ")" |
    MethodCall |
    PropertyAccess |
    SetLiteral

MethodCall = QualifiedName "(" ArgumentList? ")"

PropertyAccess = QualifiedName ("." Identifier)*

QualifiedName = Identifier ("." Identifier)*

SetLiteral = "{" (Expression ("," Expression)*)? "}"

ArgumentList = Expression ("," Expression)*

ParameterList = Parameter ("," Parameter)*

Parameter = TypeSpec Identifier

BlockStatement = "{" Statement* "}"

Statement = 
    Assignment |
    IfStatement |
    ReturnStatement |
    ExpressionStatement

ReturnStatement = "return" Expression ";"

ExpressionStatement = Expression ";"

Export = "export" IdentifierList ";"

Import = "import" QualifiedName ("." "{" IdentifierList "}")? ";"

IdentifierList = Identifier ("," Identifier)*

Identifier = [a-zA-Z_][a-zA-Z0-9_]*

Number = Integer / Float

Integer = [0-9]+

Float = [0-9]+ "." [0-9]+

String = '"' [^"]* '"'

Boolean = "true" / "false"

Whitespace = [ \t\n\r]+

Comment = "//" [^\n]* / "/*" (!"*/" .)* "*/"
```

## Implementation Strategy

### Phase 1: Basic Parser
1. Implement core grammar using php-peg
2. Create AST node classes for each language construct
3. Basic class/object definitions with simple property mappings

### Phase 2: Code Generation
1. Implement AST to F-Logic transformation
2. Handle inheritance mappings
3. Generate proper F-Logic module structure

### Phase 3: Advanced Features
1. Method implementations and rules
2. Complex type constraints
3. Module system with imports/exports

### Phase 4: Optimization & Tooling
1. Error handling and validation
2. Source maps for debugging
3. IDE support/syntax highlighting

## File Structure

```
oo-dsl-flogic/
├── composer.json
├── README.md
├── bin/
│   └── oodsl-compile
├── src/
│   ├── Parser/
│   │   ├── Grammar.peg
│   │   ├── Parser.php
│   │   └── TokenType.php
│   ├── AST/
│   │   ├── Node.php
│   │   ├── ClassNode.php
│   │   ├── ObjectNode.php
│   │   ├── MethodNode.php
│   │   ├── PropertyNode.php
│   │   ├── RuleNode.php
│   │   ├── TypeNode.php
│   │   └── ExpressionNode.php
│   ├── CodeGen/
│   │   ├── FLogicGenerator.php
│   │   ├── TypeMapper.php
│   │   └── ModuleGenerator.php
│   ├── Analysis/
│   │   ├── SemanticAnalyzer.php
│   │   └── TypeChecker.php
│   ├── Utils/
│   │   ├── ErrorHandler.php
│   │   ├── SourceLocation.php
│   │   └── Logger.php
│   └── CLI/
│       └── CompilerCommand.php
├── tests/
│   ├── Unit/
│   ├── Integration/
│   └── Examples/
│       ├── basic_class.oodsl
│       ├── inheritance.oodsl
│       └── complex_rules.oodsl
└── docs/
    ├── grammar.md
    ├── examples.md
    └── flogic_mapping.md
```

## Example Usage

```bash
# Compile DSL to F-Logic
php compiler.php input.oodsl --output output.flr

# With module output
php compiler.php input.oodsl --output-dir modules/ --module-name PersonDomain
```

This design provides a solid foundation for building your OO-like DSL that compiles to F-Logic ErgoAI, making logic programming more accessible to developers familiar with object-oriented paradigms.

