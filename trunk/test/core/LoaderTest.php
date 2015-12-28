<?php

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../core/Loader.class.php';

class LoaderTest extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        
    }

    protected function tearDown()
    {
        
    }

    public function testGetPathInfo()
    {
        $this->assertEquals($_SERVER['PATH_INFO'], Loader::getPathInfo());
    }

    /**
     * Test Loader::getMethod()
     */
    public function testGetMethod()
    {
        $this->assertEquals($_SERVER['REQUEST_METHOD'], Loader::getMethod());
    }

}