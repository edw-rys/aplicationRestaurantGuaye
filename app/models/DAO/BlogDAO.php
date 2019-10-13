<?php
require_once MODELS.'DTO/Blog/Blog.php';
require_once MODELS.'DTO/Blog/Recipe.php';
require_once MODELS.'DAO/RecipeDAO.php';
require_once MODELS.'DTO/User/User.php';
class BlogDAO {
  private $recipeDAO;

	public function __construct(){
    $this->recipeDAO = new RecipeDAO();
  }
  public function query(){
    try{
      $resultSet = Model::sql([
        "sql"=>"call getAllDataBlog();",
        "params"=>[]
      ]);
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

  
  public function queryByUser($id){
    try{
      $resultSet = Model::sql([
        "sql"=>"call getAllDataBlogForUser(?)",
        "params"=>array($id)
      ]);
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

  public function queryById($id_blog ){
    try{
      $resultSet = Model::sql([
        "sql"   =>"call getBlogForId(?)",
        "params"=>array($id_blog)
      ]);
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
  public function queryByIdCheck($id_blog , $id_user){
    try{
      $resultSet = Model::sql([
        "sql"   =>"call getBlogForIdCheck(?,?)",
        "params"=>array($id_blog, $id_user)
      ]);
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
    try{
      $resulset = Model::sql([
        "sql"   =>"call getIdLastBlog()",
        "params"=>[]
      ]);
      return empty($resulset)?$resulset:$resulset[0];
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }

  public function update($blog){
    try{
      $parametros = array(
        $blog->getRecipe()->getId_recipe(),
        $blog->getRecipe()->getUrl_image(),
        $blog->getRecipe()->getName_recipe(), 
        $blog->getRecipe()->getPreparation()
      );
        
      $count = Model::sql([
        "sql"   =>"call updateRecipe(?,?,?,?)",
        "params"=>$parametros, 
        "type"  =>"update"
      ]);

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
      return $count;
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }




  public function delete($id_blog,$id_user){
    try{
      $parametros = array($id_blog,$id_user);
      return Model::sql([
        "sql"=>"call deleteStatusBlog(?,?)",
        "params"=>$parametros, 
        "type"=>"delete"
      ]);
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  public function deleteByRol($id_blog){
    try{
      $parametros = array($id_blog);
      return Model::sql([
        "sql"=>"call deleteStatusBlogbyROL(?)",
        "params"=>$parametros, 
        "type"=>"delete"
      ]);
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  public function create(Blog $blog, $id_user){
    try{
      $parametros = array(
        $blog->getRecipe()->getUrl_image(),
        $blog->getRecipe()->getName_recipe(), 
        $blog->getRecipe()->getPreparation(), 
        $id_user);
      $count = Model::sql([
        "sql"   =>"call insertBlog(?,?,?,?)",
        "params"=>$parametros, 
        "type"  =>"insert"
      ]);
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
      return $count;
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
    try{
      $parametros = array($link, $id_sn, $id_blog);
      return Model::sql([
        "sql"   =>"call insertSocialNetwork(?,?,?)",
        "params"=>$parametros, 
        "type"  =>"insert"
      ]);
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
    try{
      return Model::sql([
        "sql"   =>"DELETE from link_social_network_blog where id_blog=?",
        "params"=>array($id_blog), 
        "type"  =>"delete"
      ]);
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }











  /////////////////////////// SOCIAL NETWORK
  public function querySocialNetwork(){
    try{
      return Model::excecuteProcedure("call getTypeSocialNetwork()",[]);
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
  public function updateDestacado($id){
    try{
      $parametros = array($id);
      return Model::excecuteProcedure("call updateBlogDescatacado(?)",$parametros, "update");
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
    try{
      $parametros = array($id_blog);
      return Model::excecuteProcedure("call getlink_social_network_blog(?)",$parametros);
    }catch(Exception $e) {
      die($e->getMessage());
      die($e->getTrace());
    }
  }
}