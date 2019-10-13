<?php

class TypeUser{
    private $id_TypeUser;
    private $name_TypeUser;
    private $status;
    public function __construct(){
    }

    public function getId_TypeUser() {
        return $this->id_TypeUser;
    }

    public function getName_TypeUser() {
        return $this->name_TypeUser;
    }

    public function getStatus() {
        return $this->status;
    }
    
    public function setId_TypeUser($id_TypeUser) {
        $this->id_TypeUser = $id_TypeUser;
    }

    public function setName_TypeUser($name_TypeUser) {
        $this->name_TypeUser = $name_TypeUser;
    }
    
    public function setStatus($status) {
        $this->status = $status;
    }
}