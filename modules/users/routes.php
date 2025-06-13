<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Users\Controllers\UserController', 
                'method'=>'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\isAdminMiddleware')),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'postUser',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Users\Controllers\UserController', 
                'method'=>'postUser',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\isAdminMiddleware')),
            'methods' => ['POST'],
        )
    ),
    array(
        'name' => 'getById',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Users\Controllers\UserController', 
                'method'=>'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\isAdminMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'update',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Users\Controllers\UserController', 
                'method'=>'updateUser',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\isAdminMiddleware')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'taxes',
        'route' => array(
            'path' => '/taxes/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Users\Controllers\UserController', 
                'method'=>'taxes',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
        ),
    ),
    array(
        'name' => 'updateDownloadTax',
        'route' => array(
            'path' => '/update-download/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Users\Controllers\UserController', 
                'method'=>'updateDownloadTax',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'updateDownloadContract',
        'route' => array(
            'path' => '/update-download-contract/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Users\Controllers\UserController', 
                'method'=>'updateDownloadContract',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'delete',
        'route' => array(
            'path' => '/delete/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Users\Controllers\UserController', 
                'method'=>'delete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm', 'Se7entech\Contractnew\Middlewares\isAdminMiddleware')),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    )
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
