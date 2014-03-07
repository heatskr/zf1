<?php

class Application_Form_User extends Zend_Form {
  public function init() {
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
      'username' => array(
        'type' => 'text',
        'options' => array(
          'required' => true,
          'label' => 'Username',
          'class' => 'form-control'
        )
      ),
      'password' => array(
        'type' => 'password',
        'options' => array(
          'required' => true,
          'label' => 'Password',
          'class' => 'form-control'
        )
      ),
      'roles' => array(
        'type' => 'multicheckbox',
        'options' => array(
          'label' => 'Roles',
          'required' => true,
          'multiOptions' => Application_Model_Role::getMultiOptions()
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
