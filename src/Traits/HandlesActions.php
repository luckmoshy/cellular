<?php

namespace Cellular\Traits;

use Cellular\LiveCell;

trait HandlesActions
{
    /**
     * Handles the actions that are sent from the client.
     */
    public function handleActions(array $snapshot, LiveCell $cell): void
    {
        // Handles updating a property on the cell
        if (! empty($snapshot['updateProperties'])) {
            $properties = $snapshot['updateProperties'];

            foreach ($properties as $property => $value) {
                $this->updateProperty($cell, $property, $value);
            }
        }

        // Handles calling a method on the cell
        if (! empty($snapshot['method'])) {
            $this->callMethod($cell, $snapshot['method']);
        }
    }

    /**
     * Calls a method on the cell instance.
     */
    private function callMethod(LiveCell $instance, string $method): void
    {
        $instance->{$method}();
    }

    /**
     * Updates a property on the cell instance.
     */
    private function updateProperty(LiveCell $instance, string $property, $value): void
    {
        $instance->{$property} = $value;
    }
}
