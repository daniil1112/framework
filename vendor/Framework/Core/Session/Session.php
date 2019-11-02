<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 07.10.2019
 * Time: 21:26
 */

namespace Engine\Core\Session;




use Exception;
use Engine\Config\ConfigParse;
use Engine\Core\Router\Router;

class Session extends ValidSession
{

    private $sessionAdd = [];


 public function __construct()
 {
     parent::__construct();

 }


 public function addSession($session = [])
 {
     if (is_array($session)) {
         $session = $this->Validation($session);
     }
     if (isset($session))
     {
         foreach ($session as $key=>$value)
         {
             $this->sessionAdd += [$key=>['value'=>$value, ]];
         }
     }
     return $this;
 }

 public function start()
 {

     if ($this->sessionAdd != [])
     {
         foreach ($this->sessionAdd as $key=>$value)
         {
             $_SESSION[$key]=$value;
             unset($this->sessionAdd[$key]);
         }
     }

 }

 public function allSession()
 {

     foreach ($_SESSION as $key=>['value'=>$value,'timer'=>$timer])
     {
         echo $key.' - '.$value.' Таймер '. $timer.'<br>';
     }
 }

public function unsetAllSession()
{
    foreach ($_SESSION as $key=>$value)
    {
        unset($_SESSION[$key]);
    }

}

public function deleteSession($keys = [])
{
//    if ($keys)
}
}