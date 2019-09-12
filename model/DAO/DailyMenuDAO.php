<?php
require_once 'model/Connection.php';
require_once 'model/DAO/FoodDAO.php';
require_once 'model/DTO/DailyMenu/DailyMenu.php';
require_once 'model/DTO/DailyMenu/FoodControl.php';
require_once 'model/DTO/DailyMenu/TypeFood.php';
require_once 'model/DTO/DailyMenu/CtgFood.php';
require_once 'model/DTO/DailyMenu/Schedule.php';
// require_once 'model/DTO/Food.php';
// require_once 'model/DTO/User/User.php';
class DailyMenuDAO {
    private $connection;
    private $foodDao;
	public function __construct(){
        $this->connection = Connection :: getConnection();
        $this->foodDao = new FoodDAO();
    }
  
    public function query(){
        if(!$this->connection) return [];
        try{
            $sentencia = $this->connection->prepare("call getAllDailyMenuFood()");
            $parametros = array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultSet;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
  
    public function insert(DailyMenu $DM,$id_admin){
        if(!$this->connection) return 0;
        try{
            $sentencia = $this->connection->prepare("call insertDailyMenu()");
            $parametros = array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetch(PDO::FETCH_OBJ);
            $sentencia->closeCursor();
            if(!empty($resultSet)){
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
        if(!$this->connection) return [];
        return $this->foodDao->updateFood( $dailyMenu->getFoodControl());
    }
    
    public function delete($id_food_control){
        if(!$this->connection) return [];
        $this->foodDao->deleteFoodControl( $id_food_control);
    }

    // QUERYS

    
    public function getTypeFood(){
        if(!$this->connection) return [];
        try{
            $sentencia = $this->connection->prepare("call getTypeFood()");
            $parametros = array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"TypeFood");
            return $resultSet;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    public function getCtgFood(){
        if(!$this->connection) return [];
        try{
            $sentencia = $this->connection->prepare("call getCtgFood()");
            $parametros = array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,'CtgFood');
            return $resultSet;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    public function getSchedule(){
        if(!$this->connection) return [];
        try{
            $sentencia = $this->connection->prepare("call getSchedule()");
            $parametros = array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,'Schedule');
            return $resultSet;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
}