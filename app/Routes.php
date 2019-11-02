<?php
/**
 * list of routers
 */

$this->router->add('home', '/', 'admin\\Home:index');
$this->router->add('test','/get/5/then', 'HomeController:index');
$this->router->add('test2','/get/(id:int)', 'HomeController:test');
