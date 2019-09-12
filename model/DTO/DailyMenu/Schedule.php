<?php
// HORARIO
class schedule{
    private $id_schedule;
    private $name_schedule;
    private $status;
    public function __construct(){
    }

    public function getId_schedule() {
        return $this->id_schedule;
    }

    public function getName_schedule() {
        return $this->name_schedule;
    }

    public function setId_schedule($id_schedule) {
        $this->id_schedule = $id_schedule;
    }

    public function setName_schedule($name_schedule) {
        $this->name_schedule = $name_schedule;
    }

}