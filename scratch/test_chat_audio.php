<?php
require_once 'C:\Users\PC\Documents\se7entech-crm\vendor\autoload.php';
require_once 'C:\Users\PC\Documents\se7entech-crm\envloader.php';
require_once 'C:\Users\PC\Documents\se7entech-crm\src\Modules\CustomerPortal\Controllers\CustomerPortalController.php';

use Symfony\Component\HttpFoundation\Session\Session;
use Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController;

$session = new Session();
$session->start();
$session->set('customer_id', 347);

// Create a dummy WebM file
$dummyWebm = tempnam(sys_get_temp_dir(), 'test_audio') . '.webm';
file_put_contents($dummyWebm, "RIFF....WAVEfmt "); // Simple header to resemble audio bytes

$_FILES['audio'] = [
    'name' => 'test_audio.webm',
    'type' => 'audio/webm',
    'tmp_name' => $dummyWebm,
    'error' => UPLOAD_ERR_OK,
    'size' => strlen("RIFF....WAVEfmt ")
];

$_POST['message'] = "Comentario de prueba con audio";

$controller = new CustomerPortalController($session);
try {
    echo "Running chatSession with audio...\n";
    $controller->chatSession(['id' => 1]);
} catch (Exception $e) {
    echo "Caught Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
} finally {
    if (file_exists($dummyWebm)) {
        unlink($dummyWebm);
    }
}
