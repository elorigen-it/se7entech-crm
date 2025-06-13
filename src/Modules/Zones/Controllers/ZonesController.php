<?php

namespace Se7entech\Contractnew\Modules\Zones\Controllers;

use Se7entech\Contractnew\Modules\Zones\Models\ZonesModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

class ZonesController{
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
        $this->data['zones'] = $this->getZones();
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
            $record = ZonesModel::getById($id);
            if($record){
                $this->data['current'] = $record;
                include __DIR__ . '/../single.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Zone id not found');
                header('location: ' . $this->base_url . '/modules/zones/');
            }  
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/zones/');
        }
    }

    private function _validateData($data){
        $validator = new Validator;
        // $validation->make
        $validation = $validator->make($data, [
            'zone-name' => 'required|min:3',
            'zone-code' => 'required|min:2',
        ]);
        $validation->setAlias('zone-name', 'Zone name');
        $validation->setAlias('zone-code', 'Zone code');
        
        $validation->validate();

        return $validation;
    }

    public function postZone(){
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
                $res = ZonesModel::postZone($request->request->all());
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>New Zone created</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/zones/');
        }
    }

    public function updateZone($params){
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
                $res = ZonesModel::update($id, $request->request->all());
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>Zone updated</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/zones/');
        } 
    }

    public function getZones(){
        return ZonesModel::getAll();
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
                echo json_encode(array('success' => ZonesModel::delete($id)));
        }
    }
}
