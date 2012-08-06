<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MIron
 * Date: 24.04.12
 * Time: 0:22
 * To change this template use File | Settings | File Templates.
 */
 
class Auth_AuthController extends Zend_Controller_Action
{
      public function indexAction()
      {
          $fc = Zend_Controller_Front::getInstance();
          
          $this->render();

      }
}
