<?php

namespace Engine\Service;

use Engine\DI\DI;

abstract class AbstractProvider
{
    /**
     * @var \Engine\DI\DI
     */
    protected $di;

    /**
     * AbstractProvider constructor.
     * @param DI $DI
     */
    public function __construct(DI $DI)
    {
        $this->di = $DI;
    }


    /**
     * @return mixed
     */
    abstract function init();
}
