<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 01.07.12
 * Time: 2:11
 * To change this template use File | Settings | File Templates.
 */
class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->render();
        /*$fc = Zend_Controller_Front::getInstance();

        $this->render();*/

    }
}
