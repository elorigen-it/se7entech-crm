<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\PayReminder\Controllers\PayReminderController', 
                'method'=>'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'processForm',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\PayReminder\Controllers\PayReminderController', 
                'method'=>'processForm',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['POST'],
        )
    ),
    array(
        'name' => 'installed',
        'route' => array(
            'path' => '/installed/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\PayReminder\Controllers\PayReminderController', 
                'method'=>'installed',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'updateGracetime',
        'route' => array(
            'path' => '/edit/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\PayReminder\Controllers\PayReminderController', 
                'method'=>'updateGracetime',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'sendReminder',
        'route' => array(
            'path' => '/reminder/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\PayReminder\Controllers\PayReminderController', 
                'method'=>'sendReminder',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getUpdateGracetime',
        'route' => array(
            'path' => '/edit/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\PayReminder\Controllers\PayReminderController', 
                'method'=>'getUpdateGracetime',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getSendReminder',
        'route' => array(
            'path' => '/reminder/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\PayReminder\Controllers\PayReminderController', 
                'method'=>'getSendReminder',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
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