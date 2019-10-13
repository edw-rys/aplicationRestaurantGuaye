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

    public function view($id_control =null, $id_food=null){
        if(!is_null($id_control) && !is_null($id_food)){
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
        var_dump($data);
        // $typesFood=$this->dailyMenuDAO->getTypeFood();
        // $ctgFood=$this->dailyMenuDAO->getCtgFood();
        // $schedules=$this->dailyMenuDAO->getSchedule();

    }


    public function index(){   

        $typesFood=$this->dailyMenuDAO->getTypeFood();
        $ctgFood=$this->dailyMenuDAO->getCtgFood();
        $schedules=$this->dailyMenuDAO->getSchedule();
        // die();

        $menusDiarios=$this->dailyMenuDAO->query();
        $dailyMenu = array();
        
        $data = [
            "title"=>"Menú diario",
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
            $data = [
                "title"=>"Menú diario",
                "menu"=>array_reverse($dailyMenu)
            ];
        }
        var_dump($data);
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
        var_dump($data);
    }
    public function save($id_control=null,$id_food=null){
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
            if( !is_null($id_control) && !is_null($id_food)){
                
                // Edit
                $check=$this->foodDao->checkUserForPostAndDate($_SESSION['ID_USER'],$id_control);
                
                if(empty($check)){
                    $data=[
                        "message"=>"No tiene permisos de eliminar este contenido.",
                        "status"=>"error",
                        "code"=>400
                    ];  
                }else{
                    $foodControl->setId_control($id_control);
                    $food->setId_food($id_food);
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
        var_dump($data);
    }
}
