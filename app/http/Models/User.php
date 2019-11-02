<?php
namespace App\http\Models;

use Engine\Abstraction\AbstractModel;

class User extends AbstractModel
{
    public function startQuery()
    {
        return $this::instance()->{$this->prefix.'s'};
    }
}