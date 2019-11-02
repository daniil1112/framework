<?php
namespace Engine\Core\Config;


class ConfigClass 
{
    



    public static function getConfig()
    {
        $config = require __DIR__.'/../../../../Config.php';
        return $config;
    }


}