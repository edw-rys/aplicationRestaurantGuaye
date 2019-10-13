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
            $resultSet = Model::sql([
                "sql"   =>"call insertDailyMenu()",
                "params"=>$parametros
            ]);
            // var_dump($resultSet);
            if(!empty($resultSet)){
                $resultSet=$resultSet[0];
                $id_menu=$resultSet->menu_diario_id;
                $resultSet=$this->foodDao->insertFood($DM->getFoodControl(), $id_menu,$id_admin);
            }
            return $resultSet;
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
                "sql"=>"call getCtgFood()",
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