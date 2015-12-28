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
 * PHPTemplate
 * @package core
 * @subpackage template
 */
class PHPTemplate
{
    /**
     * PHPTemplate object
     * @access public
     * @static
     * @var PHPTemplate
     */
    static public $mSingleton = null;
    /**
     * Set layout
     * @access private
     * @var boolean
     */
    private $mIsLayout = true;

    private function  __construct()
    {
        
    }

    /**
     * Get PHPTemplate singleton objec
     * @access public
     * @static
     * @return PHPTemplate
     */
    static public function getInstance()
    {
        self::$mSingleton = self::$mSingleton ? : new PHPTemplate();
        return self::$mSingleton;
    }

    /**
     * Set layout
     * @access public
     * @param boolean $pIsLayout
     */
    public function setLayout($pIsLayout = true)
    {
        $this->mIsLayout = (bool) $pIsLayout;
    }

    /**
     * Set object item
     * @access public
     * @param string $pName
     * @param mixed $pValue
     */
    public function setVar($pName, $pValue)
    {
        $this->$pName = $pValue;
    }

    /**
     * Display the template file
     * @access public
     * @param string $pTemplateFile
     */
    public function display($pTemplateFile)
    {
        $this->setVar('TEMPLATE_FILE', $pTemplateFile);
        extract(get_object_vars($this), EXTR_REFS);
        include_once($this->mIsLayout 
                ? (ProjectConfiguration::getConfig('template_dir').'layout.php')
                : $pTemplateFile);
    }
}