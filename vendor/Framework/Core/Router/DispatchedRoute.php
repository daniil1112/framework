<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 05.10.2019
 * Time: 20:36
 */

namespace Engine\Core\Router;


class DispatchedRoute
{

    private $controller;
    private $parameters;

    /**
     * DispatchedRoute constructor.
     * @param $controller
     * @param array $parameters
     */
    public function __construct($controller, $parameters =[])
    {
        $this->controller = $controller;
        $this->parameters = $parameters;

    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}