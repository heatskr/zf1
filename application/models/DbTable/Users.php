<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract {
  protected $_primary = array('id');
  protected $_name = 'users';
  protected $_rowClass = 'Application_Model_User';
  protected $_dependentTables = array(
    'Application_Model_DbTable_RolesUsers'
  );
}
