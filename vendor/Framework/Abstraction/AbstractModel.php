<?php
namespace Engine\Abstraction;

use Engine\Core\Database\Database;

abstract class AbstractModel extends Database
{

    public $prefix;

    public function __construct()
    {
        // $this->prefix = self;
        $class = explode('\\',get_class($this));
        $this->prefix  = mb_strtolower($class[count($class)-1]);
    }
}