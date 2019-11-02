<?php
namespace App\http\controllers;


use Engine\Abstraction\AbstractErrorController;

class ErrorController extends AbstractErrorController
{
    public function NotAdmin()
    {
        echo "Вы не имеете права для просмотра этой страницы";
        exit;
    }
}

