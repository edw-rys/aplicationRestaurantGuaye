<?php
require_once MODELS.'DTO/Blog/Blog.php';
require_once MODELS.'DTO/Blog/Recipe.php';
// require_once 'model/DTO/User.php';
class RecipeDAO {
	//Manejo de datos de actiidades

	public function __construct(){
  }

  
  public function queryLastIdRecipe(){
    try{
      $resulset=Model::sql([
        "sql"   =>"call getIdLastRecipe()",
        "params"=>[]
      ]);
      return empty($resulset)?$resulset:$resulset[0];
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  
  public function insertIntegredients($ingredient, $id_recipe){
    try{
      $parametros = array($ingredient, $id_recipe);
      return Model::sql([
        "sql"   =>"call insertIngredient(?,?)",
        "params"=>$parametros,
        "type"  =>"insert"
      ]);
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  

  //update
  public function deleteIntegredients($id_recipe){
    try{
      $parametros = array($id_recipe);
      return Model::sql([
        "sql"=>"DELETE from ingredients where id_recipe=?",
        "params"=>$parametros,
        "type"=>"delete"
      ]);
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }


  public function getIngredients($id_recipe){
    try{
      $parametros = array($id_recipe);
      return Model::sql([
        "sql"=>"call getIngredients(?)",
        "params"=>$parametros]);
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
}