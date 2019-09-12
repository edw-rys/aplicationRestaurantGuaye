<?php
include_once 'config/config.php';
//Class
require_once 'model/DTO/DailyMenu/DailyMenu.php';
require_once 'model/DTO/DailyMenu/CtgFood.php';
require_once 'model/DTO/DailyMenu/schedule.php';
require_once 'model/DTO/DailyMenu/TypeFood.php';
require_once 'model/DTO/DailyMenu/Food.php';
require_once 'model/DTO/DailyMenu/FoodControl.php';
//DAO
require_once 'model/DAO/DailyMenuDAO.php';
require_once 'model/DAO/FoodDAO.php';
class DailymenuController{
    private $dailyMenuDAO;
    private $foodDao;
    public function __construct() { 
        $this->dailyMenuDAO = new DailyMenuDAO();
        $this->foodDao = new FoodDAO();
    }
    public function sessionStart(){
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    public function view(){
        $this->sessionStart();
        if(isset($_REQUEST['idc']) && !empty($_REQUEST['idc']) &&
            isset($_REQUEST['idf']) && !empty($_REQUEST['idf'])){
                $check=$this->foodDao->checkUserForPostAndDate($_SESSION['ID_USER'],$_REQUEST['idc']);
                if(empty($check)){
                    $_SESSION['messageError']="No tiene permisos de editar este contenido.";    
                }else{
                    $editFood=$this->foodDao->queryFoodForId($_REQUEST['idc']);
                }
        }else{
            $_SESSION['messageError']="Error al intentar editar.";    
        }
        // var_dump($editFood);
        $typesFood=$this->dailyMenuDAO->getTypeFood();
        $ctgFood=$this->dailyMenuDAO->getCtgFood();
        $schedules=$this->dailyMenuDAO->getSchedule();
        require_once HEADER;
        require_once 'view/DailyMenu/DailyMenu.php';
        require_once PANELS;
        require_once FOOTER; 
    }


    public function query(){   
        $this->sessionStart();

        $typesFood=$this->dailyMenuDAO->getTypeFood();
        $ctgFood=$this->dailyMenuDAO->getCtgFood();
        $schedules=$this->dailyMenuDAO->getSchedule();

        $menusDiarios=$this->dailyMenuDAO->query();
        $dailyMenu = array();
        
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
        }
        require_once HEADER;
        require_once 'view/DailyMenu/DailyMenu.php';
        require_once PANELS;
        require_once FOOTER;
    }
    public function delete(){
        $this->sessionStart();

        $id_Control=isset($_REQUEST['idc'])?$_REQUEST['idc']:'';
        if(empty($id_Control)){
            $_SESSION['messageError']="Error al intentar eliminar";    
            $this->query();
        }
        $check=$this->foodDao->checkUserForPostAndDate($_SESSION['ID_USER'],$id_Control);
        if(empty($check)){
            $_SESSION['messageError']="No tiene permisos de eliminar este contenido.";    
        }else{
            $rowsDelete=0;
            $rowsDelete=$this->foodDao->deleteFoodControl($id_Control);
            if($rowsDelete>0)
                $_SESSION['message']="Comida eliminada de la lista";
            else
                $_SESSION['messageError']="No se pudo eliminar.";   
        }
        
                
        $this->query();
    }
    public function save(){
        $this->sessionStart();
        if(!(isset($_REQUEST['horario']) && isset($_REQUEST['type_food']) && 
            isset($_REQUEST['nombre']) && isset($_REQUEST['precio']) && 
            isset($_REQUEST['descripcion'] ) && isset($_REQUEST['ctg']) )){
                $_SESSION['messageError']="Compelte todos los campos, por favor!";
                $this->query();
        }

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
        if(
            isset($_REQUEST['idc']) && !empty($_REQUEST['idc']) &&
            isset($_REQUEST['idf']) && !empty($_REQUEST['idf'])
        ){
            
            // Edit
            $check=$this->foodDao->checkUserForPostAndDate($_SESSION['ID_USER'],$_REQUEST['idc']);
            
            if(empty($check)){
                $_SESSION['messageError']="No tiene permisos de eliminar este contenido.";    
                $this->query();
                return;
            }else{
                $foodControl->setId_control($_REQUEST['idc']);
                $food->setId_food($_REQUEST['idf']);
                $foodControl->setFood($food);
                $dailyMenu->getFoodControl($foodControl);
                $filas_afectadas=$this->dailyMenuDAO->update($dailyMenu);  
                $message="Comida editada";
                $messErr="Error al editar.";  
            }

        }else{
            // save
            $filas_afectadas=$this->dailyMenuDAO->insert($dailyMenu,$_SESSION['ID_USER']);
            $message="Comida guardada";
            $messErr="Error al guardar.";
        }
        if($filas_afectadas>0)
            $_SESSION['message']=$message;
        else
            $_SESSION['messageError']=$messErr;        
        $this->query();
    }
}
