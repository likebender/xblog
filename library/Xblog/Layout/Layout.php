<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 20.07.12
 * Time: 0:50
 * To change this template use File | Settings | File Templates.
 */
class Xblog_Layout_Layout
{
    protected $_options;
    protected $_defaultModule = 'default';
    protected $_request;
    protected $_viewDir = 'views';
    protected $_viewers = array();
    protected $_viewersData;
    protected $_template;

    public function __construct($options)
    {
        $this->setOptions($options);
    }

    public function setOptions($options)
    {
        $this->_options = $options;
        if (!isset($options['template'])) {
            throw new Exception("Template should be specified");
        }
        $this->_template = $options['template'];
        if (isset($options['viewers'])) {
            $this->setViewers($options['viewers']);
        }
    }

    public function setViewers($viewers)
    {
        $this->_viewersData = $viewers;
    }

    public function getArea($name)
    {
        foreach($this->_viewersData as $view) {
            if ($view->attributes()->area == $name) {
                $this->_viewers[$name] = $this->createViewer($view->attributes());
                $this->_viewers[$name]->toHtml();
            }
        }
    }

    public function createViewer($attributes)
    {
        try {
            if ($type = (string)$attributes->type) {
                $class = new $type($attributes);
                $class->setRequest($this->_request);
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $class;
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
            ob_start();
            include $fullPath;
            return ob_get_clean();
        }
        return false;
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
