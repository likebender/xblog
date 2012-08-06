<?php
error_reporting(E_ALL);
define('DS',DIRECTORY_SEPARATOR);
define('US','/');
ini_set('display_errors',1);
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

define('MODULE_PATH', APPLICATION_PATH . DS .'modules');

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Xblog/Application.php';

// Create application, bootstrap, and run
$application = new ZendX_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();

/**
 $options = array(
"dbname" => 'xblog',
"username"=>'root',
"password" => '123',
"host" =>'127.0.0.1',
);
$select = Zend_Db::factory("Pdo_Mysql",$options);
 */