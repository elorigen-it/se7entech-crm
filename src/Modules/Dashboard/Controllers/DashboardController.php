<?php

namespace Se7entech\Contractnew\Modules\Dashboard\Controllers;

use \Se7entech\Contractnew\Modules\Contract\Models\ContractModel;
use \Se7entech\Contractnew\Modules\Invoices\Models\InvoiceModel;
use \Se7entech\Contractnew\Modules\Tasks\Models\TaskModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DashboardController{
    public function __construct(Session $session){
        global $base_url, $base_path;
        $this->base_url = $base_url;
        $this->base_path = $base_path;
        $this->session = $session;
        chdir($this->base_path);        
    }

    public function customerDashboard(){
        $customer_id = $this->session->get('customer_id');
        
        $contracts = ContractModel::getCustomerContracts($customer_id);
        $invoices = InvoiceModel::getCustomerInvoices($customer_id);
        $tasks = TaskModel::getCustomerTasks($customer_id);

        // Compute total hours invested across all customer tasks
        $totalHours = 0;
        foreach ($tasks as $task) {
            $totalHours += \Se7entech\Contractnew\Helpers\TaskHelper::getRealTotalTime($task, true);
        }
        $this->data['total_hours_invested'] = round($totalHours, 1);

        include __DIR__ . '/../customer_dashboard.php';
    }

    
}