<?php

class Zf1_Bootstrap_Resource_Acl extends Zend_Application_Resource_ResourceAbstract {
  protected $_acl;

  public function init() {
    return $this->getAcl();
  }

  public function getAcl() {
    if (null === $this->_acl) {
      $acl = new Zend_Acl();
      $options = $this->getOptions();

      foreach ($options['roles'] as $role) {
        call_user_func_array(array($acl, 'addRole'), explode(' ', $role));
      }

      $navigation = $this->getBootstrap()
        ->bootstrap('navigation')->getResource('navigation');

      foreach ($navigation->findAllBy('-', null) as $page) {
        if (!$acl->has($page->getResource())) {
          $acl->addResource($page->getResource());
        }
      }

      foreach ($options['resources'] as $resource) {
        if (!$acl->has($resource)) {
          $acl->addResource($resource);
        }
      }

      foreach ($options['rules'] as $rule) {
        $rule = array_pad(explode(' ', $rule), 5, null);
        list($op, $type, $role, $res, $priv) = $rule;

        if ($op == 'add') {
          $op = Zend_Acl::OP_ADD;
        } elseif ($op == 'remove') {
          $op = Zend_Acl::OP_REMOVE;
        } else {
          throw new Zend_Application_Resource_Exception(
            'Invalid OP:  ' . $op);
        }

        if ($type == 'allow') {
          $type = Zend_Acl::TYPE_ALLOW;
        } elseif ($type == 'deny') {
          $type = Zend_Acl::TYPE_DENY;
        } else {
          throw new Zend_Application_Resource_Exception(
            'Invalid TYPE:  ' . $type);
        }

        $acl->setRule($op, $type, $role, $res, $priv);
      }

      $auth = Zend_Auth::getInstance();

      if ($auth->hasIdentity()) {
        $this->getBootstrap()->bootstrap('db');
        $user = $auth->getStorage()->read();
        $user->setTable(new Application_Model_DbTable_Users());
        $roles = $user->getRoles();
        $role = $roles->current()->name;
      } else {
        $role = 'guest';
      }

      $this->getBootstrap()->bootstrap('view')->getResource('view')
        ->navigation()->setAcl($acl)->setRole($role);

      $this->_acl = $acl;
    }
    return $this->_acl;
  }
}
