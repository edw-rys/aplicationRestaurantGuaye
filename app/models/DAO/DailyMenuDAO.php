<?php
require_once MODELS.'DAO/FoodDAO.php';
require_once MODELS.'DTO/DailyMenu/DailyMenu.php';
require_once MODELS.'DTO/DailyMenu/FoodControl.php';
require_once MODELS.'DTO/DailyMenu/TypeFood.php';
require_once MODELS.'DTO/DailyMenu/CtgFood.php';
require_once MODELS.'DTO/DailyMenu/Schedule.php';
// require_once 'model/DTO/Food.php';
// require_once 'model/DTO/User/User.php';
class DailyMenuDAO {
    private $foodDao;
	public function __construct(){
        $this->foodDao = new FoodDAO();
    }
  
    public function query(){
        try{
            return Model::sql([
                "sql"   =>"call getAllDailyMenuFood()",
                "params"=>[]
            ]);
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
  
    public function insert(DailyMenu $DM,$id_admin){
        try{
            $parametros = array();
            $id = Model::sql([
                "sql"=>"SELECT id_menu from DailyMenu where date_create=CURDATE() and status =1;",
                "fetch"=>"one",
                "params"=>[]
            ]);
            if(!$id){
                $id =Model::sql([
                    "sql"=>"INSERT INTO DailyMenu(date_create) values(now());",
                    "fetch"=>"one",
                    "type"=>"insert",
                    "params"=>[]
                ]);
            }else{
                $id=$id->id_menu;
            }
            if($id){
                $resultSet=$this->foodDao->insertFood($DM->getFoodControl(), $id,$id_admin);
            }
            return isset($resultSet)?$resultSet: 0;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    
    public function update(DailyMenu $dailyMenu){
        return $this->foodDao->updateFood( $dailyMenu->getFoodControl());
    }
    
    public function delete($id_food_control){
        $this->foodDao->deleteFoodControl( $id_food_control);
    }

    // QUERYS

    
    public function getTypeFood(){
        try{
            $parametros = array();
            return Model::sql([
                "sql"   =>"call getTypeFood()",
                "params"=>$parametros,
                "type"  =>"query", 
                "class" =>"TypeFood"
            ]);
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    public function getCtgFood(){
        try{
            $parametros = array();
            return Model::sql([
                "sql"   =>"call getCtgFood()",
                "params"=>$parametros,
                "type"  =>"query", 
                "class" =>"CtgFood"
            ]);
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    public function getSchedule(){
        try{
            $parametros = array();
            return Model::sql([
                "sql"=>"call getSchedule()",
                "params"=>$parametros,
                "type"  =>"query", 
                "class" =>"Schedule"
            ]);
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
}