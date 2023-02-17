<?php

namespace Cellular;

use RuntimeException;

/**
 * Provides functions to help secure the cells.
 */
class Security
{
    private string $cacheFile = WRITEPATH . 'cellular.json';
    private ClassAliaser $aliaser;

    public function __construct()
    {
        $this->aliaser = new ClassAliaser();
    }

    /**
     * Parses the request to get the snapshot, and verifies
     * that it is a valid snapshot and hasn't been tampered with.
     *
     * @throws \Exception
     */
    public function validateSnapshot(string $httpBody): array
    {
        $snapshot = json_decode($httpBody, true);

        if (empty($snapshot)) {
            throw new RuntimeException('Invalid snapshot.');
        } else if (! isset($snapshot['snapshot']['fingerprint'])) {
            throw new RuntimeException('Missing fingerprint.');
        }

        $testSnapshot = $snapshot['snapshot'];
        $fingerprint = $testSnapshot['fingerprint'];
        unset($testSnapshot['fingerprint']);

        if (! $this->verifyFingerprint($fingerprint, $testSnapshot)) {
            throw new RuntimeException('Invalid fingerprint.');
        }

        return $snapshot;
    }

    /**
     * Validates that the class is a valid cell,
     * and that it is allowed to be used, to help prevent
     * attackers firing up any class in the system.
     *
     * @param string $name The alias/name of the class to validate
     */
    public function validateClass(string $name): bool
    {
        // Class must exist
        $className = $this->aliaser->retrieveClass($name);

        if (empty($className)) {
            throw new \Exception('Unable to determine cell from alias: ' . $name);
        }
        if (! class_exists($className)) {
            throw new \Exception('Cell class does not exist: ' . $className);
        }

        // Class must extend LiveCell
        return is_subclass_of($className, LiveCell::class);
    }

    /**
     * Returns a fingerprint for the cell based off of the snapshot.
     */
    public static function fingerprint(array $snapshot): string
    {
        $key = config('Encryption')->key;
        if (empty($key)) {
            throw new \Exception('Encryption key must be set for Live Cells.');
        }

        return hash_hmac('sha256', json_encode($snapshot), $key);
    }

    /**
     * Verifies that the fingerprint matches the snapshot.
     */
    public function verifyFingerprint(string $fingerprint, array $snapshot): bool
    {
        return hash_equals($this->fingerprint($snapshot), $fingerprint);
    }
}
