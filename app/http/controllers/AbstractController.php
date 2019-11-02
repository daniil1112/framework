<?php
namespace App\http\controllers;

use Engine\DI\DI;
use Engine\Core\Session\Session;

abstract class AbstractController
{
    public  $session;

    public $view;

    protected $di;

    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->session=new Session();
        $this->view=$this->di->get('view');
    }
}