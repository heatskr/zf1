<?php

class Application_Model_DbTable_Roles extends Zend_Db_Table_Abstract {
  protected $_primary = array('id');
  protected $_name = 'roles';
  protected $_rowClass = 'Application_Model_Role';
  protected $_dependentTables = array(
    'Application_Model_DbTable_RolesUsers'
  );
  protected $_referenceMap = array(
    'Parent' => array(
      'columns'         => array('parent_id'),
      'refTableClass'   => 'Application_Model_DbTable_Roles',
      'refColumns'      => array('id'),
      'onDelete'        => self::CASCADE_RECURSE
    )
  );
}
