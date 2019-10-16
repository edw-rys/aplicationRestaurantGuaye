<?php
require_once MODELS.'/DTO/Event.php';
class EventDAO {
	//Manejo de datos de actividades

	public function __construct(){
    }
    //Diferentes sentencias de consulta
        //*Todos los eventos
    public function queryAll($value=""){
        try {
            if(empty($value)){
                return Model::sql([
                    "sql"=>"call getEventAll()",
                    "params"=>[]
                ]);
            }else{
                return Model::sql([
                    "sql"=>"call getEventAllByValue(?)",
                    "params"=>[$value]
                ]);
            }
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
                    "sql"   =>"call getEventByIdUser(?)",
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
    //*Todos un evento en especifico
    public function queryById($id_evt,$mode=null){
        try {
                $parametros = array($id_evt);
                if(is_null($mode)){
                    $resultSet = Model::sql([
                        "sql"   =>"call getEventById(?)",
                        "params"=>$parametros,
                        "type"  =>"query",
                        "class" =>"Event"
                    ]);
                }else{
                    $resultSet = Model::sql([
                        "sql"   =>"call getEventById(?)",
                        "params"=>$parametros,
                    ]);
                }
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
                "sql"   =>"call getEventByIdEvtForUser(?,?)",
                "params"=>$parametros,
                "type"  =>"query",
                "class" =>"Event"
            ]);
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
                "sql"   =>"INSERT INTO 
                            event_( affair,execution_date, start_time, end_time, comment, id_user, creation_date) 
                            VALUES (?,?,?,?,?,?,now())",
                "params"=>$parametros,
                "type"  =>"insert"
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }


    public function accept($id_evt){
        try {
            return Model::sql([
                "sql"=>"UPDATE event_ set  is_accepted=1 where id_event=?;",
                "params"=>[$id_evt],
                "type"=>"update"
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function getDataCalendarEvent(){
        try {
            return Model::sql([
                "sql"=>"SELECT execution_date, start_time, end_time, affair event_ from event_",
                "params"=>[]
            ]);
        } catch (Exception $e) {
            // die($e->getMessage());
            // die($e->getTrace());
        }
    }
}