<?php

namespace Se7entech\Contractnew\Modules\AdminAIRequests\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;

class AdminAIRequestsController {
    private $session;
    private $base_url;
    private $base_path;
    protected $data = [];

    public function __construct(Session $session) {
        global $base_url, $base_path;
        $this->base_url = $base_url;
        $this->base_path = $base_path;
        $this->session = $session;
        if (!empty($this->base_path)) {
            chdir($this->base_path);
        }
    }

    public function listRequests($params) {
        // Only verify access here. Role '0' means administrator.
        if ($this->session->get('access') !== '0') {
            header("Location: " . $this->base_url . "/dashboard.php");
            exit;
        }

        include __DIR__ . '/../../../../config/connection.php';

        $records = [];
        $query = "SELECT r.*, c.name AS customer_name, c.business_name AS customer_business_name, c.email AS customer_email 
                  FROM customer_ai_requests r 
                  LEFT JOIN customers c ON r.customer_id = c.id 
                  ORDER BY r.updated_at DESC";
                  
        $result = mysqli_query($con, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] = $row;
            }
        }

        $this->data['records'] = $records;
        include __DIR__ . '/../index.php';
    }

    public function getChatHistory($params) {
        header('Content-Type: application/json');

        if ($this->session->get('access') !== '0') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            exit;
        }

        $id = isset($params['id']) ? (int)$params['id'] : 0;
        if ($id <= 0) {
            echo json_encode(['success' => false, 'error' => 'ID inválido']);
            exit;
        }

        include __DIR__ . '/../../../../config/connection.php';

        $stmt = $con->prepare("SELECT chat_history FROM customer_ai_requests WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($res) {
            $history = json_decode($res['chat_history'], true);
            echo json_encode([
                'success' => true,
                'history' => is_array($history) ? $history : []
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Requerimiento no encontrado']);
        }
        exit;
    }
}
