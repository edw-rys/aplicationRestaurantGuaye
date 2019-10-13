<?php
require_once MODELS."DTO/User/User.php";
require_once MODELS.'DAO/BlogDAO.php';
require_once MODELS.'DTO/Blog/Blog.php';
require_once MODELS.'DTO/Blog/Recipe.php';
class BlogController {
    private $blogDAO;
    public function __construct() {
        $this->blogDAO = new BlogDAO();
    }

    public function index(){
        $allBlog = $this->blogDAO->query();
        $data=[
            "title"=>"Blog",
            "allBlog"=>$allBlog,
        ];
        View::render("blog", $data);
    }
    // public function queryAllBlog(){
    //     $blog = $this->blogDAO->query();
    // }
    public function viewRecipe($id_blog=0){
        $socialNetworkList= $this->blogDAO->querySocialNetwork();
        $blog = $this->blogDAO->queryById($id_blog);
        if(empty($blog) || is_null($blog))
            echo "null";
        else{
            include_once COMPONENTS."blog/itemAllData.php";
        }
    }
    public function seachRecipe($id_blog=null, $edit=false){
        $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:'';
        $id_blog=is_null($id_blog)?'':$id_blog;
        $blog = $this->blogDAO->queryById($id_blog);

        if($edit){
            if(isset($_SESSION['ID_USER'])){
                $blog_edit= $this->blogDAO->queryByIdCheck($id_blog , $_SESSION['ID_USER']);
                $socialNetworkList= $this->blogDAO->querySocialNetwork();
                if(!empty($blog_edit)){
                    $data=[
                        "title"=>"Blog",
                        "allBlog"=>$blog_edit,
                        "status"=>"success",
                        "code"=>200,
                        "socialNetworkList"=>$socialNetworkList
                    ];
                }else{
                    $data=[
                        "title"=>"Blog",
                        "status"=>"error",
                        "code"=>404,
                        "message"=>"Usted no tiene permisos para editar esta publicación!"
                    ];
                }
            }else{
                $data=[
                    "title"=>"Blog",
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"Necesita estar autenticado para editar."
                ];
            }
        }else{
            $data=[
                "title"=>"Blog",
                "status"=>"new",
                "code"=>200,
                "message"=>"Nuevo."
            ];
        }
        return $data;
    }
    public function queryAllBlogByUser($id=0){
        $blog = $this->blogDAO->queryByUser($id);
        return $blog;
    }
    public function chargeSocialNetwork(){
        $socialNetwork= $this->blogDAO->querySocialNetwork();
        echo json_encode($socialNetwork);
    }
    public function delete($id=0){
        if(isset($_SESSION['ID_USER'])){
            if($_SESSION['rol']==MODERADOR){
                $numfilasAfectadas= $this->blogDAO->deleteByRol($id);
                if($numfilasAfectadas>0){
                    $data=[
                        "title"=>"Blog",
                        "status"=>"success",
                        "code"=>200,
                        "message"=>"Post eliminado por un moderador!"
                    ];
                }
                else{
                    $data=[
                        "title"=>"Blog",
                        "status"=>"error",
                        "code"=>400,
                        "message"=>"Hubo un error al eliminar."
                    ];
                }
            }else{
                $numfilasAfectadas= $this->blogDAO->delete($id,$_SESSION['ID_USER']);
                if($numfilasAfectadas>0){
                    $data=[
                        "title"=>"Blog",
                        "status"=>"success",
                        "code"=>200,
                        "message"=>"Post eliminado!"
                    ];
                }else{
                    $data=[
                        "title"=>"Blog",
                        "status"=>"error",
                        "code"=>400,
                        "message"=>"Error al eliminar, asegurese de estar autenticado con en el usuario correspondiente que hizo la publicación."
                    ];
                }
            }
        }else{
            $data=[
                "title"=>"Blog",
                "status"=>"error",
                "code"=>400,
                "message"=>"Necesita estar autenticado para eliminar."
            ];
        }
        echo json_encode($data);
    }


    public function save(){
        if(!isset($_SESSION['ID_USER'])){
            $data=[
                "title"=>"Blog",
                "status"=>"error",
                "code"=>400,
                "message"=>"Necesita estar autenticado para publicar en el blog."
            ];
        }else{
            if(!(isset($_REQUEST['nombre']) && isset($_FILES['imagen']) && 
                isset($_REQUEST['ingrediente']) && isset($_REQUEST['preparacion']))){
                $data=[
                    "title"=>"Blog",
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"Faltan datos!"
                ];
            }else{
                $data = saveImage('imagen');
                if($data["status"]=="success"){
                    $url = $data["url"];

                    $recipe =new Recipe();
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
                        $verify=$this->blogDAO->queryByIdCheck($blog->getId_blog(),$_SESSION['ID_USER']);
                        if(empty($verify)){
                            $data=[
                                "title"=>"Blog",
                                "status"=>"error",
                                "code"=>400,
                                "message"=>"Usted no tiene permisos para editar esta publicación."
                            ];
                        }else{
                            $data=[
                                "title"=>"Blog",
                                "status"=>"success",
                                "code"=>200,
                                "message"=>"Editado exitosamente."
                            ];
                            $message="Editado exitosamente";
                            $numfilasAfectadas = $this->blogDAO->update($blog);
                        }
                    }else{
                        $numfilasAfectadas = $this->blogDAO->create($blog, $_SESSION['ID_USER']);
                        $message="Guardado exitosamente";
                    }
                    if ($numfilasAfectadas > 0) {
                        $data=[
                            "title"=>"Blog",
                            "status"=>"success",
                            "code"=>200,
                            "message"=>$message
                        ];
                    } else {
                        $data=[
                            "title"=>"Blog",
                            "status"=>"error",
                            "code"=>400,
                            "message"=>"No se pudo guardar los datos"
                        ];
                    }
                }else{
                    // return $data;
                }
            }
            echo json_encode($data);
        }
    }

    
    public function destacado($id=0){
        if($id!=0 && $_SESSION['rol']==MODERADOR){
            echo $this->blogDAO->updateDestacado($id);
        }else{
            echo 404;
        }
    }

    // Views
    public function new($id=0){
        if(!isset($_SERVER["user"])){
            if($id!=0){
                $data = $this->seachRecipe($id,true);
                // var_dump($data);
                if($data["status"]=='success'){
                    $blog_edit=$data["allBlog"];
                }
            }
            include_once COMPONENTS."blog/formRecipe.php";
        }else{
            echo "error";
        }
    }
}