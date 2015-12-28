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
 * Output
 * @package core
 * @subpackage template
 */
class Output
{
    static private $mStyle = 'border:1px dashed #CCC; font-family:Arial; 
        font-size:12px; background-color:#FFC; line-height:20px; color:#666;
        padding:5px; margin-bottom:15px;';

    /**
     * Import all js files, eg: jquery,common...
     * @access public
     * @static
     * @global string $TEMPLATE_JS App set template js files
     * @param string $pJSFile
     */
    static public function importJS($pJSFile = '')
    {
        global $TEMPLATE_JS;
        $pJSFile = $pJSFile ? : (
                $TEMPLATE_JS ? : ProjectConfiguration::getConfig('js_file'));
        if (!empty($pJSFile)) {
            $js_arr = explode(',', $pJSFile);
            foreach ($js_arr as $item) {
                $url = App::getUrl("js/{$item}.js");
                echo "<script type='text/javascript' src='{$url}'></script>\n";
            }
        }
    }

    /**
     * Import all css files, eg: style, common...
     * @access public
     * @static
     * @global string $TEMPLATE_CSS App set template css files
     * @param string $pCSSFile
     */
    static public function importCSS($pCSSFile = '')
    {
        global $TEMPLATE_CSS;
        $pCSSFile = $pCSSFile ? : (
                $TEMPLATE_CSS ? : ProjectConfiguration::getConfig('css_file'));
        if (!empty($pCSSFile)) {
            $css_arr = explode(',', $pCSSFile);
            foreach ($css_arr as $item) {
                $url = App::getUrl("css/{$item}.css");
                echo "<link rel='stylesheet' type='text/css' href='{$url}'/>\n";
            }
        }
    }

    /**
     * Output template charset
     * @access public
     * @static
     * @global string $TEMPLATE_CHARSET
     * @param string $pCharset
     */
    static public function charset($pCharset = '')
    {
        global $TEMPLATE_CHARSET;
        $pCharset = $pCharset ? : (
                $TEMPLATE_CHARSET ? : ProjectConfiguration::getConfig('page_charset'));
        echo "<meta http-equiv='content-type' content='text/html; charset={$pCharset}'/>\n";
    }

    /**
     * Ouput template keywords
     * @access public
     * @static
     * @global string $TEMPLATE_KEYWORDS
     * @param string $pKeywords
     */
    static public function keywords($pKeywords = '')
    {
        global $TEMPLATE_KEYWORDS;
        $pKeywords = $pKeywords ? : (
                $TEMPLATE_KEYWORDS ? : ProjectConfiguration::getConfig('page_keywords'));
        if (!empty($pKeywords)) self::meta('keywords', $pKeywords);
    }

    /**
     * Output template description
     * @access public
     * @static
     * @global string $TEMPLATE_DESCRIPTION
     * @param string $pDescription
     */
    static public function description($pDescription = '')
    {
        global $TEMPLATE_DESCRIPTION;
        $pDescription = $pDescription ? : (
                $TEMPLATE_DESCRIPTION ? : ProjectConfiguration::getConfig('page_description'));
        if (!empty($pDescription))  self::meta('description', $pDescription);
    }

    /**
     * Output template meta
     * @access public
     * @static
     * @param string $pName
     * @param string $pContent
     */
    static public function meta($pName, $pContent)
    {
        echo "<meta name='{$pName}' content='{$pContent}'/>\n";
    }

    /**
     * Output template title
     * @access public
     * @static
     * @global string $TEMPLATE_TITLE
     * @param string $pTitle
     */
    static public function title($pTitle = '')
    {
        global $TEMPLATE_TITLE;
        $pTitle = $pTitle ? : (
                $TEMPLATE_TITLE ? : ProjectConfiguration::getConfig('page_title'));
        echo $pTitle;
    }

    /**
     * Output phpinfo
     * @access public
     * @static
     */
    static public function phpinfo()
    {
        phpinfo();
    }

    /**
     * Output the complete url
     * @access public
     * @static
     * @param string $pUri
     */
    static public function url($pUri = '')
    {
        echo App::getUrl($pUri);
    }

    static public function error($pErr)
    {
        echo '<div style="', self::$mStyle, '">', $pErr, '</div>';
    }

    /**
     * Backtrace program
     * @access public
     * @static
     * @return string
     */
    static public function backtrace()
    {
        $output = '<div style="' . self::$mStyle . '"><p><B>Backtrace:</B></p>';
        $backtrace = debug_backtrace();

        foreach ($backtrace as $bt) {
            $args = '';
            foreach ($bt['args'] as $a) {
                if (!empty($args))  $args .= ', ';
                switch (gettype($a)) {
                    case 'integer':
                    case 'double':
                        $args .= $a;
                        break;
                    case 'string':
                        $a = htmlspecialchars(
                                substr($a, 0, 100)) . ((strlen($a) > 100) ? '...' : '');
                        $args .= "\"$a\"";
                        break;
                    case 'array':
                        $args .= 'Array(' . count($a) . ')';
                        break;
                    case 'object':
                        $args .= 'Object(' . get_class($a) . ')';
                        break;
                    case 'resource':
                        $args .= 'Resource(' . strstr($a, '#') . ')';
                        break;
                    case 'boolean':
                        $args .= $a ? 'True' : 'False';
                        break;
                    case 'NULL':
                        $args .= 'Null';
                        break;
                    default:
                        $args .= 'Unknown';
                }
            }
            $output .= "<p>#{$bt['line']} Call: ";
            $output .= "{$bt['class']}{$bt['type']}{$bt['function']}($args) - {$bt['file']}</p>";
        }
        echo $output,"</div>";
    }
    
}