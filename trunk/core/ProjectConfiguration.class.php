<?php

/**
 * Fabos - PHP framework
 *
 * @link http://code.google.com/p/fabos/
 * @author Caleng Tan <tcm1024@gmail.com>
 * @copyright Copyright (c) 2010, Caleng Tan
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version $Id$
 */

/**
 * ProjectConfiguration
 * @package core
 */
class ProjectConfiguration
{

    /**
     * config/config.php setting
     * @access public
     * @static
     * @var array
     */
    static public $mConfig = array();
    /**
     * config/url.php setting, an instance of SplFixedArray
     * @access public
     * @static
     * @var SplFixedArray
     */
    static public $mUrl = null;

    /**
     * ProjectConfiguration init
     * @static
     * @access public
     */
    static public function init()
    {
        self::loadConfig();
        self::loadUrl();
    }

    /**
     * Get config file content
     * @access public
     * @static
     * @param string $pFile file name
     * @return array
     */
    static private function getFile($pFile)
    {
        return include_once __DIR__ . "/../config/{$pFile}.php";
    }

    /**
     * Load config set ProjectConfiguration attribute $mConfig
     * @access public
     * @static
     */
    static public function loadConfig()
    {
        self::$mConfig = self::$mConfig ? : self::getFile('config');
    }

    /**
     * Set config value
     * @access pubic
     * @static
     * @param mixed $pKey
     * @param mixed $pValue
     */
    static public function setConfig($pKey, $pValue)
    {
        self::$mConfig[$pKey] = $pValue;
    }

    /**
     * Get all config of project
     * @static
     * @access public
     * @return array
     */
    static public function getAllConfig()
    {
        return self::$mConfig;
    }

    /**
     * Get one config of project
     * @access public
     * @static
     * @param mixed $pKey
     * @param mixed $pValue
     * @return mixed
     */
    static public function getConfig($pKey, $pDefaultValue = null)
    {
        return self::$mConfig[$pKey] ? : $pDefaultValue;
    }

    /**
     * Load url set ProjectConfiguration attribute $mUrl
     * @access public
     * @static
     */
    static public function loadUrl()
    {
        self::$mUrl = self::$mUrl
                ? : SplFixedArray::fromArray(self::getFile('url'));
    }

    /**
     * Add url to $mUrl
     * @access public
     * @static
     * @param array $pArr
     */
    static public function setUrl($pArr)
    {
        $count = self::$mUrl->getSize();
        self::$mUrl->setSize($count + 1);
        self::$mUrl[$count] = $pArr;
    }

    /**
     * Get all urls of project
     * @static
     * @access public
     * @return SplFixedArray
     */
    static public function getAllUrl()
    {
        return self::$mUrl;
    }

}