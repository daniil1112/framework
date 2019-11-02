<?php
namespace Engine\Service\View;




use Engine\Core\Template\View;
use Engine\Service\AbstractProvider;

class Provider extends AbstractProvider
{

    /**
     * @var string
     */

    public $serviceName = 'view';

    /**
     * @return mixed
     */
    function init()
    {
        $db = new View();
        
        $this->di->set($this->serviceName,$db);
    }
}