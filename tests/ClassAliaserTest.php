<?php

namespace Tests;

use Cellular\ClassAliaser;
use CodeIgniter\Test\CIUnitTestCase;
use PHPUnit\Framework\TestCase;

class ClassAliaserTest extends CIUnitTestCase
{
    protected ClassAliaser $aliaser;

    public function setUp(): void
    {
        parent::setUp();

        $this->aliaser = new ClassAliaser();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->aliaser->deleteCache();
    }

    public function testGenerateAlias()
    {
        $class = 'App\Cells\Fake_Cell';

        $alias = $this->aliaser->generateAlias($class);
        $this->assertEquals('fakecell', $alias);

        // Should add a number to the end to ensure uniqueness
        $alias = $this->aliaser->generateAlias($class);
        $this->assertEquals('fakecell1', $alias);
    }

    public function testRetrieveClass()
    {
        $class = 'App\Cells\Fake_Cell';

        $alias = $this->aliaser->generateAlias($class);
        $this->assertEquals('fakecell', $alias);

        $this->assertEquals($class, $this->aliaser->retrieveClass($alias));
    }
}
