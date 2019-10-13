<?php 
require_once MODELS."DTO/User/User.php";
class ErrorController{
    public function index() {
        $data=[
            "title"=>"Page not found"
        ];
        View::render("error", $data);
    }
}