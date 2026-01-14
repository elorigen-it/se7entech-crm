<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'invoices_index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
                'method' => 'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET']
        )
    ),
    array(
        'name' => 'invoices_create',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
                'method' => 'create',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'invoices_edit',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
                'method' => 'edit',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'invoices_update',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
                'method' => 'update',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'invoices_delete',
        'route' => array(
            'path' => '/delete/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
                'method' => 'delete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'api_invoices_get_all',
        'route' => array(
            'path' => '/api/all',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
                'method' => 'apiGetAll',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['GET', 'POST']
        )
    ),
    array(
        'name' => 'api_invoices_create',
        'route' => array(
            'path' => '/api/create',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
                'method' => 'apiCreate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'api_invoices_update',
        'route' => array(
            'path' => '/api/update/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
                'method' => 'apiUpdate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'api_invoices_delete',
        'route' => array(
            'path' => '/api/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController',
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