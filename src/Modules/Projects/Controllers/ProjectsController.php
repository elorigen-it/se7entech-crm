<?php

namespace Se7entech\Contractnew\Modules\Projects\Controllers;

use Se7entech\Contractnew\Modules\Projects\Models\ProjectsModel;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

class ProjectsController
{
    public $data = array(
        'errors' => array(),
        'last_data' => array(),
        'current' => array(),
        'success' => null,
        'session' => array()
    );

    public function __construct(Session $session)
    {
        global $base_url;
        $this->base_url = $base_url;
        $this->session = $session;
        $this->data['projects'] = $this->getProjects();
        foreach ($this->session->getFlashBag()->all() as $type => $messages) {
            if ($type === 'last_data') {
                $this->data['last_data'] = $messages[0];
                continue;
            }
            foreach ($messages as $message) {
                array_push($this->data['session'], '<div class="alert alert-' . $type . ' p-2" role="alert">' . $message . '</div>');
            }
        }

    }
    public function index()
    {
        $customers = CustomersModel::getAllV2();
        $this->data['projects'] = array_map(function ($project) use ($customers) {
            $customerData = array_filter($customers, function ($customer) use ($project) {
                return $customer['id'] == $project['customer_id'];
            });
            if (!empty($customerData)) {
                $project['customer_data'] = reset($customerData);
            } else {
                $project['customer_data'] = null;
            }

            return $project;
        }, $this->data['projects']);

        $this->data['customers'] = $customers;

        include __DIR__ . '/../index.php';
    }

    public function getById($params)
    {
        $id = $params['id'];


        if ($id) {
            $record = ProjectsModel::getById($id);
            if ($record) {
                $this->data['current'] = $record;
                $customers = CustomersModel::getAllV2();
                $this->data['customers'] = $customers;

                include __DIR__ . '/../single.php';
            } else {
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Projects id not found');

                header('location: ' . $this->base_url . '/modules/projects/');
            }
        } else {
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/projects/');
        }
    }

    private function _validateData($data)
    {
        $validator = new Validator;
        // $validation->make
        $validation = $validator->make($data, [
            'project-name' => 'required|min:3',
            'project-description' => 'required|min:1',
            'project-status' => 'required',
            'customer' => 'required'
        ]);
        $validation->setAlias('project-name', 'Project name');
        $validation->setAlias('project-description', 'Project description');
        $validation->setAlias('project-status', 'Project status');
        $validation->setAlias('customer', 'Customer');
        $validation->validate();

        return $validation;
    }

    public function postProject()
    {
        $request = Request::createFromGlobals();
        $customers = CustomersModel::getAllV2();
        $this->data['customers'] = $customers;

        if ($request->request->get('save')) {
            $validation = $this->_validateData($request->request->all());

            if ($validation->fails()) {
                // handling errors
                $errors = $validation->errors();
                $this->data['errors'] = $errors;
                $messages = $errors->all('<span>:message</span>');
                $flashes = $this->session->getFlashBag();
                // add flash messages
                foreach ($messages as $msg) {
                    $flashes->add(
                        'danger',
                        $msg
                    );
                }
                $flashes->add('last_data', $request->request->all());
            } else {
                $res = ProjectsModel::postProject($request->request->all());
                $flashes = $this->session->getFlashBag();
                if ($res) {
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>New Project created</span>'
                    );
                } else {
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/projects/');
        }
    }

    public function updateProject($params)
    {
        $request = Request::createFromGlobals();
        $id = $params['id'];
        $customers = CustomersModel::getAllV2();
        $this->data['customers'] = $customers;

        if ($request->request->get('save')) {
            $validation = $this->_validateData($request->request->all());
            if ($validation->fails()) {
                // handling errors
                $errors = $validation->errors();
                $this->data['errors'] = $errors;
                $messages = $errors->all('<span>:message</span>');
                $flashes = $this->session->getFlashBag();
                // add flash messages
                foreach ($messages as $msg) {
                    $flashes->add(
                        'danger',
                        $msg
                    );
                }
                $flashes->add('current', $request->request->all());
                // $this->data['current'] = $request->request->all();
            } else {
                $res = ProjectsModel::update($id, $request->request->all());
                $flashes = $this->session->getFlashBag();
                if ($res) {
                    $this->data['success'] = true;
                    $flashes->add(
                        'success',
                        '<span>Project updated</span>'
                    );
                } else {
                    $this->data['success'] = false;
                    $flashes->add(
                        'warning',
                        '<span>Something happened with database</span>'
                    );
                }
            }

            header('location: ' . $this->base_url . '/modules/projects/');
        }
    }

    public function getProjects()
    {
        return ProjectsModel::getAll();
    }

    public function delete($params)
    {
        $request = Request::createFromGlobals();
        $id = $request->request->get('id');
        if ($id) {
            // $flashes = $this->session->getFlashBag();
            // // add flash messages
            // $flashes->add(
            //     'success',
            //     'Record successfully deleted'
            // );
            echo json_encode(array('success' => ProjectsModel::delete($id)));
        }
    }

    public function ajax_get_projects_by_customer_id()
    {
        $request = Request::createFromGlobals();
        $customer_id = $request->request->get('customer_id');

        if ($customer_id) {
            $response = ProjectsModel::getByCustomerId($customer_id);
            echo json_encode(['success' => true, 'projects' => $response]);
            exit;
        } else {
            echo json_encode(array('error' => 'Customer ID is required', 'success' => false, 'projects' => []));
            exit;
        }

    }

    // API METHODS
    private function _jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    private function _getJsonInput()
    {
        $content = file_get_contents('php://input');
        return json_decode($content, true) ?? [];
    }

    public function apiGetAll()
    {
        try {
            $projects = ProjectsModel::getAll();
            $this->_jsonResponse(['success' => true, 'data' => $projects]);
        } catch (\Exception $e) {
            $this->_jsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function apiCreate()
    {
        $data = $this->_getJsonInput();
        // Fallback to POST if JSON is empty (for form-data support)
        if (empty($data)) {
            $request = Request::createFromGlobals();
            $data = $request->request->all();
        }

        // Validate using the existing validation logic, but need to map keys if JSON uses different naming.
        // Assuming API sends same keys as form: 'project-name', 'project-description', etc.

        $validation = $this->_validateData($data);
        if ($validation->fails()) {
            $this->_jsonResponse(['success' => false, 'errors' => $validation->errors()->all()], 400);
        }

        $res = ProjectsModel::postProject($data);
        if ($res) {
            $this->_jsonResponse(['success' => true, 'message' => 'Project created']);
        } else {
            $this->_jsonResponse(['success' => false, 'message' => 'Database error'], 500);
        }
    }

    public function apiUpdate($params)
    {
        $id = $params['id'];
        $data = $this->_getJsonInput();
        if (empty($data)) {
            $request = Request::createFromGlobals();
            $data = $request->request->all();
        }

        $validation = $this->_validateData($data);
        if ($validation->fails()) {
            $this->_jsonResponse(['success' => false, 'errors' => $validation->errors()->all()], 400);
        }

        $res = ProjectsModel::update($id, $data);
        if ($res) {
            $this->_jsonResponse(['success' => true, 'message' => 'Project updated']);
        } else {
            $this->_jsonResponse(['success' => false, 'message' => 'Database error'], 500);
        }
    }

    public function apiDelete($params)
    {
        $id = $params['id'];
        $res = ProjectsModel::delete($id);
        if ($res) {
            $this->_jsonResponse(['success' => true, 'message' => 'Project deleted']);
        } else {
            $this->_jsonResponse(['success' => false, 'message' => 'Database error'], 500);
        }
    }
}
