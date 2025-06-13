<?php     
    if (getenv('ENVIRONMENT') == 'production') {
        error_reporting(0);
        ini_set('display_errors', 0);
    } else if (getenv('ENVIRONMENT') == 'development') {
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        ini_set('display_errors', 1);
    } else if (getenv('ENVIRONMENT') == 'testing') {
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        ini_set('display_errors', 1);
    } else {
        error_reporting(E_ALL);
        //someting
    }
    $base_url = getenv('BASE_URL');
    $process_url = getenv('PROCESS_URL');
    $base_path = $_SERVER ['DOCUMENT_ROOT']; //$_SERVER ['DOCUMENT_ROOT'] -> for dev
    $smtp_host = getenv('SMTP_HOST');
    $smtp_default_username = getenv('SMTP_DEFAULT_USERNAME');
    $smtp_default_password = getenv('SMTP_DEFAULT_PASSWORD');
?>