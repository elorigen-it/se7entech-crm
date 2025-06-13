<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../envloader.php';
require __DIR__ . '/../config/config.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

use Se7entech\Contractnew\Middlewares\MiddlewareHandler;

use Symfony\Component\HttpFoundation\Session\Session;

class ModuleLoader{
    private $routes;
    private $context;
    private $middlewareHandler;
    private $sesion;

    public function __construct($_routes){
        $this->routes = new RouteCollection();
        $this->context = new RequestContext();
        $this->middlewareHandler = new MiddlewareHandler();
        $this->session = new Session();
        $this->session->start();
        foreach ($_SESSION as $key => $value) {
            $this->session->set($key, $value);
        }
        
        if($_routes){
            $this->_loadRoutes($_routes);
        }
    }

    private function _loadRoutes($_routes){
        foreach($_routes as $_route){
            $this->routes->add($_route['name'], $_route['route']);
            // $routes->add('get_zones', $get_zones);
            // $routes->add('get_zone_by_id', $get_zone_by_id);
        }
        return $this;
    }

    public function run(){
        try{
            $this->context->fromRequest(Request::createFromGlobals());
            $matcher = new UrlMatcher($this->routes, $this->context);
            $parameters = $matcher->match($this->context->getPathInfo());
            if(class_exists($parameters['controller'])){
                
                if(isset($parameters['middlewares']) && count($parameters['middlewares'])){
                    foreach($parameters['middlewares'] as $middleware){
                        if(class_exists($middleware)){
                            $this->middlewareHandler->addMiddleware(new $middleware());
                        }
                    }
                }
                // Simular una solicitud
                $request = $_REQUEST;
                
                // Manejar la solicitud a través de los middlewares
                $request = $this->middlewareHandler->handleRequest($request);
                
                $_REQUEST = $request;
                
                $controllerInfo = $parameters['controller'];
                $controller = new $controllerInfo($this->session);
                $action = $parameters['method'];
                $controller->$action($parameters);
            } else {
                echo 'Controller class not found: ' . $parameters['controller'];
            } 
            
        } catch (ResourceNotFoundException $e){
            echo 'resource not found';
            echo $e->getMessage();
        } catch ( MethodNotAllowedException $e){
            echo 'Method not allowed';
        }
    }    
}

?>