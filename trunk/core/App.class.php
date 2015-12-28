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
 * App
 * @package core
 */
class App
{

    /**
     * Controller and params
     * @access public
     * @static
     * @var array
     */
    static public $mControllerAndParams = array();
    /**
     * PHPTemplate singleton object
     * @access public
     * @static
     * @var PHPTemplate
     */
    static private $mTemplateObj = null;
    /**
     * Log object
     * @access private
     * @static
     * @var object
     */
    static private $mLogObj = null;

    /**
     * App init
     * @access public
     * @static
     */
    static public function init()
    {
        self::importCore();
        ProjectConfiguration::init();

        date_default_timezone_set(ProjectConfiguration::getConfig('timezone'));

        self::initLog();
        set_error_handler('App::errorHandler', 
                ProjectConfiguration::getConfig('error_level'));

        Loader::init();
        
        self::$mControllerAndParams = Loader::getControllerFromUrlObject();
        self::$mTemplateObj = PHPTemplate::getInstance();
    }

    /**
     * Application run
     * @access public
     * @static
     */
    static public function run()
    {
        is_null(self::$mControllerAndParams['p'])
            ? call_user_func(self::$mControllerAndParams['c'])
            : call_user_func_array(self::$mControllerAndParams['c'],
                    self::$mControllerAndParams['p']);
    }

    /**
     * Set template layout
     * @access public
     * @static
     * @param boolean $pIsLayout
     */
    static public function setLayout($pIsLayout = true)
    {
        self::$mTemplateObj->setLayout($pIsLayout);
    }

    /**
     * Set template values
     * @access public
     * @static
     * @param string $pVar
     * @param mixed $pValue
     */
    static public function setVar($pVar, $pValue)
    {
        self::$mTemplateObj->setVar($pVar, $pValue);
    }

    /**
     * Set template title
     * @access public
     * @static
     * @param string $pTitle
     */
    static public function setTitle($pTitle)
    {
        self::$mTemplateObj->setVar('TEMPLATE_TITLE', $pTitle);
    }

    /**
     * Set template JS file, eg: jquery,common...
     * @access public
     * @static
     * @param string $pJSFileName
     */
    static public function setJSFile($pJSFileName)
    {
        self::$mTemplateObj->setVar('TEMPLATE_JS', $pJSFileName);
    }

    /**
     * Set template css file, eg: main,style...
     * @access public
     * @static
     * @param string $pCSSFileName
     */
    static public function setCSSFile($pCSSFileName)
    {
        self::$mTemplateObj->setVar('TEMPLATE_CSS', $pCSSFileName);
    }

    /**
     * Set template keywords
     * @access public
     * @static
     * @param string $pKeywords
     */
    static public function setKeywords($pKeywords)
    {
        self::$mTemplateObj->setVar('TEMPLATE_KEYWORDS', $pKeywords);
    }

    /**
     * Set template description
     * @access public
     * @static
     * @param string $pDescription
     */
    static public function setDescription($pDescription)
    {
        self::$mTemplateObj->setVar('TEMPLATE_DESCRIPTION', $pDescription);
    }

    /**
     * Set template charset
     * @access public
     * @static
     * @param string $pCharset
     */
    static public function setCharset($pCharset)
    {
        self::$mTemplateObj->setVar('TEMPLATE_CHARSET', $pCharset);
    }

    /**
     * Get the default template file name
     * @access private
     * @static
     * @return string
     */
    static private function getDefaultTemplate()
    {
        $type = gettype(self::$mControllerAndParams['c']);
        $temp = '';
        if ($type == 'string') {
            list($p1, $p2) = explode('::', self::$mControllerAndParams['c']);
            $temp = $p1.(is_null($p2) ? '' : ('/'.$p2));
        } elseif ($type == 'array') {
            list($p1, $p2) = self::$mControllerAndParams['c'];
            $temp = $p1.'/'.$p2;
        }
        return $temp;
    }

    /**
     * Template show
     * @access public
     * @static
     * @param string $pTemplateName
     */
    static public function display($pTemplateName = null)
    {
        $template_file  = ProjectConfiguration::getConfig('template_dir');
        $template_file .= ($pTemplateName ? : self::getDefaultTemplate()).'.php';
        self::$mTemplateObj->display($template_file);
    }

    /**
     * Import file or directory
     * @access public
     * @static
     * @param string $pPathName filepath or directory
     * @return none
     */
    static public function import($pPathName)
    {
        if (is_dir($pPathName)) {
            $dir = dir($pPathName);
            while (false !== ($item = $dir->read())) {
                if ($item != '.' && $item != '..') {
                    $item = $pPathName.'/'.$item;
                    if (is_dir($item)) {
                        self::import($item);
                    } else if (self::getFileExtension($item) == 'php') {
                        include_once $item;
                    }
                }
            }
        } else if (is_file($pPathName)
                && self::getFileExtension($pPathName) == 'php') {
            include_once $pPathName;
        }
        return;
    }

    /**
     * Get file extension
     * @access public
     * @static
     * @param string $pFileName
     * @return string
     */
    static public function getFileExtension($pFileName)
    {
        return substr($pFileName, strrpos($pFileName, '.') + 1);
    }

    /**
     * Import core file
     * @access public
     * @static
     */
    static public function importCore()
    {
        self::import(__DIR__);
        self::import(__DIR__.'/../lib');
        self::import(__DIR__.'/../model');
    }

    /**
     * Get complete url
     * @access public
     * @static
     * @param string $pUri
     * @return string
     */
    static public function getUrl($pUri = '')
    {
        $url  = 'http://' . $_SERVER['SERVER_NAME']
            . dirname($_SERVER['SCRIPT_NAME']) . '/' . $pUri;
        return $url;
    }

    /**
     * Redirect
     * @access public
     * @static
     * @param string $pUri
     * @param string $pType LOCATION|REFRESH|META|JS
     */
    static public function redirect($pUri = '', $pType = 'LOCATION')
    {
        $url = preg_match('/^http:\/\//i', $pUri) ? $pUri : self::getUrl($pUri);
        switch ($ptype) {
            case 'LOCATION':
                header("Location: {$url}");
                exit;
            case 'REFRESH':
                header("Refresh: 0; url='".$url."'");
                exit;
            case 'META':
                echo "<mate http-equiv='refresh' content='0; url='".$url."' />";
                exit;
            case 'JS':
                echo "<script type='text/javascript'>";
                echo "window.location.href='".$url."';";
                echo "</script>";
                exit;
        }
    }

    /**
     * Uri call
     * @access public
     * @static
     * @param string $pUri path
     */
    static public function call($pUri)
    {
        self::$mControllerAndParams = Loader::getControllerFromUrlObject($pUri);
        self::run();
    }

    /**
     * Log init
     * @access private
     * @static
     */
    static private function initLog()
    {
        if (is_null(self::$mLogObj)) {
            self::import(ProjectConfiguration::getConfig('plugin_dir').'Log/Log.php');
            self::$mLogObj = Log::singleton('file', 
                    ProjectConfiguration::getConfig('log_dir').date('Y-m').'.log',
                    'Fabos');
        }
    }

    /**
     * Set log message
     * @access public
     * @static
     * @param mixed $pMsg
     * @param string $pPriority
     * @return boolean
     */
    static public function setLog($pMsg, $pPriority = null)
    {
        return self::$mLogObj->log($pMsg, $pPriority);
    }

    /**
     * Error handler
     * @access public
     * @static
     * @param int $pCode
     * @param string $pMsg
     * @param string $pFile
     * @param string $pLine
     */
    static public function errorHandler($pCode, $pMsg, $pFile, $pLine)
    {
        switch ($pCode) {
            case E_WARNING:
            case E_USER_WARNING:
                $priority = PEAR_LOG_WARNING;
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                $priority = PEAR_LOG_NOTICE;
                break;
            case E_ERROR:
            case E_USER_ERROR:
                $priority = PEAR_LOG_ERR;
                break;
            default:
                $priority = PEAR_LOG_INFO;
        }
        $tmp = $pMsg.' in '.$pFile.' at line '.$pLine;
        self::setLog($tmp, $priority);

        if (ProjectConfiguration::getConfig('is_debug')) {
            Output::error($tmp);
            Output::backtrace();
        }
    }
    
}