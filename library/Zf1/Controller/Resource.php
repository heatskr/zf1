<?php

require_once 'Zf1/Util/String.php';

class Zf1_Controller_Resource extends Zend_Controller_Action {

  protected $_dbTable;

  protected $_form;

  protected $_values;

  protected $_row;

  public function indexAction() {
    $this->view->info =  $this->_getDbTable()->info();
    $this->view->rowset =  $this->_getDbTable()->fetchAll();
    $this->_renderView();
  }

  public function newAction() {
    $form = $this->_getForm();
    $form->removeElement('id');
    if ($this->_request->isPost() && $form->isValid($this->getAllParams())) {
      $this->_values = $form->getValidValues($this->getAllParams());

      $this->_proccessNew();
      $this->_clearValues();
      $this->_row = $this->_getDbTable()->createRow($this->_values);

      $this->_beforeCreate();
      $this->_beforeSave();
      $this->_row->save();
      $this->_afterCreate();
      $this->_afterSave();

      $this->_redirect($this->_helper->url('index'));
    } else {
      $this->view->form = $form;
      $this->_renderView();
    }
  }

  public function editAction() {
    $form = $this->_getForm();
    $form->getElement('id')->setAttrib('readonly', 'readonly');
    $form->setDefaults($this->_getRow()->toArray());
    if ($this->_request->isPost() && $form->isValid($this->getAllParams())) {
      $this->_values = $form->getValidValues($this->getAllParams());

      $this->_proccessEdit();
      $this->_clearValues();
      $this->_row->setFromArray($this->_values);

      $this->_beforeCreate();
      $this->_beforeSave();
      $this->_row->save();
      $this->_afterCreate();
      $this->_afterSave();

      $this->_redirect($this->_helper->url('index'));
    } else {
      $this->view->form = $form;
      $this->_renderView();
    }
  }

  public function destroyAction() {
    if ($this->_request->isPost()) {
      $this->_beforeDelete();
      $this->_getRow()->delete();
      $this->_afterDelete();
      $this->_redirect($this->_helper->url('index'));
    } else {
      $this->_renderView();
    }
  }

  protected function _getDbTable() {
    if (null === $this->_dbTable) {
      $dbTableClass = 'Application_Model_DbTable_' .
        Zf1_Util_String::camelize($this->getParam('controller'));
      $this->_dbTable = new $dbTableClass();
    }
    return $this->_dbTable;
  }

  protected function _getForm() {
    if (null === $this->_form) {
      $info = $this->_getDbTable()->info();
      $this->_form = new Zend_Form();
      foreach ($info['metadata'] as $name => $col) {
        $this->_form->addElement('text', $name, array(
          'label' => Zf1_Util_String::humanize($name),
          'class' => 'form-control',
          'required' => !$col['NULLABLE']
        ));
      }
      $this->_form->addElement('submit', 'commit', array(
        'label' => 'Save',
        'class' => 'btn btn-default'
      ));
    }
    return $this->_form;
  }

  protected function _getRow() {
    if (null === $this->_row) {
      $this->_row = $this->_getDbTable()->fetchRow(array(
        'id = ?' => (int) $this->getParam('id')
      ));
      if (null === $this->_row) {
        throw new Zend_Controller_Dispatcher_Exception('Page not found');
      }
    }
    return $this->_row;
  }

  protected function _renderView() {
    $viewScript = $this->_helper->viewRenderer->getViewScript();
    $scriptPath = $this->view->getScriptPath($viewScript);
    if (!is_file($scriptPath)) {
      $viewScript = 'resources/' . $this->getParam('action') . '.phtml';
    }
    $this->renderScript($viewScript);
  }

  protected function _log($message, $priority = null) {
    $this->getInvokeArg('bootstrap')->getResource('log')
      ->log($message, $priority);
  }

  protected function _proccessNew() {}
  protected function _proccessEdit() {}
  protected function _beforeSave() {}
  protected function _beforeCreate() {}
  protected function _beforeUpdate() {}
  protected function _beforeDelete() {}
  protected function _afterSave() {}
  protected function _afterCreate() {}
  protected function _afterUpdate() {}
  protected function _afterDelete() {}

  private function _clearValues() {
    unset($this->_values['id']);
    foreach ($this->_values as $key => $value) {
      if ($value == '') {
        $this->_values[$key] = null;
      }
    }
  }

}
