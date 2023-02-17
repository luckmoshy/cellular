<?php

namespace Cellular;

use Cellular\Traits\HandlesActions;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\View\Cell;
use CodeIgniter\View\Exceptions\ViewException;
use ReflectionClass;

class Cellular extends Cell
{
    use HandlesActions;

    private ClassAliaser $aliaser;
    private Security $security;

    public function __construct()
    {
        $this->aliaser = new ClassAliaser();
        $this->security = new Security();
    }

    /**
     * Returns the Cell instance.
     *
     * @throws ViewException
     */
    public function initialRender(string $cellName, $params = null)
    {
        [$instance, $method] = $this->determineClass($cellName);

        $class = is_object($instance)
            ? get_class($instance)
            : null;

        if (! method_exists($instance, $method)) {
            throw ViewException::forInvalidCellMethod($class, $method);
        }

        $params = $this->prepareParams($params);

        [$html, $snapshot] = $this->toSnapshot($instance, $params);

        return <<<HTML
            <div cell:snapshot="{$snapshot}">
                {$html}
            </div>
        HTML;
    }

    /**
     * Pulls the snapshot from the request, validates it, and returns it.
     *
     * @throws \Exception
     */
    public function snapshotFromRequest(RequestInterface $request): array
    {
        $snapshot = $this->security->validateSnapshot($request->getBody());
        if (empty($snapshot)) {
            throw new \Exception('Invalid snapshot.');
        }

        return $snapshot;
    }

    /**
     * Returns the Cell instance based on the information in the snapshot.
     */
    public function fromSnapshot(array $snapshot): LiveCell
    {
        $class = $this->aliaser->retrieveClass($snapshot['name']);
        $data  = $snapshot['data'];

        $instance = new $class;
        $this->setProperties($instance, $data);

        return $instance;
    }

    /**
     * Generates the HTML and snapshot for the cell.
     */
    public function toSnapshot(LiveCell $instance): array
    {
        $html = $this->renderCell($instance, 'render', []);
        $snapshot = $this->getSnapshot($instance);

        // Generate the fingerprint
        $snapshot['fingerprint'] = Security::fingerprint($snapshot);

        $snapshot = htmlentities(json_encode($snapshot), ENT_QUOTES, 'UTF-8', false);

        return [$html, $snapshot];
    }

    /**
     * Builds a snapshot of the class and it's properties.
     */
    protected function getSnapshot(LiveCell $instance): array
    {
        return [
            'name' => $this->aliaser->generateAlias(get_class($instance)),
            'data' => $this->getProperties($instance),
            'meta' => $meta ?? ''
        ];
    }

    /**
     * Returns an array of the public properties of the class,
     * which includes any protected/private properties that have
     * a getter method (get<Foo>Property()).
     */
    protected function getProperties(LiveCell $instance): array
    {
        $properties = [];

        // Only allow public properties to be set, or protected/private
        // properties that have a method to get them (get<Foo>Property())
        $publicProperties  = $instance->getPublicProperties();

        foreach($publicProperties as $property => $value) {
            $properties[$property] = $value;
        }

        // Check for any getter methods (get<Foo>Property())
        $reflection = new ReflectionClass($this);
        foreach($reflection->getMethods() as $method) {
            if (preg_match('/^get(.+)Property$/', $method->getName(), $matches)) {
                $properties[$matches[1]] = $instance->{$method}();
            }
        }

        return $properties;
    }

    /**
     * Sets the properties on the instance.
     */
    protected function setProperties(LiveCell $instance, array $properties)
    {
        foreach($properties as $property => $value) {
            $instance->{$property} = $value;
        }
    }
}
