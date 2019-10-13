<?php

class Food{
    private $id_food;
    private $name_food;
    private $desciption_food;
    private $price;
    private $ctg_food;
    public function __construct(){
    }
    public function getId_food() {
        return $this->id_food;
    }

    public function getName_food() {
        return $this->name_food;
    }

    public function getDesciption_food() {
        return $this->desciption_food;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getCtg_food() {
        return $this->ctg_food;
    }

    public function setId_food($id_food) {
        $this->id_food = $id_food;
    }

    public function setName_food($name_food) {
        $this->name_food = $name_food;
    }

    public function setDesciption_food($desciption_food) {
        $this->desciption_food = $desciption_food;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setCtg_food($ctg_food) {
        $this->ctg_food = $ctg_food;
    }
}