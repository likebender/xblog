<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 31.07.12
 * Time: 0:52
 * To change this template use File | Settings | File Templates.
 */
class Xblog_Layout_Controller_Resource_Xlayout extends Zend_Controller_Plugin_Abstract
{
    public function init()
    {
        require_once 'Zend/Controller/Front.php';
        $front = Zend_Controller_Front::getInstance();
        if (!$front->hasPlugin(get_class($this))) {
            $front->registerPlugin(
            // register to run last | BUT before the ErrorHandler (if its available)
                new Xblog_Layout_Controller_Plugin_Xlayout(),
                101
            );
        }

        return $this;
    }
}
