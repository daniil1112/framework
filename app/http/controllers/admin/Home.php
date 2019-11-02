<?php
namespace App\http\controllers\admin;

use App\http\controllers\AbstractController;
use Engine\Core\Request\Request;

class Home extends AbstractController{

    public function index()
    {
        $request = new Request;
        echo $request->get('id');
        
    }
}