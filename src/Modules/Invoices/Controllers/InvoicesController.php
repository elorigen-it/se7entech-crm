<?php

namespace Se7entech\Contractnew\Modules\Invoices\Controllers;

use Se7entech\Contractnew\Modules\Invoices\Models\InvoiceModel;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class InvoicesController
{

    public $data = array(
        'errors' => array(),
        'last_data' => array(),
        'current' => array(),
        'success' => null,
        'session' => array()
    );
    private $base_url;
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
        global $base_url;
        $this->base_url = $base_url;
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

    private function _validateData($data)
    {
        // Basic validation - expand as needed or use Rakit Validation if available
        $errors = [];
        if (empty($data['companyName']))
            $errors[] = "Company Name is required";
        if (empty($data['productCode']) || !is_array($data['productCode']))
            $errors[] = "At least one product is required";
        return $errors;
    }

    public function apiGetAll()
    {
        try {
            // Check if user is agent or admin logic can be added here if needed
            // For now, get all
            $invoices = InvoiceModel::getAll();
            $this->_jsonResponse(['success' => true, 'data' => $invoices]);
        } catch (\Exception $e) {
            $this->_jsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function apiCreate()
    {
        $data = $this->_getJsonInput();
        if (empty($data)) {
            $request = Request::createFromGlobals();
            $data = $request->request->all();
        }

        $errors = $this->_validateData($data);
        if (!empty($errors)) {
            $this->_jsonResponse(['success' => false, 'errors' => $errors], 400);
        }

        // Add user ID from session if available/needed
        // $data['userId'] = ... 

        $res = InvoiceModel::create($data);
        if ($res) {
            $this->_jsonResponse(['success' => true, 'message' => 'Invoice created', 'id' => $res]);
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

        $errors = $this->_validateData($data);
        if (!empty($errors)) {
            $this->_jsonResponse(['success' => false, 'errors' => $errors], 400);
        }

        $res = InvoiceModel::update($id, $data);
        if ($res) {
            $this->_jsonResponse(['success' => true, 'message' => 'Invoice updated']);
        } else {
            $this->_jsonResponse(['success' => false, 'message' => 'Database error'], 500);
        }
    }

    public function apiDelete($params)
    {
        $id = $params['id'];
        $res = InvoiceModel::delete($id);
        if ($res) {
            $this->_jsonResponse(['success' => true, 'message' => 'Invoice deleted']);
        } else {
            $this->_jsonResponse(['success' => false, 'message' => 'Database error'], 500);
        }
    }

    public function index()
    {
        $this->data['invoices'] = InvoiceModel::getAll();

        // Fetch Customers logic replicated from inv.php
        $access = $_SESSION['access'] ?? 'u'; // Default to 'u' if not set
        if ($access === '0') {
            $this->data['customers'] = CustomersModel::getAllV2();
        } else {
            $this->data['customers'] = CustomersModel::getCustomersFromAgent($_SESSION['email']);
        }

        include __DIR__ . '/../index.php';
    }

    public function create()
    {
        $data = $_POST;
        // Basic validation could go here

        $res = InvoiceModel::create($data);
        if ($res) {
            $this->session->getFlashBag()->add('success', 'Invoice created successfully');
        } else {
            $this->session->getFlashBag()->add('danger', 'Error creating invoice');
        }
        $this->session->save();
        header('Location: ' . $this->base_url . '/modules/invoices/index.php');
        exit;
    }

    public function edit($params)
    {
        $id = $params['id'];
        $invoice = InvoiceModel::getById($id);
        if ($invoice) {
            $this->data['current'] = $invoice;
            $this->data['items'] = InvoiceModel::getItems($id);

            // Fetch Customers logic
            $access = $_SESSION['access'] ?? 'u';
            if ($access === '0') {
                $this->data['customers'] = CustomersModel::getAllV2();
            } else {
                $this->data['customers'] = CustomersModel::getCustomersFromAgent($_SESSION['email']);
            }

            include __DIR__ . '/../edit.php';
        } else {
            $this->session->getFlashBag()->add('warning', 'Invoice not found');
            $this->session->save();
            header('Location: ' . $this->base_url . '/modules/invoices/index.php');
            exit;
        }
    }

    public function update($params)
    {
        $id = $params['id'];
        $data = $_POST;

        $res = InvoiceModel::update($id, $data);
        if ($res) {
            $this->session->getFlashBag()->add('success', 'Invoice updated successfully');
        } else {
            $this->session->getFlashBag()->add('danger', 'Error updating invoice');
        }
        $this->session->save();
        header('Location: ' . $this->base_url . '/modules/invoices/index.php');
        exit;
    }

    public function delete()
    {
        $id = $_POST['id'];
        $res = InvoiceModel::delete($id);
        if ($res) {
            // If AJAX request
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => true]);
                exit;
            }
            $this->session->getFlashBag()->add('success', 'Invoice deleted successfully');
        } else {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => false]);
                exit;
            }
            $this->session->getFlashBag()->add('danger', 'Error deleting invoice');
        }
        $this->session->save();
        header('Location: ' . $this->base_url . '/modules/invoices/index.php');
        exit;
    }
}
