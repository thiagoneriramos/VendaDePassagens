<?php

// app/Controller/UsersController.php
class UsersController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','logout', 'loggedout');

    }

    public function view_action() {
        // códigos
        $this->layout = 'layoutPrincipal';
    }

    public function login() {
        if ($this->Auth->login()) {
            $this->redirect($this->Auth->redirect());
        } else {
            $this->Session->setFlash(__('Usuario ou Senha invalidos.'));
        }
        self::view_action();
    }

    

    public function logout() {
        if($this->Auth->logout()){
            $this->redirect(Router::url('/',true));
        }

    }
    
    public function loggedout(){
        //do nothing
    }

    public function index() {
        
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
         self::view_action();
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
         self::view_action();
    }

     public function add(){
        
        if($this->request->is('post')){
           
            if($this->User->save($this->request->data,false)){
                $this->Session->setFlash('Usuario salvo com sucesso!');
                $this->redirect(array('action'=>'index'));
            }
        }
         self::view_action();
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
         self::view_action();
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}