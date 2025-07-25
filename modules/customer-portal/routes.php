<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'contracts',
        'route' => array(
            'path' => '/contracts',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController', 
                'method'=>'contracts',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),  
    array(
        'name' => 'invoices',
        'route' => array(
            'path' => '/invoices',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController', 
                'method'=>'invoices',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),  
    array(
        'name' => 'tasks',
        'route' => array(
            'path' => '/tasks',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController', 
                'method'=>'tasks',
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