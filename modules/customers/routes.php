<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'loginAccess',
        'route' => array(
            'path' => '/login-access',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'loginAccess',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            // 'params' => array('customerId' => '[0-9]+', 'brandContentId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'generateBrandRulesForm',
        'route' => array(
            'path' => '/{customerId}/brand-rules/generate',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'generateBrandRulesForm',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('customerId' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'generateBrandRules',
        'route' => array(
            'path' => '/{customerId}/brand-rules/generate',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'generateBrandRules',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('customerId' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'confirmBrandRules',
        'route' => array(
            'path' => '/{customerId}/brand-rules/confirm',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'confirmBrandRules',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('customerId' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'generateContentForm',
        'route' => array(
            'path' => '/{customerId}/content-creator/generate',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'generateContentForm',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('customerId' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'generateContentPlan',
        'route' => array(
            'path' => '/{customerId}/content-creator/generate',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'generateContentPlan',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('customerId' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'manageBrandRules',
        'route' => array(
            'path' => '/{customerId}/brand-rules/manage',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'manageBrandRules',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('customerId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'viewBrandRule',
        'route' => array(
            'path' => '/{customerId}/brand-rules/view/{brandRuleId}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'viewBrandRule',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('customerId' => '[0-9]+', 'brandRuleId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'editBrandRule',
        'route' => array(
            'path' => '/{customerId}/brand-rules/edit/{brandRuleId}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'editBrandRule',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('customerId' => '[0-9]+', 'brandRuleId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'updateBrandRule',
        'route' => array(
            'path' => '/{customerId}/brand-rules/edit/{brandRuleId}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'updateBrandRule',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('customerId' => '[0-9]+', 'brandRuleId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'deleteBrandRule',
        'route' => array(
            'path' => '/{customerId}/brand-rules/delete/{brandRuleId}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'deleteBrandRule',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('customerId' => '[0-9]+', 'brandRuleId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'index',
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
                'method' => 'postCustomer',
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
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
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
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'updateCustomer',
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
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'delete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            // 'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'manageBrandContent',
        'route' => array(
            'path' => '/{customerId}/brand-content/manage',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'manageBrandContent',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('customerId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'viewBrandContent',
        'route' => array(
            'path' => '/{customerId}/brand-content/view/{brandContentId}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'viewBrandContent',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('customerId' => '[0-9]+', 'brandContentId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'confirmBrandContent',
        'route' => array(
            'path' => '/{customerId}/brand-content/confirm',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'confirmBrandContent',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('customerId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'editBrandContent',
        'route' => array(
            'path' => '/{customerId}/brand-content/edit/{brandContentId}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'editBrandContent',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('customerId' => '[0-9]+', 'brandContentId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'updateBrandContent',
        'route' => array(
            'path' => '/{customerId}/brand-content/edit/{brandContentId}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'updateBrandContent',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('customerId' => '[0-9]+', 'brandContentId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'deleteBrandContent',
        'route' => array(
            'path' => '/{customerId}/brand-content/delete/{brandContentId}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'deleteBrandContent',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('customerId' => '[0-9]+', 'brandContentId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'activateLoginAccess',
        'route' => array(
            'path' => '/login-access/activate',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'activateLoginAccess',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            // 'params' => array('customerId' => '[0-9]+', 'brandContentId' => '[0-9]+')
        )
    ),
    array(
        'name' => 'api_customers_get_all',
        'route' => array(
            'path' => '/api/all',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'apiGetAll',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['GET', 'POST']
        )
    ),
    array(
        'name' => 'api_customers_create',
        'route' => array(
            'path' => '/api/create',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'apiCreate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'api_customers_update',
        'route' => array(
            'path' => '/api/update/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'apiUpdate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'api_customers_delete',
        'route' => array(
            'path' => '/api/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'apiDelete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'deactivateLoginAccess',
        'route' => array(
            'path' => '/login-access/deactivate',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Customers\Controllers\CustomersController',
                'method' => 'deactivateLoginAccess',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            // 'params' => array('customerId' => '[0-9]+', 'brandContentId' => '[0-9]+')
        )
    ),

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
foreach ($definitions as $d) {
    $routeDef = array();
    $params = isset($d['params']) ? $d['params'] : [];
    $route = new Route($d['route']['path'], $d['route']['detail'], $params);
    $route->setMethods($d['route']['methods']);

    $routeDef['name'] = $d['name'];
    $routeDef['route'] = $route;

    array_push($routes, $routeDef);
}