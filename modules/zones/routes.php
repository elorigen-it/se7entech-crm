<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Zones\Controllers\ZonesController', 
                'method'=>'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'postZone',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Zones\Controllers\ZonesController', 
                'method'=>'postZone',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST'],
        )
    ),
    array(
        'name' => 'getById',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Zones\Controllers\ZonesController', 
                'method'=>'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'update',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Zones\Controllers\ZonesController', 
                'method'=>'updateZone',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'deleteZone',
        'route' => array(
            'path' => '/delete/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Zones\Controllers\ZonesController', 
                'method'=>'delete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    // array(
    //     'name' => 'addNew',
    //     'route' => array(
    //         'path' => '/{id}',
    //         'detail' => array('controller' => 'Se7entech\Contractnew\Modules\Zones\Controllers\ZonesController', 'method'=>'getById'),
    //         'methods' => ['GET'],
    //         'requirements' => array('id' => '[0-9]+')
    //     )
    // )

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
