<?php

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../core/ProjectConfiguration.class.php';

class ProjectConfigurationTest extends PHPUnit_Framework_TestCase
{

    protected $mConfig = null;
    protected $mUrl = null;

    protected function setUp()
    {
        $this->mConfig = ProjectConfiguration::getConfig();
        $this->mUrl = ProjectConfiguration::getUrl();
    }

    /**
     * Test ProjectConfiguraton::getConfig()
     */
    public function testGetConfig()
    {
        $temp = include __DIR__ . '/../../config/config.php';
        $this->assertEquals(count($this->mConfig), count($temp));
    }

    /**
     * Test ProjectConfiguration::getUrl()
     */
    public function testGetUrl()
    {
        $temp = include __DIR__ . '/../../config/url.php';
        $this->assertEquals(count($this->mUrl), count($temp));
    }

}