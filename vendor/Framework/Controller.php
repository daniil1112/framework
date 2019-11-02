<?php


namespace Engine;


use Engine\DI\DI;

abstract class Controller
{
    protected $di;

    protected $db;

    /**
     * Controller constructor.
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
    }
}