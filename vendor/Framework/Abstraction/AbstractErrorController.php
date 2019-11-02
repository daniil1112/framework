<?php
namespace Engine\Abstraction;

use Engine\Helper\Common;


abstract class AbstractErrorController
{
    public function page404()
    {
        echo 'Данная страница не найдена';
    }
    public function errorMethod()
    {
        echo 'Метод <b> '. Common::getMethod().'</b> Запрещен на данной странице';
        //TODO  Лог ошибок в бд доделать
    }
}
?>