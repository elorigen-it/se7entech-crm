<?php
namespace Se7entech\Contractnew\Modules\Reports\Models;

class ReportsModel {
    private static $table = 'sent_reports';

    public static function getTasksAndProjectsForReport($customerId, $startDate, $endDate) {
        include __DIR__ . '/../../../../config/connection.php';
        
        // Fetch projects
        $projects = [];
        $pSql = "SELECT * FROM projects_v2 WHERE customer_id = " . (int)$customerId;
        $pRes = mysqli_query($con, $pSql);
        if ($pRes && mysqli_num_rows($pRes)) {
            while ($row = mysqli_fetch_assoc($pRes)) {
                $row['tasks'] = [];
                $projects[$row['id']] = $row;
            }
        }

        // Fetch tasks
        $tasksSql = "SELECT tasks.*, 
                    invoice_user.first_name, invoice_user.last_name, invoice_user.email 
                    FROM tasks 
                    LEFT JOIN invoice_user ON tasks.asigned_to = invoice_user.id 
                    WHERE tasks.customer_id = " . (int)$customerId . " 
                      AND DATE(tasks.created_at) BETWEEN '" . mysqli_real_escape_string($con, $startDate) . "' AND '" . mysqli_real_escape_string($con, $endDate) . "' 
                    ORDER BY tasks.created_at ASC";
                    
        $tRes = mysqli_query($con, $tasksSql);
        $noProjectTasks = [];
        
        if ($tRes && mysqli_num_rows($tRes)) {
            while ($row = mysqli_fetch_assoc($tRes)) {
                $pId = $row['project_id'];
                if ($pId && isset($projects[$pId])) {
                    $projects[$pId]['tasks'][] = $row;
                } else {
                    $noProjectTasks[] = $row;
                }
            }
        }

        return [
            'projects' => array_values($projects),
            'no_project_tasks' => $noProjectTasks
        ];
    }

    public static function saveSentReport($customerId, $startDate, $endDate, $email, $userId, $pdfPath = null) {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("INSERT INTO " . self::$table . " (customer_id, start_date, end_date, sent_to_email, sent_by, pdf_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $customerId, $startDate, $endDate, $email, $userId, $pdfPath);
        return $stmt->execute();
    }

    public static function getSentReportsHistory() {
        include __DIR__ . '/../../../../config/connection.php';
        $response = [];
        $sql = "SELECT r.*, c.name as customer_name, c.business_name as customer_business_name, 
                       u.first_name as user_first_name, u.last_name as user_last_name 
                FROM " . self::$table . " r 
                JOIN customers c ON r.customer_id = c.id 
                JOIN invoice_user u ON r.sent_by = u.id 
                ORDER BY r.sent_at DESC";
        $res = mysqli_query($con, $sql);
        if ($res && mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                $response[] = $row;
            }
        }
        return $response;
    }
}
