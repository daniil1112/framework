<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 05.10.2019
 * Time: 18:29
 */

namespace Engine\Core\Router;

use Engine\Helper\Common;
use Engine\Core\Router\UrlDispatcher;
use Engine\Core\Router\DispatchedRoute;


class Router
{
    private $routes = [];
    private $host;
    private $dispatcher;

    public function __construct($host)
    {
        $this->host = $host;
    }

    /**
     * @param $key
     * @param $pattern
     * @param $controller
     * @param string $method
     */
    public function add($key, $pattern, $controller, $method = 'GET')
    {
        $this->routes[$key] = [
            'pattern' => PREFIX.$pattern,
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function dispatch($method,$uri)
    {
        if (($uri[strlen($uri)-1] == '/')&&(strlen($uri)>1))
        {
            $uri = substr($uri,0,-1);
        };
        return $this->getDispatcher()->dispatch($method,$uri);
    }

    public function getDispatcher()
    {
        if($this->dispatcher == null)
        {
            $this->dispatcher = new UrlDispatcher();

            foreach ($this->routes as $route)
            {
                $this->dispatcher->register($route['method'], $route['pattern'], $route['controller']);
            }
        }
        return $this->dispatcher;
    }

    public function validDispatcher($routerDispatch)
    {
        if ($routerDispatch == null) {
            if (Common::getMethod() == 'GET')
            {
                $routerDispatch = $this->dispatch('POST', Common::getPathUrl());
                if ($routerDispatch != null)
                {
                    $routerDispatch = new DispatchedRoute('ErrorController:errorMethod');

                }else {
                    $routerDispatch = new DispatchedRoute('ErrorController:page404');
                }
            }
        }
        return $routerDispatch;

    }
}