<?php

class PermissionsController extends Zend_Controller_Action {
  public function indexAction() {
    $acl = $this->getInvokeArg('bootstrap')->getResource('acl');
    $navigation = $this->getInvokeArg('bootstrap')->getResource('navigation');

    $fileActions = $this->_getFromFiles();
    $actions = array();

    foreach ($fileActions as $fileResource => $filePrivileges) {
      if (!array_key_exists($fileResource, $actions)) {
        $actions[$fileResource] = array();
      }
      foreach ($filePrivileges as $filePrivilege) {
        if (!array_key_exists($filePrivilege, $actions[$fileResource])) {
          $actions[$fileResource][$filePrivilege] = array(
            'label' => '',
            'title' => '',
            'file'  => true,
            'menu'  => false
          );
        }
      }
    }

    $rci = new RecursiveCachingIterator($navigation,
      CachingIterator::FULL_CACHE);
    $rii = new RecursiveIteratorIterator($rci,
      RecursiveIteratorIterator::SELF_FIRST);
    foreach ($rii as $page) {
      $actionName = $page->action == null ? 'index' : $page->action;
      if (!array_key_exists($page->controller, $actions)) {
        $actions[$page->controller] = array();
      }
      if (!array_key_exists($actionName, $actions[$page->controller])) {
        $actions[$page->controller][$actionName] = array(
          'file'  => false
        );
      }
      $actions[$page->controller][$actionName]['label'] = $page->label;
      $actions[$page->controller][$actionName]['title'] = $page->title;
      $actions[$page->controller][$actionName]['menu'] = true;
    }

    $this->view->roles = $acl->getRoles();
    $this->view->actions = $actions;
  }

  private function _getFromFiles() {
    require_once 'Zf1/Util/String.php';
    $actions = array();
    $count = 0;
    $controllerDirectory = realpath(APPLICATION_PATH . '/controllers');
    $files = array_slice(scandir($controllerDirectory), 2);
    foreach ($files as $file) {
      $filename = $controllerDirectory . '/' . $file;
      require_once $filename;
      $className = preg_replace('/.php$/', '', $file);
      $controllerName = preg_replace('/Controller$/', '', $className);
      Zf1_Util_String::parameterize(&$controllerName);
      $resource = $controllerName;
      $actions[$resource] = array();
      $r = new Zend_Reflection_Class($className);
      foreach ($r->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if (preg_match('/Action$/', $method->name)) {
          $count++;
          $actionName = preg_replace('/Action$/', '', $method->name);
          Zf1_Util_String::parameterize(&$actionName);
          $actions[$resource][$count] = $actionName;
        }
      }
    }
    return $actions;
  }

}
