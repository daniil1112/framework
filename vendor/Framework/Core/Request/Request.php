<?php
namespace Engine\Core\Request;

class Request {
    protected $data;


    public function __construct()
    {
        $request = $_REQUEST;
        
        foreach ($request as $key=>$value)
        {
            if ($this->validateKey($key) && $this->validateValue($value))
            {
                $this->data[$key] = $value; 
            } 
        }
    }
    public function get($key)
    {
        return key_exists($key,$this->data)? $this->data[$key] : null;
    }

    protected function validateValue($value)
    {
        return true;
    }

    protected function validateKey($key)
    {
        return true;
    }
}