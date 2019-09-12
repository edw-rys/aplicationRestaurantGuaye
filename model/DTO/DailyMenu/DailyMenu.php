<?php
// MENÚ DIARIO
class DailyMenu{
    private $id_menu;
    private $date_create;
    private $foodControl=array();
    public function __construct(){
    }
    public function addFoodControl($ctrl){     
        array_push($this->foodControl, $ctrl);
    }
    public function getId_menu() {
        return $this->id_menu;
    }

    public function getDate_create() {
        return $this->date_create;
    }

    public function getFoodControl() {
        return $this->foodControl;
    }

    public function setId_menu($id_menu) {
        $this->id_menu = $id_menu;
    }

    public function setDate_create($date_create) {
        $this->date_create = $date_create;
    }

    public function setFoodControl($foodControl) {
        $this->foodControl = $foodControl;
    }
}