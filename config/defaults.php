<?php

use \GeoIp2\Database\Reader;

$databaseFile = __DIR__ . '/../geoip/geolite2-city.mmdb';
$reader = new Reader($databaseFile);
// Obtener la IP del visitante
// Para testing, puedes usar una IP de ejemplo
$venezuelaIp = '38.196.192.4'; 
$chicagoIp = '162.217.184.65'; 
$ip = $chicagoIp;
$ip = $_SERVER['REMOTE_ADDR'];

$record = $reader->city($ip);
$timezone = $record->location->timeZone;

date_default_timezone_set($timezone);