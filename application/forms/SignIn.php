<?php

class Application_Form_SignIn extends Zend_Form {
  public function init() {
    $this->addElements(array(
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
      'commit' => array(
        'type' => 'submit',
        'options' => array(
          'label' => 'Send',
          'class' => 'btn btn-default'
        )
      )
    ));
  }
}
