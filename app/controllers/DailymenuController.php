<?php
//Class
require_once MODELS.'DTO/DailyMenu/DailyMenu.php';
require_once MODELS.'DTO/DailyMenu/schedule.php';
require_once MODELS.'DTO/DailyMenu/TypeFood.php';
require_once MODELS.'DTO/DailyMenu/Food.php';
require_once MODELS.'DTO/DailyMenu/CtgFood.php';
require_once MODELS.'DTO/DailyMenu/FoodControl.php';
//DAO
require_once MODELS."DTO/User/User.php";
require_once MODELS.'DAO/DailyMenuDAO.php';
require_once MODELS.'DAO/FoodDAO.php';
class DailymenuController{
    private $dailyMenuDAO;
    private $foodDao;
    public function __construct() { 
        $this->dailyMenuDAO = new DailyMenuDAO();
        $this->foodDao = new FoodDAO();
    }

    public function view($id_control =0, $id_food=0){
        if($id_control!=0 && $id_food!=0){
                $check=$this->foodDao->checkUserForPostAndDate($_SESSION['ID_USER'],$id_control);
                if(empty($check)){
                    $data=[
                        "message"=>"No tiene permisos de editar este contenido.",
                        "status"=>"error",
                        "code"=>400
                    ];
                }else{
                    $data=[
                        "status"=>"success",
                        "code"=>200,
                        "food"=>$this->foodDao->queryFoodForId($id_control)
                    ];
                }
        }else{
            $data=[
                "message"=>"Error al intentar editar.",
                "status"=>"error",
                "code"=>400
            ];
        }
        $data["typesFood"]=$this->dailyMenuDAO->getTypeFood();
        $data["ctgFood"]=$this->dailyMenuDAO->getCtgFood();
        $data["schedules"]=$this->dailyMenuDAO->getSchedule();
        return $data;
    }


    public function index(){   
        $typesFood=$this->dailyMenuDAO->getTypeFood();
        $ctgFood=$this->dailyMenuDAO->getCtgFood();
        $schedules=$this->dailyMenuDAO->getSchedule();

        $menusDiarios=$this->dailyMenuDAO->query();
        $dailyMenu = array();
        
        $data = [
            "title"=>"Menú diario",
            "typesFood"=>$typesFood,
            "ctgFood"=>$ctgFood,
            "schedules"=>$schedules,
        ];
        
        foreach($menusDiarios as $dm){
            $menu = new DailyMenu();
            $menu->setId_menu($dm->id_menu);
            $menu->setDate_create($dm->date_create);
            $foodControls=$this->foodDao->queryFoods($dm->id_menu);
            $menu->setFoodControl($foodControls);
            array_push($dailyMenu, $menu);
        }
        if(!empty($dailyMenu)){
            $dailyMenu=array_reverse($dailyMenu);
            $data["menu"]=(isset($_SESSION['rol']) && $_SESSION['rol']==ADMINISTRADOR )? $dailyMenu: $dailyMenu[0];
        }
        // var_dump($data);+
        View::render("dailyMenu",$data);
    }
    public function delete($id_Control=null){
        if(is_null($id_Control)){
            $data=[
                "message"=>"Error al intentar eliminar.",
                "status"=>"error",
                "code"=>400
            ];
        }else{
            $check=$this->foodDao->checkUserForPostAndDate($_SESSION['ID_USER'],$id_Control);
            if(empty($check)){
                $data=[
                    "message"=>"No tiene permisos de eliminar este contenido.",
                    "status"=>"error",
                    "code"=>400
                ];    
            }else{
                $rowsDelete=0;
                $rowsDelete=$this->foodDao->deleteFoodControl($id_Control);
                if($rowsDelete>0){
                    $data=[
                        "message"=>"Comida eliminada de la lista.",
                        "status"=>"success",
                        "code"=>200
                    ];  
                }
                else{
                    $data=[
                        "message"=>"No se pudo eliminar.",
                        "status"=>"error",
                        "code"=>400
                    ];  
                }
            }
        }
        echo json_encode($data);
    }
    public function save(){
        if(!(isset($_REQUEST['horario']) && isset($_REQUEST['type_food']) && 
            isset($_REQUEST['nombre']) && isset($_REQUEST['precio']) && 
            isset($_REQUEST['descripcion'] ) && isset($_REQUEST['ctg']) )){
                $data=[
                    "message"=>"Compelte todos los campos, por favor!.",
                    "status"=>"error",
                    "code"=>400
                ];  
        }else{
            //Create category 
            $ctg=new CtgFood( );
            $ctg->setId_ctgfood($_REQUEST['ctg']);
            //
            $tf=new TypeFood();
            $tf->setId_TypeFood($_REQUEST['type_food']);
            $sch=new schedule();
            $sch->setId_schedule($_REQUEST['horario']);
            //Create foodcontrol        
            $foodControl=new FoodControl();
            $foodControl->setTypefood($tf);
            $foodControl->setSchedule($sch);
            //Create food
            $food=new Food();
            $food->setName_food($_REQUEST['nombre']);
            $food->setDesciption_food($_REQUEST['descripcion']);
            $food->setPrice($_REQUEST['precio']);
            $food->setCtg_food($ctg );
            
            
            //Set foof
            $foodControl->setFood($food);
            //Create dailymenu and set foodcontrol
            $dailyMenu=new DailyMenu();
            $dailyMenu->setFoodControl($foodControl);
            $filas_afectadas=0;

            if( isset($_POST["idc"]) && $_POST["idc"]!=0 &&
                isset($_POST["idf"]) && $_POST["idf"]!=0){
                // Edit
                $check=$this->foodDao->checkUserForPostAndDate($_SESSION['ID_USER'],$_POST["idc"]);
                
                if(empty($check)){
                    $data=[
                        "message"=>"No tiene permisos de editar este contenido.",
                        "status"=>"error",
                        "code"=>400
                    ];  
                }else{
                    $foodControl->setId_control($_POST["idc"]);
                    $food->setId_food($_POST["idf"]);
                    $foodControl->setFood($food);
                    $dailyMenu->getFoodControl($foodControl);
                    $filas_afectadas=$this->dailyMenuDAO->update($dailyMenu);  
                    if($filas_afectadas>0){
                        $data=[
                            "message"=>"Comida editada.",
                            "status"=>"success",
                            "code"=>200
                        ];
                    }
                    else{
                        $data=[
                            "message"=>"Error al editar.",
                            "status"=>"error",
                            "code"=>400
                        ];
                    }
                }
    
            }else{
                // save
                $filas_afectadas=$this->dailyMenuDAO->insert($dailyMenu,$_SESSION['ID_USER']);
                if($filas_afectadas>0){
                    $data=[
                        "message"=>"Comida guardada.",
                        "status"=>"success",
                        "code"=>200
                    ];
                }
                else{
                    $data=[
                        "message"=>"Error al guardar.",
                        "status"=>"error",
                        "code"=>400
                    ];
                }
            }
        }
        echo json_encode($data);
    }
    // Views
    public function new($id_control=0 , $id_food=0){
        if(isset($_SESSION["rol"]) && $_SESSION["rol"]==ADMINISTRADOR){
            $data = $this->view($id_control,$id_food);
            include_once COMPONENTS."dailyMenu/formDailyMenu.php";
        }else{
            echo "error";
        }
    }
}
