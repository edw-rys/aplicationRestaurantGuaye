<?php
require_once 'model/Connection.php';
require_once 'model/DTO/User/TypeUser.php';
class TypeUserDAO {
	//Manejo de datos de actiidades
	private $connection;

	public function __construct(){
		$this->connection = Connection :: getConnection();
    }
    public function query(){
        try{
			$sentencia = $this->connection->prepare("call getTypeUser()");
			$parametros = array();
			$sentencia->execute($parametros);
			$resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,'TypeUser');
			return $resultSet;
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
	public function queryOne($_id){
        try{
			$sentencia = $this->connection->prepare("call getTypeUserForId(?);");
			$parametros = array($_id);
			$sentencia->execute($parametros);
			$resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,'TypeUser');
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