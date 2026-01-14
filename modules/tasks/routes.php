<?php
use Symfony\Component\Routing\Route;

$definitions = array(
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
    // Task Categories CRUD routes
    array(
        'name' => 'listTaskCategories',
        'route' => array(
            'path' => '/categories',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'createTaskCategory',
        'route' => array(
            'path' => '/categories',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'postCategory',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
        )
    ),
    array(
        'name' => 'getTaskCategory',
        'route' => array(
            'path' => '/categories/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'updateTaskCategory',
        'route' => array(
            'path' => '/categories/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'updateCategory',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'deleteTaskCategory',
        'route' => array(
            'path' => '/categories/{id}/delete',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'deleteCategory',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'adminDashboard',
        'route' => array(
            'path' => '/admin-dashboard',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'adminDashboard',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'getAdminDashboardData',
        'route' => array(
            'path' => '/api/admin-dashboard-data',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'getAdminDashboardData',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'postTask',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'postTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'viewById',
        'route' => array(
            'path' => '/{id}/view',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'viewById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
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
                'method' => 'getById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
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
                'method' => 'puseTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
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
                'method' => 'resumeTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
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
                'method' => 'startTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'finish',
        'route' => array(
            'path' => '/{id}/finish/{resource}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'finishTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+', 'resource' => '[a-zA-Z0-9\s\-\_\.\,\!\@\#\$\%\^\&\*\(\)\+\=\?\:\;\'\"]+') //query parameters requirements
        )
    ),
    array(
        'name' => 'reopen',
        'route' => array(
            'path' => '/{id}/reopen',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'reopenTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
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
                'method' => 'deleteTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
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
                'method' => 'updateTask',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+') //query parameters requirements
        )
    ),

    // API Routes (Protected by JWT)
    array(
        'name' => 'apiGetAllTasks',
        'route' => array(
            'path' => '/api/all',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiGetAll',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'apiGetTaskById',
        'route' => array(
            'path' => '/api/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiGetById',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['GET'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'apiCreateTask',
        'route' => array(
            'path' => '/api/create',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiCreate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
        )
    ),
    array(
        'name' => 'apiUpdateTask',
        'route' => array(
            'path' => '/api/update/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiUpdate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'apiDeleteTask',
        'route' => array(
            'path' => '/api/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiDelete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    // Task State Management
    array(
        'name' => 'apiStartTask',
        'route' => array(
            'path' => '/api/start/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiStart',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'apiPauseTask',
        'route' => array(
            'path' => '/api/pause/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiPause',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'apiResumeTask',
        'route' => array(
            'path' => '/api/resume/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiResume',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'apiFinishTask',
        'route' => array(
            'path' => '/api/finish/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiFinish',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'apiReopenTask',
        'route' => array(
            'path' => '/api/reopen/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskController',
                'method' => 'apiReopen',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    // API Labels
    array(
        'name' => 'apiListLabels',
        'route' => array(
            'path' => '/api/labels',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'apiIndex',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'apiCreateLabel',
        'route' => array(
            'path' => '/api/labels/create',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'apiCreate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
        )
    ),
    array(
        'name' => 'apiUpdateLabel',
        'route' => array(
            'path' => '/api/labels/update/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'apiUpdate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'apiDeleteLabel',
        'route' => array(
            'path' => '/api/labels/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskLabelController',
                'method' => 'apiDelete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    // API Categories
    array(
        'name' => 'apiListCategories',
        'route' => array(
            'path' => '/api/categories',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'apiIndex',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['GET'],
        )
    ),
    array(
        'name' => 'apiCreateCategory',
        'route' => array(
            'path' => '/api/categories/create',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'apiCreate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
        )
    ),
    array(
        'name' => 'apiUpdateCategory',
        'route' => array(
            'path' => '/api/categories/update/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'apiUpdate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
    array(
        'name' => 'apiDeleteCategory',
        'route' => array(
            'path' => '/api/categories/delete/{id}',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Tasks\Controllers\TaskCategoryController',
                'method' => 'apiDelete',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\JWTMiddleware')
            ),
            'methods' => ['POST'],
            'params' => array('id' => '[0-9]+')
        )
    ),
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