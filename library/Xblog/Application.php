<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 7/27/12
 * Time: 2:11 PM
 * To change this template use File | Settings | File Templates.
 */
require_once 'Zend/Application.php';
class ZendX_Application extends Zend_Application
{
    protected $_configFileName = 'config.ini';
    protected $_configFolder = 'config';
    protected $_activeModules = array();

    /**
     * Constructor
     *
     * Initialize application. Potentially initializes include_paths, PHP
     * settings, and bootstrap class.
     *
     * @param  string                   $environment
     * @param  string|array|Zend_Config $options String path to configuration file, or array/Zend_Config of configuration options
     * @throws Zend_Application_Exception When invalid options are provided
     * @return void
     */
    public function __construct($environment, $options = null)
    {
        $this->_environment = (string) $environment;

        require_once 'Zend/Loader/Autoloader.php';
        $this->_autoloader = Zend_Loader_Autoloader::getInstance();
        $options = $this->_loadModuleConfigs();
        $this->setOptions($options);
    }

    /**
     * activate modules and load module configs and set options
     * @return array
     */
    public function _loadModuleConfigs()
    {
        $modules = new DirectoryIterator(MODULE_PATH);
        $_options = array();

        foreach($modules as $module) {
            if ($module->isDot()) {
                continue;
            }
            $modulePath = MODULE_PATH
                . DS . $module->getFilename();
            $configPath = $modulePath
                . DS . $this->_configFolder
                . DS . $this->_configFileName;

            $this->_activeModule[$module->getFilename()] = array(
                'module' => $modulePath,
                "config" => $configPath
            );

            if (file_exists($configPath)) {
                $_options = $this->mergeOptions($_options, $this->_loadConfig($configPath));
            }
        }
        $_options['modules'] = $this->_activeModule;

        return $_options;
    }
}
