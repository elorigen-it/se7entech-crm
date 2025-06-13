<?php
session_start();
require('./vendor/autoload.php');
require_once './config/config.php';
require_once './config/connection.php';
require_once './access.php';

use Se7entech\Contractnew\Helpers\Mailer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $budget = $_POST['budget'];
    $currency = $_POST['currency'];

    if(!empty($id) && !empty($budget) && !empty($currency)) {
        $to = "admin@se7entech.net";
        $toName = "Admin Se7entech";
        $subject = "Nuevo formulario rellenado en Get-Started";
    
        $from = "no-reply@se7entech.net";
        $fromName = 'Se7entech LLC';

        $content = "
        <html>
            <head>
                <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    text-align: center;
                    color: #333;
                }
                p {
                    text-align: center;
                    color: #777;
                }
                .url {
                    text-align: center;
                    margin-top: 20px;
                    font-size: 18px;
                    color: #333;
                }
                </style>
            </head>
            <body>
                <div class='container'>
                <h1>Se ha rellenado un nuevo formulario en Get-Started</h1>
                <p>La URL donde se ha guardado el formulario es en:</p>
                <p class='url'>https://se7entech.net/shared-data?id=$id</p>
                <p>El budget es de:</p>
                <p class='url'>$budget $currency</p>
                </div>
            </body>
        </html>";
    
        $mailer = new Mailer($from, $fromName, $to, $toName, $subject, $content, false, $from, 'jvkD1ka?1');
        $result = $mailer->send();
    }

    $logContent = '';
    $logContent .= "Result: " . ($result) . ", ";
    foreach ($_POST as $key => $value) {
        $logContent .= "$key: $value, ";
    }
    $logContent = rtrim($logContent, ', ');

    $logFile = 'log.txt';

    file_put_contents($logFile, $logContent . PHP_EOL, FILE_APPEND | LOCK_EX);
}



?>