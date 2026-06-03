<?php
namespace Se7entech\Contractnew;
require_once 'vendor/autoload.php';
require_once 'dompdf/src/Autoloader.php';
\Dompdf\Autoloader::register();

$customerId = 197;
$startDate = '2025-01-01';
$endDate = '2026-06-30';
$executiveSummary = 'iniciativas que contribuyeron a la mejora de la eficiencia operativa y la calidad del servicio. Los proyectos ejecutados reflejan un compromiso constante con la excelencia, proporcionando resultados tangibles.';
$professionalTasks = [
    334 => 'ELABORACIÓN DE (3) CARRUSELES - Versión profesional pulida por la IA'
];

include 'config/connection.php';
$customer = Modules\Customers\Models\CustomersModel::getById($customerId);
$reportData = Modules\Reports\Models\ReportsModel::getTasksAndProjectsForReport($customerId, $startDate, $endDate);

ob_start();
include 'src/Modules/Reports/pdf_template.php';
$html = ob_get_clean();

$dompdf = new \Dompdf\Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

global $_dompdf_warnings;
echo "--- DOMPDF WARNINGS ---\n";
print_r($_dompdf_warnings);

echo "\n--- CPDF MESSAGES ---\n";
if (method_exists($dompdf->getCanvas(), 'get_cpdf')) {
    $cpdf = $dompdf->getCanvas()->get_cpdf();
    if ($cpdf && isset($cpdf->messages)) {
        echo $cpdf->messages . "\n";
    } else {
        echo "No messages or CPDF not used.\n";
    }
} else {
    echo "get_cpdf method does not exist.\n";
}
