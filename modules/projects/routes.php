<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'postProject',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'postProject',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
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
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'updateProject',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'updateProject',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
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
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'delete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'api_projects_get_all',
        'route' => array(
            'path' => '/api/all',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'apiGetAll',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['GET', 'POST']
        )
    ),
    array(
        'name' => 'api_projects_create',
        'route' => array(
            'path' => '/api/create',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'apiCreate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'api_projects_update',
        'route' => array(
            'path' => '/api/update/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'apiUpdate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'api_projects_delete',
        'route' => array(
            'path' => '/api/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'apiDelete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'ajax_get_projects_by_customer_id',
        'route' => array(
            'path' => '/ajax/get_projects_by_customer_id',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Projects\Controllers\ProjectsController',
                'method' => 'ajax_get_projects_by_customer_id',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
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