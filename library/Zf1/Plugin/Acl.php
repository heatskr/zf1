<?php

class Zf1_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
  // public function routeStartup(Zend_Controller_Request_Abstract $request) {
  //   $this->getResponse()->appendBody("<p>routeStartup() called</p>\n");
  // }
  //
  // public function routeShutdown(Zend_Controller_Request_Abstract $request) {
  //   $this->getResponse()->appendBody("<p>routeShutdown() called</p>\n");
  // }

  public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
    $acl = Zend_Controller_Front::getInstance()
      ->getParam('bootstrap')->getResource('acl');
    $resource = $request->getModuleName() . ':' .
      $request->getControllerName();
    $privilege = $request->getActionName();

    if (!$acl->has($resource)) {
      return;
    }

    $result = false;

    $auth = Zend_Auth::getInstance();
    $roles = array();
    if ($auth->hasIdentity()) {
      $user   = $auth->getStorage()->read();
      $user->setTable(new Application_Model_DbTable_Users());
      foreach ($user->getRoles() as $role) {
        array_push($roles, $role->name);
      }
    } else {
      array_push($roles, 'guest');
    }
    foreach ($roles as $role) {
      if ($acl->isAllowed($role, $resource, $privilege)) {
        $result = true;
        break;
      }
    }
    if (!$result) {
      $url = Zend_Controller_Action_HelperBroker::getStaticHelper('url');
      $this->getResponse()->setRedirect($url->url(array(
        'controller' => 'users',
        'action' => 'sign-in'
      )));
    }
  }

  // public function preDispatch(Zend_Controller_Request_Abstract $request) {
  //   $this->getResponse()->appendBody("<p>preDispatch() called</p>\n");
  // }

  // public function postDispatch(Zend_Controller_Request_Abstract $request) {
  //   $this->getResponse()->appendBody("<p>postDispatch() called</p>\n");
  // }

  // public function dispatchLoopShutdown() {
  //   $this->getResponse()->appendBody("<p>dispatchLoopShutdown() called</p>\n");
  // }
}