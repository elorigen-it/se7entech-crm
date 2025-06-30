<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tests\Controllers\TestsController', 
                'method'=>'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware',)
            ),
            'methods' => ['GET'],
        )
    ),  
    array(
        'name' => 'tasks',
        'route' => array(
            'path' => '/tasks',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tests\Controllers\TestsController', 
                'method'=>'tasks',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware',)
            ),
            'methods' => ['GET'],
        )
    ),   
    array(
        'name' => 'postbrand',
        'route' => array(
            'path' => '/postbrand',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tests\Controllers\TestsController', 
                'method'=>'postBrand',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware',)
            ),
            'methods' => ['POST'],
        )
    ), 
    array(
        'name' => 'availableModels',
        'route' => array(
            'path' => '/available-models',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tests\Controllers\TestsController', 
                'method'=>'getAvailableModels',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware',)
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