<?php
namespace Se7entech\Contractnew;
require_once 'vendor/autoload.php';
require_once 'dompdf/src/Autoloader.php';
\Dompdf\Autoloader::register();

$customerId = 197;
$startDate = '2025-01-01';
$endDate = '2026-06-30';
$executiveSummary = 'iniciativas.';

include 'config/connection.php';
$customer = Modules\Customers\Models\CustomersModel::getById($customerId);
$reportData = Modules\Reports\Models\ReportsModel::getTasksAndProjectsForReport($customerId, $startDate, $endDate);

ob_start();
include 'src/Modules/Reports/pdf_template.php';
$html = ob_get_clean();

$dompdf = new \Dompdf\Dompdf();
$dompdf->loadHtml($html);

// Use Reflection to call private processHtml() method
$reflector = new \ReflectionClass($dompdf);
$method = $reflector->getMethod('processHtml');
$method->setAccessible(true);
$method->invoke($dompdf);

// Apply styles
$cssProperty = $reflector->getProperty('css');
$cssProperty->setAccessible(true);
$css = $cssProperty->getValue($dompdf);

$treeProperty = $reflector->getProperty('tree');
$treeProperty->setAccessible(true);
$tree = $treeProperty->getValue($dompdf);

$css->apply_styles($tree);

$root = $tree->get_root();

function print_frame_details($frame, $depth = 0) {
    $node = $frame->get_node();
    $tagName = $node ? $node->nodeName : '#text';
    
    if ($tagName !== '#comment') {
        $style = $frame->get_style();
        $cb = $frame->get_containing_block();
        $pos = $frame->get_position();
        $margin_h = $frame->get_margin_height();
        
        $details = sprintf(
            "<%s> POS:(%.1f, %.1f) CB:(%.1f, %.1f) SIZE:(%s, %s) MARGIN-H:%.1f line-height:%s",
            $tagName,
            $pos['x'] ?? 0, $pos['y'] ?? 0,
            $cb['w'] ?? 0, $cb['h'] ?? 0,
            is_numeric($style->width) ? sprintf("%.1f", $style->width) : (string)$style->width,
            is_numeric($style->height) ? sprintf("%.1f", $style->height) : (string)$style->height,
            $margin_h,
            $style->line_height
        );
        echo str_repeat("  ", $depth) . $details . "\n";
    }
    
    $child = $frame->get_first_child();
    while ($child) {
        print_frame_details($child, $depth + 1);
        $child = $child->get_next_sibling();
    }
}

echo "--- Frame Tree Geometry (Before Render) ---\n";
print_frame_details($root);
