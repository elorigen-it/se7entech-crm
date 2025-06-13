<?php

namespace Se7entech\Contractnew\Modules\PayReminder\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;
use Se7entech\Contractnew\Modules\PayReminder\Models\PayReminderModel;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Se7entech\Contractnew\Helpers\Mailer;
use Exception;

class PayReminderController
{
    public $data;
    private $session;

    public function __construct(Session $session)
    {
        global $base_url, $base_path;
        $this->base_url = $base_url;
        $this->base_path = $base_path;
        $this->session = $session;

        $this->session->set('email', $_SESSION['email']);
        $this->session->set('access', $_SESSION['access']);

        $this->data['contract_grace'] = PayReminderModel::getNeeded();
        $this->data['access'] = $this->session->get('access');
    }

    public function index()
    {
        include __DIR__ . '/../index.php';
    }

    public function processForm()
    {
        $request = Request::createFromGlobals();
        if ($request->request->has('save')) {
            $this->createCustomer($request);
        } else if ($request->request->has('saveFormat')) {
            $this->createFormat($request);
        }
        //header('Location: ' . $this->base_url . '/modules/payReminder/');
        exit();
    }

    private function createFormat($request)
    {
        $postData = $request->request->all();
        $files = $request->files->all();

        $file = reset($files);

        if ($file) {
            $originalName = $file->getClientOriginalName();
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$extension;

            $path = "/src/Modules/PayReminder/tmp/";
    
            // Move the file to the directory where brochures are stored
            
            $file->move(
                $this->base_path . $path,
                $fileName
            );

            $filePath = $this->base_path . $path . $fileName;

            $postData['filepath'] = $filePath;
        }  

        try {
            $agent_email = $this->session->get('email');
            //$postData['agent_email'] = $agent_email;
            $insertedId = PayReminderModel::createFormat($postData);
            $_SESSION['flash']['success'] = 'New Format Created';
        } catch (Exception $e) {
            $_SESSION['flash']['warning'] = 'Something happened with database';
        }
    }

    public function createCustomer($request)
    {
        $postData = $request->request->all();
        $validator = $this->_validateData($postData);
    
        if ($validator->fails()) {
            $_SESSION['flash']['danger'] = $validator->errors()->firstOfAll();
            $_SESSION['flash']['last_data'] = $postData;
            header('Location: ' . $this->base_url . '/modules/payReminder/');
            exit();
        }
    
        try {
            $agent_email = $this->session->get('email');
            $postData['agent_email'] = $agent_email;
            $insertedId = CustomersModel::createCustomer($postData);
            $_SESSION['flash']['success'] = 'New Customer Created';
        } catch (Exception $e) {
            $_SESSION['flash']['warning'] = 'Something happened with database';
        }
    }

    public function installed(){
        $request = Request::createFromGlobals();
        $id = $request->request->get('id');
        $selectedOptions = $request->request->get('selectedOptions');

        $domain = 'NO';
        $hosting = 'NO';
        $marketing = 'NO';

        if (str_contains($selectedOptions, 'Domain')) {
            $domain = $request->request->get('domain');
        }

        if (str_contains($selectedOptions, 'Hosting')) {
            $hosting = 'YES';
        }

        if (str_contains($selectedOptions, 'Marketing')) {
            $marketing = 'YES';
        }

        // Creamos el array $data solo con las variables que están definidas
        $data = compact('domain', 'hosting', 'marketing');

        if($id && $selectedOptions){
            $result = PayReminderModel::installed($id, $data);
            if($result === true) {
                echo json_encode(array('success' => $result));
            } else {
                echo $result;
            }
        } else {
            echo json_encode(array('success' => false));
        }
    }

    public function getSendReminder($params){
        $id = $params['id'];
        if($id){
            $record = PayReminderModel::getById($id);
            if($record){
                $this->data['grace_time'] = $record;
                $this->data['clients'] = CustomersModel::getClients();
                $this->data['formats'] = PayReminderModel::getFormats();
                $this->data['selectedClient'] = CustomersModel::getCustomerV2($id);

                include __DIR__ . '/../mailerForm.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'contract id not found');

                header('location: ' . $this->base_url . '/modules/payReminder/');
            }  
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/payReminder/');
        }
    }

    public function sendReminder($params){
        $id = $params['id'];
        
        if($id){
            $request = Request::createFromGlobals();
            if($request->request->get('save')){
                $postData = $request->request->all();
    
                $to = //$postData["cemail"];
                $to = "se7entech@icloud.com";
                $toName = $postData["clientName"];
                $subject = $postData['subject'];
                $format_id = $postData['format'];
    
                $from = "admin@se7entech.net";
                $fromName = 'Se7entech LLC';
                $contentArray = PayReminderModel::getFormatsById($format_id);
                $content = $contentArray['html'];
    
                $mailer = new Mailer($from, $fromName, $to, $toName, $subject, $content, false, $from, 'Se7entech775$');
                $result = $mailer->send();

                header('location: ' . $this->base_url . '/modules/payReminder/');
            } else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'contract id not found');

                header('location: ' . $this->base_url . '/modules/payReminder/');
            }  
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/payReminder/');
        }
    }

    private function _validateData($data)
    {
        try {
            $validator = new Validator;
        } catch (Exception $e) {
            echo 'Error al crear el validador: ' . $e->getMessage();
            error_log('Error al crear el validador: ' . $e->getMessage(), 0);
        }
        
        $validation = $validator->make($data, [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required|min:3',
            'businessname' => 'required|min:3'
        ]);

        $validation->validate();
        
        return $validation;
    }
}
