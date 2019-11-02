<?php
namespace App\http\controllers;

use App\http\Models\User;
use Engine\Core\Database\Database;




class HomeController {
    
    public function index($dsf = 'tes',$namr)
    {
        echo $dsf.' '.$namr;
    }

    public function test($id)
    {
        // $id = [
        //     'name' => 'daniil',
        //     'surname' => 'frolov'
        // ];
        
        // $database = Database::instance();
        // $post = $database->users->whereGroup(
        //     function($q){
        //         $q->where('id','=','1');
        //     }
        // )
        // ->orWhereGroup(function($q){
        //     $q->where('name','=','kate');
        // })
        // ->get();
        // dd($post);
        $user = new User();
        dd($user->startQuery()->where('name','=','daniil')->get());

        

    }
}