<?php

namespace Mgilet\NotificationBundle\Annotation;

use ReflectionClass;

class AttributeReader
{
    public function getClassAttributes(string $className, string $attributeName): array
    {
        $reflectionClass = new ReflectionClass($className);
        $attributes = $reflectionClass->getAttributes($attributeName);

        return array_map(fn($attribute) => $attribute->newInstance(), $attributes);
    }

    public function getPropertyAttributes(string $className, string $propertyName, string $attributeName): array
    {
        $reflectionClass = new ReflectionClass($className);
        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $attributes = $reflectionProperty->getAttributes($attributeName);

        return array_map(fn($attribute) => $attribute->newInstance(), $attributes);
    }

}
