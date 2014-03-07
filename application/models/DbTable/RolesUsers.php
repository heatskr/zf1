<?php

class Application_Model_DbTable_RolesUsers extends Zend_Db_Table_Abstract
{
  protected $_primary = array('id');
  protected $_name = 'roles_users';
  protected $_referenceMap = array(
    'Role' => array(
      'columns'         => array('role_id'),
      'refTableClass'   => 'Application_Model_DbTable_Roles',
      'refColumns'      => array('id'),
      'onDelete'        => self::CASCADE_RECURSE
    ),
    'User' => array(
      'columns'         => array('user_id'),
      'refTableClass'   => 'Application_Model_DbTable_Users',
      'refColumns'      => array('id'),
      'onDelete'        => self::CASCADE_RECURSE
    )
  );
}
