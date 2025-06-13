<?php

namespace Se7entech\Contractnew\Modules\Calendar\Controllers;

use Se7entech\Contractnew\Modules\Calendar\Models\CalendarModel;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Se7entech\Contractnew\Modules\Users\Models\UserModel;

use Se7entech\Contractnew\Modules\Appointments\Models\AppointmentsModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

class CalendarController{
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
        $this->session->set('zone_id', $_SESSION['zone_id']);

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

    public function getAllAppointments(){
        $user_access = $this->session->get('access');
        //echo var_dump($user_access);
        $user_zone = $this->session->get('zone_id');
        $appointments = ($user_access == '0') ? AppointmentsModel::getAll() : AppointmentsModel::getAllByZone($user_zone);

        if(count($appointments)){
            for($i=0;$i<count($appointments);$i++){
                $customer = CustomersModel::getCustomer($appointments[$i]['customer_table'], $appointments[$i]['customer_id']);
                $agent = UserModel::getByEmail($appointments[$i]['agent_email']);
                $appointments[$i]['customer'] = $customer;
                $appointments[$i]['agent'] = $agent;
                $date_start_visible = date('m/d/Y h:ia', strtotime($appointments[$i]['date_start']));
                $date_end_visible = date('m/d/Y h:ia', strtotime($appointments[$i]['date_end']));

                $date_start = date('m/d/Y H:i:s', strtotime($appointments[$i]['date_start']));
                $date_end = date('m/d/Y H:i:s', strtotime($appointments[$i]['date_end']));
                $appointments[$i]['date_start'] = $date_start;
                $appointments[$i]['date_end'] = $date_end;
                $appointments[$i]['date_start_visible'] = $date_start_visible;
                $appointments[$i]['date_end_visible'] = $date_end_visible;                
                
            }
        }
        echo json_encode($appointments);
        // exit;
    }

    public function getById($params){
        $id = $params['id'];
        if($id){
            $record = RolesModel::getById($id);
            if($record){
                $this->data['current'] = $record;
                include __DIR__ . '/../single.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Role id not found');

                header('location: /modules/roles/');
            }  
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/roles/');
        }
    }

    private function _validateData($data){
        $validator = new Validator;
        // $validation->make
        $validation = $validator->make($data, [
            'role-name' => 'required|min:3',
            'role-commission' => 'required|min:1',
        ]);
        $validation->setAlias('role-name', 'Role name');
        $validation->setAlias('role-commission', 'Role Commission');
        
        $validation->validate();

        return $validation;
    }

    public function postRole(){
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
                $res = RolesModel::postRole($request->request->all());
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>New Role created</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/roles/');
        }
    }

    public function updateRole($params){
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
                $res = RolesModel::update($id, $request->request->all());
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>Role updated</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/roles/');
        } 
    }

    public function getRoles(){
        return CalendarModel::getAll();
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
            echo json_encode(array('success' => CalendarModel::delete($id)));
        }
    }
}
