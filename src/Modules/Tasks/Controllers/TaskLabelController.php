<?php

namespace Se7entech\Contractnew\Modules\Tasks\Controllers;

use Se7entech\Contractnew\Modules\Tasks\Models\TaskLabelModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

class TaskLabelController {

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
        $labels = TaskLabelModel::getAll();
        $this->data['labels'] = $labels;
        include __DIR__ . '/../labels/index.php';
    }

    public function postLabel(){
        $request = Request::createFromGlobals();
        $data = $request->request->all();
        $validator = new Validator;
        $validation = $validator->make($data, [
            'label-name' => 'required',
            'label-background-color' => 'required',
            'label-text-color' => 'required'
        ]);
        $validation->validate();
        
        if ($validation->fails()) {
            $this->data['errors'] = $validation->errors()->all();
            $this->data['last_data'] = $data;
            $labels = TaskLabelModel::getAll();
            $this->data['labels'] = $labels;

            echo var_dump($this->data['errors']);
            include __DIR__ . '/../labels/index.php';
        } else {
            $res = TaskLabelModel::postLabel($data);
            $flashes = $this->session->getFlashBag();
            if($res['success']){
                $this->data['success'] = true;
                $flashes->add('success', '<span>New Label created</span>');
            }else{
                $this->data['success'] = false;
                $flashes->add('warning', '<span>Something happened with database</span>');
            }
            header('location: /modules/tasks/index.php/labels');
        }
    }

    public function getById($params){
        $id = $params['id'];
        $request = Request::createFromGlobals();
        $data = $request->query->all();
        $data['id'] = $id;
        $validator = new Validator;
        $validation = $validator->make($data, [
            'id' => 'required|integer'
        ]);
        $validation->validate();

        if ($validation->fails()) {
            $this->data['errors'] = $validation->errors()->all();
            include __DIR__ . '/../labels/index.php';
        } else {
            $res = TaskLabelModel::getById($data['id']);
            if($res){
                $this->data['current'] = $res[0];
                include __DIR__ . '/../labels/single.php';
            }else{
                echo json_encode(array('error' => 'Something happened with database'));
            }
        }
    }

    public function updateLabel($params){
        $request = Request::createFromGlobals();
        $data = $request->request->all();
        $id = $params['id'];
        $validator = new Validator;
        $validation = $validator->make($data, [
            'label-name' => 'required',
            'label-background-color' => 'required',
            'label-text-color' => 'required',
        ]);
        $validation->validate();

        if ($validation->fails()) {
            $this->data['errors'] = $validation->errors()->all();
            $res = TaskLabelModel::getById($id);
            if($res){
                $this->data['current'] = $res[0];
                include __DIR__ . '/../labels/single.php';
            }
        } else {
            $res = TaskLabelModel::updateLabel($id, $data);
            if($res){
                $flashes = $this->session->getFlashBag();
                $flashes->add('success', '<span>Label updated successfully</span>');
                $this->data['success'] = true;
                header('location: /modules/tasks/index.php/labels/'.$id);
            }else{
                return json_encode(array('error' => 'Something happened with database'));
            }
        }
    }


    public function deleteLabel($params){
        $request = Request::createFromGlobals();
        $id = $request->request->get('id');
        if($id){
            echo json_encode(array('success' => TaskLabelModel::delete($id)));
        }
    }
}
