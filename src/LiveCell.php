<?php

namespace Cellular;

use CodeIgniter\View\Cells\Cell;
use ReflectionClass;

class LiveCell extends Cell
{
    // /**
    //  * Responsible for converting the view into HTML.
    //  * Expected to be overridden by the child class
    //  * in many occasions, but not all.
    //  */
    // public function render(): string
    // {
    //     if (! function_exists('decamelize')) {
    //         helper('inflector');
    //     }

    //     return $this->view($this->view);
    // }

    // /**
    //  * Actually renders the view, and returns the HTML.
    //  * In order to provide access to public properties and methods
    //  * from within the view, this method extracts $data into the
    //  * current scope and captures the output buffer instead of
    //  * relying on the view service.
    //  */
    // protected function view(?string $view, array $data = []): string
    // {
    //     $properties = $this->getPublicProperties();
    //     $properties = $this->includeComputedProperties($properties);
    //     $properties = array_merge($properties, $data);

    //     // If no view is specified, we'll try to guess it based on the class name.
    //     if (empty($view)) {
    //         $view = decamelize((new ReflectionClass($this))->getShortName());
    //         $view = str_replace('_cell', '', $view);
    //     }

    //     // Locate our view, preferring the directory of the class.
    //     if (! is_file($view)) {
    //         // Get the local pathname of the Cell
    //         $ref  = new ReflectionClass($this);
    //         $view = dirname($ref->getFileName()) . DIRECTORY_SEPARATOR . $view . '.php';
    //     }

    //     $html =  (function () use ($properties, $view): string {
    //         extract($properties);
    //         ob_start();
    //         include $view;

    //         return ob_get_clean() ?: '';
    //     })();

    //     // Add a data attribute to the cell's outermost element
    //     // that represents the class's state in JSON.

    //     return $html;
    // }

    // /**
    //  * Allows the developer to define computed properties
    //  * as methods with `get` prefixed to the protected/private property name.
    //  */
    // protected function includeComputedProperties(array $properties): array
    // {
    //     $reservedProperties = ['data', 'view'];
    //     $privateProperties  = $this->getNonPublicProperties();

    //     foreach ($privateProperties as $property) {
    //         $name = $property->getName();

    //         // don't include any methods in the base class
    //         if (in_array($name, $reservedProperties, true)) {
    //             continue;
    //         }

    //         $computedMethod = 'get' . ucfirst($name) . 'Property';

    //         if (method_exists($this, $computedMethod)) {
    //             $properties[$name] = $this->{$computedMethod}();
    //         }
    //     }

    //     return $properties;
    // }
}
