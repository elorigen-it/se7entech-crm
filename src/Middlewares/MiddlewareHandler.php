<?php
namespace Se7entech\Contractnew\Middlewares;

class MiddlewareHandler {
    private $middlewares = [];

    public function addMiddleware($middleware) {
        $this->middlewares[] = $middleware;
    }

    public function handleRequest($request) {
        foreach ($this->middlewares as $middleware) {
            $request = $middleware->handle($request);
        }

        return $request;
    }
}