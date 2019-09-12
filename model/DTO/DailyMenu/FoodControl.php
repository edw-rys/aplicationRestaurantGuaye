<?php

class FoodControl{
    private $id_control;
    private $typefood;
    private $schedule;
    private $admin;
    private $food;
    public function __construct(){
    }
    public function getId_control() {
        return $this->id_control;
    }

    public function getTypefood() {
        return $this->typefood;
    }

    public function getSchedule() {
        return $this->schedule;
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function getFood() {
        return $this->food;
    }

    public function setId_control($id_control) {
        $this->id_control = $id_control;
    }

    public function setTypefood($typefood) {
        $this->typefood = $typefood;
    }

    public function setSchedule($schedule) {
        $this->schedule = $schedule;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
    }

    public function setFood($food) {
        $this->food = $food;
    }


}