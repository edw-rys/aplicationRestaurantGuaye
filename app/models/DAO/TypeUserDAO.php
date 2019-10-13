<?php
require_once MODELS.'DTO/User/TypeUser.php';
class TypeUserDAO {
	//Manejo de datos de actiidades
	public function __construct(){
    }
    public function query(){
        try{
			$parametros = array();
      		return Model::sql([
				  "sql"=>"call getTypeUser(?,?)",
				  "params"=>$parametros,
				  "type"=>"query",
				  "class"=>"TypeUser"
				]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
	public function queryOne($_id){
        try{
			$parametros = array($_id);
			$resultSet = Model::sql([
				"sql"=>"call getTypeUserForId(?);",
				"params"=>$parametros,
				"type"=>"query",
				"class"=>"TypeUser"
				]);
			return $resultSet[0];
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
    }
    public function update(){

    }
    public function delete(){

    }
    public function create(){

    }

}