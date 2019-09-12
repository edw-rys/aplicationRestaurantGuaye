<?php
require_once 'model/DTO/User/User.php';
class FrontController {

    public function __construct() {     
    }

    public function route() {

        $controller = (isset($_REQUEST['c'])) ? $_REQUEST['c'] : 'Index';
        $action = (isset($_REQUEST['a'])) ? $_REQUEST['a'] : 'query';

        $controller = strtolower($controller); // strtolower Make a string lowercase
        $controller = ucwords($controller) . "Controller"; //ucwords — Uppercase the first character of each word in a string   

        if(!(file_exists("controller/" . $controller . ".php"))){
            $controller ="IndexController";
            $action="notFound";
        }
        require_once "controller/" . $controller . ".php"; // require de la clase del controlador
        $controller = new $controller; // creacion del objeto controlador
        if(!(method_exists($controller, $action))){
            $action = "query";
        }
        $controller->$action(); //llamada a la funcion del controlador (action) que se va a ejecutar    
        

        
    }
}
