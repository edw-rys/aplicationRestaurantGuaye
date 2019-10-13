<?php
require_once MODELS.'/DTO/Event.php';
class EventDAO {
	//Manejo de datos de actividades

	public function __construct(){
    }
    //Diferentes sentencias de consulta
        //*Todos los eventos
    public function queryAll(){
        try {
            return Model::sql([
                "sql"=>"call getEventAll()",
                "params"=>[]
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    //*Todos un evento en especifico
    public function queryForId($id_evt){
        try {
                $parametros = array($id_evt);
                $resultSet = Model::sql([
                    "sql"   =>"call getEventForId(?)",
                    "params"=>$parametros,
                    "type"  =>"query",
                    "class" =>"Event"
                ]);
            if(count($resultSet) > 0)
                return $resultSet[0] ;
            else
                return $resultSet;
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function checkEvtByUser($id_evt,$id_us){
        try {
            $parametros = array($id_evt,$id_us);
            return Model::sql([
                "sql"   =>"call getEventForIdEvtForUser(?,?)",
                "params"=>$parametros,
                "type"  =>"query",
                "class" =>"Event"
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    
        //*Todos los eventos de un usuario
    public function queryByUser($id_user,$value){
        try {
            if(empty($value)){
                $parametros = array($id_user);
                $resultSet = Model::sql([
                    "sql"   =>"call getEventForIdUser(?)",
                    "params"=>$parametros,
                ]);
            }else{
                $parametros = array($id_user,$value);
                $resultSet = Model::sql([
                    "sql"   =>"call getEventByIdUsByValue(?,?)",
                    "params"=>$parametros,
                ]);
            }
            return $resultSet ;
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
        //  verificar Horario no ocupado
    public function checkSchedule($date, $hour_in,$hour_out){
        try {
            $parametros = array($date, $hour_in,$hour_out);
            return Model::sql([
                "sql"   =>"call getEventForDate(?,?,?)",
                "params"=>$parametros,
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }


    ////////////////


    public function update(Event $event){
        try {
            $parametros = array($event->getId_event(),
                $event->getAffair(),$event->getExecutionDate()
                ,$event->getStart_time() ,$event->getEnd_time() 
                ,$event->getComments(),$event->getUser());
            return Model::sql([
                "sql"   =>"call updateEvent(?,?,?,?,?,?,?)",
                "params"=>$parametros,
                "type"  =>"update"
            ]);
            // retorna el num de filas afectadas
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function delete( $id_event){
        try {
            $parametros = array( $id_event);
            return Model::sql([
                "sql"=>"call deleteStatusEvent(?)",
                "params"=>  $parametros,
                "type"  =>"delete"
            ]);
            // retorna el num de filas afectadas
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function create(Event $event){
        try {
            $parametros = array($event->getAffair(),$event->getExecutionDate()
                ,$event->getStart_time() ,$event->getEnd_time() 
                ,$event->getComments(),$event->getUser());
            return Model::sql([
                "sql"   =>"call insertEvent(?,?,?,?,?,?)",
                "params"=>$parametros,
                "type"  =>"insert"
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }


    public function accept($id_evt){
        if(!$this->connection) return 0;
        try {
            $parametros = array($id_evt);
            return Model::sql([
                "sql"=>"call acceptEvent(?)",
                "params"=>$parametros,
                "type"=>"upate"
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
   
}