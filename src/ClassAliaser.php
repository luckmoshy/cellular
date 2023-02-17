<?php

namespace Cellular;

use CodeIgniter\Files\Exceptions\FileNotFoundException;

/**
 * Works with a cache file to store and read class aliases
 * for the Security class.
 */
class ClassAliaser
{
    protected string $cacheFile = WRITEPATH . 'cellular.json';
    protected array $cache = [];

    public function __construct()
    {
        helper('filesystem');
        $this->cache = $this->getCache();
    }

    /**
     * Generates an alias from the class name and stores it in the cache file.
     */
    public function generateAlias(string $class): string
    {
        $alias = $this->generateAliasFromClass($class);
        $this->saveAlias($class, $alias);

        return $alias;
    }

    /**
     * Looks up the alias in the cache file and returns the class name.
     */
    public function retrieveClass(string $alias): string
    {
        return $this->cache[$alias] ?? '';
    }

    /**
     * Deletes the cache file and the local cache array.
     */
    public function deleteCache(): void
    {
        if (is_file($this->cacheFile)) {
            unlink($this->cacheFile);
        }

        $this->cache = [];
    }

    /**
     * Determines the alias to use based on the class name.
     * Ensures it's unique in $this->cache.
     */
    protected function generateAliasFromClass(string $class): string
    {
        // Generate a unique alias from the class name $class
        $alias = strtolower(substr($class, strrpos($class, '\\') + 1));
        $alias = str_replace('_', '', $alias);

        // If the alias already exists in $this->cache, then
        // add a number to the end of it to make it unique.
        if (array_key_exists($alias, $this->cache)) {
            $alias .= count($this->cache);
        }

        return $alias;
    }

    /**
     * Stores the alias in the cache file.
     */
    private function saveAlias(string $class, string $alias): void
    {
        $this->cache[$alias] = $class;
        $this->storeCache($this->cache);
    }

    /**
     * Reads the cache file and saves a local cache of the file.
     */
    private function getCache(): array
    {
        // Ensure the file exists
        if (! file_exists($this->cacheFile)) {
            $this->storeCache([]);
        }

        // Read the cache file contents and convert it from JSON to an array
        return json_decode(file_get_contents($this->cacheFile), true) ?? [];
    }

    /**
     * Stores the given array into the cache file.
     * @throws FileNotFoundException
     */
    private function storeCache(array $cache): void
    {
        helper('filesystem');
        write_file($this->cacheFile, json_encode($cache, JSON_PRETTY_PRINT), 'w');
    }
}
