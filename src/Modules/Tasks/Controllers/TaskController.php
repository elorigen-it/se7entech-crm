<?php

namespace Se7entech\Contractnew\Modules\Tasks\Controllers;

use Se7entech\Contractnew\Modules\Tasks\Models\TaskModel;
use Se7entech\Contractnew\Modules\Tasks\Models\TaskLabelModel;
use Se7entech\Contractnew\Modules\Tasks\Models\TaskCategoryModel;


use Se7entech\Contractnew\Modules\Users\Models\UserModel;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Se7entech\Contractnew\Modules\Projects\Models\ProjectsModel;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;

use Se7entech\Contractnew\Helpers\Mailer;
use Se7entech\Contractnew\Helpers\TimezoneUtils;
use GeoIp2\Database\Reader;

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
        $categories = TaskCategoryModel::getAll();

        $this->data['tasks'] = $tasks;
        $this->data['users'] = $users;
        $this->data['customers'] = $customers;
        $this->data['labels'] = $labels;
        $this->data['categories'] = $categories;

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
            $labels = TaskLabelModel::getAll();
            $categories = TaskCategoryModel::getAll();
            $customers = CustomersModel::getAllV2();
            
            $flashes = $this->session->getFlashBag();
            foreach ($this->data['errors'] as $error) {
                $flashes->add('danger', $error);
            }
            $this->data['tasks'] = $tasks;
            $this->data['users'] = $users;
            $this->data['labels'] = $labels;
            $this->data['categories'] = $categories;
            $this->data['customers'] = $customers;
            
            include __DIR__ . '/../index.php';
        } else {
            $data['deadline'] = TimezoneUtils::fromUserTimeZoneDateStringToTimestamp($data['deadline']);
            $data['estimated_time'] = $data['estimated_time'] ? $data['estimated_time'] * 60 : 0;
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
            $categories = TaskCategoryModel::getAll();
            $res = TaskModel::getById($data['id']);

            if($res){
                $this->data['current'] = $res[0];
                $this->data['current']['deadline'] = isset($this->data['current']['deadline']) ? TimezoneUtils::fromTimestampToUserTimezoneDateString($this->data['current']['deadline']) : '';
                $this->data['current']['estimated_time'] = isset($this->data['current']['estimated_time']) ? $this->data['current']['estimated_time'] / 60 : 0;
                $this->data['current']['custom_total_time'] = isset($this->data['current']['custom_total_time']) ? $this->data['current']['custom_total_time'] / 60 : 0;
                $this->data['customers'] = $customers;
                $this->data['users'] = $users;
                $this->data['labels'] = $labels;
                $this->data['categories'] = $categories;
                $this->data['projects'] = ProjectsModel::getByCustomerId($this->data['current']['customer_id']);

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
            $categories = TaskCategoryModel::getAll();
            $res = TaskModel::getById($id);
            if($res){
                $this->data['current'] = $res[0];
                $this->data['customers'] = $customers;
                $this->data['users'] = $users;
                $this->data['labels'] = $labels;
                $this->data['categories'] = $categories;
                include __DIR__ . '/../single.php';
            }
        } else {
            $data['deadline'] = TimezoneUtils::fromUserTimeZoneDateStringToTimestamp($data['deadline']);
            $data['estimated_time'] = ($data['estimated_time']) ? $data['estimated_time'] * 60 : 0;
            $data['custom_total_time'] = ($data['custom_total_time']) ? $data['custom_total_time'] * 60 : 0;

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
            $categories = TaskCategoryModel::getAll();
            if($res){
                $projects = ProjectsModel::getByCustomerId($res[0]['customer_id']);
                $this->data['current'] = $res[0];
                $this->data['labels'] = $labels;
                $this->data['categories'] = $categories;
                $this->data['projects'] = $projects;
                if($this->data['current']['deadline']){
                    $deadline = TimezoneUtils::fromTimestampToUserTimezoneDateString($this->data['current']['deadline']);
                }else{
                    $deadline = 'No deadline set';
                }
                $this->data['current']['deadline'] = $deadline;
                $this->data['current']['estimated_time'] = isset($this->data['current']['estimated_time']) ? $this->data['current']['estimated_time'] / 60 : 'Not set';
                $this->data['current']['custom_total_time'] = isset($this->data['current']['custom_total_time']) ? $this->data['current']['custom_total_time'] / 60 : 'Not set';

                include __DIR__ . '/../view.php';
            }else{
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Task id not found');

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
        $resource = $params['resource'];
        $resource = base64_decode($resource);
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
            'final_resource' => $resource
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

    /**
     * Render the Admin Dashboard View
     */
    public function adminDashboard(){
        // Check admin access
        if($this->session->get('access') != '0'){
            header('Location: ' . $this->base_url . '/dashboard');
            exit;
        }
        
        include __DIR__ . '/../admin_dashboard.php';
    }
    /**
     * API Endpoint: Get data for Admin Dashboard
     */
    public function getAdminDashboardData(){
        // Check admin access
        if($this->session->get('access') != '0'){
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        $users = UserModel::getAll();
        $tasks = TaskModel::getAll();
        
        $usersMap = [];
        foreach($users as $user){
            $usersMap[$user['id']] = $user;
            $usersMap[$user['id']]['tasks'] = [];
            $usersMap[$user['id']]['stats'] = [
                'total_hours' => 0,
                'daily_history' => []
            ];
        }
        foreach($tasks as $task){
            $userId = $task['asigned_to'];
            if(isset($usersMap[$userId])){
                // Calculate Net Duration using view.php logic
                $task['calculated_duration'] = $this->calculateNetDuration($task);

                $usersMap[$userId]['tasks'][] = $task;
                
                // Calculate Total Hours using the new calculated duration
                $totalSeconds = $task['calculated_duration'];
                $usersMap[$userId]['stats']['total_hours'] += ($totalSeconds / 3600);

                // Calculate Daily History
                $dailyData = $this->calculateDailyHours($task);
                foreach($dailyData as $date => $seconds){
                    if(!isset($usersMap[$userId]['stats']['daily_history'][$date])){
                        $usersMap[$userId]['stats']['daily_history'][$date] = 0;
                    }
                    $usersMap[$userId]['stats']['daily_history'][$date] += ($seconds / 3600);
                }
            }
        }
        // Format daily history for frontend (array of objects)
        foreach($usersMap as &$user){
            $history = [];
            foreach($user['stats']['daily_history'] as $date => $hours){
                $history[] = ['date' => $date, 'hours' => round($hours, 2)];
            }
            // Sort by date desc
            usort($history, function($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });
            $user['stats']['daily_history'] = $history;
            $user['stats']['total_hours'] = round($user['stats']['total_hours'], 2);
        }
        header('Content-Type: application/json');
        echo json_encode(array_values($usersMap));
        exit;
    }

        /**
     * Helper: Calculate net duration matching view.php logic
     */
    private function calculateNetDuration($task){
        if(!$task['start_time']) return 0;
        
        $end_time = !empty($task['end_time']) ? $task['end_time'] : time();
        
        // 3. Obtener y procesar los intervalos de pausa
        $paused_intervals = !empty($task['pause_intervals']) ? explode(',', $task['pause_intervals']) : [];

        // Handle PAUSED state: effective end time is the start of the last pause
        if($task['status'] == 'paused' && !empty($paused_intervals)){
            $last_pause_start = end($paused_intervals);
            if($last_pause_start){
                $end_time = $last_pause_start;
            }
        }
        
        // 2. Calcular el tiempo total (en segundos)
        $total_seconds = $end_time - $task['start_time'];
        
        // Si es impar, eliminamos el último timestamp (pausa no finalizada)
        if (count($paused_intervals) % 2 !== 0) {
            array_pop($paused_intervals); 
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
        return $net_seconds > 0 ? $net_seconds : 0;
    }
    /**
     * Helper: Calculate daily hours from task timestamps
     */
    private function calculateDailyHours($task){
        $dailyLog = [];
        
        // If no start time, we can't calculate history
        if(empty($task['start_time'])) return [];
        $intervals = [];
        $currentStart = $task['start_time'];
        
        // Parse pause intervals
        // Format: start_pause,end_pause,start_pause,end_pause...
        $pauses = [];
        if(!empty($task['pause_intervals'])){
            $parts = explode(',', $task['pause_intervals']);
            for($i = 0; $i < count($parts); $i+=2){
                if(isset($parts[$i]) && isset($parts[$i+1])){
                    $pauses[] = ['start' => $parts[$i], 'end' => $parts[$i+1]];
                }
            }
        }
        // Determine end time for calculation (finished time or now if active)
        $finalEnd = !empty($task['end_time']) ? $task['end_time'] : time();
        if($task['status'] == 'paused' && !empty($pauses)){
             // If currently paused, the last pause start is the effective end of the last work segment
             $lastPause = end($pauses);
             $finalEnd = $lastPause['start']; 
        }
        // Build work segments: [Start, End]
        // Segment 1: Start Time -> First Pause Start
        // Segment 2: First Pause End -> Second Pause Start
        // ...
        // Last Segment: Last Pause End -> Final End
        $workSegments = [];
        $lastWorkStart = $currentStart;
        foreach($pauses as $pause){
            if($pause['start'] > $lastWorkStart){
                $workSegments[] = ['start' => $lastWorkStart, 'end' => $pause['start']];
            }
            $lastWorkStart = $pause['end'];
        }
        
        // Add final segment
        if($finalEnd > $lastWorkStart){
            $workSegments[] = ['start' => $lastWorkStart, 'end' => $finalEnd];
        }
        // Distribute segments into days
        foreach($workSegments as $segment){
            $segStart = $segment['start'];
            $segEnd = $segment['end'];
            
            while($segStart < $segEnd){
                $currentDay = date('Y-m-d', $segStart);
                $nextDayStart = strtotime($currentDay . ' +1 day');
                
                $segmentEndForDay = min($segEnd, $nextDayStart);
                $duration = $segmentEndForDay - $segStart;
                
                if(!isset($dailyLog[$currentDay])) $dailyLog[$currentDay] = 0;
                $dailyLog[$currentDay] += $duration;
                
                $segStart = $segmentEndForDay;
            }
        }
        return $dailyLog;
    }
}