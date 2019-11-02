<?php
namespace Engine;



use Engine\Core\Router\DispatchedRoute;
use Engine\Helper\Common;


class Cms
{
    /**
     * @var
     */
    private $di;

    public $router;

    /**
     * Сms constructor.
     * @param $di
     */
    public function __construct($di)
    {
        $this->di=$di;
        $this->router = $this->di->get('router');

    }

    public function run()
    {
        try {
            require_once __DIR__.'/../../app/Routes.php';
            $routerDispatch = $this->router->dispatch(Common::getMethod(), Common::getPathUrl());


            $routerDispatch = $this->router->validDispatcher($routerDispatch);


            list($class, $action) = explode(':', $routerDispatch->getController(), 2);

            $controller = '\\App\\http\\controllers\\' . $class;
            $parameters = $routerDispatch->getParameters();

            call_user_func_array([new $controller($this->di), $action], $parameters);


        } catch (\Exception  $e)
        {
            echo $e->getMessage().'<br>'.'В файле '.$e->getFile().'<br>'. 'В строке '. $e->getLine();
            exit;
        }

    }
}