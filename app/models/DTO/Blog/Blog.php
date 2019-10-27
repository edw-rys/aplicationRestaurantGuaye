<?php

class Blog{
    private $destacado;
    private $id_blog;
    private $recipe;
    private $date_blog;
    private $user;
    private $url_social_network=array();
    private $creation_date;
    
    public function __construct(){
        $url_social_network=array();
    }
    public function addLink($link){     
        array_push($this->url_social_network, $link);
    }
    
    public function getcreation_date(){
        return $this->creation_date;
    }
    public function setcreation_date($creation_date){
        $this->creation_date = $creation_date;
    }
    public function getDestacado() {
        return $this->destacado;
    }
    public function setDestacado($destacado) {
        $this->destacado = $destacado;
    }
    
    // gets and sets
    public function getRecipe() {
        return $this->recipe;
    }

    public function setRecipe($recipe) {
        $this->recipe = $recipe;
    }

    public function getId_blog() {
        return $this->id_blog;
    }

    public function getDate_blog() {
        return $this->date_blog;
    }
    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }
    public function setId_blog($id_blog) {
        $this->id_blog = $id_blog;
    }

    public function setDate_blog($date_blog) {
        $this->date_blog = $date_blog;
    }
    public function setUrl_social_network($url_social_network) {
        $this->url_social_network = $url_social_network;
    }
    public function getUrl_social_network() {
        return $this->url_social_network;
    }
}