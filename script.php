<?php/*

function convertirTextoATiempoEnDias($texto) {
    // Convertimos el texto a minúsculas para facilitar la comparación
    $texto = strtolower($texto);
    
    if(str_contains($texto, 'unlimited')) {
        return -1;
    }
    
    if($texto == '' || str_contains($texto, 'N/A')) {
        return 0;
    }
        
    // Definimos un array asociativo para mapear las unidades de tiempo a sus valores en días
    $unidades_tiempo = [
        'día' => 1,
        'días' => 1,
        'dia' => 1,
        'dias' => 1,
        'd' => 1,
        'semana' => 7,
        'semanas' => 7,
        'mes' => 30,
        'meses' => 30,
        'month' => 30,
        'months' => 30,
        'año' => 365,
        'años' => 365,
        'year' => 365,
        'years' => 365,
    ];
    
    // Construimos el patrón dinámicamente
    $patron = '/(\d+)\s*(' . implode('|', array_keys($unidades_tiempo)) . ')/';
    
    // Inicializamos el total de días en 0
    $total_dias = 0;
    
    // Buscamos coincidencias en el texto
    preg_match_all($patron, $texto, $matches, PREG_SET_ORDER);
    
    // Iteramos sobre las coincidencias
    foreach ($matches as $match) {
        // Obtenemos la cantidad y la unidad de tiempo
        $cantidad = intval($match[1]);
        $unidad = $match[2];
        
        // Sumamos al total de días la cantidad multiplicada por el valor en días de la unidad
        if (array_key_exists($unidad, $unidades_tiempo)) {
            $total_dias += $cantidad * $unidades_tiempo[$unidad];
        }
    }
    
    return $total_dias;
}

$servername = "localhost";
$username = "se7entechnet_kundan";
$password = "Kundan@7542";
$dbname = "se7entechnet_contractnew";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para seleccionar id y maintenance_period de la tabla contract
$sql = "SELECT id, maintenance_period FROM contract";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Iterar sobre cada fila del resultado
    while($row = $result->fetch_assoc()) {
        // Obtener los valores de la fila
        $contract_id = $row["id"];
        $maintenance_period = $row["maintenance_period"];
        
        // Convertir el periodo de mantenimiento a días
        $grace_time = convertirTextoATiempoEnDias($maintenance_period);
        
        // Insertar el nuevo valor en la tabla contract_gracetime
        $insert_sql = "INSERT INTO contract_gracetime (contract_id, grace_time) VALUES ('$contract_id', '$grace_time')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "Nuevo registro insertado correctamente.\n";
        } else {
            echo "Error al insertar registro: " . $conn->error . "\n";
        }
    }
} else {
    echo "No se encontraron resultados.";
}

// Cerrar conexión
$conn->close();*/
