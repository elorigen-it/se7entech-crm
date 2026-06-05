<?php
namespace Se7entech\Contractnew\Modules\Reports\Controllers;

use Se7entech\Contractnew\Modules\Reports\Models\ReportsModel;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Se7entech\Contractnew\Helpers\OpenAIHelper;
use Se7entech\Contractnew\Helpers\Mailer;
use Se7entech\Contractnew\Modules\Users\Models\UserModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ReportsController {
    public $data = [
        'errors' => [],
        'success' => null,
        'session' => []
    ];
    private $base_url;
    private $session;

    public function __construct(Session $session) {
        $this->session = $session;
        global $base_url;
        $this->base_url = $base_url;
        foreach ($this->session->getFlashBag()->all() as $type => $messages) {
            foreach ($messages as $message) {
                array_push($this->data['session'], '<div class="alert alert-' . $type . ' p-2" role="alert">' . $message . '</div>');
            }
        }
    }

    private function _jsonResponse($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    public function index() {
        $this->data['customers'] = CustomersModel::getAllV2();
        $this->data['history'] = ReportsModel::getSentReportsHistory();
        include __DIR__ . '/../dashboard.php';
    }

    public function generate() {
        $customerId = $_POST['customer_id'] ?? null;
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;

        if (!$customerId || !$startDate || !$endDate) {
            $this->_jsonResponse(['success' => false, 'error' => 'Missing required fields.'], 400);
        }

        $customer = CustomersModel::getById($customerId);
        $reportData = ReportsModel::getTasksAndProjectsForReport($customerId, $startDate, $endDate);

        $this->_jsonResponse([
            'success' => true,
            'customer' => $customer,
            'reportData' => $reportData
        ]);
    }

    public function aiPolish() {
        $customerId = $_POST['customer_id'] ?? null;
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;

        if (!$customerId || !$startDate || !$endDate) {
            $this->_jsonResponse(['success' => false, 'error' => 'Missing required fields.'], 400);
        }

        $customer = CustomersModel::getById($customerId);
        $reportData = ReportsModel::getTasksAndProjectsForReport($customerId, $startDate, $endDate);

        // Build list of tasks for the prompt
        $tasksList = [];
        $noProjectCount = 1;
        
        foreach ($reportData['projects'] as $project) {
            foreach ($project['tasks'] as $task) {
                $hours = \Se7entech\Contractnew\Helpers\TaskHelper::getRealTotalTime($task, true);
                $origDesc = strip_tags(html_entity_decode($task['task_description_for_customer'] ? $task['task_description_for_customer'] : $task['description']));
                $tasksList[] = [
                    'id' => $task['id'],
                    'project' => $project['name'],
                    'task_name' => $task['name'],
                    'original_description' => $origDesc,
                    'hours' => $hours
                ];
            }
        }

        foreach ($reportData['no_project_tasks'] as $task) {
            $hours = \Se7entech\Contractnew\Helpers\TaskHelper::getRealTotalTime($task, true);
            $origDesc = strip_tags(html_entity_decode($task['task_description_for_customer'] ? $task['task_description_for_customer'] : $task['description']));
            $tasksList[] = [
                'id' => $task['id'],
                'project' => 'General Tasks',
                'task_name' => $task['name'],
                'original_description' => $origDesc,
                'hours' => $hours
            ];
        }

        if (empty($tasksList)) {
            $this->_jsonResponse(['success' => false, 'error' => 'No tasks found in this date range.']);
        }

        $systemPrompt = "You are a professional business advisor. Your task is to take a list of projects and tasks completed for a customer during a period and generate:
1. A professional Executive Summary (in Spanish) detailing the overall achievements and value delivered during the period. Make it read like a polished business report. Do NOT invent, calculate, or mention specific numbers of hours worked in the summary.
2. A polished, client-friendly list of task descriptions that explain the work clearly and professionally (in Spanish), translating low-level technical jargon into business-oriented terms. Do NOT include, mention, or modify the hours/duration of tasks within the descriptions.
Respond STRICTLY in JSON format matching this schema:
{
  \"executive_summary\": \"Your executive summary text here\",
  \"tasks\": [
    { \"id\": 123, \"professional_description\": \"Your cleaned-up task description here\" }
  ]
}";

        $userPrompt = json_encode([
            'customer' => $customer['business_name'] ? $customer['business_name'] : $customer['name'],
            'period' => $startDate . ' to ' . $endDate,
            'tasks' => $tasksList
        ]);

        $res = OpenAIHelper::generateCompletion($systemPrompt, $userPrompt);
        $this->_jsonResponse($res);
    }

    public function downloadPdf() {
        $customerId = $_POST['customer_id'] ?? null;
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $executiveSummary = $_POST['executive_summary'] ?? '';
        $professionalTasksJson = $_POST['professional_tasks'] ?? '{}';
        
        $professionalTasks = json_decode($professionalTasksJson, true);

        if (!$customerId || !$startDate || !$endDate) {
            die("Missing parameters.");
        }

        $customer = CustomersModel::getById($customerId);
        $reportData = ReportsModel::getTasksAndProjectsForReport($customerId, $startDate, $endDate);

        // Include dompdf
        require_once __DIR__ . '/../../../../dompdf/src/Autoloader.php';
        \Dompdf\Autoloader::register();
        
        ob_start();
        include __DIR__ . '/../pdf_template.php';
        $html = ob_get_clean();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $fileName = 'Report-' . ($customer['business_name'] ? str_replace(' ', '-', $customer['business_name']) : 'Customer') . '-' . $startDate . '-to-' . $endDate . '.pdf';
        $dompdf->stream($fileName, ["Attachment" => false]);
        exit;
    }

    public function sendEmail() {
        $customerId = $_POST['customer_id'] ?? null;
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $email = $_POST['email'] ?? null;
        $executiveSummary = $_POST['executive_summary'] ?? '';
        $professionalTasksJson = $_POST['professional_tasks'] ?? '{}';
        
        $professionalTasks = json_decode($professionalTasksJson, true);

        if (!$customerId || !$startDate || !$endDate || !$email) {
            $this->session->getFlashBag()->add('danger', 'Missing parameters to send email.');
            $this->session->save();
            header('Location: ' . $this->base_url . '/modules/reports/');
            exit;
        }

        $customer = CustomersModel::getById($customerId);
        $reportData = ReportsModel::getTasksAndProjectsForReport($customerId, $startDate, $endDate);

        // Include dompdf
        require_once __DIR__ . '/../../../../dompdf/src/Autoloader.php';
        \Dompdf\Autoloader::register();
        
        ob_start();
        include __DIR__ . '/../pdf_template.php';
        $html = ob_get_clean();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();

        // Save PDF permanently
        $reportsDir = __DIR__ . '/../../../../uploads/reports';
        if (!file_exists($reportsDir)) {
            mkdir($reportsDir, 0777, true);
        }
        $fileName = 'Report-' . $customerId . '-' . time() . '.pdf';
        $pdfFile = $reportsDir . '/' . $fileName;
        file_put_contents($pdfFile, $pdfOutput);

        // Prepare email
        $subject = "Informe de Trabajo / Work Report - " . ($customer['business_name'] ? $customer['business_name'] : $customer['name']) . " (" . date('d/M/Y', strtotime($startDate)) . " al " . date('d/M/Y', strtotime($endDate)) . ")";
        
        $emailBody = "<p>Estimado/a <strong>" . htmlspecialchars($customer['name']) . "</strong>,</p>";
        $emailBody .= "<p>Adjunto a este correo encontrará el informe detallado de las tareas y proyectos trabajados en el periodo del <strong>" . date('d/M/Y', strtotime($startDate)) . "</strong> al <strong>" . date('d/M/Y', strtotime($endDate)) . "</strong>.</p>";
        if (!empty($executiveSummary)) {
            $emailBody .= "<h3>Resumen Ejecutivo:</h3>";
            $emailBody .= "<p style='background-color:#f7f9fa; border-left:4px solid #0daea8; padding:12px; font-style:italic;'>" . nl2br(htmlspecialchars($executiveSummary)) . "</p>";
        }
        $emailBody .= "<p>Si tiene alguna pregunta sobre el informe adjunto, por favor no dude en responder a este correo.</p>";
        $emailBody .= "<br/><p>Atentamente,</p><p><strong>El equipo de SE7ENTECH</strong></p>";

        $userId = $_SESSION['userid'] ?? $_SESSION['id'] ?? 1;

        $smtpUser = null;
        $smtpPass = null;
        $user = UserModel::getById($userId);
        if ($user && !empty($user['smtp_user']) && !empty($user['smtp_pass'])) {
            $smtpUser = $user['smtp_user'];
            $smtpPass = $user['smtp_pass'];
        }

        if (empty($smtpUser) || empty($smtpPass)) {
            $smtpUser = getenv('SMTP_DEFAULT_USERNAME') ?: 'admin@se7entech.net';
            $smtpPass = getenv('SMTP_DEFAULT_PASSWORD') ?: 'Se7entech775$';
        }

        $resendApiKey = getenv('RESEND_API_KEY') ?: ($_ENV['RESEND_API_KEY'] ?? ($_SERVER['RESEND_API_KEY'] ?? null));
        $resendFromEmail = getenv('RESEND_FROM_EMAIL') ?: ($_ENV['RESEND_FROM_EMAIL'] ?? ($_SERVER['RESEND_FROM_EMAIL'] ?? 'no-reply@se7entech.net'));
        $resendFromName = getenv('RESEND_FROM_NAME') ?: ($_ENV['RESEND_FROM_NAME'] ?? ($_SERVER['RESEND_FROM_NAME'] ?? 'SE7ENTECH'));
        
        $fromEmail = !empty($resendApiKey) ? $resendFromEmail : $smtpUser;
        $fromName = !empty($resendApiKey) ? $resendFromName : 'SE7ENTECH';

        $mailer = new Mailer(
            $fromEmail,
            $fromName,
            $email,
            $customer['name'],
            $subject,
            $emailBody,
            null,
            !empty($resendApiKey) ? false : $smtpUser,
            !empty($resendApiKey) ? false : $smtpPass
        );
        $mailer->addAttachment($pdfFile);
        $mailResult = $mailer->send();

        if ($mailResult === true) {
            // Save to history log
            $relativePdfPath = 'uploads/reports/' . $fileName;
            ReportsModel::saveSentReport($customerId, $startDate, $endDate, $email, $userId, $relativePdfPath);
            $this->session->getFlashBag()->add('success', 'Report successfully sent to ' . htmlspecialchars($email));
        } else {
            // Delete PDF file if email sending failed
            if (file_exists($pdfFile)) {
                unlink($pdfFile);
            }
            $this->session->getFlashBag()->add('danger', 'Error sending email: ' . $mailResult);
        }

        $this->session->save();
        header('Location: ' . $this->base_url . '/modules/reports/');
        exit;
    }
}
