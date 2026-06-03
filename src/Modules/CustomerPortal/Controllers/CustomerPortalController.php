<?php

namespace Se7entech\Contractnew\Modules\CustomerPortal\Controllers;

use \Se7entech\Contractnew\Modules\Contract\Models\ContractModel;
use \Se7entech\Contractnew\Modules\Invoices\Models\InvoiceModel;
use \Se7entech\Contractnew\Modules\Tasks\Models\TaskModel;
use \Se7entech\Contractnew\Modules\Projects\Models\ProjectsModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Se7entech\Contractnew\Helpers\TaskHelper;

class CustomerPortalController{
    public function __construct(Session $session){
        global $base_url, $base_path;
        $this->base_url = $base_url;
        $this->base_path = $base_path;
        $this->session = $session;
        chdir($this->base_path);        
    }

    public function tasks(){
        $customer_id = $this->session->get('customer_id');
        
        $contracts = ContractModel::getCustomerContracts($customer_id);
        $invoices = InvoiceModel::getCustomerInvoices($customer_id);
        // $tasks = TaskModel::getCustomerTasks($customer_id);
        $projects = ProjectsModel::getCustomerProjectsWithTasks($customer_id);
        // $this->data['tasks'] = $tasks;
        foreach ($projects as &$project) {
            if (isset($project['tasks']) && is_array($project['tasks'])) {
                foreach ($project['tasks'] as &$task) {
                    $task['total_time'] = TaskHelper::getRealTotalTime($task, true);
                    $task['estimated_time'] = TaskHelper::getEstimatedTime($task, true);
                    $task['deadline'] = TaskHelper::getFormattedDeadline($task);
                }
                unset($task);
            }
        }
        unset($project);
        $this->data['projects'] = $projects;
        include __DIR__ . '/../tasks.php';
    }

    public function contracts(){
        $customer_id = $this->session->get('customer_id');
        $contracts = ContractModel::getCustomerContracts($customer_id);
        $this->data['contracts'] = $contracts;
        include __DIR__ . '/../contracts.php';
    }

    public function invoices(){
        $customer_id = $this->session->get('customer_id');
        $invoices = InvoiceModel::getCustomerInvoices($customer_id);
        $this->data['invoices'] = $invoices;
        // Check if there is an invoices.php file, or include tasks if missing, but let's assume we might need a placeholder or view
        include __DIR__ . '/../invoices.php';
    }
}