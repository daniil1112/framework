<?php

use Engine\Core\Request\Request;
use Symfony\Component\VarDumper\VarDumper;


if (!function_exists('dd')) {
    function dd($var)
    {
        foreach (func_get_args() as $var) {
            VarDumper::dump($var);
        }
    exit;
    }
}

function getRequest()
{
    return new Request();
}
?>