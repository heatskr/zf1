<?php

class Application_Form_Role extends Zend_Form {
  public function init() {
    $rolesTable = new Application_Model_DbTable_Roles();
    $roles = $rolesTable->fetchAll(null, 'name ASC');
    $multiOptions = array('' => '');
    foreach ($roles as $role) {
      $multiOptions[$role->id] = $role->name;
    }
    $this->addElements(array(
      'id' => array(
        'type'    => 'text',
        'options' => array(
          'required' => true,
          'readonly' => 'readonly',
          'label'    => 'Id',
          'class'    => 'form-control'
        )
      ),
      'name' => array(
        'type' => 'text',
        'options' => array(
          'required' => true,
          'label' => 'Name',
          'class' => 'form-control'
        )
      ),
      'parent_id' => array(
        'type' => 'select',
        'options' => array(
          'required' => false,
          'label' => 'Parent',
          'class' => 'form-control',
          'multiOptions' => $multiOptions
        )
      ),
      'commit' => array(
        'type' => 'submit',
        'options' => array(
          'label' => 'Save',
          'class' => 'btn btn-default'
        )
      )
    ));
  }
}
