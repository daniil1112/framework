<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 16.10.2019
 * Time: 19:23
 */

namespace Engine\Core;

use Engine\Config\ConfigParse;

class AbstractCore
{

    public  $config = [];

    public function __construct()
    {
        // $this->config =  require __DIR__.'/../../cms/Config/Main.php';
    }

}