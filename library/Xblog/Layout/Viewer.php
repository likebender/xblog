<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 23.07.12
 * Time: 0:59
 * To change this template use File | Settings | File Templates.
 */
class Xblog_Layout_Viewer
{
    protected  $_options = array();
    protected $_defaultModule = 'default';
    protected $_viewDir = 'views';
    protected $_template;

    public function __construct($options = array())
    {
        $this->setOptions((array) $options);
        $trol = array_pop($this->_options);
        $this->_template = $trol['template'];
    }

    public function toHtml()
    {
        $this->_template = implode(DS,explode('/',$this->_template));
        $fullPath = MODULE_PATH
            . DS . $this->getRequest()->getModuleName()
            . DS . $this->_viewDir . DS . $this->_template;

        if (!file_exists($fullPath)) {
            $fullPath = MODULE_PATH.DS.$this->_defaultModule.DS.$this->_viewDir.DS.$this->_template;
        }

        if (file_exists($fullPath)) {
            include $fullPath;
        }
        return false;
    }

    public function setOptions(array $options)
    {
        $this->_options = array_merge(
            $this->_options,
            $options
        );

        return $this;
    }

    public function getOptions($name)
    {
        if (isset($this->_options[$name])) {
            return $this->_options[$name];
        }
        return null;
    }

    public function getRequest()
    {
        if ($this->_request === null) {
            $this->_request = new Zend_Controller_Request_Http();
        }
        return $this->_request;
    }

    public function setRequest(Zend_Controller_Request_Http $request)
    {
        $this->_request = $request;
    }

}
