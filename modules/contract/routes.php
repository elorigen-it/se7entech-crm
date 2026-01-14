<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController',
                'method' => 'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'postContract',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController',
                'method' => 'postContract',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['POST']
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getAllContracts',
        'route' => array(
            'path' => '/getAllContracts/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController',
                'method' => 'getAllContracts',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['POST']
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getAllInvoices',
        'route' => array(
            'path' => '/getAllInvoices/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController',
                'method' => 'getAllInvoices',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
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
                'method' => 'notifications',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
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
                'method' => 'associateInvoice',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
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
                'method' => 'getAssociatedInvoices',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['POST']
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getById',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController',
                'method' => 'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'printContract',
        'route' => array(
            'path' => '/printContract/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController',
                'method' => 'printContract',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'update',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController',
                'method' => 'updateContract',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
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
                'controller' => 'Se7entech\Contractnew\Modules\Contract\Controllers\ContractController',
                'method' => 'delete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')
            ),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),

    // API Routes
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

    // API Routes
    array(
        'name' => 'api_contracts_get_all',
        'route' => array(
            'path' => '/api/all',
            'detail' => array(
                'controller' => 'Se7entech\\Contractnew\\Modules\\Contract\\Controllers\\ContractController',
                'method' => 'apiGetAll',
                'middlewares' => array('Se7entech\\Contractnew\\Middlewares\\JWTMiddleware')
            ),
            'methods' => ['GET']
        )
    ),
    array(
        'name' => 'api_contracts_create',
        'route' => array(
            'path' => '/api/create',
            'detail' => array(
                'controller' => 'Se7entech\\Contractnew\\Modules\\Contract\\Controllers\\ContractController',
                'method' => 'apiCreate',
                'middlewares' => array('Se7entech\\Contractnew\\Middlewares\\JWTMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'api_contracts_update',
        'route' => array(
            'path' => '/api/update/{id}',
            'detail' => array(
                'controller' => 'Se7entech\\Contractnew\\Modules\\Contract\\Controllers\\ContractController',
                'method' => 'apiUpdate',
                'middlewares' => array('Se7entech\\Contractnew\\Middlewares\\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'api_contracts_delete',
        'route' => array(
            'path' => '/api/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\\Contractnew\\Modules\\Contract\\Controllers\\ContractController',
                'method' => 'apiDelete',
                'middlewares' => array('Se7entech\\Contractnew\\Middlewares\\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'api_contracts_attach_invoices',
        'route' => array(
            'path' => '/api/attach-invoices',
            'detail' => array(
                'controller' => 'Se7entech\\Contractnew\\Modules\\Contract\\Controllers\\ContractController',
                'method' => 'apiAttachInvoices',
                'middlewares' => array('Se7entech\\Contractnew\\Middlewares\\JWTMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'api_contracts_get_invoices',
        'route' => array(
            'path' => '/api/invoices/{contract_id}',
            'detail' => array(
                'controller' => 'Se7entech\\Contractnew\\Modules\\Contract\\Controllers\\ContractController',
                'method' => 'apiGetInvoices',
                'middlewares' => array('Se7entech\\Contractnew\\Middlewares\\JWTMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('contract_id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'api_contracts_send_notification',
        'route' => array(
            'path' => '/api/send-notification',
            'detail' => array(
                'controller' => 'Se7entech\\Contractnew\\Modules\\Contract\\Controllers\\ContractController',
                'method' => 'apiSendNotification',
                'middlewares' => array('Se7entech\\Contractnew\\Middlewares\\JWTMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'api_contracts_signature_links',
        'route' => array(
            'path' => '/api/signature-links/{contract_id}',
            'detail' => array(
                'controller' => 'Se7entech\\Contractnew\\Modules\\Contract\\Controllers\\ContractController',
                'method' => 'apiGetSignatureLinks',
                'middlewares' => array('Se7entech\\Contractnew\\Middlewares\\JWTMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('contract_id' => '[0-9]+')
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