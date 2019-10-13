<?php
require_once MODELS."DTO/User/User.php";
require_once MODELS.'DAO/EventDAO.php';
require_once MODELS.'DTO/Event.php';
class EventController {
    private $eventDao;
    public function __construct() { 
        $this->eventDao = new EventDAO();
    }
    public function index($id_user=null){
        $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:0;
        $results = $this->eventDao->queryByUser($id_user,"");
        $data = [
            "title"=>"Eventos"
        ];
        if(!empty($results)){
            $data = [
                "title"=>"Eventos",
                "events"=>array_reverse($results)
            ];
        }
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        
    }

    public function queryData(){
        $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:0;
        $value=isset($_REQUEST['value'])?$_REQUEST['value']:'';
        $results = $this->eventDao->queryByUser($id_user, $value);
        if(!empty($results)){
            $results=array_reverse($results);
        }
        echo json_encode($results);
    }
    public function show($id=null){
        if(!is_null($id)){
            $verify = $this->eventDao->checkEvtByUser($id,  $_SESSION['ID_USER']);
            if(empty($verify)){
                $data = [
                    "message"=>"Usted no tiene permisos para editar este evento!",
                    "code"=>400,
                    "status"=>"error"
                ];
            }else{
                $event= $this->eventDao->queryForId($id);
                if(!empty($event)){
                    if(date("Y-m-d")>$event->getExecutionDate()){
                        $data = [
                            "message"=>"No se permite actualizar reservaciones que ya han pasado su fecha de reservación.",
                            "code"=>400,
                            "status"=>"error"
                        ];
                    }else{
                        $data = [
                            "code"=>200,
                            "status"=>"success",
                            "event"=>$event
                        ];
                    }
                }else{
                    $data = [
                        "code"=>400,
                        "status"=>"error",
                        "message"=>"No se encontró evento",
                    ];
                } 
            }
            var_dump($data);
        }
    }
    public function save(){
        //en caso de la ausencia de algún campo, retornar =>faltan campos
        if(!(isset($_REQUEST['asunto']) && isset($_REQUEST['fecha']) && 
            isset($_REQUEST['inHour']) && isset($_REQUEST['outHour']) && 
            isset($_REQUEST['comentarios']))){
                $data = [
                    "code"=>400,
                    "status"=>"error",
                    "message"=>"Compelte todos los campos, por favor!",
                ];
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
            $data = [
                "code"=>400,
                "status"=>"error",
                "message"=>"No se pudo guardar los datos, hay choque de horarios con otra reservación",
            ];
        }else{
            $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:'';
            $event->setUser($id_user);
            $numfilasAfectadas = 0;
            if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
                // editar
                // verificar que la publicación concuerda con su respectivo dueño
                $verify = $this->eventDao->checkEvtByUser($_REQUEST['id'],  $_SESSION['ID_USER']);
                if(empty($verify)){
                    $data = [
                        "code"=>400,
                        "status"=>"error",
                        "message"=>"Usted no tiene permisos para editar este evento!",
                    ];
                }else{
                    $event->setId_event($_REQUEST['id']);
                    $numfilasAfectadas = $this->eventDao->update($event);
                    $data = [
                        "code"=>200,
                        "status"=>"success",
                        "message"=>"Editado exitosamente",
                    ];
                }
            }else{
                $numfilasAfectadas = $this->eventDao->create($event);
                
                if ($numfilasAfectadas > 0) {
                    $data = [
                        "code"=>200,
                        "status"=>"success",
                        "message"=>"Guardado exitosamente",
                    ];
                } else {
                    $data = [
                        "code"=>400,
                        "status"=>"error",
                        "message"=>"No se pudo guardar los datos",
                    ];
                }
            }
        }
        var_dump($data);
    }
    public function delete($id_=null){
        if(!is_null($id_)){
            $verify = $this->eventDao->checkEvtByUser($id_,  $_SESSION['ID_USER']);
            if(empty($verify)){
                $data = [
                    "code"=>400,
                    "status"=>"error",
                    "message"=>"Usted no tiene permisos para eliminar este evento!",
                ];
            }else{
                $event= $this->eventDao->queryForId($id_);
                if(!empty($event)){
                    
                    if(date("Y-m-d")>$event->getExecutionDate()){
                        $data = [
                            "code"=>400,
                            "status"=>"error",
                            "message"=>"No se permite eliminar datos reservaciones que ya han pasado su fecha de reservación.",
                        ];
                    }else{
                        $numfilasAfectadas= $this->eventDao->delete($id_);
                        if ($numfilasAfectadas > 0) {
                            $data = [
                                "code"=>400,
                                "status"=>"error",
                                "message"=>"Datos eliminados correctamente.",
                            ];
                        } else {
                            $data = [
                                "code"=>400,
                                "status"=>"error",
                                "message"=>"Error al eliminar los datos",
                            ];
                        }
                    }
                }
            }
            var_dump($data);    
        }
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
        if(isset($_SESSION['USER']) && isset($_SESSION['rol']) && $_SESSION['rol']==101){
            $results = $this->eventDao->queryAll();
            $data = [
                "title"=>"eventos",
            ];
            if(!empty($results)){
                $data = [
                    "title"=>"eventos",
                    "code"=>400,
                    "status"=>"error",
                    "events"=>array_reverse($results)
                ];
            }
        }else{
            $data = [
                "code"=>400,
                "status"=>"error",
                "message"=>"Debe ser autenticado con un usuario administrador.",
            ];
        }
        var_dump($data);
    }
}