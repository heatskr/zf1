<?php

class Application_Form_Page extends Zend_Form {
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
      'label' => array(
        'type' => 'text',
        'options' => array(
          'required' => true,
          'label' => 'Label',
          'class' => 'form-control'
        )
      ),
      'description' => array(
        'textarea',
        'options' => array(
          'required' => false,
          'label' => 'Description',
          'class' => 'form-control',
          'attribs' => array(
            'rows' => 2
          )
        )
      ),
      'action_id' => array(
        'type' => 'select',
        'options' => array(
          'required' => true,
          'label' => 'Privilege',
          'class' => 'form-control',
          'multiOptions' => Application_Model_Action::getMultiOptions()
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