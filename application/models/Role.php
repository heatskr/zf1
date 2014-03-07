<?php

class Application_Model_Role extends Zend_Db_Table_Row_Abstract {
  protected $_tableClass = 'Application_Model_DbTable_Roles';
  protected $_users;
  protected $_parent;
  public function getUsers($rule = null) {
    if ($this->_users === null) {
      $this->_users = $this->findManyToManyRowset(
        'Application_Model_DbTable_Users',
        'Application_Model_DbTable_RolesUsers',
        $rule
      );
    }
    return $this->_users;
  }
  public function getParent() {
    if (null === $this->_parent) {
      $this->_parent = $this->findParentRow(
        'Application_Model_DbTable_Roles', 'Parent');
      if (null === $this->_parent) {
        $this->_parent = false;
      }
    }
    return $this->_parent;
  }
  static function getMultiOptions() {
    $roles = array();
    $rolesTable = new Application_Model_DbTable_Roles();
    foreach ($rolesTable->fetchAll('id > 1') as $role) {
      $roles[$role->id] = $role->name;
    }
    return $roles;
  }
}
