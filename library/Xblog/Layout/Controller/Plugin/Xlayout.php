<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 12.07.12
 * Time: 1:30
 * To change this template use File | Settings | File Templates.
 */
class Xblog_Layout_Controller_Plugin_Xlayout extends Zend_Controller_Plugin_Abstract
{
    protected $_layout;
    protected  $_configFile = 'layout.xml';

    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {

        $controllerDirectories = Zend_Controller_Front::getInstance()
            ->getDispatcher()
            ->getControllerDirectory();

        foreach ($controllerDirectories as $directory) {
            $path = str_replace('controllers','config', $directory)
                . DS . $this->_configFile;
            if (file_exists($path)) {
                $this->_extendLayoutConfig(
                    new Xblog_SimpleXml_Element($path, 0, true)
                );
            }
        }
        $para = $request->getParam('error_handler');
        if ($request->getParam('error_handler')) {
            $tagList = array(
                "no-route"
            );
            $request->setDispatched(true);
            $request->clearParams();
        } else {
            $tagList = array(
                $request->getModuleName(),
                $request->getControllerName(),
                $request->getActionName()
            );
        }


        $path = '.';
        $layout = null;
        $viewers = array();

        foreach ($tagList as $tag) {
            $path .= US.$tag;
            if (!$this->getLayout()->xpath($path)) {
                break;
            }
            $viewers = array_merge(
                $viewers,
                $this->getLayout()->xpath($path.'/viewer')
            );
            $layout = $this->getLayout()->xpath($path.'/layout') ?
                array_pop($this->getLayout()->xpath($path.'/layout')) :
                $layout;
        }

        if (!$layout) {
            throw new Exception('Layout tag should to present');
        }

        $options = $layout->getAttributes();
        $options['viewers'] = $viewers;

        $layoutObject = new Xblog_Layout_Layout($options);
        $layoutObject->setRequest($request);
        $this->getResponse()->setBody($layoutObject->toHtml());
    }

    public function _extendLayoutConfig(Xblog_SimpleXml_Element $xmlDocument)
    {
        if (!$this->getLayout()) {
            return $this->setLayout($xmlDocument);
        }
        $this->getLayout()->extend($xmlDocument);
        return $this;
    }

    public function getLayout()
    {
        return $this->_layout;
    }

    public function setLayout(Xblog_SimpleXml_Element $layout)
    {
        $this->_layout = $layout;
        return $this;
    }

    public function setRequest(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
    }

    public function getRequest()
    {
        if (!$this->_request instanceof Zend_Controller_Request_Abstract ) {
            $this->_request = new Zend_Controller_Request_Http();
        }
        return $this->_request;
    }
}
