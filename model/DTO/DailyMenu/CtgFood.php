<?php

class CtgFood{
    private $id_ctgfood;
    private $name_ctgfood;
    private $status;
    public function __construct(){
    }
    public function getId_ctgfood() {
        return $this->id_ctgfood;
    }

    public function getName_ctgfood() {
        return $this->name_ctgfood;
    }

    public function setId_ctgfood($id_ctgfood) {
        $this->id_ctgfood = $id_ctgfood;
    }

    public function setName_ctgfood($name_ctgfood) {
        $this->name_ctgfood = $name_ctgfood;
    }
}