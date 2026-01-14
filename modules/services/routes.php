<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\hasServicePermission')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'postService',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'postService',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\hasServicePermission')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getById',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\hasServicePermission')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'updateService',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'updateService',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\hasServicePermission')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'delete',
        'route' => array(
            'path' => '/delete/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'delete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\hasServicePermission')
            ),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    // API Routes
    array(
        'name' => 'api_services_get_all',
        'route' => array(
            'path' => '/api/all',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'apiGetAll',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['GET']
        )
    ),
    array(
        'name' => 'api_services_create',
        'route' => array(
            'path' => '/api/create',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'apiCreate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'api_services_update',
        'route' => array(
            'path' => '/api/update/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'apiUpdate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'api_services_delete',
        'route' => array(
            'path' => '/api/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Services\Controllers\ServicesController',
                'method' => 'apiDelete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    )
);

$routes = array();
foreach ($definitions as $d) {
    $routeDef = array();
    $params = isset($d['params']) ? $d['params'] : [];
    $route = new Route($d['route']['path'], $d['route']['detail'], $params);
    $route->setMethods($d['route']['methods']);

    $routeDef['name'] = $d['name'];
    $routeDef['route'] = $route;

    array_push($routes, $routeDef);
}