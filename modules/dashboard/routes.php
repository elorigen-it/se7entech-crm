<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'customerDashboard',
        'route' => array(
            'path' => '/customer',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Dashboard\Controllers\DashboardController', 
                'method'=>'customerDashboard',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),   
);

$routes = array();
foreach($definitions as $d){
    $routeDef = array();
    $params = isset($d['params']) ? $d['params'] : [];
    $route = new Route($d['route']['path'], $d['route']['detail'], $params);
    $route->setMethods($d['route']['methods']);

    $routeDef['name'] = $d['name'];
    $routeDef['route'] = $route;

    array_push($routes, $routeDef);
}