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