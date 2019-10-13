<?php

class SocialNetwork{
    private $id_socialNetwork;
    private $name_socialNetwork;
    public function __construct(){
    }

    public function getId_socialNetwork() {
        return $this->id_socialNetwork;
    }

    public function getName_socialNetwork() {
        return $this->name_socialNetwork;
    }

    public function setId_socialNetwork($id_socialNetwork) {
        $this->id_socialNetwork = $id_socialNetwork;
    }

    public function setName_socialNetwork($name_socialNetwork) {
        $this->name_socialNetwork = $name_socialNetwork;
    }
}