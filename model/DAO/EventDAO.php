<?php
require_once 'model/Connection.php';
require_once 'model/DTO/Event.php';
class EventDAO {
	//Manejo de datos de actiidades
	private $connection;

	public function __construct(){
		$this->connection = Connection::getConnection();
    }
    //Diferentes sentencias de consulta
        //*Todos los eventos
    public function queryAll(){
        if(!$this->connection) return [];
        try {
            $sentencia = $this->connection->prepare("call getEventAll()");
            $parametros = array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultSet ;
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    //*Todos un evento en especifico
    public function queryForId($id_evt){
        if(!$this->connection) return null;
        
        try {
                $sentencia = $this->connection->prepare("call getEventForId(?)");
                $parametros = array($id_evt);
                $sentencia->execute($parametros);
                $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS, "Event");
            if(count($resultSet) > 0)
                return $resultSet[0] ;
            else
                return $resultSet;
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function checkEvtForUser($id_evt,$id_us){
        if(!$this->connection) return null;
        try {
            $sentencia = $this->connection->prepare("call getEventForIdEvtForUser(?,?);");
            $parametros = array($id_evt,$id_us);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS, "Event");
            return $resultSet;
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    
        //*Todos los eventos de un usuario
    public function queryByUser($id_user,$value){
        if(!$this->connection) return [];
        try {
            if(empty($value)){
                $sentencia = $this->connection->prepare("call getEventForIdUser(?)");
                $parametros = array($id_user);
                $sentencia->execute($parametros);
                $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            }else{
                $sentencia = $this->connection->prepare("call getEventByIdUsByValue(?,?)");
                $parametros = array($id_user,$value);
                $sentencia->execute($parametros);
                $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            }
            return $resultSet ;
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
        //  verificar Horario no ocupado
    public function checkSchedule($date, $hour_in,$hour_out){
        if(!$this->connection) return null;
        try {
            $sentencia = $this->connection->prepare("call getEventForDate(?,?,?)");
            $parametros = array($date, $hour_in,$hour_out);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultSet ;
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }


    ////////////////


    public function update(Event $event){
        if(!$this->connection) return 0;
        try {
            $sentencia = $this->connection->prepare("call updateEvent(?,?,?,?,?,?,?)");

            $parametros = array($event->getId_event(),
                $event->getAffair(),$event->getExecutionDate()
                ,$event->getStart_time() ,$event->getEnd_time() 
                ,$event->getComments(),$event->getUser());
            $sentencia->execute($parametros);
            return $sentencia->rowCount();
            // retorna el num de filas afectadas
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function delete( $id_event){
        if(!$this->connection) return 0;
        try {
            $sentencia = $this->connection->prepare("call deleteStatusEvent(?)");

            $parametros = array( $id_event);

            $sentencia->execute($parametros);
            return $sentencia->rowCount();
            // retorna el num de filas afectadas
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function create(Event $event){
        if(!$this->connection) return 0;
        try {
            $sentencia = $this->connection->prepare("call insertEvent(?,?,?,?,?,?)");

            $parametros = array($event->getAffair(),$event->getExecutionDate()
                ,$event->getStart_time() ,$event->getEnd_time() 
                ,$event->getComments(),$event->getUser());

            $sentencia->execute($parametros);
            return $sentencia->rowCount();
            // retorna el num de filas afectadas
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }


    public function accept($id_evt){
        if(!$this->connection) return 0;
        try {
            $sentencia = $this->connection->prepare("call acceptEvent(?)");
            $parametros = array($id_evt);
            $sentencia->execute($parametros);
            return $sentencia->rowCount();
            // retorna el num de filas afectadas
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
   
}