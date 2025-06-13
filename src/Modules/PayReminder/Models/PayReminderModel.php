<?php
namespace Se7entech\Contractnew\Modules\PayReminder\Models;

use Se7entech\Contractnew\Helpers\EscapeString;
use Se7entech\Contractnew\Modules\Contract\Models\ContractModel;
use Exception;

class PayReminderModel {
    const API_KEY = "051d1bce-e433-4259-bd31-875dd8e70051";
    // Movido a CustomersModel
    /*public static function createCustomer($data){
        include __DIR__ . '/../../../../config/connection.php';

        if (!$con) {
            throw new Exception("Error: Conexión a la base de datos no válida.");
        }
        
        $sql = "INSERT INTO clients (name, phone, address, email, notes, businessname, logid, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 0)";

        //$sql = "INSERT INTO customers (type, name, phone, address, email, notes, business_name, status, agent_email)
                //VALUES ('customer', ?, ?, ?, ?, ?, ?, 0, ?)";
        
        $data = EscapeString::escapeArray($con, $data);
        
        $stmt = mysqli_prepare($con, $sql);
        
        if (!$stmt) {
            $errorMessage = "Error al preparar la consulta: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }
        
        mysqli_stmt_bind_param($stmt, "sssssss", $data['name'], $data['phone'], $data['address'], $data['email'], $data['notes'], $data['businessname'], $data['agent_email']);

        $success = mysqli_stmt_execute($stmt);
        
        if ($success) {
            $newCustomerId = $con->insert_id;
            self::createClient($con, $data);
            return $newCustomerId;
        } else {
            $errorMessage = "Error al crear el customer: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }
    }
    
    public static function createClient($con, $data){
        $sql = "INSERT INTO clients (name, phone, address, email, notes, businessname, logid, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        
        $data = EscapeString::escapeArray($con, $data);
        
        $stmt = mysqli_prepare($con, $sql);
        
        if (!$stmt) {
            $errorMessage = "Error al preparar la consulta: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }
        
        mysqli_stmt_bind_param($stmt, "sssssss", $data['name'], $data['phone'], $data['address'], $data['email'], $data['notes'], $data['businessname'], $data['agent_email']);
        
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            $errorMessage = "Error al crear el cliente: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }
    }*/

    public static function getNeeded(){
        include __DIR__ . '/../../../../config/connection.php';
    
        $fresponse = [];
        $response = [];
    
        $sql = "SELECT cg.*, c.customer_name_1, c.company_name_1 
                FROM contract_gracetime cg
                INNER JOIN contract c ON cg.contract_id = c.id";
    
        $res = mysqli_query($con, $sql);
    
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($fresponse, $row);
            }

            foreach($fresponse as $row){
                $contract_id = $row['contract_id'];
                $type = $row['type'];
                $setup_date = null;
        
                // Determinar el nombre del campo setup_date según el tipo
                switch($type) {
                    case 1:
                        $setup_date_field = 'setup_date_domain';
                        $service_field = 'domain';
                        break;
                    case 2:
                        $setup_date_field = 'setup_date_hosting';
                        $service_field = 'hosting';
                        break;
                    case 3:
                        $setup_date_field = 'setup_date_marketing';
                        $service_field = 'marketing';
                        break;
                    default:
                        $setup_date_field = '';
                        $service_field = '';
                        break;
                }

                $row['setup_date_domain'] = null;
                $row['setup_date_hosting'] = null;
                $row['setup_date_marketing'] = null;
                $row['domain'] = 'NO';
                $row['hosting'] = 'NO';
                $row['marketing'] = 'NO';

                if(!empty($service_field)) {
                    if($service_field == 'domain'){
                        $service = $row['extra'];
                    } else {
                        $service = 'YES';
                    }
                }

                // Obtener el setup_date correspondiente
                if (!empty($setup_date_field)) {
                    $setup_date = $row['setup_date'];
                }
        
                // Verificar si ya existe el contract_id en $response
                if (isset($response[$contract_id])) {
                    // Si ya existe, añadir setup_date al resultado existente
                    $response[$contract_id][$service_field] = $service;
                    $response[$contract_id][$setup_date_field] = $setup_date;
                } else {
                    // Si no existe, agregar una nueva fila al response
                    $response[$contract_id] = $row;
                    $response[$contract_id][$setup_date_field] = $setup_date;
                    $response[$contract_id][$service_field] = $service;
                }
            }
        }
    
        return $response;
    }


    public static function getById($id){
        include __DIR__ . '/../../../../config/connection.php';
        //$response = [];

        $sql = "SELECT cg.*, c.customer_name_1, c.company_name_1 
        FROM contract_gracetime cg
        INNER JOIN contract c ON cg.contract_id = c.id
        WHERE cg.contract_id = $id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            return mysqli_fetch_assoc($res);
        }
        
        return false;
    }

    public static function getFormats(){
        include __DIR__ . '/../../../../config/connection.php';
        $response = [];

        $sql = "SELECT * 
        FROM pay_reminder_format
        ORDER BY id DESC";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
    
        return $response;
    }

    public static function getFormatsById($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "SELECT * 
        FROM pay_reminder_format
        WHERE id = $id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            return mysqli_fetch_assoc($res);
        }
    
        return false;
    }

    private static function installedProcess($id, $data, $type) {
        include_once __DIR__ . '/../../../../config/connection.php';

        $actualDate = date('Y-m-d');

        $sqlMaintenance = "SELECT maintenance_period FROM contract WHERE id = {$id}";

        $resultMaintenance = $con->query($sqlMaintenance);

        if ($resultMaintenance->num_rows > 0) {
            $rowMaintenance = $resultMaintenance->fetch_assoc();
            $maintenancePeriod = $rowMaintenance['maintenance_period'];

            $days = ContractModel::convertGracetime($maintenancePeriod);
        }

        $checkSql = "SELECT * FROM contract_gracetime WHERE contract_id = {$id} AND type = {$type}";
                
        $result = $con->query($checkSql);

        switch($type) {
            case 1:
                if ($result->num_rows == 0) {
                    // Si no existe la fila, la creamos
                    $sql = "INSERT INTO contract_gracetime (contract_id, grace_time, type, setup_date, extra) VALUES ({$id}, {$days}, {$type}, '$actualDate', '{$data['domain']}')";
                } else {
                    $sql = "UPDATE contract_gracetime SET setup_date = '$actualDate', extra = '{$data['domain']}' WHERE contract_id = {$id} AND type = {$type}";
                }
                break;
            case 2:
                if ($result->num_rows == 0) {
                    // Si no existe la fila, la creamos
                    $sql = "INSERT INTO contract_gracetime (contract_id, grace_time, type, setup_date, extra) VALUES ({$id}, {$days}, {$type}, '$actualDate', '{$data['domain']}')";
                } else {
                    $sql = "UPDATE contract_gracetime SET setup_date = '$actualDate' WHERE contract_id = {$id} AND type = {$type}";
                }
                break;
            case 3:
                if ($result->num_rows == 0) {
                    // Si no existe la fila, la creamos
                    $sql = "INSERT INTO contract_gracetime (contract_id, grace_time, type, setup_date, extra) VALUES ({$id}, {$days}, {$type}, '$actualDate', '{$data['domain']}')";
                } else {
                    $sql = "UPDATE contract_gracetime SET setup_date = '$actualDate' WHERE contract_id = {$id} AND type = {$type}";
                }
                break;
        }

        //return $sql;

        // Ejecutar la consulta
        if ($con->query($sql)) {
            return true;
        } else {
            return "Error al actualizar: " . $con->error;
        }
    }

    public static function installed($id, $data) {
        include_once __DIR__ . '/../../../../config/connection.php';

        // Agregamos los campos que están definidos en $data
        if (isset($data['domain'])) {
            $type = 1;
            $result = self::installedProcess($id, $data, $type);
        } else if (isset($data['hosting'])) {
            $type = 2;
            $result = self::installedProcess($id, $data, $type);
        } else if (isset($data['marketing'])) {
            $type = 3;
            $result = self::installedProcess($id, $data, $type);
        }

        return $result;
    }

    public static function createFormat($postData)
    {
        include __DIR__ . '/../../../../config/connection.php'; 

        $sql = "INSERT INTO pay_reminder_format (name, html)
                VALUES (?, ?)";

        $curl = curl_init();

        $file_path = $postData['filepath'];
        //var_dump($file_path);
        $cfile = curl_file_create($file_path);
        //var_dump($cfile);
        
        $data = array('inputFile' => $cfile);
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.cloudmersive.com/convert/docx/to/html',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $data,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: multipart/form-data',
            'Apikey: 051d1bce-e433-4259-bd31-875dd8e70051'
          ),
        ));
        
        $response = curl_exec($curl);
        
        if(curl_errno($curl)){
            $errorMessage = 'Curl error: ' . curl_error($curl);
            echo $errorMessage;
        }
        
        curl_close($curl);

        // Expresión regular para encontrar todos los <p> con el atributo align="center"
        $pattern = '/<p\s+([^>]*?)align="center"([^>]*?)>/i';

        // Función de reemplazo para añadir 'text-align: center;' al estilo en línea
        $replacement = function($matches) {
            // Obtener el contenido del atributo style si existe
            $style = '';
            if (preg_match('/style="([^"]*?)"/i', $matches[0], $styleMatch)) {
                // Añadir 'text-align: center;' al final del atributo style existente
                $style = rtrim($styleMatch[1], '; ') . '; text-align: center;';
                // Reemplazar el atributo style con el nuevo valor
                return str_replace($styleMatch[0], 'style="' . $style . '"', $matches[0]);
            } else {
                // Si no existe el atributo style, añadirlo
                return str_replace('<p ', '<p style="text-align: center;" ', $matches[0]);
            }
        };

        // Usar preg_replace_callback para aplicar la función de reemplazo a cada coincidencia
        $modifiedHtml = preg_replace_callback($pattern, $replacement, $response);

        // Mostrar el HTML modificado (puedes guardarlo en la base de datos o usarlo como necesites)
        echo $modifiedHtml;
        
        // Mostrar el HTML modificado
        //echo $modifiedHtml;

        /*
        $postData = EscapeString::escapeArray($con, $postData);
        $stmt = mysqli_prepare($con, $sql);

        if (!$stmt) {
            $errorMessage = "Error al preparar la consulta: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }

        mysqli_stmt_bind_param($stmt, "ss", $postData['name'], $result);

        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            return true;
        } else {
            $errorMessage = "Error al crear el formato: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }*/
    }
    
}