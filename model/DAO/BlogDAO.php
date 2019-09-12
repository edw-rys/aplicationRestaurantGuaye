<?php
require_once 'model/Connection.php';
require_once 'model/DTO/Blog/Blog.php';
require_once 'model/DTO/Blog/Recipe.php';
require_once 'model/DAO/RecipeDAO.php';
require_once 'model/DTO/User/User.php';
class BlogDAO {
	//Manejo de datos de actiidades
	private $connection;
  private $recipeDAO;
	public function __construct(){
    $this->connection = Connection :: getConnection();
    $this->recipeDAO = new RecipeDAO();
  }
  public function query(){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getAllDataBlog()");
      $parametros = array();
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
      // $this->connection=null
      $sentencia->closeCursor();
      $allBlog=array();
      if(!empty($resultSet)){
        foreach($resultSet as $res){
        $blog=$this->chargeBlog($res);
          array_push($allBlog, $blog);
        }
      }
        
      return $allBlog ;
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }

  
  public function queryForUser($id){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getAllDataBlogForUser(?)");
      $parametros = array($id);
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
      // $this->connection=null
      $sentencia->closeCursor();
      $allBlog=array();
      if(!empty($resultSet)){
        foreach($resultSet as $res){
        $blog=$this->chargeBlog($res);
          array_push($allBlog, $blog);
        }
      }
      // var_dump($allBlog);
        
      return $allBlog ;
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }

  public function queryForId($id_blog ){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getBlogForId(?)");
      $parametros = array($id_blog );
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
      $sentencia->closeCursor();
      if(count($resultSet)>0){
        $res=$resultSet[0];
        $blog=$this->chargeBlog($res);
        return $blog;
      }
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  public function queryForIdCheck($id_blog , $id_user){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getBlogForIdCheck(?,?)");
      $parametros = array($id_blog, $id_user );
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
      $sentencia->closeCursor();
      if(count($resultSet)>0){
        $res=$resultSet[0];
        $blog=$this->chargeBlog($res);
        return $blog;
      }
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }

  public function queryLastIdBlog(){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getIdLastBlog()");
      $parametros = array();
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetch(PDO::FETCH_OBJ);
      return $resultSet;
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
    
  }

  public function update($blog){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("call updateRecipe(?,?,?,?)");
      $parametros = array(
        $blog->getRecipe()->getId_recipe(),
        $blog->getRecipe()->getUrl_image(),
        $blog->getRecipe()->getName_recipe(), 
        $blog->getRecipe()->getPreparation());
        $sentencia->execute($parametros);
        $sentencia->closeCursor();
        $this->deleteLinks($blog->getId_blog());
        $this->recipeDAO->deleteIntegredients($blog->getRecipe()->getId_recipe());
      if(!empty($blog->getRecipe()->getIngredients())){
        foreach($blog->getRecipe()->getIngredients() as $ingredient){
          $this->recipeDAO->insertIntegredients($ingredient['value'], $blog->getRecipe()->getId_recipe() );
        }
      }
      if(!empty($blog->getUrl_social_network())){
        foreach($blog->getUrl_social_network() as $link){
          $this->insertLinks($link['link'],$link['id_type'] ,$blog->getId_blog());
        }
      }
      
      
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }




  public function delete($id_blog,$id_user){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("call deleteStatusBlog(?,?)");
      $parametros = array($id_blog,$id_user);
      $sentencia->execute($parametros);
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  public function deleteByRol($id_blog){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("call deleteStatusBlogbyROL(?)");
      $parametros = array($id_blog);
      $sentencia->execute($parametros);
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }




  public function create(Blog $blog, $id_user){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("call insertBlog(?,?,?,?)");
      $parametros = array(
        $blog->getRecipe()->getUrl_image(),
        $blog->getRecipe()->getName_recipe(), 
        $blog->getRecipe()->getPreparation(), 
        $id_user);
      $sentencia->execute($parametros);
      $sentencia->closeCursor();
      
      $id_blog=$this->queryLastIdBlog();
      $id_recipe = $this->recipeDAO->queryLastIdRecipe();
      
      if(!empty($blog->getRecipe()->getIngredients())){
        foreach($blog->getRecipe()->getIngredients() as $ingredient){
          $this->recipeDAO->insertIntegredients($ingredient['value'],$id_recipe->id_recipe );
        }
      }
      if(!empty($blog->getUrl_social_network())){
        foreach($blog->getUrl_social_network() as $link){
          $this->insertLinks($link['link'],$link['id_type'] ,$id_blog->id_blog);
        }
      }
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  /*public function insertIntegredients($ingredient, $id_recipe){
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
  }*/
  public function insertLinks($link, $id_sn, $id_blog){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("call insertSocialNetwork(?,?,?)");
      $parametros = array($link, $id_sn, $id_blog);
      $sentencia->execute($parametros);
      $sentencia->closeCursor();
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }

  //update
  /* public function deleteIntegredients($id_recipe){
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
  }*/
  public function deleteLinks($id_blog){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("delete from link_social_network_blog where id_blog=?");
      $parametros = array($id_blog);
      $sentencia->execute($parametros);
      $sentencia->closeCursor();
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }











  /////////////////////////// SOCIAL NETWORK
  public function querySocialNetwork(){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getTypeSocialNetwork()");
      $parametros = array();
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
      // var_dump($resultSet);
      return $resultSet ;
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  public function updateDestacado($id){
    if(!$this->connection) return 0;
    try{
      $sentencia = $this->connection->prepare("call updateBlogDescatacado(?)");
      $parametros = array($id);
      $sentencia->execute($parametros);
      return $sentencia->rowCount();
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }

  /////////////////////////// BLOG


  public function chargeBlog($res){
    //usuario creador del post en el blog
    $user=new User();
    $user->setId_user($res->id_user);
    $user->setUsername($res->username);
    $user->setName_user($res->name_user);
    $user->setLast_name($res->last_name);

    //objeto de la receta
    $recipe= new Recipe();
    $recipe->setId_recipe($res->id_recipe);
    $recipe->setName_recipe($res->name);
    $recipe->setUrl_image($res->url_image);
    $recipe->setPreparation($res->preparation);
    
    //obtener ingredientes
    $ingredients = $this->recipeDAO->getIngredients($recipe->getId_recipe());
    
    $recipe->setIngredients($ingredients);
    
    //obtener redes sociales
    $socialnetwork = $this->getSocialNetwork($res->id_blog);


    // objeto del blog
    $blog=new Blog();
    $blog->setDestacado($res->destacado);
    $blog->setId_blog($res->id_blog);
    $blog->setDate_blog($res->creation_date);
    $blog->setRecipe($recipe);
    $blog->setUser($user);
    $blog->setUrl_social_network($socialnetwork);
    return $blog;
  }

  /* public function getIngredients($id_recipe){
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
  }*/
  public function getSocialNetwork($id_blog){
    if(!$this->connection) return [];
    try{
      $sentencia = $this->connection->prepare("call getlink_social_network_blog(?)");
      $parametros = array($id_blog);
      $sentencia->execute($parametros);
      $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
      return $resultSet ;
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
}