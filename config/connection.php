<?php
$con_host = getenv('DATABASE_HOST');
$con_user = getenv('DATABASE_USER');
$con_pass = getenv('DATABASE_PASSWORD');
$con_db = getenv('DATABASE_NAME');
$con_port = getenv('DATABASE_PORT');
$con_socket = getenv('DATABASE_SOCKET');
$con_charset = getenv('DATABASE_CHARSET');
$con_collation = getenv('DATABASE_COLLATE');
$con_timezone = getenv('DATABASE_TIMEZONE');

$con = mysqli_connect($con_host,$con_user,$con_pass,$con_db);
mysqli_query($con,"SET NAMES '".$con_charset."' COLLATE '".$con_collation."'");
?>