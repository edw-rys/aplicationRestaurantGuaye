<?php
include_once 'config/config.php';
require_once 'model/DAO/BlogDAO.php';
require_once 'model/DTO/Blog/Blog.php';
require_once 'model/DTO/Blog/Recipe.php';
class BlogController {
    private $blogDAO;
    public function __construct() {
        $this->blogDAO = new BlogDAO();
    }

    public function sessionStart(){
        if (!isset($_SESSION)) {
            session_start();
        }
    }


    public function query(){
        $allBlog = $this->blogDAO->query();
        require_once HEADER;
        require_once 'view/Blog/blog.php';
        require_once PANELS;
        require_once FOOTER;
    }
    public function queryAllBlog(){
        $blog = $this->blogDAO->query();
    }
    public function viewRecipe(){
        $this->sessionStart();
        $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:'';
        $id_blog=isset($_REQUEST['id'])?$_REQUEST['id']:'';
        $blog = $this->blogDAO->queryForId($id_blog);

        if(isset($_REQUEST['edit'])){
            if(isset($_SESSION['ID_USER'])){
                $blog_edit= $this->blogDAO->queryForIdCheck($id_blog , $_SESSION['ID_USER']);
                $socialNetworkList= $this->blogDAO->querySocialNetwork();
                if(empty($blog_edit))
                    $_SESSION['messageError']="Usted no tiene permisos para editar esta publicación!";
            }else{
                $_SESSION['messageError']="Necesita estar autenticado para editar.";
            }
        }
        require_once HEADER;
        require_once 'view/Blog/viewBlog.php';
        require_once PANELS;
        require_once FOOTER;
    }
    public function queryAllBlogForUser(){
        $id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
        $blog = $this->blogDAO->queryForUser($id);
    }
    public function chargeSocialNetwork(){
        $socialNetwork= $this->blogDAO->querySocialNetwork();
        echo json_encode($socialNetwork);
    }
    public function remove(){
        $this->sessionStart();
        if(isset($_SESSION['ID_USER'])){
            $id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
            if($_SESSION['rol']==MODERADOR){
                $numfilasAfectadas= $this->blogDAO->deleteByRol($id);
                if($numfilasAfectadas>0)
                    $_SESSION['message']="Post eliminado por un moderador!";
                else
                    $_SESSION['messageError']="Hubo un error al eliminar.";    
            }else{
                $numfilasAfectadas= $this->blogDAO->delete($id,$_SESSION['ID_USER']);
                if($numfilasAfectadas>0)
                    $_SESSION['message']="Post eliminado!";
                else
                    $_SESSION['messageError']="Error al eliminar, asegurese de estar autenticado con en el usuario correspondiente que hizo la publicación.";    
            }
        }else{
            $_SESSION['messageError']="Necesita estar autenticado para eliminar.";
        }
        $this->query();
    }
    public function last(){
        var_dump($_REQUEST['nombre']);
        var_dump($_REQUEST['imagen']);
        var_dump($_REQUEST['ingrediente']);
        var_dump( $_REQUEST['input-social'] );
        var_dump( $_REQUEST['social-op'] );
        
        // echo strlen($_REQUEST['input-social'][0]);
        $R=$this->blogDAO->queryLastIdRecipe();
        echo $R->id_recipe;
    }

    public function save(){
        $this->sessionStart();
        if(!isset($_SESSION['ID_USER'])){
            $_SESSION['messageError']="Necesita estar autenticado para publicar en el blog.";
            $this->query();
        }
        if(!(isset($_REQUEST['nombre']) && isset($_FILES['imagen']) && 
            isset($_REQUEST['ingrediente']) && isset($_REQUEST['preparacion']))){
            $_SESSION['messageError']="Faltan datos!";
            $this->query();
        }


        $url=$this->saveImage('imagen');
        $recipe =new Recipe();
        // $recipe->setIngredients($_REQUEST['ingrediente']);
        $recipe->setPreparation($_REQUEST['preparacion']);        
        $recipe->setUrl_image($url);
        $recipe->setName_recipe($_REQUEST['nombre']);
        for($i=0; $i<count($_REQUEST['ingrediente']) ;$i++){
            $ingredient_=array(
                "value"=>$_REQUEST['ingrediente'][$i]
            );
            $recipe->addIngredients($ingredient_);
        }
        $blog=new Blog();
        $blog->setRecipe($recipe);
        if(isset($_REQUEST['input-social']) && isset($_REQUEST['social-op'])){
            if(count($_REQUEST['input-social'])==count($_REQUEST['social-op'])){
                for($i=0;$i<count($_REQUEST['input-social']);$i++){
                    $link=array(
                                "link"=>$_REQUEST['input-social'][$i],
                                "id_type"=>$_REQUEST['social-op'][$i]
                            );
                    $blog->addLink($link);
                }
            }
        }
        $numfilasAfectadas =0;
        if (isset($_REQUEST['id']) && !empty($_REQUEST['id']) &&  isset($_REQUEST['id_recipe']) && !empty($_REQUEST['id_recipe']) ) {
            // editar
            $blog->setId_blog($_REQUEST['id']);
            $blog->getRecipe()->setId_recipe($_REQUEST['id_recipe']);
            $verify=$this->blogDAO->queryForIdCheck($blog->getId_blog(),$_SESSION['ID_USER']);
            if(empty($verify)){
                $_SESSION['messageError']="Usted no tiene permisos para editar esta publicación";
                $this->query();
            }
            $numfilasAfectadas = $this->blogDAO->update($blog);
            $message="Editado exitosamente";
        }else{
            $numfilasAfectadas = $this->blogDAO->create($blog, $_SESSION['ID_USER']);
            $message="Guardado exitosamente";
        }
        if ($numfilasAfectadas > 0) {
            $_SESSION['message'] = $message;
        } else {
            $_SESSION['messageError'] = "No se pudo guardar los datos";
        }
        $this->query();
    }

    private function saveImage($_name){
        if($_FILES[$_name]['size']>2*1000*1000){
            $this->sessionStart();
            $_SESSION['messageError']="Tamaño de archivo permitido: max 2mb";
            $this->query();
            return;
        }
        if(!$this->validateExt($_FILES[$_name]['name'])){
            $this->sessionStart();
            $_SESSION['messageError']="Formato de archivo no es válido";
            $this->query();
            return;
        }
        

        opendir(ROUTEFILES);
        $parts = explode(".",$_FILES[$_name]['name']);
        // con el final del explode que sería la extensión de la imagen
        $origen=  $_FILES[$_name]['tmp_name'];
        $destino= ROUTEFILES. $this->generateRandomString(7). '.'.end($parts);//ends obtiene el último valor del arreglo
        move_uploaded_file($origen, $destino);
        // $_FILES[$_name]['type']; tipo de archivo
        return  $destino;
    }
    //generar nombre random
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } 
    // validar extención del archivo
    private function validateExt( $nombre){
        $patron = "%\.(gif|jpe?g|png|svg)$%i"; 
        return preg_match($patron, $nombre) ;
    }





    public function destacado(){
        $this->sessionStart();
        if(isset($_REQUEST['id']) && $_SESSION['rol']==MODERADOR){
            $id=$_REQUEST['id'];
            echo $this->blogDAO->updateDestacado($id);
        }else{
            echo 404;
        }
    }
}