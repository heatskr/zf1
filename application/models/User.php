<?php

class Application_Model_User extends Zend_Db_Table_Row_Abstract {
  protected $_tableClass = 'Application_Model_DbTable_Users';
  protected $_roles;
  public function getRoles($rule = null) {
    if ($this->_roles === null) {
      $this->_roles = $this->findManyToManyRowset(
        'Application_Model_DbTable_Roles',
        'Application_Model_DbTable_RolesUsers',
        $rule
      );
    }
    return $this->_roles;
  }
}
