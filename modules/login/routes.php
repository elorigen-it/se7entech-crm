<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Login\Controllers\LoginController', 
                'method'=>'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'indexCustomer',
        'route' => array(
            'path' => '/customer',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Login\Controllers\LoginController', 
                'method'=> 'indexCustomer',
                'middlewares' => array()
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'loginCustomer',
        'route' => array(
            'path' => '/customer',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Login\Controllers\LoginController', 
                'method'=> 'loginCustomer',
                'middlewares' => array()
            ),
            'methods' => ['POST'],
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