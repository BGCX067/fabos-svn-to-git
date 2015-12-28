<?php

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../core/App.class.php';

class AppTest extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->object = new App;
    }

    protected function tearDown()
    {
        
    }

}