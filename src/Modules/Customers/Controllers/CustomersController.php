<?php

namespace Se7entech\Contractnew\Modules\Customers\Controllers;

use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

class CustomersController {
    public $data = array(
        'errors' => array(),
        'last_data' => array(),
        'current' => array(),
        'success' => null,
        'session' => array(),
        'records' => array(),
        'users' => array() // Si necesitas lista de usuarios/agentes
    );

    public function __construct(Session $session) {
        global $base_url;
        $this->base_url = $base_url;
        $this->session = $session;
        $this->data['records'] = $this->getCustomers();
        
        // Si necesitas cargar usuarios/agentes para dropdowns
        // $this->data['users'] = $this->getUsers(); 
        
        foreach ($this->session->getFlashBag()->all() as $type => $messages) {
            if($type === 'last_data') {
                $this->data['last_data'] = $messages[0];
                continue;
            }
            foreach($messages as $message) {
                array_push($this->data['session'], '<div class="alert alert-'.$type.' p-2" role="alert">'.$message.'</div>');
            }
        }
    }

    public function index() {
        include __DIR__ . '/../index.php';
    }

    public function getById($params) {
        $id = $params['id'];
        if($id) {
            $record = CustomersModel::getById($id);
            if($record) {
                $this->data['current'] = $record;
                include __DIR__ . '/../single.php';
            } else {
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Customer not found');
                header('location: /modules/customers/');
            }  
        } else {
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/customers/');
        }
    }

    private function _validateData($data) {
        $validator = new Validator;
        
        $validation = $validator->make($data, [
            'type' => 'required|in:customer,lead',
            'name' => 'required|min:3',
            'email' => 'nullable|email',
            'phone' => 'nullable|min:8',
            'status' => 'required|in:active,inactive'
        ]);
        
        $validation->setAliases([
            'type' => 'Customer Type',
            'name' => 'Customer Name'
        ]);
        
        $validation->validate();

        return $validation;
    }

    public function postCustomer() {
        $request = Request::createFromGlobals();
        if($request->request->get('save')) {
            $validation = $this->_validateData($request->request->all());

            if ($validation->fails()) {
                $errors = $validation->errors();
                $this->data['errors'] = $errors;
                $messages = $errors->all('<span>:message</span>');
                $flashes = $this->session->getFlashBag();
                
                foreach($messages as $msg) {
                    $flashes->add('danger', $msg);
                }
                $flashes->add('last_data', $request->request->all());
            } else {
                // Procesar imagen si existe
                $imagePath = null;
                if ($request->files->has('image') && $request->files->get('image')) {
                    $imagePath = $this->handleImageUpload($request->files->get('image'));
                    echo var_dump($imagePath);
                }
                
                // Preparar datos para el modelo
                $customerData = $request->request->all();
                if ($imagePath) {
                    $customerData['image'] = $imagePath;
                }

                $currentUserEmail = $this->session->get('email');

                if ($currentUserEmail) {
                    $customerData['agent_email'] = $currentUserEmail;
                }

                $res = CustomersModel::create($customerData);
                $flashes = $this->session->getFlashBag();
                
                if($res) {
                    $this->data['success'] = true;
                    $flashes->add('success', '<span>New customer created</span>');
                } else {
                    $this->data['success'] = false;
                    $flashes->add('warning', '<span>Error saving customer</span>');
                }
            }

            header('location: ' . $this->base_url . '/modules/customers/');
        }
    }

    public function updateCustomer($params) {
        $request = Request::createFromGlobals();
        $id = $params['id'];
        
        if($request->request->get('save')) {
            $validation = $this->_validateData($request->request->all());
            
            if ($validation->fails()) {
                $errors = $validation->errors();
                $this->data['errors'] = $errors;
                $messages = $errors->all('<span>:message</span>');
                $flashes = $this->session->getFlashBag();
                
                foreach($messages as $msg) {
                    $flashes->add('danger', $msg);
                }
                $flashes->add('last_data', $request->request->all());
            } else {
                // Procesar imagen si existe
                $imagePath = null;
                if ($request->files->has('image') && $request->files->get('image')) {
                    $imagePath = $this->handleImageUpload($request->files->get('image'));
                    
                    // Eliminar imagen anterior si existe
                    $currentCustomer = CustomersModel::getById($id);
                    if ($currentCustomer && $currentCustomer['image']) {
                        $this->deleteImage($currentCustomer['image']);
                    }
                }
                
                // Preparar datos para el modelo
                $customerData = $request->request->all();

                // Verificar si se debe eliminar la imagen
                $removeImage = $request->request->get('remove_image');
                $currentCustomer = CustomersModel::getById($id);

                if ($removeImage) {
                    // Eliminar imagen si existe
                    if ($currentCustomer && !empty($currentCustomer['image'])) {
                        $this->deleteImage($currentCustomer['image']);
                    }
                    $customerData['image'] = null;
                } elseif ($imagePath) {
                    // Si se subió una nueva imagen
                    $customerData['image'] = $imagePath;
                } else {
                    // Mantener la imagen actual
                    if ($currentCustomer && !empty($currentCustomer['image'])) {
                        $customerData['image'] = $currentCustomer['image'];
                    }
                }
                
                $res = CustomersModel::update($id, $customerData);
                $flashes = $this->session->getFlashBag();
                
                if($res) {
                    $this->data['success'] = true;
                    $flashes->add('success', '<span>Customer updated</span>');
                } else {
                    $this->data['success'] = false;
                    $flashes->add('warning', '<span>Error updating customer</span>');
                }
            }

            header('location: ' . $this->base_url . '/modules/customers/');
        }
    }

    public function getCustomers() {
        return CustomersModel::getAll();
    }

    public function delete($params) {
        $request = Request::createFromGlobals();
        $id = $request->request->get('id');
        
        if($id) {
            // Eliminar imagen asociada si existe
            $customer = CustomersModel::getById($id);
            if ($customer && $customer['image']) {
                $this->deleteImage($customer['image']);
            }
            
            $result = CustomersModel::delete($id);
            echo json_encode(array('success' => $result));
        }
    }

    private function handleImageUpload($file) {
        $uploadDir = __DIR__ . '/../../../../uploads/customers/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $file->move($uploadDir, $fileName);
        
        return '/uploads/customers/' . $fileName;
    }

    private function deleteImage($imagePath) {
        $fullPath = __DIR__ . '/../../../..' . $imagePath;
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}