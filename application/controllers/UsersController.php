<?php

class UsersController extends Zf1_Controller_Resource {

  private $_rolesValues = array();

  protected function _getForm() {
    if (null === $this->_form) {
      $this->_form = new Application_Form_User();
      if ($this->getParam('action') == 'edit') {
        $this->_form->getElement('password')->setRequired(false);
        foreach ($this->_getRow()->getRoles() as $role) {
          array_push($this->_rolesValues, $role->id);
        }
        $this->_form->setDefault('roles', $this->_rolesValues);
      }
    }
    return $this->_form;
  }

  protected function _proccessEdit() {
    if (empty($this->_values['password'])) {
      unset($this->_values['password']);
    }
  }

  protected function _beforeSave() {
    if (array_key_exists('password', $this->_values)) {
      $this->_row->password = sha1($this->_row->password);
    }
  }

  protected function _afterSave() {
    $rolesUsersTable = new Application_Model_DbTable_RolesUsers();
    $removedRoles = array_diff($this->_rolesValues, $this->_values['roles']);
    foreach ($removedRoles as $rid) {
      $roleUser = $rolesUsersTable->fetchRow(array(
        'role_id = ?' => (int) $rid,
        'user_id = ?' => (int) $this->_row->id
      ));
      $roleUser->delete();
    }
    foreach ($this->_values['roles'] as $rid) {
      $roleUser = $rolesUsersTable->fetchRow(array(
        'role_id = ?' => (int) $rid,
        'user_id = ?' => (int) $this->_row->id
      ));
      if ($roleUser === null) {
        $rolesUsersTable->insert(array(
          'role_id' => $rid,
          'user_id' => $this->_row->id
        ));
      }
    }
  }

  public function signInAction() {
    $form = new Application_Form_SignIn();
    if ($this->_request->isPost()) {
      if ($form->isValid($this->_getAllParams())) {
        $values = $form->getValidValues($this->_getAllParams());

        $authAdapter = $this->getInvokeArg('bootstrap')
          ->getResource('authAdapter');
        $authAdapter->setIdentity($this->getParam('username'));
        $authAdapter->setCredential($this->getParam('password'));
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()) {
          $storage = $auth->getStorage();
          $dbTable = new Application_Model_DbTable_Users();
          $row = $dbTable->fetchRow($authAdapter->getResultRowObject()->id);
          $row->getRoles();
          $storage->write($row);
          $this->_redirect('');
        } else {
          foreach ($result->getMessages() as $message) {
            $form->addDecorator('FormErrors');
            $form->addErrorMessage($message);
          }
        }
      }
    } else {
      $this->view->form = $form;
      $this->renderScript('resources/new.phtml');
    }
  }

  public function signOutAction() {
    Zend_Auth::getInstance()->clearIdentity();
    $this->_redirect('');
  }
}