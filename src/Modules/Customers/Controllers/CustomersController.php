<?php

namespace Se7entech\Contractnew\Modules\Customers\Controllers;

use \Mpdf\Mpdf;
use Se7entech\Contractnew\Modules\Contract\Models\ContractModel;
use Se7entech\Contractnew\Modules\Invoices\Models\InvoiceModel;

use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Se7entech\Contractnew\Modules\Services\Models\ServicesModel;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;
use Se7entech\Contractnew\Helpers\Mailer;

class CustomersController{
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
        $this->session->set('user', $_SESSION['user']);
        $this->session->set('userid', $_SESSION['userid']);

        $this->data['customers'] = $this->getCustomers();
        $this->data['contracts'] = $this->getContracts();        
        
        $this->data['services'] = ServicesModel::getAll();

        $groups = [];
        if(count($this->data['services'])){
            foreach($this->data['services'] as $service){
                $exists = false;
                if(count($groups)){
                    foreach($groups as $_group){
                        if($_group[1] === $service['department_id']){
                            $exists = true;
                        }
                    }
                }
                if(!$exists){
                    array_push($groups, array($service['department_name'], $service['department_id']));
                }
            }
        }
        $this->data['groups'] = $groups;
        
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

    public function notifications(){
        // ini_set('display_errors', '1');
        // ini_set('display_startup_errors', '1');
        // error_reporting(E_ALL);
        
        $request = Request::createFromGlobals();
        $toEmail = $request->request->get('toemail');
        $contractid = $request->request->get('contractid');
               
        //consigue el nombre del usuario actual
        $user = $this->session->get('user');
        $contract = ContractModel::getById($contractid);
        // $contractItems = ContractModel::getItems($contract['rand']);
        // $contractItemsHtml = '';
        $total = ($contract['total_purchase'] + $contract['sale_tax'] + $contract['shipping_handling']) - $contract['additional_deposit'];
        // if(count($contractItems)){
        //     foreach($contractItems as $contractitem){
        //         $total +=$contractitem['h'];
        //         $contractItemsHtml .= "<tr>
        //             <td style='font-size:13px'>" . $contractitem['g'] . "</td>
        //             <td style='font-size:13px'>" . $contractitem['h'] . "</td>
        //             <td style='font-size:13px'>" . $contractitem['des'] . "</td>
        //         </tr>";
        //     }
        // }
        $invoices = ContractModel::getAssociatedInvoices($contractid);
        $public_invoice_payment_links = '';
        
        if(count($invoices)){
            $counter = 1;
            foreach($invoices as $invoice => $vals){
                $link = 'https://se7entech.net/invoicepay/index.php?id=' . base64_encode('SVTCHMKTNG,' . $vals['invoice_id']);
                $text = $link;
                $inv = InvoiceModel::getById($vals['invoice_id']);
                if($inv){
                    $text = ($inv['order_concept']) ? $inv['order_concept'] : 'Invoice Nr ' . $counter;
                }else{
                    $text = 'Invoice Nr ' . $counter;
                }
                $public_invoice_payment_links .= "<a href='$link'>$text</a><br>";

                $counter++;
            }
        }

        //consigue el nombre de la compañia
        $company_name = $contract['company_name_1'];
        
        //consigue el nombre del responsable de la compañia
        $client_name = $contract['customer_name_1'];

        // crea los enlaces publicos del contrato: https://crm.se7entech.net/sign2?id=10244733
        // "https://se7entech.net/invoicepay/index.php?id=". base64_encode('SVTCHMKTNG,' . $invoiceDetails["order_id"]);
        $linksign = "https://crm.se7entech.net/sign2?id=".$contract['id'];
        $public_contract_sign = "<a href='$linksign'>$linksign</a>";
        // $public_contract_sign = 'aa';
        // carga la plantilla html y pasale los datos
        $content = file_get_contents(__DIR__ . '/../thankyou-purchase.html');
        $content = str_replace(array('%base_url%', '%client_name%', '%contract_signature%', '%invoice_payments%', '%agent_name%'), array($this->base_url, $client_name, $public_contract_sign, $public_invoice_payment_links, $user), $content);
        // TODO: send password to email. 
        // $from, $fromName, $to, $toName, $subject, $content, $altContent
        
        // crea el pdf del contrato
        $mpdf = new Mpdf();
        $mpdf->useSubstitutions = false;
        
        // Write contract HTML code:
        $logopath = __DIR__ . '/../assets/logo.png';
        $type = pathinfo($logopath, PATHINFO_EXTENSION);
        $logo = file_get_contents($logopath);
        $logoimg = 'data:image/' . $type . ';base64,' . base64_encode($logo);

        $url = __DIR__ . '/../contract-template.html';
        $contract_html = file_get_contents($url);
        $contract_html = str_replace(
            array(
                '%id%', '%agent_name_1%', '%customer_name_1%', 
                '%company_name_1%', '%contract_date_start%', '%contract_date_end%',
                '%services%', '%maintenance_period%',
                '%company_name_2%', '%total%', '%shipping_handling%',
                '%sale_tax%', '%total_purchase%', '%additional_deposit%',
                '%payment_date%', '%dues_after_payment%', '%agent_name_2%',
                '%contract_sign_date_agent%', '%customer_name_3%', '%contract_sign_date_customer%', 
                '%agent_sign%', '%customer_sign%', '%logoimg%'
            ),
            array(
                $contract['id'], $contract['agent_name_1'], $contract['customer_name_1'], 
                $contract['company_name_1'], date('F d, Y', strtotime($contract['contract_date_start'])), date('F d, Y', strtotime($contract['contract_date_end'])),
                $contract['services'], $contract['maintenance_period'],
                $contract['customer_name_2'], $contract['total_purchase'], $contract['shipping_handling'],
                $contract['sale_tax'], (int) $contract['total_purchase'] + (int) $contract['shipping_handling'] + (int) $contract['sale_tax'], $contract['additional_deposit'],
                $contract['payment_date'], abs( ( (int) $contract['total_purchase'] + (int) $contract['shipping_handling'] + (int) $contract['sale_tax']) - (int) $contract['additional_deposit']), $contract['agent_name_2'], 
                date('F d, Y', strtotime($contract['contract_sign_date_agent'])), $contract['customer_name_3'], date('F d, Y', strtotime($contract['contract_sign_date_customer'])), 
                $contract['agent_sign'], $contract['customer_sign'], $logoimg

            ),
            $contract_html);

        // echo var_dump($contract_html);
        

        $mpdf->WriteHTML($contract_html);

        // Output a PDF file directly to the browser
        
        $contractPath = __DIR__.'/../tmp/'.uniqid('STContract-').'.pdf';
        $mpdf->Output($contractPath, \Mpdf\Output\Destination::FILE);

        // crea el/los pdf de las facturas

        //agrega los pdf como adjuntos al correo

        //envia el correo
        $from = 'no-reply@se7entech.net';
        $fromName = 'Se7entech LLC';
        $toName = $client_name;
        $subject = 'Appreciation for Your Recent Purchase';

        $mailer = new Mailer($from, $fromName, $toEmail, $toName, $subject, $content);
        $mailer->addAttachment($contractPath);
        if($mailer->send() === true){
            echo json_encode(array('success' => true, 'data' => 'success'));
        }else{
            echo json_encode(array('success' => false, 'data' => 'error'));
        }

    }

    public function associateInvoice(){
        $request = Request::createFromGlobals();
        $contractid = $request->request->get('contractid');
        $invoicesids = $request->request->get('invoicesids');
        if(strstr($invoicesids, ',')){
            $invoicesids = explode(',', $invoicesids);
        }else{
            $invoicesids = array($invoicesids);
        }

        $res = ContractModel::attachInvoices($contractid, $invoicesids);
        echo json_encode(array('success' => $res));
    }

    public function getAllInvoices(){
        $allInvoices = InvoiceModel::getAll();
        $response = array('success' => true, 'data' => $allInvoices);
        echo json_encode($response);
    }

    public function getAssociatedInvoices(){
        $request = Request::createFromGlobals();
        $contractid = $request->request->get('contractid');
        $response = array('success' => false);

        if($contractid){
            $contractInvoices = ContractModel::getAssociatedInvoices($contractid);
            $response['success'] = true;
            $response['data'] = $contractInvoices;
        }

        echo json_encode($response);
    }

    public function getById($params){
        $id = $params['id'];
        if($id){
            $record = ContractModel::getById($id);
            if($record){
                $this->data['current'] = $record;
                include __DIR__ . '/../single.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Contract id not found');

                header('location: /modules/contract/');
            }  
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/contract/');
        }
    }

    private function _validateData($data){
        $validator = new Validator;
        // $validation->make
        $validation = $validator->make($data, [
            'agent_name_1' => 'required|min:3',
            'agent_name_2' => 'required|min:3',
            'customer_name_1' => 'required|min:3',
            'customer_name_2' => 'required|min:3',
            'customer_name_3' => 'required|min:3',
            'company_name_1' => 'required|min:3',
            'company_name_2' => 'required|min:3',
            'contract_date_start' => 'required',
            'contract_date_end' => 'required',
            'services' => 'required',
            // 'maintenance_period' => 'required',

            'total_purchase' => 'required'

        ]);
        $validation->setAlias('agent_name_1', 'Agent name');
        $validation->setAlias('agent_name_2', 'Agent name');

        $validation->setAlias('customer_name_1', 'Customer name');
        $validation->setAlias('customer_name_2', 'Customer name');
        $validation->setAlias('customer_name_3', 'Customer name');

        $validation->setAlias('company_name_1', 'Customer company name');
        $validation->setAlias('company_name_2', 'Customer company name');

        $validation->setAlias('contract_date_start', 'Contract start date');
        $validation->setAlias('contract_date_end', 'Contract end date');

        $validation->setAlias('services', 'Services');
        // $validation->setAlias('maintenance_period', 'Maintenance period');
        $validation->setAlias('total_purchase', 'Total purchase');
                
        $validation->validate();

        return $validation;
    }

    public function postContract(){
        $request = Request::createFromGlobals();
        if($request->request->get('save')){
            $data = $request->request->all();
            if($this->session->get('access') != 0 ){
                $data['agent_name_1'] = $this->session->get('user');
                $data['agent_name_2'] = $this->session->get('user');
            }
            $data['agent_id'] = $this->session->get('userid');
            $validation = $this->_validateData($data);

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
                // $data = $request->request->all();
                $res = ContractModel::postContract($data);
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>New contract created</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/contract/');
        }
    }

    public function updateContract($params){
        $request = Request::createFromGlobals();
        $id = $params['id'];
        if($request->request->get('save')){
            $data = $request->request->all();
            if($this->session->get('access') != 0 ){
                $data['agent_name_1'] = $this->session->get('user');
                $data['agent_name_2'] = $this->session->get('user');
            }
            $validation = $this->_validateData($data);
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
                $record = ContractModel::getById($id);
                $data = $request->request->all();
                $data['customer_id'] = $record['customer_id'];
                
                $res = ContractModel::update($id, $data);
                $flashes = $this->session->getFlashBag();
                if($res){
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>Contract updated</span>'
                    );
                }else{
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/contract/');
        } 
    }

    public function getContracts(){
        if($this->session->get('access') === '0' ) {
            $contracts = ContractModel::getAll();
        }else{
            $contracts = ContractModel::getContractsFromAgent($this->session->get('userid'));
        }

        return $contracts;
    }

    public function getCustomers(){
        if($this->session->get('access') === '0' ) {
            $customers = CustomersModel::getAllV2();
        }else{
            $customers = CustomersModel::getCustomersFromAgent($this->session->get('email'));
        }

        return $customers;
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
            echo json_encode(array('success' => ContractModel::delete($id)));
        }
    }

    public function printContract($params){
        $id = $params['id'];
        echo var_dump($id);

    }
}
