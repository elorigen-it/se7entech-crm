<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController', 
                'method'=>'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'postCustomer',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController', 
                'method'=>'postCustomer',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST']
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getById',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController', 
                'method'=>'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'update',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController', 
                'method'=>'updateCustomer',
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
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController', 
                'method'=>'delete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    )

    // array(
    //     'name' => 'acceptAppointment',
    //     'route' => array(
    //         'path' => '/accept/{id}',
    //         'detail' => array(
    //             'controller' => 'Se7entech\Contractnew\Modules\Appointments\Controllers\AppointmentsController', 
    //             'method'=>'acceptAppointment',
    //             'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
    //         'methods' => ['GET'],
    //         'params' => array('id' => '[0-9]+') //query parameters requirements
    //     )
    // ),
    // array(
    //     'name' => 'rejectAppointment',
    //     'route' => array(
    //         'path' => '/reject/{id}',
    //         'detail' => array(
    //             'controller' => 'Se7entech\Contractnew\Modules\Appointments\Controllers\AppointmentsController', 
    //             'method'=>'rejectAppointment',
    //             'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
    //         'methods' => ['GET'],
    //         'params' => array('id' => '[0-9]+') //query parameters requirements
    //     )
    // ),
    // array(
    //     'name' => 'sendReminders',
    //     'route' => array(
    //         'path' => '/send-reminders/',
    //         'detail' => array(
    //             'controller' => 'Se7entech\Contractnew\Modules\Appointments\Controllers\AppointmentsController', 
    //             'method'=>'sendReminders',
    //             'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
    //         'methods' => ['GET'],
    //     )
    // ),
    // array(
    //     'name' => 'updateAppointment',
    //     'route' => array(
    //         'path' => '/{id}',
    //         'detail' => array(
    //             'controller' => 'Se7entech\Contractnew\Modules\Appointments\Controllers\AppointmentsController', 
    //             'method'=>'updateAppointment',
    //             'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
    //         'methods' => ['POST'],
    //         'params' => array('id' => '[0-9]+') //query parameters requirements
    //     )
    // ),
   
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