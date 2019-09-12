<?php
include_once 'config/config.php';
require_once 'model/DAO/EventDAO.php';
require_once 'model/DTO/Event.php';
class EventController {
    private $eventDao;
    public function __construct() { 
        $this->eventDao = new EventDAO();
    }
    public function sessionStart(){
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function query(){
        $this->sessionStart();
        $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:0;
        $results = $this->eventDao->queryByUser($id_user,"");
        if(!empty($results)){
            $results=array_reverse($results);
        }
        // var_dump($results);
        require_once HEADER;
        require_once 'view/Event/event.php';
        require_once PANELS;
        require_once FOOTER;
    }

    public function queryData(){
        $this->sessionStart();
        $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:0;
        $value=isset($_REQUEST['value'])?$_REQUEST['value']:'';
        $results = $this->eventDao->queryByUser($id_user, $value);
        if(!empty($results)){
            $results=array_reverse($results);
        }
        echo json_encode($results);
    }
    public function show(){
        $this->sessionStart();
        if(isset($_REQUEST['id'])){
            $id_=isset($_REQUEST['id'])?$_REQUEST['id']:'';
            
            
            $verify = $this->eventDao->checkEvtForUser($id_,  $_SESSION['ID_USER']);
            if(empty($verify)){
                $_SESSION['messageError'] = "Usted no tiene permisos para editar este evento!";
                $this->query();
                return;
            }
            $event= $this->eventDao->queryForId($id_);
            if(!empty($event)){
                if(date("Y-m-d")>$event->getExecutionDate()){
                    $this->sessionStart();
                    $_SESSION['messageError']="No se permite actualizar reservaciones que ya han pasado su fecha de reservación.";
                    
                    $this->query();
                }
            }else unset($event);
        }
        require_once HEADER;
        require_once 'view/Event/eventInsert.php';
        require_once PANELS;
        require_once FOOTER;
    }
    public function saveEvent(){
        $this->sessionStart();
        //en caso de la ausencia de algún campo, retornar =>faltan campos
        if(!(isset($_REQUEST['asunto']) && isset($_REQUEST['fecha']) && 
            isset($_REQUEST['inHour']) && isset($_REQUEST['outHour']) && 
            isset($_REQUEST['comentarios']))){
                $_SESSION['messageError']="Compelte todos los campos, por favor!";
                $this->show();
        }
        

        $event= new Event();
        $event->setExecutionDate($_REQUEST['fecha']);
        $event->setAffair($_REQUEST['asunto']);
        $event->setStart_time($_REQUEST['inHour']);
        $event->setEnd_time($_REQUEST['outHour']);
        $event->setComments($_REQUEST['comentarios']);

        
        //verificar choque de horas
        if($this->checkSchedule( $_REQUEST['fecha'],$_REQUEST['inHour'], $_REQUEST['outHour'],
        )){
            $_SESSION['messageError'] = "No se pudo guardar los datos, hay choque de horarios con otra reservación";
            $this->show();
            return;
        }
        $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:'';
        
        $event->setUser($id_user);
        $numfilasAfectadas = 0;
        $message="";
        if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
            // editar
            // verificar que la publicación concuerda con su respectivo dueño
            $verify = $this->eventDao->checkEvtForUser($_REQUEST['id'],  $_SESSION['ID_USER']);
            if(empty($verify)){
                $_SESSION['messageError'] = "Usted no tiene permisos para editar este evento!";
                $this->query();
                return;
            }
            $event->setId_event($_REQUEST['id']);
            $numfilasAfectadas = $this->eventDao->update($event);
            $message="Editado exitosamente";
        }else{
            $numfilasAfectadas = $this->eventDao->create($event);
            $message="Guardado exitosamente";
        }
        if ($numfilasAfectadas > 0) {
            $_SESSION['message'] = $message;
        } else {
            $_SESSION['messageError'] = "No se pudo guardar los datos";
        }
        $this->query();
    }
    public function delete(){
        $this->sessionStart();
        if(isset($_REQUEST['id'])){
            $id_=isset($_REQUEST['id'])?$_REQUEST['id']:'';
            $verify = $this->eventDao->checkEvtForUser($_REQUEST['id'],  $_SESSION['ID_USER']);
            if(empty($verify)){
                $_SESSION['messageError'] = "Usted no tiene permisos para eliminar este evento!";
                $this->query();
                return;
            }
            $event= $this->eventDao->queryForId($id_);
            if(!empty($event)){
                
                if(date("Y-m-d")>$event->getExecutionDate()){
                    $this->sessionStart();
                    $_SESSION['messageError']="No se permite eliminar datos reservaciones que ya han pasado su fecha de reservación.";
                    
                }else{
                    $numfilasAfectadas= $this->eventDao->delete($id_);
                    if ($numfilasAfectadas > 0) {
                        $_SESSION['message'] = "Datos eliminados correctamente";
                    } else {
                        $_SESSION['messageError'] = "Error al eliminar los datos";
                    }
                }
            }
        }
        header("Location:index.php?c=event");
    }
    //verifica choque de horarios y que hora_in < hora_out
    public function checkSchedule($date_, $hourin, $hourout){
        if( $hourin==$hourout or  $hourin> $hourout){
            return true;
        }
        $data=$this->eventDao->checkSchedule($date_, $hourin, $hourout);
        if(!empty($data )){
            return true;
        }
        return false;
    }
    public function checkSheduleAjax(){
        if(isset($_REQUEST['fecha']) && isset($_REQUEST['inHour']) && isset($_REQUEST['outHour'])){
            echo $this->checkSchedule($_REQUEST['fecha'], $_REQUEST['inHour'], $_REQUEST['outHour']);
        }
    }
    public function acceptEvt(){
        $this->sessionStart();
        if(isset($_SESSION['USER']) && isset($_SESSION['rol']) && $_SESSION['rol']!=101){
            echo 2;//advertencia, debe ser autenticado con un usuario administrador
        }else{
            if(isset($_REQUEST['id_evt'])){
                $update=$this->eventDao->accept($_REQUEST['id_evt']);
                if($update>0){
                    echo 1;//se aceptó
                }else{
                    echo 0;//hubo un error
                }
            }
        }
    }
    public function usacpc(){
        $this->panelUserAcceptPanel();
    }
    public function panelUserAcceptPanel(){
        $this->sessionStart();
        if(isset($_SESSION['USER']) && isset($_SESSION['rol']) && $_SESSION['rol']==101){
            $results = $this->eventDao->queryAll();
            if(!empty($results)){
                $results=array_reverse($results);
            }
            require_once HEADER;
            require_once 'view/Event/eventForUser.php';
            require_once PANELS;
            require_once FOOTER;
            
        }else{
            $_SESSION['messageError']="debe ser autenticado con un usuario administrador";
            header("Location:index.php");
        }
    }
}