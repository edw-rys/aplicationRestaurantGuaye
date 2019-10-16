<?php
require_once MODELS."DTO/User/User.php";
require_once MODELS.'DAO/EventDAO.php';
require_once MODELS.'DTO/Event.php';
class EventController {
    private $eventDao;
    public function __construct() { 
        $this->eventDao = new EventDAO();
    }
    public function index(){
        if(!isset($_SESSION["USER"])){
            Redirect::to("");
        }else{
            $data = [
                "title"=>"Eventos"
            ];
            if($_SESSION["rol"]==ADMINISTRADOR){
                $results = $this->eventDao->queryAll();
            }else{
                $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:0;
                $results = $this->eventDao->queryByUser($id_user,"");
            }
            if(!empty($results)){
                $data = [
                    "title"=>"Eventos",
                    "events"=>array_reverse($results)
                ];
            }
            View::render("event",$data);
        }
    }
    public function query($value=null){
        if(!isset($_SESSION["USER"]) || is_null($value)){
            echo "null";
        }else{
            $data = [
                "title"=>"Eventos"
            ];
            if($_SESSION["rol"]==ADMINISTRADOR){
                $results = $this->eventDao->queryAll($value);
                if(!empty($results)){
                    $data = [
                        "title"=>"Eventos",
                        "events"=>array_reverse($results)
                    ];
                }
                include COMPONENTS."event/viewAdmin.php";
            }else{
                $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:0;
                $results = $this->eventDao->queryByUser($id_user,$value);
                if(!empty($results)){
                    $data = [
                        "title"=>"Eventos",
                        "events"=>array_reverse($results)
                    ];
                }
                include COMPONENTS."event/viewUser.php";
            }
        }
    }

    public function new($id=null){
        if(isset($_SESSION["USER"])){
            if(!is_null($id)){
                $data =$this->show($id);
                if(isset($data["event"])){
                    $event=$data["event"];
                }
            }
            require_once COMPONENTS."event/formEvent.php";
        }else{
        }
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
                $event= $this->eventDao->queryById($id);
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
        }
        return $data;
    }
    /**
     * Show View 
     */
    public function getItemView($id=null){
        if(!is_null($id)){
            $event =$this->eventDao->queryById($id, "object");
            if(isset($_SESSION["ID_USER"]) && $event->id_user==$_SESSION["ID_USER"]){
                if(!empty($event)){
                    echo json_encode($event);
                }
            }
        }
    }

    public function save(){
        //en caso de la ausencia de algún campo, retornar =>faltan campos
        if(!(isset($_POST['asunto']) && isset($_POST['fecha']) && 
            isset($_POST['inHour']) && isset($_POST['outHour']) && 
            isset($_POST['comentarios']))){
                $data = [
                    "code"=>400,
                    "status"=>"error",
                    "message"=>"Compelte todos los campos, por favor!",
                ];
        }else{
            $event= new Event();
            $event->setExecutionDate($_POST['fecha']);
            $event->setAffair($_POST['asunto']);
            $event->setStart_time($_POST['inHour']);
            $event->setEnd_time($_POST['outHour']);
            $event->setComments($_POST['comentarios']);
            //verificar choque de horas
            if($this->checkSchedule( $_POST['fecha'],$_POST['inHour'], $_POST['outHour'],
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
                        $event->setId_event($_POST['id']);
                        $numfilasAfectadas = $this->eventDao->update($event);
                        $data = [
                            "code"=>200,
                            "status"=>"success",
                            "message"=>"Editado exitosamente",
                            "idEvent"=>$_POST['id']
                        ];
                    }
                }else{
                    $numfilasAfectadas = $this->eventDao->create($event);
                    
                    if ($numfilasAfectadas > 0) {
                        $data = [
                            "code"=>200,
                            "status"=>"success",
                            "message"=>"Guardado exitosamente",
                            "idEvent"=>$numfilasAfectadas
                        ];
                    } else {
                        $data = [
                            "code"=>400,
                            "status"=>"error",
                            "message"=>"No se pudo guardar los datos",
                            "dat"=>$numfilasAfectadas
                        ];
                    }
                }
            }
        }
        echo json_encode($data);
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
                $event= $this->eventDao->queryById($id_);
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
                                "code"=>200,
                                "status"=>"success",
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
            echo json_encode($data);    
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
    public function accept($id=null){
        if(isset($_SESSION['USER']) && isset($_SESSION['rol']) && $_SESSION['rol']!=101){
            //advertencia, debe ser autenticado con un usuario administrador
            $data =[
                "code"=>400,
                "status"=>"error",
                "message"=>"Función no disponible"
            ];
        }else{
            if(!is_null($id)){
                $update=$this->eventDao->accept($id);
                if($update){
                    //se aceptó
                    $data =[
                        "code"=>200,
                        "status"=>"success",
                        "message"=>"Petición aceptada"
                    ];
                }else{
                    //hubo un error
                    $data =[
                        "code"=>400,
                        "status"=>"error",
                        "message"=>"Hubo un error al aceptar la petición"
                    ];
                }
            }else{
                $data =[
                    "code"=>400,
                    "status"=>"error",
                    "message"=>"No ha seleccionado la petición."
                ];
            }
        }
        echo json_encode($data);
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