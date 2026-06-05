<?php

namespace Se7entech\Contractnew\Modules\CustomerPortal\Controllers;

use \Se7entech\Contractnew\Modules\Contract\Models\ContractModel;
use \Se7entech\Contractnew\Modules\Invoices\Models\InvoiceModel;
use \Se7entech\Contractnew\Modules\Tasks\Models\TaskModel;
use \Se7entech\Contractnew\Modules\Projects\Models\ProjectsModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Se7entech\Contractnew\Helpers\TaskHelper;
use Se7entech\Contractnew\Helpers\OpenAIHelper;
use Se7entech\Contractnew\Helpers\Mailer;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;

class CustomerPortalController{
    public function __construct(Session $session){
        global $base_url, $base_path;
        $this->base_url = $base_url;
        $this->base_path = $base_path;
        $this->session = $session;
        if (!empty($this->base_path)) {
            chdir($this->base_path);
        }
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
        
        foreach ($contracts as &$contract) {
            $contract['associated_invoices'] = ContractModel::getAssociatedInvoicesOnly($contract['id']);
        }
        unset($contract);

        $this->data['contracts'] = $contracts;
        include __DIR__ . '/../contracts.php';
    }

    public function invoices(){
        $customer_id = $this->session->get('customer_id');
        $invoices = InvoiceModel::getCustomerInvoices($customer_id);

        foreach ($invoices as &$invoice) {
            $invoice['associated_contracts'] = ContractModel::getAssociatedContractsOnly($invoice['order_id']);
        }
        unset($invoice);

        $this->data['invoices'] = $invoices;
        // Check if there is an invoices.php file, or include tasks if missing, but let's assume we might need a placeholder or view
        include __DIR__ . '/../invoices.php';
    }

    public function aiRequest($params) {
        $customer_id = $this->session->get('customer_id');
        if (!$customer_id) {
            header("Location: " . $this->base_url . "/modules/dashboard/index.php/customer");
            exit;
        }
        
        include __DIR__ . '/../../../../config/connection.php';
        
        $requests = [];
        $stmt = $con->prepare("SELECT * FROM customer_ai_requests WHERE customer_id = ? ORDER BY updated_at DESC");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        $stmt->close();
        
        $this->data['requests'] = $requests;
        include __DIR__ . '/../ai_request_list.php';
    }

    public function newRequest($params) {
        $customer_id = $this->session->get('customer_id');
        if (!$customer_id) {
            header("Location: " . $this->base_url . "/modules/dashboard/index.php/customer");
            exit;
        }
        
        include __DIR__ . '/../../../../config/connection.php';
        
        $type = isset($_GET['type']) ? trim($_GET['type']) : '';
        $greeting = '¡Hola! Soy tu asistente de requerimientos de IA. Cuéntame sobre el software, sitio web o aplicación móvil que deseas construir, y te ayudaré a definir el requerimiento completo de manera estructurada.';
        
        switch ($type) {
            case 'flyer':
                $greeting = '¡Hola! He visto que deseas solicitar un **Flyer Promocional**. Para poder estructurar tu solicitud de forma completa, por favor indícame:\n1. El nombre del proyecto.\n2. La descripción detallada de lo que necesitas (texto del flyer, colores, formato, etc.).\n3. ¿Cuentas con material? (Fotos, logos, etc.)\n4. La fecha deseada de entrega y nivel de prioridad.';
                break;
            case 'reel':
                $greeting = '¡Hola! Veo que deseas solicitar un **Reel / Video corto**. Para estructurar tu solicitud, por favor indícame:\n1. El nombre del proyecto y qué necesitas que hagamos.\n2. La duración deseada (15, 30 o 60 segundos).\n3. El objetivo principal (Venta, Promoción, Branding, etc.).\n4. ¿Cuentas con material de video o necesitas que agendemos una sesión?';
                break;
            case 'commercial':
                $greeting = '¡Hola! Veo que deseas solicitar un **Comercial Profesional**. Para definir tu requerimiento, por favor indícame:\n1. El nombre del proyecto y qué necesitas que hagamos.\n2. La duración deseada (15, 30 o 60 segundos).\n3. Descripción de la solicitud y objetivo principal.\n4. ¿Cuentas con material o necesitas que agendemos una sesión?';
                break;
            case 'design':
                $greeting = '¡Hola! Veo que deseas solicitar un **Diseño / Imagen**. Para estructurar tu solicitud, por favor indícame:\n1. El nombre del proyecto y tipo de diseño (Diseño para impresión, banner, etc.).\n2. Descripción detallada de lo que debe contener el diseño.\n3. ¿Cuentas con logos, textos o imágenes de referencia?\n4. Fecha deseada de entrega.';
                break;
            case 'menu':
                $greeting = '¡Hola! Veo que deseas solicitar un **Menú (Nuevo o Actualización)**. Por favor indícame:\n1. Si es un menú nuevo o la actualización de uno existente.\n2. El nombre del proyecto y los cambios o productos a agregar (precios, imágenes, platos).\n3. ¿Cuentas con los textos y precios finales listos para subir?';
                break;
            case 'website':
                $greeting = '¡Hola! Veo que deseas solicitar un **Sitio Web o Actualización de Website**. Por favor indícame:\n1. Si es una nueva página o una actualización de contenido existente.\n2. Los detalles del sitio (Agregar formulario, sistema de reservas, SEO, productos, etc.).\n3. ¿Cuentas con el material de logo, textos e imágenes listos?';
                break;
            case 'campaign':
                $greeting = '¡Hola! Veo que deseas solicitar una **Campaña Publicitaria (Ads)**. Por favor indícame:\n1. El nombre del proyecto y objetivo principal (Promoción, Venta, Branding, etc.).\n2. El presupuesto estimado y la duración de la campaña.\n3. Público objetivo e ideas creativas o referencias que tengas.';
                break;
            case 'prices':
                $greeting = '¡Hola! Veo que deseas solicitar una **Actualización de Precios / Productos**. Por favor indícame:\n1. El nombre del proyecto o lista de productos.\n2. Los nuevos precios o productos a actualizar.\n3. Si hay cambios en los horarios o detalles adicionales.';
                break;
            case 'photo_video':
                $greeting = '¡Hola! Veo que deseas solicitar una **Sesión de Fotos y Videos**. Por favor indícame:\n1. El nombre del proyecto y qué tipo de material necesitas (Fotos de comida, videos promocionales, etc.).\n2. La fecha tentativa y ubicación deseada para la sesión.\n3. La descripción de lo que se filmará o fotografiará.';
                break;
            case 'support':
                $greeting = '¡Hola! Veo que necesitas **Soporte Técnico**. Por favor indícame:\n1. El nombre del problema o requerimiento.\n2. La descripción detallada del error o lo que necesitas configurar (Google Business, correcciones, etc.).\n3. Nivel de prioridad (Baja, Media, Alta).';
                break;
        }

        $initialHistory = json_encode([
            [
                'role' => 'assistant',
                'content' => $greeting
            ]
        ]);
        
        $stmt = $con->prepare("INSERT INTO customer_ai_requests (customer_id, chat_history, status, progress) VALUES (?, ?, 'draft', 0)");
        $stmt->bind_param("is", $customer_id, $initialHistory);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        
        header("Location: " . $this->base_url . "/modules/customer-portal/index.php/ai-request/chat/" . $id);
        exit;
    }

    public function chatInterface($params) {
        $customer_id = $this->session->get('customer_id');
        $id = isset($params['id']) ? (int)$params['id'] : 0;
        
        if (!$customer_id) {
            header("Location: " . $this->base_url . "/modules/dashboard/index.php/customer");
            exit;
        }
        
        include __DIR__ . '/../../../../config/connection.php';
        
        $stmt = $con->prepare("SELECT * FROM customer_ai_requests WHERE id = ? AND customer_id = ?");
        $stmt->bind_param("ii", $id, $customer_id);
        $stmt->execute();
        $request_data = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if (!$request_data) {
            header("Location: " . $this->base_url . "/modules/customer-portal/index.php/ai-request");
            exit;
        }

        $customer = CustomersModel::getById($customer_id);
        $request_data['mega_upload_link'] = isset($customer['mega_upload_link']) ? $customer['mega_upload_link'] : null;
        
        $this->data['request'] = $request_data;
        include __DIR__ . '/../ai_request.php';
    }

    public function chatSession($params) {
        header('Content-Type: application/json');
        $customer_id = $this->session->get('customer_id');
        $id = isset($params['id']) ? (int)$params['id'] : 0;
        
        if (!$customer_id) {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            exit;
        }
        
        include __DIR__ . '/../../../../config/connection.php';
        
        $stmt = $con->prepare("SELECT * FROM customer_ai_requests WHERE id = ? AND customer_id = ?");
        $stmt->bind_param("ii", $id, $customer_id);
        $stmt->execute();
        $request_data = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if (!$request_data) {
            echo json_encode(['success' => false, 'error' => 'Requerimiento no encontrado']);
            exit;
        }
        
        if ($request_data['status'] !== 'draft') {
            echo json_encode(['success' => false, 'error' => 'Este requerimiento ya ha sido enviado y no se puede modificar']);
            exit;
        }
        
        // Start logging
        $logFile = __DIR__ . '/../../../../uploads/temp/chat_debug.log';
        $logDir = dirname($logFile);
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $logData = "\n========================================\n";
        $logData .= date('[Y-m-d H:i:s] ') . "CHAT SESSION START - Request ID: " . $id . ", Customer ID: " . $customer_id . "\n";
        $logData .= "FILES: " . json_encode($_FILES) . "\n";
        $logData .= "POST: " . json_encode($_POST) . "\n";
        
        $userMessage = '';
        if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
            $tempDir = __DIR__ . '/../../../../uploads/temp';
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }
            $uploadedName = $_FILES['audio']['name'];
            $ext = pathinfo($uploadedName, PATHINFO_EXTENSION);
            if (empty($ext)) {
                $ext = 'webm';
            }
            $ext = preg_replace('/[^a-zA-Z0-9]/', '', $ext);
            $tempFile = $tempDir . '/audio_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            
            $uploadedSuccess = false;
            if (PHP_SAPI === 'cli') {
                $uploadedSuccess = copy($_FILES['audio']['tmp_name'], $tempFile);
            } else {
                $uploadedSuccess = move_uploaded_file($_FILES['audio']['tmp_name'], $tempFile);
            }
            
            if ($uploadedSuccess) {
                $fileSize = filesize($tempFile);
                $logData .= "AUDIO FILE SAVED: " . $tempFile . " (Size: " . $fileSize . " bytes)\n";
                
                $transcriptionResult = OpenAIHelper::transcribeAudio($tempFile);
                $logData .= "WHISPER RESULT: " . json_encode($transcriptionResult) . "\n";
                
                if (file_exists($tempFile)) {
                    unlink($tempFile);
                }
                
                if ($transcriptionResult['success']) {
                    $userMessage = $transcriptionResult['text'];
                    $textMsg = isset($_POST['message']) ? trim($_POST['message']) : '';
                    if (!empty($textMsg)) {
                        $userMessage = $textMsg . "\n\n(Comentario de voz): " . $userMessage;
                    }
                } else {
                    $logData .= "WHISPER ERROR: " . $transcriptionResult['error'] . "\n";
                    file_put_contents($logFile, $logData, FILE_APPEND);
                    echo json_encode(['success' => false, 'error' => 'Error al transcribir audio: ' . $transcriptionResult['error']]);
                    exit;
                }
            } else {
                $logData .= "AUDIO FILE SAVE FAILED\n";
                file_put_contents($logFile, $logData, FILE_APPEND);
                echo json_encode(['success' => false, 'error' => 'Error al guardar el archivo de audio temporal']);
                exit;
            }
        } else {
            $userMessage = isset($_POST['message']) ? trim($_POST['message']) : '';
            $logData .= "NO AUDIO UPLOADED or UPLOAD ERROR (error code: " . (isset($_FILES['audio']['error']) ? $_FILES['audio']['error'] : 'no file field') . "). Using message: " . $userMessage . "\n";
        }
        
        if (empty($userMessage)) {
            $logData .= "USER MESSAGE EMPTY - EXITING\n";
            file_put_contents($logFile, $logData, FILE_APPEND);
            echo json_encode(['success' => false, 'error' => 'Mensaje vacío']);
            exit;
        }

        $logData .= "USER MESSAGE TO AI: " . $userMessage . "\n";
        
        $history = json_decode($request_data['chat_history'], true);
        if (!is_array($history)) {
            $history = [];
        }
        
        $history[] = ['role' => 'user', 'content' => $userMessage];
        
        $systemPrompt = "Eres un Asistente Inteligente de Recopilación de Requerimientos para Se7entech, una empresa de desarrollo de software, diseño web y marketing digital. "
            . "Tu objetivo es conversar con el cliente de forma interactiva y amigable en español para recopilar toda la información necesaria sobre su requerimiento o proyecto.\n\n"
            . "Identifica la categoría del requerimiento a partir de la conversación (ej. Nuevo menú, Actualización de menú, Flyer promocional, Publicación/Carrusel, Reel/Video corto, Comercial profesional, Historia, Diseño de impresión/Banner, Actualización/Nueva página web, Cambio de precios/Productos, Google Business, Soporte técnico, etc.).\n"
            . "De acuerdo con el tipo de requerimiento, debes sugerir y guiar la conversación para obtener las siguientes especificaciones esenciales:\n"
            . "- **Videos/Reels/Comerciales**: Duración deseada (ej. 15, 30, 60 segundos), el objetivo (venta, branding, etc.), y si disponen de material visual o necesitan agendar una sesión.\n"
            . "- **Sitio Web / Páginas Web**: Si es nuevo o actualización, secciones/funcionalidades necesarias (formularios, reservas, pasarela de pago, SEO, etc.), y disponibilidad de textos/logos.\n"
            . "- **Menús / Cambio de Precios**: Detalles de los platos, precios o productos a actualizar, y si los textos/precios finales están listos.\n"
            . "- **Flyers / Diseños / Posts**: Descripción detallada, textos/imágenes que deben ir, y si se requiere algún formato de impresión específico.\n"
            . "- **Soporte Técnico / Google Business**: Descripción del error o configuración, y nivel de prioridad.\n"
            . "Es sumamente importante que en todo requerimiento preguntes y confirmes la prioridad/plazo deseado, si tienen material de apoyo (e invítalos a subirlo si tienen el link de MEGA: " . ($request_data['mega_upload_link'] ?? 'No disponible') . "), y obtengas una AUTORIZACIÓN EXPLÍCITA del cliente para iniciar con los trabajos antes de marcar el requerimiento como listo (`is_ready = true`).\n\n"
            . "Para dar una respuesta estructurada, debes responder ÚNICAMENTE en formato JSON válido con las siguientes claves:\n"
            . "1. 'reply': Tu respuesta cordial al usuario en español. Debe reconocer lo que ha dicho, dar feedback y hacer una o dos preguntas claras para profundizar en lo que falte.\n"
            . "2. 'progress': Un número entero del 0 al 100 indicando el porcentaje estimado de completitud de la información recopilada. Sé realista: comienza en 10-20% y sube gradualmente a medida que el cliente proporcione detalles. Solo sube a 80%+ cuando tengas las respuestas a las preguntas clave del tipo de solicitud y la autorización explícita.\n"
            . "3. 'missing_info_feedback': Un array de strings en español listando los puntos clave que aún faltan definir (ej. 'Confirmar duración del video', 'Obtener textos finales', 'Autorización explícita del cliente').\n"
            . "4. 'is_ready': Un booleano. Debe ser true solo cuando el progreso sea de al menos 80% y el cliente haya dado su autorización explícita para iniciar el requerimiento.\n"
            . "5. 'structured_document': Un objeto con las siguientes claves en español:\n"
            . "   - 'subject': Un título claro y conciso para el proyecto.\n"
            . "   - 'summary': Un resumen ejecutivo del proyecto (1-2 párrafos).\n"
            . "   - 'details': Detalle exhaustivo del requerimiento en formato Markdown, estructurado con subtítulos (ej. Tipo de Solicitud, Objetivos, Funcionalidades/Detalles, Materiales y Enlaces, Prioridad y Plazos, Autorización). Este documento debe actualizarse y completarse de forma incremental a lo largo de la conversación.\n\n"
            . "No agregues explicaciones fuera del JSON. Todo el output debe ser un JSON válido.";
            
        $userPrompt = "Historial de conversación anterior:\n";
        foreach ($history as $msg) {
            $userPrompt .= ($msg['role'] === 'user' ? 'Cliente: ' : 'Asistente: ') . $msg['content'] . "\n";
        }
        $userPrompt .= "Nuevo mensaje del cliente: " . $userMessage . "\n\n";
        $userPrompt .= "Por favor, analiza la conversación completa y responde con el formato JSON solicitado.";
        
        $aiResponse = OpenAIHelper::generateCompletion($systemPrompt, $userPrompt);
        $logData .= "OPENAI RESPONSE SUCCESS: " . ($aiResponse['success'] ? 'true' : 'false') . "\n";
        if (!$aiResponse['success']) {
            $logData .= "OPENAI ERROR: " . $aiResponse['error'] . "\n";
            file_put_contents($logFile, $logData, FILE_APPEND);
            echo json_encode(['success' => false, 'error' => $aiResponse['error']]);
            exit;
        }
        
        $aiData = $aiResponse['data'];
        $logData .= "OPENAI DATA: " . json_encode($aiData) . "\n";
        file_put_contents($logFile, $logData, FILE_APPEND);
        
        $history[] = ['role' => 'assistant', 'content' => $aiData['reply']];
        $updatedHistoryStr = json_encode($history);
        $progress = (int)$aiData['progress'];
        
        $subject = isset($aiData['structured_document']['subject']) ? $aiData['structured_document']['subject'] : $request_data['subject'];
        $summary = isset($aiData['structured_document']['summary']) ? $aiData['structured_document']['summary'] : $request_data['summary'];
        $details = isset($aiData['structured_document']['details']) ? $aiData['structured_document']['details'] : $request_data['details'];
        
        if (is_array($subject)) {
            $subject = implode(' ', $subject);
        }
        if (is_array($summary)) {
            $summary = implode("\n", $summary);
        }
        if (is_array($details)) {
            $markdown = '';
            foreach ($details as $section => $content) {
                if (is_array($content)) {
                    $content = implode("\n", $content);
                }
                $markdown .= "### " . $section . "\n" . $content . "\n\n";
            }
            $details = trim($markdown);
        }
        
        $stmt = $con->prepare("UPDATE customer_ai_requests SET chat_history = ?, progress = ?, subject = ?, summary = ?, details = ? WHERE id = ?");
        $stmt->bind_param("sisssi", $updatedHistoryStr, $progress, $subject, $summary, $details, $id);
        $stmt->execute();
        $stmt->close();
        
        echo json_encode([
            'success' => true,
            'transcription' => $userMessage,
            'reply' => $aiData['reply'],
            'progress' => $progress,
            'missing_info_feedback' => $aiData['missing_info_feedback'],
            'is_ready' => $aiData['is_ready'],
            'structured_document' => [
                'subject' => $subject,
                'summary' => $summary,
                'details' => $details
            ]
        ]);
        exit;
    }

    public function confirmAndSend($params) {
        header('Content-Type: application/json');
        $customer_id = $this->session->get('customer_id');
        $id = isset($params['id']) ? (int)$params['id'] : 0;
        
        if (!$customer_id) {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            exit;
        }
        
        include __DIR__ . '/../../../../config/connection.php';
        
        $stmt = $con->prepare("SELECT * FROM customer_ai_requests WHERE id = ? AND customer_id = ?");
        $stmt->bind_param("ii", $id, $customer_id);
        $stmt->execute();
        $request_data = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if (!$request_data) {
            echo json_encode(['success' => false, 'error' => 'Requerimiento no encontrado']);
            exit;
        }
        
        if ($request_data['status'] !== 'draft') {
            echo json_encode(['success' => false, 'error' => 'Este requerimiento ya ha sido enviado']);
            exit;
        }
        
        $subject = isset($_POST['subject']) ? trim($_POST['subject']) : $request_data['subject'];
        $summary = isset($_POST['summary']) ? trim($_POST['summary']) : $request_data['summary'];
        $details = isset($_POST['details']) ? trim($_POST['details']) : $request_data['details'];
        
        if (empty($subject) || empty($summary) || empty($details)) {
            echo json_encode(['success' => false, 'error' => 'El título, resumen y detalles no pueden estar vacíos']);
            exit;
        }
        
        $customer = CustomersModel::getById($customer_id);
        if (!$customer) {
            echo json_encode(['success' => false, 'error' => 'Cliente no encontrado']);
            exit;
        }
        
        require_once __DIR__ . '/../../../../dompdf/src/Autoloader.php';
        \Dompdf\Autoloader::register();
        
        $customerName = htmlspecialchars($customer['business_name'] ?: $customer['name']);
        $customerEmail = htmlspecialchars($customer['email'] ?: 'No especificado');
        $customerPhone = htmlspecialchars($customer['phone'] ?: 'No especificado');
        $formattedDate = date('d/m/Y H:i:s');
        
        $lines = explode("\n", str_replace("\r", "", $details));
        $detailsRowsHtml = "";
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                $detailsRowsHtml .= "<tr><td style='height: 8px; font-size: 1px; line-height: 1;'>&nbsp;</td></tr>";
                continue;
            }
            
            $line = htmlspecialchars($line);
            $line = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $line);
            
            if (strpos($line, '### ') === 0) {
                $content = substr($line, 4);
                $detailsRowsHtml .= "<tr><td style='font-size: 15px; font-weight: bold; color: #5e72e4; padding: 10px 0 4px 0; font-family: Helvetica, Arial, sans-serif;'>$content</td></tr>";
            } elseif (strpos($line, '## ') === 0) {
                $content = substr($line, 3);
                $detailsRowsHtml .= "<tr><td style='font-size: 17px; font-weight: bold; color: #5e72e4; padding: 12px 0 4px 0; font-family: Helvetica, Arial, sans-serif;'>$content</td></tr>";
            } elseif (strpos($line, '# ') === 0) {
                $content = substr($line, 2);
                $detailsRowsHtml .= "<tr><td style='font-size: 20px; font-weight: bold; color: #5e72e4; padding: 14px 0 4px 0; font-family: Helvetica, Arial, sans-serif;'>$content</td></tr>";
            } elseif (strpos($line, '- ') === 0) {
                $content = substr($line, 2);
                $detailsRowsHtml .= "<tr><td style='font-size: 13px; padding: 2px 0 2px 15px; font-family: Helvetica, Arial, sans-serif;'>&bull; $content</td></tr>";
            } elseif (strpos($line, '* ') === 0) {
                $content = substr($line, 2);
                $detailsRowsHtml .= "<tr><td style='font-size: 13px; padding: 2px 0 2px 15px; font-family: Helvetica, Arial, sans-serif;'>&bull; $content</td></tr>";
            } else {
                $detailsRowsHtml .= "<tr><td style='font-size: 13px; padding: 3px 0; font-family: Helvetica, Arial, sans-serif;'>$line</td></tr>";
            }
        }
        
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body {
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    color: #333;
                    line-height: 1.6;
                    padding: 10px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .header-table {
                    border-bottom: 2px solid #5e72e4;
                    padding-bottom: 15px;
                }
                .logo-text {
                    font-size: 26px;
                    font-weight: bold;
                    color: #5e72e4;
                }
                .meta-text {
                    text-align: right;
                    font-size: 11px;
                    color: #888;
                }
                .title-td {
                    font-size: 22px;
                    font-weight: bold;
                    color: #32325d;
                    padding: 10px 0;
                }
                .section-header-td {
                    font-size: 16px;
                    font-weight: bold;
                    color: #5e72e4;
                    border-bottom: 1px solid #e9ecef;
                    padding: 8px 0;
                }
                .client-info-table {
                    background-color: #f8f9fe;
                    border: 1px solid #e9ecef;
                }
                .client-info-table td {
                    padding: 8px 12px;
                    font-size: 13px;
                }
                .label-td {
                    font-weight: bold;
                    color: #525f7f;
                }
                .summary-table {
                    background-color: #f6f9fc;
                    border-left: 4px solid #11cdef;
                }
                .summary-td {
                    padding: 15px;
                    font-style: italic;
                    font-size: 13px;
                }
                .details-table td {
                    font-size: 13px;
                    padding: 5px 0;
                }
            </style>
        </head>
        <body>
            <table class='header-table'>
                <tr>
                    <td>
                        <span class='logo-text'>SE7ENTECH</span><br>
                        <span style='font-size:12px;color:#888;'>Requerimiento de Proyecto</span>
                    </td>
                    <td class='meta-text'>
                        Fecha: {$formattedDate}<br>
                        ID Requerimiento: #AI-{$id}
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class='title-td'>
                        Requerimiento: " . htmlspecialchars($subject) . "
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class='section-header-td'>
                        Información del Cliente
                    </td>
                </tr>
            </table>

            <table class='client-info-table'>
                <tr>
                    <td class='label-td' width='25%'>Cliente/Empresa:</td>
                    <td>{$customerName}</td>
                </tr>
                <tr>
                    <td class='label-td'>Email:</td>
                    <td>{$customerEmail}</td>
                </tr>
                <tr>
                    <td class='label-td'>Teléfono:</td>
                    <td>{$customerPhone}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class='section-header-td'>
                        Resumen Ejecutivo
                    </td>
                </tr>
            </table>

            <table class='summary-table'>
                <tr>
                    <td class='summary-td'>
                        " . nl2br(htmlspecialchars($summary)) . "
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class='section-header-td'>
                        Especificaciones Detalladas
                    </td>
                </tr>
            </table>

            <table class='details-table'>
                {$detailsRowsHtml}
            </table>
        </body>
        </html>
        ";
        
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        
        $reportsDir = __DIR__ . '/../../../../uploads/reports';
        if (!file_exists($reportsDir)) {
            mkdir($reportsDir, 0777, true);
        }
        $fileName = 'AI-Requirement-' . $id . '-' . time() . '.pdf';
        $pdfFile = $reportsDir . '/' . $fileName;
        file_put_contents($pdfFile, $pdfOutput);
        
        $relativePdfPath = 'uploads/reports/' . $fileName;
        
        $stmt = $con->prepare("UPDATE customer_ai_requests SET status = 'submitted', subject = ?, summary = ?, details = ?, pdf_path = ?, progress = 100 WHERE id = ?");
        $stmt->bind_param("ssssi", $subject, $summary, $details, $relativePdfPath, $id);
        $stmt->execute();
        $stmt->close();
        
        $adminEmail = 'admin@se7entech.net';
        $adminName = 'Se7entech Administrator';
        
        $emailSubject = "Nuevo Requerimiento de Proyecto IA: " . $subject . " - " . $customerName;
        $emailContent = "
        <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <h2 style='color: #5e72e4;'>Nuevo Requerimiento Recibido</h2>
            <p>Se ha generado un nuevo requerimiento de proyecto recopilado con asistencia de Inteligencia Artificial.</p>
            <table style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>
                <tr>
                    <td style='padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f9f9f9; width: 25%;'>Cliente:</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>{$customerName}</td>
                </tr>
                <tr>
                    <td style='padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f9f9f9;'>Email del Cliente:</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>{$customerEmail}</td>
                </tr>
                <tr>
                    <td style='padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f9f9f9;'>Proyecto:</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>{$subject}</td>
                </tr>
                <tr>
                    <td style='padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f9f9f9;'>Fecha de Envío:</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>{$formattedDate}</td>
                </tr>
            </table>
            <h3>Resumen Ejecutivo:</h3>
            <blockquote style='background-color: #f1f3f9; border-left: 4px solid #5e72e4; padding: 15px; margin: 0 0 20px 0;'>
                " . nl2br(htmlspecialchars($summary)) . "
            </blockquote>
            <p>Se adjunta el PDF oficial con las especificaciones detalladas recopiladas para su revisión.</p>
            <p>Atentamente,<br><strong>Se7entech CRM</strong></p>
        </div>
        ";
        $recipients = [];
        if (!empty($customer['email'])) {
            $recipients[] = [
                'email' => $customer['email'],
                'name' => $customerName
            ];
        }
        $recipients[] = [
            'email' => $adminEmail,
            'name' => $adminName
        ];

        $mailer = new Mailer('no-reply@se7entech.net', 'Se7entech AI Assistant', $recipients, false, $emailSubject, $emailContent);
        $mailer->addAttachment($pdfFile);
        $sendResult = $mailer->send();
        
        if ($sendResult === true) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => true, 'warning' => 'Requerimiento guardado pero falló el envío de correo: ' . $sendResult]);
        }
        exit;
    }

    public function deleteRequest($params) {
        header('Content-Type: application/json');
        $customer_id = $this->session->get('customer_id');
        $id = isset($params['id']) ? (int)$params['id'] : 0;
        
        if (!$customer_id) {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            exit;
        }
        
        include __DIR__ . '/../../../../config/connection.php';
        
        $stmt = $con->prepare("SELECT * FROM customer_ai_requests WHERE id = ? AND customer_id = ?");
        $stmt->bind_param("ii", $id, $customer_id);
        $stmt->execute();
        $request_data = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if (!$request_data) {
            echo json_encode(['success' => false, 'error' => 'Requerimiento no encontrado']);
            exit;
        }
        
        if ($request_data['status'] !== 'draft') {
            echo json_encode(['success' => false, 'error' => 'No se puede eliminar un requerimiento ya enviado']);
            exit;
        }
        
        $stmt = $con->prepare("DELETE FROM customer_ai_requests WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        echo json_encode(['success' => true]);
        exit;
    }
}