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
    array(
        'name' => 'ai_request_list',
        'route' => array(
            'path' => '/ai-request',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController',
                'method' => 'aiRequest',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['GET']
        )
    ),
    array(
        'name' => 'ai_request_new',
        'route' => array(
            'path' => '/ai-request/new',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController',
                'method' => 'newRequest',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['GET']
        )
    ),
    array(
        'name' => 'ai_request_chat_interface',
        'route' => array(
            'path' => '/ai-request/chat/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController',
                'method' => 'chatInterface',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['GET']
        ),
        'params' => array('id' => '[0-9]+')
    ),
    array(
        'name' => 'ai_request_chat_session',
        'route' => array(
            'path' => '/ai-request/chat/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController',
                'method' => 'chatSession',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['POST']
        ),
        'params' => array('id' => '[0-9]+')
    ),
    array(
        'name' => 'ai_request_confirm',
        'route' => array(
            'path' => '/ai-request/confirm/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController',
                'method' => 'confirmAndSend',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['POST']
        ),
        'params' => array('id' => '[0-9]+')
    ),
    array(
        'name' => 'ai_request_delete',
        'route' => array(
            'path' => '/ai-request/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\CustomerPortal\Controllers\CustomerPortalController',
                'method' => 'deleteRequest',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\CustomerAuthenticationMiddleware')
            ),
            'methods' => ['POST']
        ),
        'params' => array('id' => '[0-9]+')
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