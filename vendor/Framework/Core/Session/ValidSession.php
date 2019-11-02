<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 16.10.2019
 * Time: 17:54
 */

namespace Engine\Core\Session;


use Engine\Config\ConfigParse;
use Engine\Core\AbstractCore;

class ValidSession extends AbstractCore
{


    public function __construct()
    {
        parent::__construct();
    }

    protected function  Validation($ses = [])
    {
        foreach ($ses as $key=>$value)
        {

            if (!($this -> preValidKey($key)))
            {
                unset ($ses[$key]);
            }
        }
        return $ses;
    }

    private function preValidKey($key)
    {
        return $this->validLength($key, $this->config['max_key_session'])&& (!($this->validInt($key))) ;
    }

    private function validLength($name,$max)
    {
        return (strlen($name) <= $max);
    }

    private function validInt($name)
    {
        return is_integer($name);
    }
}