<?php

namespace Se7entech\Contractnew\Modules\Tasks\Controllers;

use Se7entech\Contractnew\Modules\Tasks\Models\TaskModel;
use Se7entech\Contractnew\Modules\Tasks\Models\TaskLabelModel;

use Se7entech\Contractnew\Modules\Users\Models\UserModel;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

use Se7entech\Contractnew\Helpers\Mailer;


class TaskController {

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
        // $this->data['tasks'] = $this->getTasks();
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
        $tasks = TaskModel::getAll();
        $users = UserModel::getAll();
        $customers = CustomersModel::getAllV2();
        $labels = TaskLabelModel::getAll();

        $this->data['tasks'] = $tasks;
        $this->data['users'] = $users;
        $this->data['customers'] = $customers;
        $this->data['labels'] = $labels;

        if($this->session->get('access') != '0'){
            $tasks = array_filter($tasks, function($task) {
                return $task['asigned_to'] == $this->session->get('userid');
            });
            $this->data['tasks'] = $tasks;
        }
        include __DIR__ . '/../index.php';
    }

    public function postTask(){
        $request = Request::createFromGlobals();
        $data = $request->request->all();
        $validator = new Validator;
        $validation = $validator->make($data, [
            'customer-id' => 'required|integer',
            'customer-tempname' => 'required',
            'task-name' => 'required',
            'task-description' => 'required',
            'task-user' => 'required'
        ]);
        $validation->validate();

        if ($validation->fails()) {
            $this->data['errors'] = $validation->errors()->all();
            $this->data['last_data'] = $data;

            $tasks = TaskModel::getAll();
            $users = UserModel::getAll();
            $customers = CustomersModel::getAllV2();
            $this->data['tasks'] = $tasks;
            $this->data['users'] = $users;
            $this->data['customers'] = $customers;
            
            include __DIR__ . '/../index.php';
        } else {
            $res = TaskModel::postTask($data);
            $flashes = $this->session->getFlashBag();
            if($res['success']){
                $this->data['success'] = true;
                $flashes->add(
                    'success',
                    '<span>New Task created</span>'
                );
                //send email to user    
                $user = UserModel::getById($data['task-user']);            
                $subject = 'New Task Created ' . $data['task-name'];
                //get from template
                $template = file_get_contents(__DIR__ . '/../../../../email-templates/index.html');
                $template = str_replace('{{task-name}}', $data['task-name'], $template);
                $template = str_replace('{{task-url}}', $this->base_url . '/modules/tasks/index.php/' . $res['id'] . '/view', $template);
                $smtpUser = 'no-reply@se7entech.net';
                $smtpPass = 'jvkD1ka?1';
                //send email
                // $from, $fromName, $to, $toName, $subject, $content, $altContent = null, $smtpUser = false, $smtpPass = false, $toCC=false, $toCCO=false
                $email = new Mailer('no-reply@se7entech.net', 'Se7entech CRM', $user['email'], $user['first_name'] . $user['last_name'], $subject, $template, null, $smtpUser, $smtpPass);
                $email->send();

            }else{
                $this->data['success'] = false;
                $flashes->add(
                    'warning',
                    '<span>Something happened with database</span>'
                );
            }
            header('location: /modules/tasks/');
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
            include __DIR__ . '/../index.php';
        } else {
            $users = UserModel::getAll();
            $customers = CustomersModel::getAllV2();
            $labels = TaskLabelModel::getAll();
            $res = TaskModel::getById($data['id']);
            if($res){
                $this->data['current'] = $res[0];
                $this->data['customers'] = $customers;
                $this->data['users'] = $users;
                $this->data['labels'] = $labels;

                include __DIR__ . '/../single.php';
            }else{
                echo json_encode(array('error' => 'Something happened with database'));
            }
        }
    }

    public function updateTask($params){
        $request = Request::createFromGlobals();
        $data = $request->request->all();
        $id = $params['id'];
        $validator = new Validator;
        $validation = $validator->make($data, [
            'customer-id' => 'required',
            'task-description' => 'required',
            'customer-tempname' => 'required',
            'task-name' => 'required',
            'task-user' => 'required'
        ]);
        $validation->validate();

        if ($validation->fails()) {
            $this->data['errors'] = $validation->errors()->all();
            $users = UserModel::getAll();
            $customers = CustomersModel::getAllV2();
            $labels = TaskLabelModel::getAll();
            $res = TaskModel::getById($id);
            if($res){
                $this->data['current'] = $res[0];
                $this->data['customers'] = $customers;
                $this->data['users'] = $users;
                $this->data['labels'] = $labels;
                include __DIR__ . '/../single.php';
            }
        } else {
            $res = TaskModel::updateTask($id, $data);
            if($res){
                header('location: /modules/tasks/index.php/'.$id.'/view');
            }else{
                return json_encode(array('error' => 'Something happened with database'));
            }
        }
    }

    public function viewById($params){
        $id = $params['id'];

        if($id){
            $res = TaskModel::getById($id);
            $labels = TaskLabelModel::getAll();
            if($res){
                $this->data['current'] = $res[0];
                $this->data['labels'] = $labels;
                include __DIR__ . '/../view.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Role id not found');

                header('location: /modules/tasks/');
            } 
        }else{
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/tasks/');
        }
    }

    public function puseTask($params){
        $id = $params['id'];
        $reason = $params['reason'];
        $task = TaskModel::getById($id);
        if(!$task){
            return json_encode(array('error' => 'Task not found'));
        }

        $intervals = $task[0]['pause_intervals'] ? explode(',', $task[0]['pause_intervals']) : array();
        array_push($intervals, time());
        $pause_intervals = implode(',', $intervals);

        $reasons = $task[0]['pause_reasons'] ? explode('|||', $task[0]['pause_reasons']) : array();
        array_push($reasons, $reason);
        $pause_reasons = implode('|||', $reasons);

        $update = array(
            'pause_intervals' => $pause_intervals,
            'pause_reasons' => $pause_reasons,
            'status' => 'paused'
        );
        $res = TaskModel::pauseTask($id, $update);

        if($res){
            $task = TaskModel::getById($id);
            $this->data['current'] = $task[0];
            $flashes = $this->session->getFlashBag();
            $this->data['success'] = true;
            $flashes->add(
                'success',
                '<span>Task paused</span>'
            );
            header('location: /modules/tasks/index.php/'.$id.'/view');
        }else{
            echo json_encode(array('error' => 'Something happened with database'));
        }
    }

    public function resumeTask($params){
        $id = $params['id'];
        
        $task = TaskModel::getById($id);
        if(!$task){
            return json_encode(array('error' => 'Task not found'));
        }

        $timestamp = time();
        $paused_intervals = explode(',', $task[0]['pause_intervals']);
        array_push($paused_intervals, $timestamp);
        // Si es impar, eliminamos el último timestamp (pausa no finalizada)
        if (count($paused_intervals) % 2 !== 0) {
            array_pop($paused_intervals); // Elimina el último elemento
        }

        // 4. Calcular el tiempo total pausado
        $total_paused = 0;
        for ($i = 0; $i < count($paused_intervals); $i += 2) {
            if (isset($paused_intervals[$i+1])) {
                $total_paused += ($paused_intervals[$i+1] - $paused_intervals[$i]);
            }
        }
        
        $update = array(
            'pause_intervals' => $task[0]['pause_intervals'] . ','. $timestamp,
            'status' => 'started',
            'total_pauses' => $total_paused,
        );
        $res = TaskModel::resumeTask($id, $update);

        if($res){
            $task = TaskModel::getById($id);
            $this->data['current'] = $task[0];
            $flashes = $this->session->getFlashBag();
            $this->data['success'] = true;
            $flashes->add(
                'success',
                '<span>Task resumed</span>'
            );
            header('location: /modules/tasks/index.php/'.$id.'/view');
        }else{
            echo json_encode(array('error' => 'Something happened with database'));
        }
    }

    public function startTask($params){
        $id = $params['id'];
        
        $task = TaskModel::getById($id);
        if(!$task){
            return json_encode(array('error' => 'Task not found'));
        }

        $update = array(
            'start_time' => time(),
            'status' => 'started'
        );
        $res = TaskModel::startTask($id, $update);

        if($res){
            $task = TaskModel::getById($id);
            $this->data['current'] = $task[0];
            $flashes = $this->session->getFlashBag();
            $this->data['success'] = true;
            $flashes->add(
                'success',
                '<span>Task started</span>'
            );
            header('location: /modules/tasks/index.php/'.$id.'/view');
        }else{
            echo json_encode(array('error' => 'Something happened with database'));
        }
    }

    public function finishTask($params){
        $id = $params['id'];
        
        $task = TaskModel::getById($id);
        if(!$task){
            return json_encode(array('error' => 'Task not found'));
        }
        $timestamp = time();

        $start_time = new \DateTime('@' . $task[0]['start_time']);
        
        // 2. Calcular el tiempo total (en segundos)
        $total_seconds = $timestamp - $start_time->getTimestamp();
        
        // 3. Obtener y procesar los intervalos de pausa (ejemplo: "1641000000,1641003600,1641010000,1641012000")
        $paused_intervals = explode(',', $task[0]['pause_intervals']);
        
        // Si es impar, eliminamos el último timestamp (pausa no finalizada)
        if (count($paused_intervals) % 2 !== 0) {
            array_pop($paused_intervals); // Elimina el último elemento
        }

        // 4. Calcular el tiempo total pausado
        $total_paused = 0;
        for ($i = 0; $i < count($paused_intervals); $i += 2) {
            if (isset($paused_intervals[$i+1])) {
                $total_paused += ($paused_intervals[$i+1] - $paused_intervals[$i]);
            }
        }
        
        // 5. Calcular el tiempo neto (total - pausas)
        $net_seconds = $total_seconds - $total_paused;
        $update = array(
            'end_time' => $timestamp,
            'status' => 'finished',
            'total_time' => $net_seconds,
            'total_pauses' => $total_paused,
        );
        $res = TaskModel::finishTask($id, $update);

        if($res){
            $task = TaskModel::getById($id);
            $this->data['current'] = $task[0];
            $flashes = $this->session->getFlashBag();
            $this->data['success'] = true;
            $flashes->add(
                'success',
                '<span>Task finished</span>'
            );
            header('location: /modules/tasks/index.php/'.$id.'/view');
        }else{
            echo json_encode(array('error' => 'Something happened with database'));
        }
    }

    public function reopenTask($params){
        $id = $params['id'];
        
        $task = TaskModel::getById($id);
        if(!$task){
            return json_encode(array('error' => 'Task not found'));
        }

        $update = array(
            'status' => 'started',
            'end_time' => 'NULL',
            'total_time' => 'NULL',
        );
        $res = TaskModel::reopenTask($id, $update);

        if($res){
            $task = TaskModel::getById($id);
            $this->data['current'] = $task[0];
            $flashes = $this->session->getFlashBag();
            $this->data['success'] = true;
            $flashes->add(
                'success',
                '<span>Task reopened</span>'
            );
            header('location: /modules/tasks/index.php/'.$id.'/view');
        }else{
            echo json_encode(array('error' => 'Something happened with database'));
        }
    }

    public function deleteTask($params){
        $request = Request::createFromGlobals();
        $id = $request->request->get('id');
        if($id){
            // $flashes = $this->session->getFlashBag();
            // // add flash messages
            // $flashes->add(
            //     'success',
            //     'Record successfully deleted'
            // );
            echo json_encode(array('success' => TaskModel::delete($id)));
        }
    }
}