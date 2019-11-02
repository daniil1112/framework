<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 02.10.2019
 * Time: 21:49
 */

namespace Engine\DI;


class DI
{
    /**
     * @var array
     */
    private $container = [];

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key,$value)
    {
        $this->container[$key] = $value;


        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->container[$key];
    }

    /**
     * @param $key
     * @return bool
     */

    public function has($key)
    {
        return isset($this->container[$key]);
    }
}