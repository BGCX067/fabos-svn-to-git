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
 * Loader
 * @package core
 */
class Loader
{

    /**
     * Reqest path info
     * @access public
     * @static
     * @var string
     */
    static public $mPathInfo = '';
    /**
     * Request method
     * @access public
     * @static
     * @var string
     */
    static public $mMethod = '';
    /**
     * Project url
     * @access public
     * @static
     * @var SplFixedArray
     */
    static public $mPojrectUrl = null;

    /**
     * Loader init
     * @access public
     * @static
     */
    static public function init()
    {
        self::setMethod();
        self::setPathInfo();

        self::$mPojrectUrl = ProjectConfiguration::getAllUrl();
    }

    /**
     * Set method
     * @access private
     * @static
     */
    static private function setMethod()
    {
        self::$mMethod = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get method
     * @access public
     * @static
     * @return string
     */
    static public function getMethod()
    {
        return self::$mMethod;
    }

    /**
     * Set path info
     * @access private
     * @static
     */
    static private function setPathInfo()
    {
        self::$mPathInfo = self::$mMethod . ' ';

        $uri = filter_input(INPUT_SERVER,
                'REQUEST_URI', FILTER_SANITIZE_SPECIAL_CHARS);

        $pattern = array(
            '/(' . str_replace('/', '\/', dirname($_SERVER['SCRIPT_NAME'])
                    . '(/index.php)?').')/',
            '/(\?.*)?/', '/(\/$)?/');
        $uri = preg_replace($pattern, '', $uri);
        self::$mPathInfo .= $uri ? : '/';
    }

    /**
     * Get path info
     * @access public
     * @static
     * @return string
     */
    static public function getPathInfo()
    {
        return self::$mPathInfo;
    }

    /**
     * Get controller from $mProjectUrl by request
     * @access public
     * @static
     * @param string $pPathInfo
     * @return array
     */
    static public function getControllerFromUrlObject($pPathInfo = '')
    {
        $controller_params = array();
        $pPathInfo = $pPathInfo ? : self::$mPathInfo;

        self::$mPojrectUrl->rewind();
        while (self::$mPojrectUrl->valid()) {
            list($pattern, $controller) = self::$mPojrectUrl->current();

            $pattern = '/' . str_replace('/', '\/', $pattern) . '/';
            preg_match_all($pattern, $pPathInfo, $matched);
            if ($matched[0][0] == $pPathInfo) {
                $controller_params['c'] = $controller;
                $controller_params['p'] = self::getParamsFromRequest($matched);
                break;
            }
            self::$mPojrectUrl->next();
        }

        return $controller_params;
    }

    /**
     * Get url params from request
     * @access private
     * @static
     * @param array $pMatchedArr
     * @return array|null
     */
    static private function getParamsFromRequest($pMatchedArr)
    {
        unset($pMatchedArr[0]);
        return $pMatchedArr ? array_map(function($item) {
                            return $item[0];
                        }, $pMatchedArr) : null;
    }

}