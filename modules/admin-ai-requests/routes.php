<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'admin_ai_request_list',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\AdminAIRequests\Controllers\AdminAIRequestsController',
                'method' => 'listRequests',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\isAdminMiddleware')
            ),
            'methods' => ['GET']
        )
    ),
    array(
        'name' => 'admin_ai_request_chat_history',
        'route' => array(
            'path' => '/chat-history/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\AdminAIRequests\Controllers\AdminAIRequestsController',
                'method' => 'getChatHistory',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\isAdminMiddleware')
            ),
            'methods' => ['GET']
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
