<?php
// src/Translator/TranslationContext.php
namespace FLogicDSL\Translator;

use FLogicDSL\Parser\ClassDeclarationNode;

/**
 * Maintains context during translation
 */
class TranslationContext
{
    private array $classes = [];
    private array $objects = [];
    private array $rules = [];
    private int $variableCounter = 0;

    public function addClass(ClassDeclarationNode $class): void
    {
        $this->classes[$class->getName()] = $class;
    }

    public function getClass(string $name): ?ClassDeclarationNode
    {
        return $this->classes[$name] ?? null;
    }

    public function hasClass(string $name): bool
    {
        return isset($this->classes[$name]);
    }

    public function getAllClasses(): array
    {
        return $this->classes;
    }

    public function addObject(string $name, string $className): void
    {
        $this->objects[$name] = $className;
    }

    public function getObjectClass(string $objectName): ?string
    {
        return $this->objects[$objectName] ?? null;
    }

    public function addRule(string $name): void
    {
        $this->rules[] = $name;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function generateVariable(string $prefix = 'Var'): string
    {
        return '?' . $prefix . (++$this->variableCounter);
    }

    public function resetVariableCounter(): void
    {
        $this->variableCounter = 0;
    }

    /**
     * Check if a property exists in a class hierarchy
     */
    public function hasProperty(string $className, string $propertyName): bool
    {
        $class = $this->getClass($className);
        if (!$class) {
            return false;
        }

        // Check current class
        foreach ($class->getProperties() as $property) {
            if ($property->getName() === $propertyName) {
                return true;
            }
        }

        // Check parent class
        if ($class->getParentClass()) {
            return $this->hasProperty($class->getParentClass(), $propertyName);
        }

        return false;
    }

    /**
     * Check if a method exists in a class hierarchy
     */
    public function hasMethod(string $className, string $methodName): bool
    {
        $class = $this->getClass($className);
        if (!$class) {
            return false;
        }

        // Check current class
        foreach ($class->getMethods() as $method) {
            if ($method->getName() === $methodName) {
                return true;
            }
        }

        // Check parent class
        if ($class->getParentClass()) {
            return $this->hasMethod($class->getParentClass(), $methodName);
        }

        return false;
    }

    /**
     * Get the complete inheritance chain for a class
     */
    public function getInheritanceChain(string $className): array
    {
        $chain = [$className];
        $class = $this->getClass($className);

        while ($class && $class->getParentClass()) {
            $parentName = $class->getParentClass();
            $chain[] = $parentName;
            $class = $this->getClass($parentName);
        }

        return $chain;
    }

    /**
     * Check if one class inherits from another
     */
    public function inheritsFrom(string $childClass, string $parentClass): bool
    {
        $chain = $this->getInheritanceChain($childClass);
        return in_array($parentClass, $chain);
    }
}
?>