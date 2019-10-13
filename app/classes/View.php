<?php
class View{
    public static function render($view , $data=[]){
        // convert array assoc to object
        // echo VIEWS.CONTROLLER.DS.$view."View.php<br>";
        $obj = to_object($data); // $data en array assoc o $d en objectos
        if(!is_file(VIEWS.CONTROLLER.DS.$view."View.php")){
            die(sprintf("No existe la vista %sView en la carpeta %s", $view, CONTROLLER));
        }
        require_once HEADER;
        require_once VIEWS.CONTROLLER.DS.$view."View.php";
        require_once FOOTER;
        exit();
    }
}
