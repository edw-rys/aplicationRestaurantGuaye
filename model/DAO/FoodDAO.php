<?php
require_once 'model/Connection.php';
require_once 'model/DTO/DailyMenu/Food.php';
require_once 'model/DTO/DailyMenu/FoodControl.php';
require_once 'model/DTO/User/User.php';
class FoodDAO {
	private $connection;
	public function __construct(){
		$this->connection = Connection :: getConnection();
    }
  
    public function queryFoods($id_menu){
        if(!$this->connection) return [];
        try{
            $sentencia = $this->connection->prepare("call getFood(?)");
            $parametros = array($id_menu);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultSet;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    
    public function queryFoodForId($id_foodcontrol){
        if(!$this->connection) return [];
        try{
            $sentencia = $this->connection->prepare("call getFoodForID(?)");
            $parametros = array($id_foodcontrol);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetch(PDO::FETCH_OBJ);
            return $resultSet;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    public function insertFood(FoodControl $foodControl, $id_menu,$id_admin){
        if(!$this->connection) return 0;
        try{
            $sentencia = $this->connection->prepare("call insertFood(?,?,?,?,?,?,?,?)");
            $parametros = array(
                $foodControl->getFood()->getName_food(),
                $foodControl->getFood()->getDesciption_food(),
                $foodControl->getFood()->getPrice(),
                $foodControl->getFood()->getCtg_food()->getId_ctgfood(),
                $foodControl->getTypefood()->getId_TypeFood(),
                $foodControl->getSchedule()->getId_schedule(),
                $id_admin,
                $id_menu
            );
            $sentencia->execute($parametros);
            $sentencia->closeCursor();
            return $sentencia->rowCount();
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    
    public function updateFood(FoodControl $foodControl){
        if(!$this->connection) return [];
        try{
            $sentencia = $this->connection->prepare("call updateFood(?,?,?,?,?,?,?,?)");
            $parametros = array(
                $foodControl->getFood()->getId_food(),
                $foodControl->getId_control(),
                $foodControl->getFood()->getName_food(),
                $foodControl->getFood()->getDesciption_food(),
                $foodControl->getFood()->getPrice(),
                $foodControl->getFood()->getCtg_food()->getId_ctgfood(),
                $foodControl->getTypefood()->getId_TypeFood(),
                $foodControl->getSchedule()->getId_schedule()
            );
            // var_dump($parametros);
            $sentencia->execute($parametros);
            $sentencia->closeCursor();
            return $sentencia->rowCount();
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    
    public function deleteFoodControl($id_food){
        if(!$this->connection) return 0;
        try{
            $sentencia = $this->connection->prepare(" delete from foodControl where id_control=?;");
            $parametros = array($id_food);
            $sentencia->execute($parametros);
            $sentencia->closeCursor();
            return $sentencia->rowCount();
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }

    // check
    public function checkUserForPostAndDate($id_user, $id_post){
        if(!$this->connection) return [];
        try{
            $sentencia = $this->connection->prepare("call checkUserForPostAndDate(?,?);");
            $parametros = array($id_user, $id_post);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"TypeFood");
            return $resultSet;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
}