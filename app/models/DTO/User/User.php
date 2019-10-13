<?php

class User{
    private $id_user;
    private $username;
    private $name_user;
    private $last_name;
    private $password;
    private $phone_number;
    private $type_user;
 //   private $id_TypeUser;
    public function __construct(){
    }
    public function getId_user() {
        return $this->id_user;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getName_user() {
        return $this->name_user;
    }

    public function getLast_name() {
        return $this->last_name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPhone_number() {
        return $this->phone_number;
    }

    public function getType_user() {
        return $this->type_user;
    }

    public function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setName_user($name_user) {
        $this->name_user = $name_user;
    }

    public function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setPhone_number($phone_number) {
        $this->phone_number = $phone_number;
    }

    public function setType_user($type_user) {
        $this->type_user = $type_user;
    }
}