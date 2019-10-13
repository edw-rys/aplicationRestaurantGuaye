<?php

class Event{
    private $id_event;
    private $affair;  //ASUNTO
    private $creation_date;
    private $execution_date;
    private $start_time;
    private $end_time;
    private $comment;
    private $id_user;
    private $status;
    private $is_accepted;
    public function __construct(){
    }
    
    // Gets and Sets

    public function getIs_accepted() {
        return $this->is_accepted;
    }

    public function setIs_accepted() {
        return $this->is_accepted;
    }
    public function getId_event() {
        return $this->id_event;
    }

    public function getAffair() {
        return $this->affair;
    }

    public function getDate() {
        return $this->creation_date;
    }

    public function getStart_time() {
        return $this->start_time;
    }

    public function getEnd_time() {
        return $this->end_time;
    }

    public function getComments() {
        return $this->comment;
    }

    public function getUser() {
        return $this->id_user;
    }

    public function getExecutionDate() {
        return $this->execution_date;
    }

    
    public function setExecutionDate($execution_date) {
        $this->execution_date = $execution_date;
    }
    public function setId_event($id_event) {
        $this->id_event = $id_event;
    }

    public function setAffair($affair) {
        $this->affair = $affair;
    }

    public function setDate($creation_date) {
        $this->creation_date = $creation_date;
    }

    public function setStart_time($start_time) {
        $this->start_time = $start_time;
    }

    public function setEnd_time($end_time) {
        $this->end_time = $end_time;
    }

    public function setComments($comment) {
        $this->comment = $comment;
    }

    public function setUser($id_user) {
        $this->id_user = $id_user;
    }


}