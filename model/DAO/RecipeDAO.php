<?php
require_once 'model/Connection.php';
require_once 'model/DTO/Blog/Blog.php';
require_once 'model/DTO/Blog/Recipe.php';
// require_once 'model/DTO/User.php';
class RecipeDAO {
	//Manejo de datos de actiidades
	private $connection;

	public function __construct(){
		$this->connection = Connection :: getConnection();
  }

  
  public function queryLastIdRecipe(){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getIdLastRecipe()");
      $parametros = array();
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetch(PDO::FETCH_OBJ);
      return $resultSet;
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  
  public function insertIntegredients($ingredient, $id_recipe){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("call insertIngredient(?,?)");
      $parametros = array($ingredient, $id_recipe);
      $sentencia->execute($parametros);
      $sentencia->closeCursor();
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  

  //update
  public function deleteIntegredients($id_recipe){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("delete from ingredients where id_recipe=?");
      $parametros = array($id_recipe);
      $sentencia->execute($parametros);
      $sentencia->closeCursor();
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }


  public function getIngredients($id_recipe){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getIngredients(?)");
      $parametros = array($id_recipe);
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
      return $resultSet ;
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
}