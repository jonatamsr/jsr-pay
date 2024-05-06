<?php

namespace App\Domain\Entities;

abstract class Entity
{
    public function __construct(array $data) {
        $this->attachValues($data);
    }

    public static function properties(): array
    {
        return array_keys(get_class_vars(get_called_class()));
    }

    public function attachValues(array $values): void
    {
        $properties = self::properties();
        foreach ($values as $propertyName => $propertyValue) {
            if (!in_array($propertyName, $properties)) {
                continue;
            }

            $this->{$propertyName} = $propertyValue;
        }
    }

    public function toArray(): array
    {
        $response = [];

        foreach (self::properties() as $propertyClass) {
            $response[$propertyClass] = $this->{$propertyClass};
        }

        return $response;
    }
}