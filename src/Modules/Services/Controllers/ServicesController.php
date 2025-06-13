<?php

namespace Se7entech\Contractnew\Modules\Services\Controllers;

use Se7entech\Contractnew\Modules\Services\Models\ServicesModel;
use Se7entech\Contractnew\Modules\Departments\Models\DepartmentsModel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

class ServicesController{
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
        $this->session->set('access', $_SESSION['access']);
        $this->session->set('userid', $_SESSION['userid']);
        
        $this->data['services'] = $this->getServices();

        if($this->session->get('access') == '0'){
            $this->data['departments'] = DepartmentsModel::getAll();
        }else{
            $this->data['departments'] = DepartmentsModel::getUserDepartment($this->session->get('userid'));
        }

        foreach ($this->session->getFlashBag()->all() as $type => $messages) {
            if($type === 'last_data'){
                $this->data['last_data'] = $messages[0];
                continue;
            }
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
            $record = ServicesModel::getById($id);
            if($record){
                $this->data['current'] = $record;
                include __DIR__ . '/../single.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Service id not found');

                header('location: /modules/services/');
            }  
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/services/');
        }
    }

    private function _validateData($data){
        $validator = new Validator;
        // $validation->make
        $validation = $validator->make($data, [
            'service-name' => 'required|min:3',
            'service-price' => 'required|min:1',
            'department' => 'required|min:1'
        ]);
        $validation->setAlias('service-name', 'Service name');
        $validation->setAlias('service-price', 'Service price');
        $validation->setAlias('department', 'Department');

        
        $validation->validate();

        return $validation;
    }

    public function postService(){
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
                $flashes->add('last_data', $request->request->all());
            }else{
                $res = ServicesModel::postService($request->request->all());
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>New Service created</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/services/');
        }
    }

    public function updateService($params){
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
                $flashes->add('current', $request->request->all());
                // $this->data['current'] = $request->request->all();
            }else{
                $res = ServicesModel::update($id, $request->request->all());
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>Service updated</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/services/');
        } 
    }

    public function getServices(){
        $services = array();
        if($this->session->get('access') == '0'){
            $services = ServicesModel::getAll();
        }else{
            $services = ServicesModel::getUserServices($this->session->get('userid'));
        }
        return $services;
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
            echo json_encode(array('success' => ServicesModel::delete($id)));
        }
    }
}
