<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController', 
                'method'=>'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'getAllInvoices',
        'route' => array(
            'path' => '/getAllInvoices/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Invoices\Controllers\InvoicesController', 
                'method'=>'getAllInvoices',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST']
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'notifications',
        'route' => array(
            'path' => '/notifications/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController', 
                'method'=>'notifications',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST']
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'associateInvoice',
        'route' => array(
            'path' => '/associateInvoice/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController', 
                'method'=>'associateInvoice',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST']
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getAssociatedInvoices',
        'route' => array(
            'path' => '/getAssociatedInvoices/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController', 
                'method'=>'getAssociatedInvoices',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
            'methods' => ['POST']
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    // array(
    //     'name' => 'getById',
    //     'route' => array(
    //         'path' => '/{id}',
    //         'detail' => array(
    //             'controller' => 'Se7entech\Contractnew\Modules\Appointments\Controllers\AppointmentsController', 
    //             'method'=>'getById',
    //             'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
    //         'methods' => ['GET'],
    //         'params' => array('id' => '[0-9]+') //query parameters requirements
    //     )
    // ),
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
    // array(
    //     'name' => 'delete',
    //     'route' => array(
    //         'path' => '/delete/',
    //         'detail' => array(
    //             'controller' => 'Se7entech\Contractnew\Modules\Appointments\Controllers\AppointmentsController', 
    //             'method'=>'delete',
    //             'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
    //         'methods' => ['POST'],
    //         // 'params' => array('id' => '[0-9]+') //query parameters requirements
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