<?php

namespace Cellular\Traits;

use Cellular\LiveCell;

trait Dehydrate
{
    protected function deydrate(LiveCell $class): array
    {
        $reflection = new \ReflectionClass($class);
        $properties = $reflection->getProperties();

        $data = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($class);
        }

        return $data;
    }
}
