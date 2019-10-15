<?php
require_once MODELS.'DTO/DailyMenu/Food.php';
require_once MODELS.'DTO/DailyMenu/FoodControl.php';
require_once MODELS.'DTO/User/User.php';
class FoodDAO {
	public function __construct(){
    }
  
    public function queryFoods($id_menu){
        try{
            $parametros = array($id_menu);
            return Model::sql([
                "sql"=>"call getFood(?)",
                "params"=>$parametros
            ]);
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    
    public function queryFoodForId($id_foodcontrol){
        try{
            $parametros = array($id_foodcontrol);
            return Model::sql([
                "sql"=>"call getFoodForID(?)",
                "params"=>$parametros,
                "fetch"=>"one"
            ]);
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    public function insertFood(FoodControl $foodControl, $id_menu,$id_admin){
        try{
            $parametros = array(
                $foodControl->getFood()->getName_food(),
                $foodControl->getFood()->getDesciption_food(),
                $foodControl->getFood()->getPrice(),
                $foodControl->getFood()->getCtg_food()->getId_ctgfood(),
            );
            $id = Model::sql([
                "sql"=>"INSERT INTO Food( name_food, description_food , price, id_ctgfood)
                values(?, ?, ?,?);",
                "params"=>$parametros,
                "type"=>"insert"
            ]);
            $parametros = array(
                $foodControl->getTypefood()->getId_TypeFood(),
                $foodControl->getSchedule()->getId_schedule(),
                $id_admin,
                $id_menu
            );
            $id_control = Model::sql([
                "sql"   =>"INSERT INTO foodControl( id_TypeFood, id_schedule, id_admin,id_menu,id_food ) 
                VALUES(?, ?, ?, ?,(SELECT MAX(id_food) FROM Food) );",
                "params"=>$parametros,
                "type"=>"insert",
                "fetch"=>"one"
            ]);
            return $id_control;
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    
    public function updateFood(FoodControl $foodControl){
        try{
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
            return Model::sql([
                "sql"   =>"call updateFood(?,?,?,?,?,?,?,?)",
                "params"=>$parametros,
                "type"  =>"update"
            ]);
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
    
    public function deleteFoodControl($id_food){
        try{
            $parametros = array($id_food);
            return Model::sql([
                "sql"=>" delete from foodControl where id_control=?;",
                "params"=>$parametros,
                "type"=>"delete"
            ]);
            return $sentencia->rowCount();
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }

    // check
    public function checkUserForPostAndDate($id_user, $id_post){
        try{
            $parametros = array($id_user, $id_post);
            return Model::sql([
                "sql"=>"call checkUserForPostAndDate(?,?)",
                "params"=>$parametros,
                "type"=>"query",
                "class"=>"TypeFood"
            ]);
        }catch(Exception $e) {
        die($e->getMessage());
        die($e->getTrace());
        }
    }
}