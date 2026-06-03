<?php
namespace Se7entech\Contractnew;
require_once 'vendor/autoload.php';
require_once 'dompdf/src/Autoloader.php';
\Dompdf\Autoloader::register();
require_once 'envloader.php';

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

file_put_contents('test_html_rendered.html', $html);

$dompdf = new \Dompdf\Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$pdfOutput = $dompdf->output();
file_put_contents('test_report.pdf', $pdfOutput);
echo "Final test PDF generated successfully!\n";
