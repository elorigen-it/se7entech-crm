<?php
namespace Se7entech\Contractnew;
require_once 'vendor/autoload.php';
require_once 'dompdf/src/Autoloader.php';
\Dompdf\Autoloader::register();

$dompdf = new \Dompdf\Dompdf();
$rootDir = $dompdf->getOptions()->getRootDir();
$fontDir = $dompdf->getOptions()->getFontDir();
echo "RootDir: " . $rootDir . "\n";
echo "FontDir: " . $fontDir . "\n";

$fontMetrics = $dompdf->getFontMetrics();
$dejavuNormal = $fontMetrics->getFont("dejavu sans", "normal");
echo "DejaVu Sans normal path: " . $dejavuNormal . "\n";
echo "Is file readable: " . (is_readable($dejavuNormal) ? "YES" : "NO") . "\n";
echo "UFM readable: " . (is_readable($dejavuNormal . ".ufm") ? "YES" : "NO") . "\n";
