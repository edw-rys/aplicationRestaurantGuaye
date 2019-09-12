<?php
include_once 'config/config.php';
class IndexController {
    public function __construct() {}
    
    public function query(){
        require_once HEADER;
        require_once 'view/static/index.php';
        require_once FOOTER;
    }

    public function static(){
        $pagina = (isset($_REQUEST['p'])) ? $_REQUEST['p'] : 'Index';
        require_once HEADER;
        $dir='view/static/'.$pagina.".php";
        if(!(file_exists($dir)))
            $dir='view/static/notFound.php';
    	require_once $dir;
    	require_once FOOTER;
    }
    public function notFound(){
        require_once HEADER;
        require_once 'view/static/notFound.php';
        require_once FOOTER;
    }
}
