<?php

namespace Se7entech\Contractnew\Modules\Departments\Controllers;

use Se7entech\Contractnew\Modules\Departments\Models\DepartmentsModel;
use Se7entech\Contractnew\Modules\Users\Models\UserModel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

class DepartmentsController{
    public $data = array(
        'errors' => array(),
        'last_data' => array(),
        'current' => array(),
        'success' => null,
        'session' => array()
    );

    public function __construct(Session $session){
        global $base_url;
        $this->base_url = $base_url;
        $this->session = $session;
        $this->data['departments'] = $this->getDepartments();
        $this->data['users'] = UserModel::getAll();

        foreach ($this->session->getFlashBag()->all() as $type => $messages) {
            foreach($messages as $message){
                array_push($this->data['session'], '<div class="alert alert-'.$type.' p-2" role="alert">'.$message.'</div>');
            }
        }

    }
    public function index(){
        include __DIR__ . '/../index.php';
    }

    public function getById($params){
        $id = $params['id'];
        if($id){
            $record = DepartmentsModel::getById($id);
            if($record){
                $this->data['current'] = $record;
                include __DIR__ . '/../single.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Department id not found');
                header('location: ' . $this->base_url . '/modules/departments/');
            }  
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/departments/');
        }
    }

    private function _validateData($data){
        $validator = new Validator;
        // $validation->make
        $validation = $validator->make($data, [
            'department-name' => 'required|min:3',
            'department-responsible' => 'required|min:1',
        ]);
        $validation->setAlias('department-name', 'Department name');
        $validation->setAlias('department-responsible', 'Department responsible');
        
        $validation->validate();

        return $validation;
    }

    public function postDepartment(){
        $request = Request::createFromGlobals();
        if($request->request->get('save')){
            $validation = $this->_validateData($request->request->all());

            if ($validation->fails()) {
                // handling errors
                $errors = $validation->errors();
                $this->data['errors'] = $errors;
                $messages = $errors->all('<span>:message</span>');
                $flashes = $this->session->getFlashBag();
                // add flash messages
                foreach($messages as $msg){
                    $flashes->add(
                        'danger',
                        $msg
                    );
                }
                $this->data['last_data'] = $request->request->all();
            }else{
                $res = DepartmentsModel::postDepartment($request->request->all());
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>New department created</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/departments/');
        }
    }

    public function updateDepartment($params){
        $request = Request::createFromGlobals();
        $id = $params['id'];
        if($request->request->get('save')){
            $validation = $this->_validateData($request->request->all());
            if ($validation->fails()) {
                // handling errors
                $errors = $validation->errors();
                $this->data['errors'] = $errors;
                $messages = $errors->all('<span>:message</span>');
                $flashes = $this->session->getFlashBag();
                // add flash messages
                foreach($messages as $msg){
                    $flashes->add(
                        'danger',
                        $msg
                    );
                }
                $this->data['current'] = $request->request->all();
            }else{
                $res = DepartmentsModel::update($id, $request->request->all());
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>Department updated</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/departments/');
        } 
    }

    public function getDepartments(){
        return DepartmentsModel::getAll();
    }

    public function delete($params){
        $request = Request::createFromGlobals();
        $id = $request->request->get('id');
        if($id){
                // $flashes = $this->session->getFlashBag();
                // // add flash messages
                // $flashes->add(
                //     'success',
                //     'Record successfully deleted'
                // );
                echo json_encode(array('success' => DepartmentsModel::delete($id)));
        }
    }
}
