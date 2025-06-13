<?php

namespace Se7entech\Contractnew\Modules\Appointments\Controllers;

use Se7entech\Contractnew\Modules\Zones\Models\ZonesModel;
use Se7entech\Contractnew\Modules\Appointments\Models\AppointmentsModel;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Se7entech\Contractnew\Modules\Users\Models\UserModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;
use Se7entech\Contractnew\Helpers\Mailer;


class AppointmentsController{
    public $data = array(
        'errors' => array(),
        'last_data' => array(),
        'current' => array(),
        'success' => null,
        'session' => array(),
        'zones' => array()
    );

    public function __construct(Session $session, $external = false){
        global $base_url;
        $this->base_url = $base_url;
        $this->session = $session;
        if($external===false){
            $this->session->set('access', $_SESSION['access']);
            $this->session->set('user', $_SESSION['user']);
            $this->session->set('userid', $_SESSION['userid']);
            
            $this->session->set('email', $_SESSION['email']);
            $this->session->set('designation', $_SESSION['designation']);
            $this->session->set('zone_id', $_SESSION['zone_id']);
            $this->session->set('avatar', $_SESSION['avatar']);
            
            $this->userdata = UserModel::getById($this->session->get('userid'));
            
            $this->data['customers'] = CustomersModel::getAllV2();
            foreach ($this->session->getFlashBag()->all() as $type => $messages) {
                if($type === 'last_data'){
                    $this->data['last_data'] = $messages[0];
                    continue;
                }
                if($type === 'current'){
                    $this->data['current'] = $messages[0];
                    continue;
                }
                foreach($messages as $message){
                    array_push($this->data['session'], '<div class="alert alert-'.$type.' p-2" role="alert">'.$message.'</div>');
                }
            }
            $this->data['zones'] = ZonesModel::getAll();
            $this->data['users'] = UserModel::getAll();
            $this->data['access'] = $this->session->get('access');
            $this->data['email'] = $this->session->get('email');
            $this->data['zone_id'] = $this->session->get('zone_id');
            $this->data['avatar'] = $this->session->get('avatar');
            $this->data['appointments'] = $this->data['access'] === '0' ? AppointmentsModel::getAll() : AppointmentsModel::getAllByZone($this->data['zone_id']);
            // $this->data['appointments'] = AppointmentsModel::getAllByZone($this->data['zone_id']);
    
            
            
            $this->_addAppointmentsDetails();

        }

    }
    public function index(){
        include __DIR__ . '/../index.php';
    }

    private function _addAppointmentsDetails(){
        for($i=0;$i<count($this->data['appointments']);$i++){
            $customer = CustomersModel::getCustomerV2($this->data['appointments'][$i]['customer_id']);
            if(count($customer)){
                $this->data['appointments'][$i]['customer_name'] = $customer['name'];
            }
        }
    }

    public function getById($params){
        $id = $params['id'];
        if($id){
            $record = AppointmentsModel::getById($id);
            if($record){
                $this->data['current'] = $record;
                include __DIR__ . '/../single.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Appointment id not found');

                header('location: ' . $this->base_url . '/modules/appointments/');
            }  
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/appointments/');
        }
    }

    public function postAppointment(){
        include __DIR__ . '/../../../../config/config.php';

        $request = Request::createFromGlobals();
        if($request->request->get('save')){
            $postData = $request->request->all();
            if(strlen($postData['customer_email'])){
                $message = '';

                if(isset($_FILES["banner"]["name"]) && $_FILES["banner"]["name"] != ''){
                    $tmp_dir = __DIR__ . "/../../../../uploads/appointments/";
                    $imageFileType = strtolower(pathinfo(basename($_FILES["banner"]["name"]),PATHINFO_EXTENSION));
                    $filename = rand(0,10000) . uniqid('-rand-') . '.' . $imageFileType;
                    $targetFile = $tmp_dir . $filename;
                    $targetUrl = $this->base_url . '/uploads/appointments/' . $filename;
                    move_uploaded_file($_FILES['banner']['tmp_name'], $targetFile);

                    $message = '<div style="text-align:center;max-width:400px;margin:0 auto;"><img src="'.$targetUrl.'" alt="main-banner" style="max-width:100%; display:block"></div>';
                }

                if(isset($_FILES['banner2']["name"]) && $_FILES["banner2"]["name"] != ''){
                    $tmp_dir = __DIR__ . "/../../../../uploads/appointments/";
                    $imageFileType = strtolower(pathinfo(basename($_FILES["banner2"]["name"]),PATHINFO_EXTENSION));
                    $filename = rand(0,10000) . uniqid('-rand-') . '.' . $imageFileType;
                    $targetFile = $tmp_dir . $filename;
                    $targetUrl = $this->base_url . '/uploads/appointments/' . $filename;
                    move_uploaded_file($_FILES['banner2']['tmp_name'], $targetFile);

                    $message .= '<div style="text-align:center;max-width:400px;margin:0 auto;"><img src="'.$targetUrl.'" alt="second-banner" style="max-width:100%; display:block"></div>';
                }
                
                if(isset($_FILES["attachment1"]["name"]) && $_FILES["attachment1"]["name"] != ''){
                    $tmp_dir = __DIR__ . "/../../../../uploads/appointments/";
                    $fileType = strtolower(pathinfo(basename($_FILES["attachment1"]["name"]),PATHINFO_EXTENSION));
                    $filename = rand(0,10000) . uniqid('-rand-') . '.' . $fileType;
                    $targetFile = $tmp_dir . $filename;
                    $targetUrl = $this->base_url . '/uploads/appointments/' . $filename;
                    move_uploaded_file($_FILES['attachment1']['tmp_name'], $targetFile);
                    
                    $attachment1 = $targetFile;
                }
                if(isset($_FILES["attachment2"]["name"]) && $_FILES["attachment2"]["name"] != ''){
                    $tmp_dir = __DIR__ . "/../../../../uploads/appointments/";
                    $fileType = strtolower(pathinfo(basename($_FILES["attachment2"]["name"]),PATHINFO_EXTENSION));
                    $filename = rand(0,10000) . uniqid('-rand-') . '.' . $fileType;
                    $targetFile = $tmp_dir . $filename;
                    $targetUrl = $this->base_url . '/uploads/appointments/' . $filename;
                    move_uploaded_file($_FILES['attachment2']['tmp_name'], $targetFile);
                    
                    $attachment2 = $targetFile;
                }
                $message .= $postData['message'];

                $arrayEmails = explode(',', $postData['customer_email']);

                foreach($arrayEmails as $email){
                    if(!$request->request->get('agent_email')){
                        $postData['agent_email'] = $this->data['email'];
                    }
                    if(isset($postData['no_customer'])){
                        $validation = $this->_validateDataNoCustomer($postData);
                    }else{
                        $validation = $this->_validateData($postData);
                    }
    
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
                        $flashes->add('last_data', $postData);
                
                    }else{
                        $postData['status'] = 'created';
                        $customer = ['name' => 'Recipient'];
                        $insertId = AppointmentsModel::postAppointment($postData, $email);
                        // $insertId = AppointmentsModel::insert_id();
                        if(!isset($postData['no_customer'])){
                            $customer = CustomersModel::getCustomerV2($postData['customer_id']);
                        }
    
                        $flashes = $this->session->getFlashBag();
                        if($insertId){
                            // echo var_dump($base_url . '/modules/appointment/accept/'.$insertId);
                            // exit;
                            $this->data['success'] = true;
                            $flashes->add(
                                'success',
                                '<span>New Appointment created</span>'
                            );
                            $user = $this->session->get('user');
                            $designation = $this->session->get('designation');
                            $avatar = $this->session->get('avatar') ? $this->session->get('avatar') : $this->base_url . '/uploads/avatars/default.png';
                            $appointment_date = explode(' ', $postData['date_start']);
                            // $message = $postData['message'];

                            // if(isset($_FILES['banner'])){
                            //     $tmp_dir = __DIR__ . "/../../../../uploads/appointments/";
                            //     $imageFileType = strtolower(pathinfo(basename($_FILES["banner"]["name"]),PATHINFO_EXTENSION));
                            //     $filename = rand(0,10000) . uniqid('-rand-') . '.' . $imageFileType;
                            //     $targetFile = $tmp_dir . $filename;
                            //     $targetUrl = $this->base_url . '/uploads/appointments/' . $filename;
                            //     move_uploaded_file($_FILES['banner']['tmp_name'], $targetFile);

                            //     $message = '<div style="text-align:center;max-width:400px;margin:0 auto;"><img src="'.$targetUrl.'" style="max-width:100%; display:block"></div>' . $postData['message'];
                            // }

                            $content = file_get_contents(__DIR__ . '/../new-appointment-template.html');
                            $content = str_replace(
                                array('%base_url%', '%agent_name%', '%agent_designation%', '%accept_url%', '%reject_url%', '%agent_image%', '%appointment_date%', '%appointment_time%', '%appointment_timezone%', '%agent_message%' ), 
                                array($this->base_url, $user, $designation, $this->base_url . '/appointment-approved.php?id='.base64_encode($insertId), $this->base_url . '/appointment-rejected.php?id='.base64_encode($insertId), $avatar, $appointment_date[0], $appointment_date[1] . ' ' . $appointment_date[2], '-5UTC/GMT', $message),
                                $content);
                            
                            // $from, $fromName, $to, $toName, $subject, $content, $altContent
                            $from = $this->userdata['smtp_user'];
                            $fromName = $this->session->get('user');
                            
                            // $to = explode(',', $postData['customer_email']);
                            // if($to == false){
                            //     $to = $postData['customer_email'];
                            // }

                            $to = $email;
                            $toName = $customer['name'];
                            $subject = $postData['subject'];
                            
                            $mailer = new Mailer($from, $fromName, $to, $toName, $subject, $content, false, $this->userdata['smtp_user'], $this->userdata['smtp_pass']);
                            
                            if(isset($attachment1)){
                                $mailer->addAttachment($attachment1);
                            }
                            if(isset($attachment2)){
                                $mailer->addAttachment($attachment2);
                            }
                            $mailer->send();
    
                        }else{
                            $this->data['success'] = false;
                            $flashes->add(
                                'warning',
                                '<span>Something happened with database</span>'
                            );
                        }
                    }
                }
                
            }
            

            header('location: ' . $this->base_url . '/modules/appointments/');
        }
    }

    public function acceptAppointment($id){
        $record = AppointmentsModel::getById($id);
        $success = false;
        if($record){
            $success = AppointmentsModel::accept($id);
        }

        // header('location: '.$base_url.'/appointment-approved.php');  
    }

    public function rejectAppointment($id){
        $record = AppointmentsModel::getById($id);
        $success = false;
        if($record){
            $success = AppointmentsModel::reject($id);
        }

        // header('location: '.$base_url.'/appointment-rejected.php');
    }

    public function updateAppointment($params){
        $request = Request::createFromGlobals();
        $id = $params['id'];
        $currentAppointment = AppointmentsModel::getById($id); 
        if($request->request->get('save')){
            $postData = $request->request->all();
            
            $validation = $this->_validateDataToUpdate($postData);
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
            }else{
                $postData = $request->request->all();
                $res = AppointmentsModel::update($id, $postData);
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>Appointment updated</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }

                if($currentAppointment['agent_email'] != $postData['agent_email']){
                    $customer = CustomersModel::getCustomerV2($postData['customer_id'] );
                    
                    $user = $this->session->get('user');
                    $designation = $this->session->get('designation');
                    $avatar = $this->session->get('avatar') ? $this->session->get('avatar') : $this->base_url . '/uploads/avatars/default.png';
                    $appointment_date = explode(' ', $postData['date_start']);

                    $content = file_get_contents(__DIR__ . '/../changed-agent-template.html');
                    $content = str_replace(
                        array('%base_url%', '%agent_name%', '%agent_designation%', '%agent_image%', '%business_name%', '%appointment_date%', '%appointment_time%', '%appointment_timezone%' ), 
                        array($this->base_url, $user, $designation, $avatar, $customer['business_name'], $appointment_date[0], $appointment_date[1] . ' ' . $appointment_date[2], '-5UTC/GMT'),
                        $content);
                    // $from, $fromName, $to, $toName, $subject, $content, $altContent
                    $from = 'no-reply@se7entech.net';
                    $fromName = 'Se7entech LLC';
                    $to = $postData['agent_email'];
                    
                    $toName = 'Agent';
                    $subject = 'Appointment Assignation';
                    
                    $mailer = new Mailer($from, $fromName, $to, $toName, $subject, $content, false, $from, 'jvkD1ka?1');
                    $mailer->send();
                    
                }
            }

            header('location: ' . $this->base_url . '/modules/appointments/index.php/' . $id);
        } 
    }

    public function getUsers(){
        return UserModel::getAll();
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
            echo json_encode(array('success' => AppointmentsModel::delete($id)));
        }
    }

    private function _validateData($data){
        $validator = new Validator;
        $validation = $validator->make($data, [
            'subject' => 'required|min:3',
            'customer_email' => 'required|min:3',
            'customer_id' => 'required',
            'agent_email' => 'required|email',
            'date_start' => 'required|date:Y-m-d g:i A',
            'date_end' => 'required|date:Y-m-d g:i A',
            'message' => 'required'            
        ]);
        $validation->setAlias('subject', 'Subject');
        $validation->setAlias('customer_email', 'Customer Email');
        $validation->setAlias('customer_id', 'Customer Id');
        $validation->setAlias('date_start', 'Date Start');
        $validation->setAlias('date_end', 'Date End');
        $validation->setAlias('message', 'Message');
        
        $validation->validate();

        return $validation;
    }

    private function _validateDataNoCustomer($data){
        $validator = new Validator;
        $validation = $validator->make($data, [
            'subject' => 'required|min:3',
            'customer_email' => 'required|min:3',
            'agent_email' => 'required|email',
            'date_start' => 'required|date:Y-m-d g:i A',
            'date_end' => 'required|date:Y-m-d g:i A',
            'message' => 'required'            
        ]);
        $validation->setAlias('subject', 'Subject');
        $validation->setAlias('customer_email', 'Customer Email');
        $validation->setAlias('date_start', 'Date Start');
        $validation->setAlias('date_end', 'Date End');
        $validation->setAlias('message', 'Message');
        
        $validation->validate();

        return $validation;
    }

    private function _validateDataToUpdate($data){
        $validator = new Validator;
        $validation = $validator->make($data, [
            'subject' => 'required|min:3',
            'customer_email' => 'required|min:3',
            'customer_id' => 'required',
            'agent_email' => 'required|email',
            'date_start' => 'required|date:Y-m-d g:i A',
            'date_end' => 'required|date:Y-m-d g:i A',
            'status' => 'required',
            'message' => 'required'            
        ]);
        $validation->setAlias('subject', 'Subject');
        $validation->setAlias('customer_email', 'Customer Email');
        $validation->setAlias('customer_id', 'Customer Id');
        $validation->setAlias('date_start', 'Date Start');
        $validation->setAlias('date_end', 'Date End');
        $validation->setAlias('status', 'Status');
        $validation->setAlias('message', 'Message');
        
        $validation->validate();

        return $validation;
    }

    public function sendReminders(){
        include __DIR__ . '/../../../../config/config.php';

        date_default_timezone_set('America/Chicago');
        $appointments = AppointmentsModel::getFutureValidAppointments();
        $now = time();
        $rule1Hour = 60*60; //1 hour
        $rule30Min = 60*30; //30 mins
        $rule5Min = 60*5; //5 mins

        if(count($appointments)){
            foreach($appointments as $appointment){
                $appointmentStartTimeTimestamp = strtotime($appointment['date_start']);
                $send = false;
                $time = false;
                if($now + $rule5Min >= $appointmentStartTimeTimestamp){
                    $send = true;
                    $time = 5;
                }
                else if($now + $rule30Min >= $appointmentStartTimeTimestamp){
                    $send = true;
                    $time = 30;
                }
                else if($now + $rule1Hour >= $appointmentStartTimeTimestamp){
                    $send = true;
                    $time = 60;
                }
                if($send){
                    $appointment_date = explode(' ', $appointment['date_start']);
                    $content_customer = file_get_contents(__DIR__ . '/../appointment-alert-customer.html');
                    $content_customer = str_replace(
                        array('%base_url%', '%agent_name%', '%agent_designation%', '%agent_image%', '%message%', '%time%' ), 
                        array($this->base_url, $appointment['first_name'], $appointment['designation'], $appointment['avatar'], $appointment['message'], $time),
                        $content_customer);

                    $content_agent = file_get_contents(__DIR__ . '/../appointment-alert-agent.html');
                    $content_agent = str_replace(
                        array('%base_url%', '%agent_name%', '%agent_designation%', '%agent_image%', '%message%', '%time%', '%customer_business%'), 
                        array($this->base_url, $appointment['first_name'], $appointment['designation'], $appointment['avatar'], $appointment['message'], $time, $appointment['customer_details']['business_name']),
                        $content_agent);
                }
                if(!AppointmentsModel::reminderMailed($appointment['id'], 'alert_'.$time)){
                    $from = 'no-reply@se7entech.net';
                    $fromName = 'Se7entech LLC';
                    $toCustomer = $appointment['customer_email'];
                    $toCustomerName = 'Customer';
                    $subject = 'Appointment Reminder';
                    
                    $mailer = new Mailer($from, $fromName, $toCustomer, $toCustomerName, $subject, $content_customer, false, $from, 'jvkD1ka1?');
                    $mailer->send();

                    $toAgent = $appointment['agent_email'];
                    $toAgentName = 'Agent';
                    $subject = 'Appointment Reminder';
                    
                    $mailer = new Mailer($from, $fromName, $toAgent, $toAgentName, $subject, $content_agent, false, $from, 'jvkD1ka?1');
                    $mailer->send();

    
                    AppointmentsModel::updateReminder($appointment['id'], '1', 'alert_'.$time);
                }
                
                
            }
        }
    }
}
