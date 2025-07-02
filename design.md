# F-Logic ErgoAI Translations for DSL Examples


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

# OO-like DSL for F-Logic ErgoAI - Design Specification

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
src/
├── Parser/
│   ├── Grammar.peg
│   ├── Parser.php
│   └── Lexer.php
├── AST/
│   ├── Node.php
│   ├── ClassNode.php
│   ├── ObjectNode.php
│   ├── MethodNode.php
│   └── RuleNode.php
├── CodeGen/
│   ├── FLogicGenerator.php
│   ├── ModuleGenerator.php
│   └── TypeMapper.php
├── Utils/
│   ├── ErrorHandler.php
│   └── SourceMap.php
└── CLI/
    └── Compiler.php
```

## Example Usage

```bash
# Compile DSL to F-Logic
php compiler.php input.oodsl --output output.flr

# With module output
php compiler.php input.oodsl --output-dir modules/ --module-name PersonDomain
```

This design provides a solid foundation for building your OO-like DSL that compiles to F-Logic ErgoAI, making logic programming more accessible to developers familiar with object-oriented paradigms.

## 1. simple_test.oodsl.txt

**Original DSL:**
```
// Simple test
class Vehicle {
    string brand;
    integer year;
}

object Honda : Vehicle {
    brand = "Honda";
    year = 2020;
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class definition with signatures
Vehicle[brand => string, year => integer].

// Object instance
Honda:Vehicle[brand -> "Honda", year -> 2020].
```

---

## 2. var_assignment.oodsl.txt

**Original DSL:**
```
method Person.test() returns float {
    let x = 10;
    var y = 20;
    return x + y;
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Method signature
Person[test() => float].

// Method implementation
?X[test() -> ?Result] :- 
    ?X:Person,
    ?X = 10,
    ?Y = 20,
    ?Result is ?X + ?Y.
```

---

## 3. string_operations.oodsl.txt

**Original DSL:**
```
class Person {
    string firstName;
    string lastName;
    string email;
}

method Person.getFullName() returns string {
    fullName = this.firstName + " " + this.lastName;
    return fullName;
}

method Person.getDisplayName() returns string {
    name = this.firstName.toUpperCase();
    return name;
}

rule LongName {
    if (Person.firstName.length() > 10) {
        Person.hasLongName = true;
    }
}

rule ValidEmail {
    if (Person.email.indexOf("@") > 0) {
        Person.hasValidEmail = true;
    }
}

method Person.getFormattedInfo() returns string {
    name = this.firstName.toUpperCase() + " " + this.lastName.toLowerCase();
    email = this.email.trim();
    return name + " <" + email + ">";
}

rule ComplexEmailValidation {
    if (Person.email.length() > 5 &&
        Person.email.indexOf("@") > 0 &&
        Person.email.indexOf(".") > Person.email.indexOf("@")) {
        Person.hasValidComplexEmail = true;
    }
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class signature
Person[firstName => string, lastName => string, email => string].
Person[getFullName() => string, getDisplayName() => string, getFormattedInfo() => string].
Person[hasLongName => boolean, hasValidEmail => boolean, hasValidComplexEmail => boolean].

// Method implementations
?X[getFullName() -> ?FullName] :-
    ?X:Person,
    ?X[firstName -> ?First, lastName -> ?Last],
    ?FullName = ?First + " " + ?Last.

?X[getDisplayName() -> ?Name] :-
    ?X:Person,
    ?X[firstName -> ?First],
    str_upper(?First, ?Name).

?X[getFormattedInfo() -> ?Result] :-
    ?X:Person,
    ?X[firstName -> ?First, lastName -> ?Last, email -> ?Email],
    str_upper(?First, ?UpperFirst),
    str_lower(?Last, ?LowerLast),
    str_trim(?Email, ?TrimmedEmail),
    ?Name = ?UpperFirst + " " + ?LowerLast,
    ?Result = ?Name + " <" + ?TrimmedEmail + ">".

// Rules
@!{LongName} ?X[hasLongName -> true] :-
    ?X:Person,
    ?X[firstName -> ?Name],
    str_length(?Name, ?Len),
    ?Len > 10.

@!{ValidEmail} ?X[hasValidEmail -> true] :-
    ?X:Person,
    ?X[email -> ?Email],
    str_index(?Email, "@", ?Pos),
    ?Pos > 0.

@!{ComplexEmailValidation} ?X[hasValidComplexEmail -> true] :-
    ?X:Person,
    ?X[email -> ?Email],
    str_length(?Email, ?Len),
    ?Len > 5,
    str_index(?Email, "@", ?AtPos),
    ?AtPos > 0,
    str_index(?Email, ".", ?DotPos),
    ?DotPos > ?AtPos.
```

---

## 4. complex_method.oodsl.txt

**Original DSL:**
```
class Person {
    float salary;
    float bonus;
}

method Person.calculateNetSalary() returns float {
    gross = this.salary + this.bonus;
    tax = gross * 0.25;
    return gross - tax;
}

method Employee.calculateBonus() returns float {
    baseAmount = this.salary * 0.1;
    yearsMultiplier = this.yearsOfService * 0.02;
    bonus = baseAmount + (baseAmount * yearsMultiplier);
    return bonus;
}

method Person.getFullInfo() returns string {
    firstName = this.firstName;
    lastName = this.lastName;
    age = this.age;
    return firstName + " " + lastName + " (" + age + ")";
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class signatures
Person[salary => float, bonus => float].
Person[calculateNetSalary() => float, getFullInfo() => string].
Person[firstName => string, lastName => string, age => integer].
Employee[yearsOfService => integer, calculateBonus() => float].

// Method implementations
?X[calculateNetSalary() -> ?NetSalary] :-
    ?X:Person,
    ?X[salary -> ?Salary, bonus -> ?Bonus],
    ?Gross is ?Salary + ?Bonus,
    ?Tax is ?Gross * 0.25,
    ?NetSalary is ?Gross - ?Tax.

?X[calculateBonus() -> ?Bonus] :-
    ?X:Employee,
    ?X[salary -> ?Salary, yearsOfService -> ?Years],
    ?BaseAmount is ?Salary * 0.1,
    ?YearsMultiplier is ?Years * 0.02,
    ?Bonus is ?BaseAmount + (?BaseAmount * ?YearsMultiplier).

?X[getFullInfo() -> ?Info] :-
    ?X:Person,
    ?X[firstName -> ?First, lastName -> ?Last, age -> ?Age],
    ?Info = ?First + " " + ?Last + " (" + ?Age + ")".
```

---

## 5. collection_test.oodsl.txt

**Original DSL:**
```
class Family {
    set<Person> children;
    string surname;
}

class Person {
    string name;
    integer age;
}

object SmithFamily : Family {
    surname = "Smith";
    children += {alice, bob, charlie};
}

object alice : Person {
    name = "Alice";
    age = 16;
}

object bob : Person {
    name = "Bob";
    age = 14;
}

object charlie : Person {
    name = "Charlie";
    age = 12;
}

rule LargeFamily {
    if (Family.children.count() > 2) {
        Family.isLarge = true;
    }
}

rule SmallFamily {
    if (Family.children.size() <= 2) {
        Family.isSmall = true;
    }
}

rule SmithFamilySize {
    if (SmithFamily.children.count() == 3) {
        SmithFamily.hasThreeKids = true;
    }
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class signatures
Family[children *=> Person, surname => string].
Family[isLarge => boolean, isSmall => boolean, hasThreeKids => boolean].
Person[name => string, age => integer].

// Object instances
SmithFamily:Family[surname -> "Smith"].
SmithFamily[children -> {alice, bob, charlie}].

alice:Person[name -> "Alice", age -> 16].
bob:Person[name -> "Bob", age -> 14].
charlie:Person[name -> "Charlie", age -> 12].

// Rules
@!{LargeFamily} ?Family[isLarge -> true] :-
    ?Family:Family,
    |?Family.children| > 2.

@!{SmallFamily} ?Family[isSmall -> true] :-
    ?Family:Family,
    |?Family.children| =< 2.

@!{SmithFamilySize} SmithFamily[hasThreeKids -> true] :-
    |SmithFamily.children| == 3.
```

---

## 6. chained_progression.oodsl.txt

**Original DSL (partial - showing key chained access patterns):**
```
rule SpouseAge {
    if (Person.spouse.age > 30) {
        Person.hasOlderSpouse = true;
    }
}

rule SpouseCity {
    if (Person.spouse.address.city == "Tech City") {
        Person.spouseLivesInTechCity = true;
    }
}

rule SpouseCountry {
    if (Person.spouse.address.country.name == "United States") {
        Person.spouseIsAmerican = true;
    }
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class signatures
Person[spouse => Person, address => Address, hasOlderSpouse => boolean].
Person[spouseLivesInTechCity => boolean, spouseIsAmerican => boolean].
Address[city => string, country => Country].
Country[name => string].

// Object instances (partial)
John:Person[spouse -> Mary, address -> JohnAddress].
Mary:Person[age -> 32, address -> JohnAddress].
JohnAddress:Address[city -> "Tech City", country -> USA].
USA:Country[name -> "United States"].

// Rules with chained access
@!{SpouseAge} ?Person[hasOlderSpouse -> true] :-
    ?Person:Person,
    ?Person[spouse -> ?Spouse],
    ?Spouse[age -> ?Age],
    ?Age > 30.

@!{SpouseCity} ?Person[spouseLivesInTechCity -> true] :-
    ?Person:Person,
    ?Person[spouse -> ?Spouse],
    ?Spouse[address -> ?Address],
    ?Address[city -> "Tech City"].

@!{SpouseCountry} ?Person[spouseIsAmerican -> true] :-
    ?Person:Person,
    ?Person[spouse -> ?Spouse],
    ?Spouse[address -> ?Address],
    ?Address[country -> ?Country],
    ?Country[name -> "United States"].
```

---

## 7. method_progression.oodsl.txt

**Original DSL:**
```
rule TestMethodCall {
    if (Person.isAdult()) {
        Person.canWork = true;
    }
}

rule TestMethodAnd {
    if (Person.isAdult() && Person.isActive == true) {
        Person.isEligible = true;
    }
}

rule TestMethodWithParam {
    if (Person.isOlderThan(25)) {
        Person.isMatture = true;
    }
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class signatures
Person[isAdult() => boolean, isActive => boolean, isOlderThan(integer) => boolean].
Person[canWork => boolean, isEligible => boolean, isMatture => boolean].
Person[age => integer].

// Method implementations
?X[isAdult() -> true] :- ?X:Person, ?X[age -> ?Age], ?Age >= 18.
?X[isAdult() -> false] :- ?X:Person, ?X[age -> ?Age], ?Age < 18.

?X[isOlderThan(?TargetAge) -> true] :- 
    ?X:Person, 
    ?X[age -> ?Age], 
    ?Age > ?TargetAge.

// Rules
@!{TestMethodCall} ?Person[canWork -> true] :-
    ?Person:Person,
    ?Person[isAdult() -> true].

@!{TestMethodAnd} ?Person[isEligible -> true] :-
    ?Person:Person,
    ?Person[isAdult() -> true],
    ?Person[isActive -> true].

@!{TestMethodWithParam} ?Person[isMatture -> true] :-
    ?Person:Person,
    ?Person[isOlderThan(25) -> true].
```

---

## 8. boolean_progression.oodsl.txt

**Original DSL:**
```
rule SimpleAnd {
    if (Person.age > 25 && Person.salary > 40000.0) {
        Person.isGoodCandidate = true;
    }
}

rule MixedConditions {
    if (Person.isActive == true && (Person.age > 30 || Person.salary > 60000.0)) {
        Person.isEligible = true;
    }
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class signatures
Person[age => integer, salary => float, isActive => boolean].
Person[isGoodCandidate => boolean, isEligible => boolean].

// Rules
@!{SimpleAnd} ?Person[isGoodCandidate -> true] :-
    ?Person:Person,
    ?Person[age -> ?Age],
    ?Age > 25,
    ?Person[salary -> ?Salary],
    ?Salary > 40000.0.

@!{MixedConditions} ?Person[isEligible -> true] :-
    ?Person:Person,
    ?Person[isActive -> true],
    ((?Person[age -> ?Age], ?Age > 30) ; 
     (?Person[salary -> ?Salary], ?Salary > 60000.0)).
```

---

## 9. complex_boolean.oodsl.txt

**Original DSL:**
```
rule EligibleForPromotion {
    if (Employee.age >= 25 && Employee.yearsOfService >= 3 && Employee.salary < 100000.0) {
        Employee.eligibleForPromotion = true;
    }
}

rule QualifiedEmployee {
    if (Employee.isActive == true && (Employee.hasGoodRating == true || Employee.isManager == true)) {
        Employee.isQualified = true;
    }
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class signatures
Employee[age => integer, yearsOfService => integer, salary => float].
Employee[isActive => boolean, hasGoodRating => boolean, isManager => boolean].
Employee[eligibleForPromotion => boolean, isQualified => boolean].

// Rules
@!{EligibleForPromotion} ?Employee[eligibleForPromotion -> true] :-
    ?Employee:Employee,
    ?Employee[age -> ?Age],
    ?Age >= 25,
    ?Employee[yearsOfService -> ?Years],
    ?Years >= 3,
    ?Employee[salary -> ?Salary],
    ?Salary < 100000.0.

@!{QualifiedEmployee} ?Employee[isQualified -> true] :-
    ?Employee:Employee,
    ?Employee[isActive -> true],
    ((?Employee[hasGoodRating -> true]) ; 
     (?Employee[isManager -> true])).
```

---

## 10. enhanced_methods.oodsl.txt

**Original DSL:**
```
class Person {
    // Method implementations inside class (NEW FEATURE!)
    integer getAge() {
        return this.age;
    }

    boolean isEligible() returns boolean {
        return this.age >= 18;
    }
}

// Traditional outside-class method definitions
method Person.isAdult() returns boolean {
    return this.age >= 18;
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class signatures
Person[age => integer].
Person[getAge() => integer, isEligible() => boolean, isAdult() => boolean].

// Method implementations (both styles translate to same F-Logic)
?X[getAge() -> ?Age] :-
    ?X:Person,
    ?X[age -> ?Age].

?X[isEligible() -> true] :-
    ?X:Person,
    ?X[age -> ?Age],
    ?Age >= 18.

?X[isAdult() -> true] :-
    ?X:Person,
    ?X[age -> ?Age],
    ?Age >= 18.
```

---

## 11. inheritance.oodsl.txt

**Original DSL:**
```
class LivingBeing {
    string name;
    boolean isAlive;
}

class Person inherits from LivingBeing {
    integer age;
    Person spouse;
    set<Person> children;
}

class Employee inherits from Person {
    string employeeId;
    string department;
    float salary;
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class hierarchy
Person::LivingBeing.
Employee::Person.

// Class signatures
LivingBeing[name => string, isAlive => boolean].
Person[age => integer, spouse => Person, children *=> Person].
Employee[employeeId => string, department => string, salary => float].

// Object instances
Mary:Person[name -> "Mary Smith", age -> 28, isAlive -> true].
Mary[children -> {Alice, Bob}].

Alice:Person[name -> "Alice Smith", age -> 5, isAlive -> true].
Bob:Person[name -> "Bob Smith", age -> 8, isAlive -> true].

JohnEmployee:Employee[
    name -> "John Manager",
    age -> 35,
    isAlive -> true,
    employeeId -> "EMP001",
    department -> "Engineering",
    salary -> 75000.0
].
```

---

## 12. advanced_features.oodsl.txt

**Original DSL:**
```
class Vehicle {
    string brand;
    string model;
    integer year;
    boolean isElectric;
}

class Car inherits from Vehicle {
    integer doors{2..5};
    string fuelType;
    float engineSize;
}

class Fleet {
    string name;
    set<Vehicle> vehicles;
    Person owner;
}
```

**Expected F-Logic ErgoAI:**
```prolog
// Class hierarchy
Car::Vehicle.
Motorcycle::Vehicle.

// Class signatures with cardinality constraints
Vehicle[brand => string, model => string, year => integer, isElectric => boolean].
Car[doors{2..5} => integer, fuelType => string, engineSize => float].
Fleet[name => string, vehicles *=> Vehicle, owner => Person].

// Object instances
Honda:Car[
    brand -> "Honda",
    model -> "Civic", 
    year -> 2020,
    doors -> 4,
    fuelType -> "Gasoline",
    engineSize -> 2.0,
    isElectric -> false
].

Tesla:Car[
    brand -> "Tesla",
    model -> "Model 3",
    year -> 2023,
    doors -> 4,
    fuelType -> "Electric",
    engineSize -> 0.0,
    isElectric -> true
].

MyFleet:Fleet[
    name -> "Personal Fleet",
    vehicles -> {Honda, Tesla, Harley},
    owner -> John
].

// Rules
@!{ModernVehicle} ?Vehicle[isModern -> true] :-
    ?Vehicle:Vehicle,
    ?Vehicle[year -> ?Year],
    ?Year >= 2020.

@!{EcoFriendly} ?Vehicle[isEcoFriendly -> true] :-
    ?Vehicle:Vehicle,
    ?Vehicle[isElectric -> true].
```

---
