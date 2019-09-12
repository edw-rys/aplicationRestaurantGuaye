<?php

class TypeFood{
    private $id_TypeFood;
    private $name_TypeFood;
    private  $status;
    public function __construct(){
    }
    public function getId_TypeFood() {
        return $this->id_TypeFood;
    }

    public function getName_TypeFood() {
        return $this->name_TypeFood;
    }

    public function setId_TypeFood($id_TypeFood) {
        $this->id_TypeFood = $id_TypeFood;
    }

    public function setName_TypeFood($name_TypeFood) {
        $this->name_TypeFood = $name_TypeFood;
    }
}