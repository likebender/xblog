<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_pluginLoader;

    /*protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    } */
    protected function _initFallback()
    {
        Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
    }

    protected function _initFrontModules() {
        $this->bootstrap('frontController');
        $front = $this->getResource('frontController');
        $front->addModuleDirectory(MODULE_PATH);
    }

    /**
     * Get the plugin loader for resources
     *
     * @return Zend_Loader_PluginLoader_Interface
     */
    public function getPluginLoader()
    {
        $this->_pluginLoader = parent::getPluginLoader();
        Zend_Loader_Autoloader::getInstance()->registerNamespace('Xblog');

        $this->_pluginLoader
            ->addPrefixPath('Xblog_Layout_Controller_Resource','Xblog/Layout/Controller/Resource');

        return $this->_pluginLoader;
    }
}

