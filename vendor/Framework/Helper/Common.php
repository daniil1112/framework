<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 06.10.2019
 * Time: 14:57
 */

namespace Engine\Helper;


class Common
{

    public function isPost()
    {
        if ($this->getMethod() == 'POST')
        {
            return true;
        }

        return false;
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return bool|string
     */
    public function getPathUrl()
    {
        $pathUri = $_SERVER ['REQUEST_URI'];

        if ($position = strpos($pathUri, '?'))
        {
            $pathUri = substr($pathUri, 0, $position);
        }

        return $pathUri;
    }
}