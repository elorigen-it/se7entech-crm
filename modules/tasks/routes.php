<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'postTask',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'postTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    // Task Labels CRUD routes
    array(
        'name' => 'listTaskLabels',
        'route' => array(
            'path' => '/labels',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'createTaskLabel',
        'route' => array(
            'path' => '/labels',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'postLabel',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
        )
    ),
    array(
        'name' => 'getTaskLabel',
        'route' => array(
            'path' => '/labels/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'updateTaskLabel',
        'route' => array(
            'path' => '/labels/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'updateLabel',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'deleteTaskLabel',
        'route' => array(
            'path' => '/labels/{id}/delete',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'deleteLabel',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'viewById',
        'route' => array(
            'path' => '/{id}/view',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'viewById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'getById',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'pause',
        'route' => array(
            'path' => '/{id}/pause/{reason}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'puseTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+', 'reason' => '[a-zA-Z0-9\s\-\_\.\,\!\@\#\$\%\^\&\*\(\)\+\=\?\:\;\'\"]+') //query parameters requirements //query parameters requirements
        )
    ),
    array(
        'name' => 'resume',
        'route' => array(
            'path' => '/{id}/resume',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'resumeTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'start',
        'route' => array(
            'path' => '/{id}/start',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'startTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'finish',
        'route' => array(
            'path' => '/{id}/finish',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'finishTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'reopen',
        'route' => array(
            'path' => '/{id}/reopen',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'reopenTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'delete',
        'route' => array(
            'path' => '/delete/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'deleteTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'updateTask',
        'route' => array(
            'path' => '/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController', 
                'method'=>'updateTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    
    // array(
    //     'name' => 'delete',
    //     'route' => array(
    //         'path' => '/delete/',
    //         'detail' => array(
    //             'controller' => 'Se7entech\Contractnew\Modules\Roles\Controllers\RolesController', 
    //             'method'=>'delete',
    //             'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware', 'Se7entech\Contractnew\Middlewares\hasFilledRequirementForm')),
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