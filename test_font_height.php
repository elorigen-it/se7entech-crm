<?php
namespace Se7entech\Contractnew;
require_once 'vendor/autoload.php';
require_once 'dompdf/src/Autoloader.php';
\Dompdf\Autoloader::register();

$dompdf = new \Dompdf\Dompdf();
$canvas = $dompdf->getCanvas();

$dejavuPath = $dompdf->getFontMetrics()->getFont("dejavu sans", "normal");
$dejavuBoldPath = $dompdf->getFontMetrics()->getFont("dejavu sans", "bold");
$helveticaPath = $dompdf->getFontMetrics()->getFont("helvetica", "normal");

echo "dejavu sans: " . $dejavuPath . "\n";
echo "dejavu sans height at 11pt: " . $canvas->get_font_height($dejavuPath, 11) . "\n";
echo "dejavu sans bold height at 11pt: " . $canvas->get_font_height($dejavuBoldPath, 11) . "\n";
echo "helvetica height at 11pt: " . $canvas->get_font_height($helveticaPath, 11) . "\n";
