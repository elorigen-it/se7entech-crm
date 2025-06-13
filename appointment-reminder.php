<?php
require_once __DIR__ . '/vendor/autoload.php';

use Se7entech\Contractnew\Modules\Appointments\Controllers\AppointmentsController;
use Symfony\Component\HttpFoundation\Session\Session;
$session = new Session();
$session->start();

$ac = new AppointmentsController($session);
$ac->sendReminders();