<?php
use Symfony\Component\Routing\Route;

$definitions = array(
    array(
        'name' => 'reports_index',
        'route' => array(
            'path' => '/',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Reports\Controllers\ReportsController',
                'method' => 'index',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['GET']
        )
    ),
    array(
        'name' => 'reports_generate',
        'route' => array(
            'path' => '/generate',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Reports\Controllers\ReportsController',
                'method' => 'generate',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'reports_ai_polish',
        'route' => array(
            'path' => '/ai-polish',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Reports\Controllers\ReportsController',
                'method' => 'aiPolish',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'reports_download_pdf',
        'route' => array(
            'path' => '/download-pdf',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Reports\Controllers\ReportsController',
                'method' => 'downloadPdf',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST']
        )
    ),
    array(
        'name' => 'reports_send',
        'route' => array(
            'path' => '/send',
            'detail' => array(
                'controller' => 'Se7entech\Contractnew\Modules\Reports\Controllers\ReportsController',
                'method' => 'sendEmail',
                'middlewares' => array('Se7entech\Contractnew\Middlewares\AuthenticationMiddleware')
            ),
            'methods' => ['POST']
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
